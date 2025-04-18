
    window.openItem = async function(packageId) {
        console.log('Opening package with ID:', packageId);
        try {
            const {
                package: pkg,
                foods,
                utilities
            } = await fetchPackageData(packageId);
            console.log('Package:', pkg);
            console.log('Foods:', foods);
            console.log('utils:', utilities);

            const htmlContent = `
                <div class="max-h-[80vh] overflow-y-auto">
                    <div id="modal-message" class="hidden mb-4 p-3 rounded text-sm"></div>
                    <!-- Header Section -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">${pkg.name}</h2>
                        <p class="text-gray-600 text-sm">${pkg.description}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Image Section -->
                        <div class="relative group">
                            <img src="/packagePics/${pkg.image}" 
                                 alt="${pkg.name}" 
                                 class="w-full h-64 object-cover rounded-xl shadow-lg">
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/60 to-transparent rounded-xl">
                                <div class="text-white flex justify-between items-end">
                                    <div>
                                        <p class="text-sm">Per pax</p>
                                        <p class="text-2xl font-bold">₱${Number(pkg.price_per_person).toFixed(2)}</p>
                                    </div>
                                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm">Min. ${pkg.min_pax} Pax</span>
                                </div>
                            </div>
                        </div>

                        <!-- Foods Section -->
                        <div class="bg-gray-50 p-2 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Included Foods</h3>
                            <form id="packageSelectionForm">
                                ${renderFoods(foods)}
                            </form>
                        </div>
                    </div>

                    <!-- Utilities Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold mb-4">Utilities</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${renderUtilities(utilities)}
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <button onclick="addSelectedPackageToCart(${pkg.id})" id="selectPackageBtn" class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                            Add to cart
                        </button>
                    </div>
                </div>
            `;

            Swal.fire({
                html: htmlContent,
                width: 800,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#fff'
            });
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
                confirmButtonText: 'Try Again'
            }).then(result => {
                if (result.isConfirmed) openItem(packageId);
            });
        }
    }

    window.addSelectedPackageToCart = async function(packageId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const form = document.getElementById('packageSelectionForm');
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        const groups = {};

        // Group checkboxes by food item id.
        checkboxes.forEach(checkbox => {
            const name = checkbox.name; // e.g., "food_item_5[]"
            const match = name.match(/food_item_(\d+)\[\]/);
            if (match) {
                const foodId = match[1];
                if (!groups[foodId]) {
                    groups[foodId] = [];
                }
                groups[foodId].push(checkbox);
            }
        });

        // Validate that each food item group has at least one option checked.
        for (const foodId in groups) {
            const groupCheckboxes = groups[foodId];
            const checked = Array.from(groupCheckboxes).filter(cb => cb.checked);
            if (checked.length === 0) {
                showModalMessage('error', 'Please select at least one option for every food item.');
                document.getElementById('modal-message').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }
        }

        // If validation passes, collect selected options with objects.
        const selectedOptions = {};
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const foodIdMatch = checkbox.name.match(/food_item_(\d+)/);
                if (foodIdMatch) {
                    const foodId = foodIdMatch[1];
                    if (!selectedOptions[foodId]) {
                        selectedOptions[foodId] = [];
                    }
                    selectedOptions[foodId].push({
                        id: checkbox.value,
                        type: checkbox.getAttribute('data-type')
                    });
                }
            }
        });

        try {
            const data = await fetchPackageData(packageId);
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    package_id: packageId,
                    quantity: 1,
                    selected_options: selectedOptions, // e.g., { "5": [ { "id": "1", "type": "Fried" } ] }
                    included_utilities: data.utilities
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Something went wrong.');
            }

            const responseData = await response.json();

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '<span class="text-gray-200">Added to Cart!</span>',
                text: data.message || 'Package added to your cart.',
                timer: 2000,
                showConfirmButton: false,
                background: '#1F2937',
                color: '#E5E7EB',
                toast: true
            });
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
                confirmButtonText: 'OK'
            });
        }
    }

    const packageCache = new Map();

    // FUNCTION PARA MAKUHA UNG PACKAGE DETAILS
    async function fetchPackageData(packageId) {
        if (packageCache.has(packageId)) {
            return packageCache.get(packageId);
        }

        try {
            const response = await fetch(`/package/details/${packageId}`);

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Server error: ${errorText.slice(0, 100)}`);
            }

            const data = await response.json();

            if (!data.success) throw new Error(data.message);

            // Return only relevant data for the frontend
            const packageData = {
                package: data.package,
                foods: data.foods,
                utilities: data.utilities
            };

            // Cache the data
            packageCache.set(packageId, packageData);

            return packageData;
        } catch (error) {
            console.error('Fetch error:', error);
            throw error;
        }
    }

    // FUNCTION FOR FOOD ITEMS RENDER
    function renderFoods(foods) {
        console.log('Rendering foods:', foods);

        if (!foods || foods.length === 0) {
            return '<p class="text-gray-500">No food items available.</p>';
        }

        return foods.map(packageItem => {
            const item = packageItem.item;
            const optionsHtml = (packageItem.options || []).map(option => `
            <label class="inline-flex items-center space-x-2 mb-2 mr-4">
                <input 
                    type="checkbox" 
                    name="food_item_${item.id}[]" 
                    value="${option.id}" 
                    data-type="${option.type}" 
                    class="form-checkbox text-blue-600">
                <span>${option.type}</span>
            </label>
        `).join('');

            return `
            <div class="mb-6">
                <div class="font-semibold text-gray-700 mb-2">${item.name}</div>
                <div class="flex flex-wrap">
                    ${optionsHtml}
                </div>
            </div>
        `;
        }).join('');
    }
    // FUNCTION FOR FOOD ITEMS RENDER
    function renderUtilities(utilities) {
        if (!utilities || utilities.length === 0) {
            return '<p class="text-gray-500">No utilities</p>';
        }
        return utilities.map(util => `
            <div class="flex p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800 mb-1">${util.name}</h4>
                    ${util.description ? `<p class="text-sm text-gray-600">${util.description}</p>` : ''}
                </div>
            </div>
        `).join('');
    }

    function showModalMessage(type, message) {
        const msgBox = document.getElementById('modal-message');
        if (!msgBox) return;

        msgBox.textContent = message;
        msgBox.classList.remove('hidden', 'bg-red-100', 'bg-green-100', 'text-red-700', 'text-green-700');

        if (type === 'error') {
            msgBox.classList.add('bg-red-100', 'text-red-700');
        } else if (type === 'success') {
            msgBox.classList.add('bg-green-100', 'text-green-700');
        }
    }
