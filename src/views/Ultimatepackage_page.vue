<script setup>
import { ref } from 'vue';

// Separate states for each dropdown
const showDropdown1 = ref(false);
const showDropdown2 = ref(false);

// Toggle functions for each dropdown
const toggleDropdown1 = () => {
    showDropdown1.value = !showDropdown1.value;
    showDropdown2.value = false; // Close other dropdown
};

const toggleDropdown2 = () => {
    showDropdown2.value = !showDropdown2.value;
    showDropdown1.value = false; // Close other dropdown
};

// Close dropdowns when clicking outside
const closeDropdowns = (event) => {
    if (!event.target.closest(".dropdown")) {
        showDropdown1.value = false;
        showDropdown2.value = false;
    }
};

// Attach event listener to close dropdowns when clicking outside
document.addEventListener("click", closeDropdowns);
</script>


<template>
    
    <div class="bg-red-100 min-h-screen py-5">
        
        <div class="items flex justify-center gap-20 py-4 my-2 bg-white text-sm font-normal">
            <a href="#">Celebration Package </a>
            <a href="#">Beef</a>
            <a href="#">Poultry</a>
            <a href="#">Dessert</a>
            <a href="#">Fish/Seafoods</a>
            <a href="#">Paella</a>
            <a href="#">Other Cuisines</a>
        </div>


        <div class="holder py-10 px-30 flex">
            <div class="left">
                <img src="/assets/Ultimatepackage.png" class="h-150 w-100">
                <div class="flex gap-5 mt-2">
                    <div>
                        <img src="/assets/food1.jpg" class="w-20 rounded-sm">
                        <p>Duo 1</p>
                    </div>
                    <div>
                        <img src="/assets/food2.jpg" class="w-20 rounded-sm">
                        <p>Duo 2</p>
                    </div>

                    <div>
                        <img src="/assets/food3.jpg" class="w-20 rounded-sm">
                        <p>Duo 3</p>
                    </div>
                    <div>
                        <img src="/assets/food2.jpg" class="w-20 rounded-sm">
                        <p>Duo 4</p>
                    </div>
                </div>
            </div>


            <div class="right pl-5">
                <p class="font-medium text-2xl pb-5">Ultimate Package</p>
                <hr>
                <p class="font-medium text-3xl py-3">P700.00 - P1000.00</p>
                <hr>
                <p class="font-medium text-2xl text-red-600 py-3">Promo starts at 50% discount</p>
                <p class="font-medium text-m pb-10">(All bundles are good for 4 pax)</p>

                <div class="pl-5">
                    <p class="font-medium text-lg">Duo 1 - P700.00</p>
                    <p class="font-medium text-m pl-10">Classic Chicken Adobo - The timeless savory blend of soy sauce, vinegar, garlic, and bay leaves. A true Filipino favorite!</p>

                </div>

                <div class="pl-5">
                    <p class="font-medium text-lg">Duo 2 - P700.00</p>
                    <p class="font-medium text-m pl-10">Classic Chicken Adobo - The timeless savory blend of soy sauce, vinegar, garlic, and bay leaves. A true Filipino favorite!</p>

                </div>

                <div class="pl-5">
                    <p class="font-medium text-lg">Duo 3 - P1,000.00</p>
                    <p class="font-medium text-m pl-10">Classic Chicken Adobo - The timeless savory blend of soy sauce, vinegar, garlic, and bay leaves. A true Filipino favorite!</p>

                </div>

                <div class="pl-5">
                    <p class="font-medium text-lg">Duo 4 - P1,200.00</p>
                    <p class="font-medium text-m pl-10">Classic Chicken Adobo - The timeless savory blend of soy sauce, vinegar, garlic, and bay leaves. A true Filipino favorite!</p>

                </div>


                <div>
                    <div class="flex gap-10 p-10 cursor-pointer">
                            <!-- First Dropdown -->
                            <div class="relative inline-block text-left dropdown">
                                <button @click.stop="toggleDropdown1" class="px-4 py-2 bg-blue-500 text-white rounded-lg focus:outline-none cursor-pointer">
                                    Number of Pax
                                </button>
                                <div v-if="showDropdown1"
                                    class="absolute left-0 mt-2 w-35 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">30-50 pax</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">50-75 pax</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">75-100 pax</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">100-150 pax</a>
                                </div>
                            </div>

                            <!-- Second Dropdown -->
                            <div class="relative inline-block text-left dropdown">
                                <button @click.stop="toggleDropdown2" class="px-4 py-2 bg-green-500 text-white rounded-lg focus:outline-none cursor-pointer">
                                    Variants
                                </button>
                                <div v-if="showDropdown2"
                                    class="absolute left-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Duo 1 - Classic</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Duo 2 - Spicy</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Duo 3 - Coconut</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Duo 4 - Gata</a>
                                </div>
                            </div>
                        </div>
                    
                </div>

            </div>
        </div>

    </div>
</template>