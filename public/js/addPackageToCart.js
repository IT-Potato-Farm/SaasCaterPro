window.openItem = async function (packageId) {
    console.log("test if nag syncc");
    try {
        const {
            package: pkg,
            foods,
            utilities,
        } = await fetchPackageData(packageId);
        const htmlContent = `
                <div class="max-h-[80vh] overflow-y-auto px-4 md:px-6 py-4">
                    <!-- Header Section -->
                    <div class="mb-5 md:mb-7">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 md:mb-3">${
                            pkg.name
                        }</h2>
                        <p class="text-gray-600 text-xs md:text-sm">${
                            pkg.description
                        }</p>
                    </div>
                    <div class="grid grid-cols-1 gap-5 md:gap-7 mb-7 md:mb-9">
                        <!-- Image Section -->
                        <div class="relative group">
                            <img src="/storage/packagepics/${pkg.image}" 
                                alt="${pkg.name}" 
                                class="w-full h-48 md:h-64 object-cover rounded-lg md:rounded-xl shadow">
                            <div class="absolute bottom-0 left-0 right-0 p-4 md:p-5 bg-gradient-to-t from-black/60 to-transparent rounded-lg md:rounded-xl">
                                <div class="text-white flex justify-between items-end">
                                    <div>
                                        <p class="text-xs md:text-sm">Per pax</p>
                                        <p class="text-xl md:text-2xl font-bold">₱${Number(
                                            pkg.price_per_person
                                        ).toFixed(2)}</p>
                                    </div>
                                    <span class="bg-white/20 px-3 py-1 md:px-4 md:py-1.5 rounded-full text-xs md:text-sm">Min. ${
                                        pkg.min_pax
                                    } Pax</span>
                                </div>
                            </div>
                        </div>

                        <!-- Foods Section -->
                        <div class="bg-gray-50 p-4 md:p-5 rounded-lg md:rounded-xl border border-gray-200">
                            <h3 class="text-base md:text-lg font-semibold mb-4 md:mb-5">Included Foods</h3>
                                <div id="modal-message" class="hidden mb-4 p-3 rounded text-sm"></div>
                            <form id="packageSelectionForm" class="space-y-4">
                                ${renderFoods(foods)}
                            </form>
                        </div>
                    </div>
                    <!-- Utilities Section -->
                    <div class="border-t border-gray-200 pt-5 md:pt-7">
                        <h3 class="text-base md:text-lg font-semibold mb-4 md:mb-5">Utilities</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                            ${renderUtilities(utilities)}
                        </div>
                    </div>
                    
                    <div class="mt-6 md:mt-8 text-center">
                        <button onclick="addSelectedPackageToCart(${
                            pkg.id
                        })" id="selectPackageBtn" class="px-5 py-3 md:px-7 md:py-4 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors text-sm md:text-base">
                            Add to cart
                        </button>
                    </div>
                </div>
            `;
        Swal.fire({
            html: htmlContent,
            width: window.innerWidth < 768 ? "90%" : 800,
            showCloseButton: true,
            showConfirmButton: false,
            background: "#fff",
            padding: "0",
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: error.message,
            confirmButtonText: "Try Again",
        }).then((result) => {
            if (result.isConfirmed) openItem(packageId);
        });
    }
};

window.addSelectedPackageToCart = async function (packageId) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const form = document.getElementById("packageSelectionForm");
    const optionInputs = form.querySelectorAll('input[type="radio"], input[type="checkbox"]');
    const foodItemElements = form.querySelectorAll("[data-food-id]");
    
    const allFoodItems = new Map();
    const foodItemsWithOptions = new Set();
    
    foodItemElements.forEach((element) => {
        const foodId = element.getAttribute("data-food-id");
        const foodName = element.querySelector(".font-semibold").textContent;
        if (foodId) {
            allFoodItems.set(foodId, foodName);
            
            // Check if this food has radio buttons/options
            const hasOptions = element.querySelectorAll('input[type="radio"]').length > 0;
            if (hasOptions) {
                foodItemsWithOptions.add(foodId);
            }
        }
    });

    if (allFoodItems.size === 0) {
        showModalMessage("error", "This package does not contain any food items.");
        return;
    }
    
    // Validate 
    let validationFailed = false;
    
    foodItemsWithOptions.forEach((foodId) => {
        const selected = form.querySelector(`input[name="food_item_${foodId}"]:checked`);
        if (!selected) {
            showModalMessage("error", `Please select an option for "${allFoodItems.get(foodId)}".`);
            validationFailed = true;
        }
    });
    
    if (validationFailed) return;
    
   
    const selectedOptions = {};
    
    // add food items with options
    optionInputs.forEach((input) => {
        const foodIdMatch = input.name.match(/food_item_(\d+)/);
        if (input.checked && foodIdMatch) {
            const foodId = foodIdMatch[1];
            if (!selectedOptions[foodId]) {
                selectedOptions[foodId] = [];
            }
            selectedOptions[foodId].push({
                id: input.value,
                type: input.getAttribute("data-type"),
            });
        }
    });
    
    // OR add food items without options
    allFoodItems.forEach((foodName, foodId) => {
        if (!foodItemsWithOptions.has(foodId) && !selectedOptions[foodId]) {
            
            selectedOptions[foodId] = [
                {
                    id: foodId,
                    type: foodName.trim(), 
                },
            ];
        }
    });
    
    // Debug 
    console.log("Selected options to send:", JSON.stringify(selectedOptions, null, 2));
    
    try {
        const data = await fetchPackageData(packageId);
        const response = await fetch("/cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: JSON.stringify({
                package_id: packageId,
                quantity: 1,
                selected_options: selectedOptions, //  { "5": [{ "id": "1", "type": "Fried" }] }
                included_utilities: data.utilities,
            }),
        });
        
        if (response.status === 401) {
            Swal.fire({
                icon: "info",
                title: "Login Required",
                text: "Please log in to add items to your cart",
                confirmButtonText: "Login Now",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/loginpage";
                }
            });
            return;
        }
        
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || "Something went wrong.");
        }
        
        const responseData = await response.json();
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: '<span class="text-gray-200">Added to Cart!</span>',
            text: data.message || "Package added to your cart.",
            timer: 2000,
            showConfirmButton: false,
            background: "#1F2937",
            color: "#E5E7EB",
            toast: true,
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: error.message,
            confirmButtonText: "OK",
        });
    }
};


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
            utilities: data.utilities,
        };
        // Cache the data
        packageCache.set(packageId, packageData);
        return packageData;
    } catch (error) {
        console.error("Fetch error:", error);
        throw error;
    }
}

// FUNCTION FOR FOOD ITEMS RENDER
function renderFoods(foods) {
    if (!foods || foods.length === 0) {
        return '<p class="text-gray-500 py-2">No food items available.</p>';
    }
    return foods
        .map((packageItem) => {
            const item = packageItem.item;
            const hasOptions =
                packageItem.options && packageItem.options.length > 0;
            const optionsHtml = (packageItem.options || [])
                .map(
                    (option) => `
            <label class="inline-flex items-center space-x-3 mb-3 mr-5">
                <input 
                    type="radio" 
                    name="food_item_${item.id}" 
                    value="${option.id}" 
                    data-type="${option.type}" 
                    class="form-radio h-4 w-4 md:h-5 md:w-5 text-green-600 focus:ring-green-500">
                <span class="text-sm md:text-base">${option.type}</span>
            </label>
        `
                )
                .join("");
            return `
            <div class="mb-6" data-food-id="${item.id}">
                <div class="font-semibold text-gray-700 mb-3 text-base md:text-lg">${item.name}</div>
                <div class="flex flex-wrap">
                    ${optionsHtml}
                </div>
            </div>
        `;
        })
        .join("");
}
// FUNCTION FOR FOOD ITEMS RENDER
function renderUtilities(utilities) {
    if (!utilities || utilities.length === 0) {
        return '<p class="text-gray-500 py-3">No utilities</p>';
    }
    return utilities
        .map(
            (util) => `
            <div class="flex p-4 md:p-5 bg-white rounded-lg border border-gray-200 hover:border-blue-300 transition-colors">
                <div class="flex-1">
                    <h4 class="font-medium text-gray-800 mb-2 text-base md:text-lg">${
                        util.name
                    }</h4>
                    ${
                        util.description
                            ? `<p class="text-sm text-gray-600">${util.description}</p>`
                            : ""
                    }
                </div>
            </div>
        `
        )
        .join("");
}
function showModalMessage(type, message) {
    const msgBox = document.getElementById("modal-message");
    if (!msgBox) return;
    msgBox.textContent = message;
    msgBox.classList.remove(
        "hidden",
        "bg-red-100",
        "bg-green-100",
        "text-red-700",
        "text-green-700"
    );
    if (type === "error") {
        msgBox.classList.add("bg-red-100", "text-red-700");
    } else if (type === "success") {
        msgBox.classList.add("bg-green-100", "text-green-700");
    }
}