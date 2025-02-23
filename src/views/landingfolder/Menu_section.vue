<script setup>

const emit = defineEmits(['openModal']);
    
</script>

<template>
    <h2 class="text-center font-bold text-6xl mt-20 ">MENU</h2>
    <div class="cardholder flex p-4 mt-5 justify-center gap-8 ">
        
        <!-- FIRST STYLE OPTION -->
        <!-- <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <img src="/assets/food1.jpg">

            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package A - Classic Delight</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">Includes 1 appetizer, 2 main courses, 1 dessert, and drinks. Perfect for small gatherings. (Serves 5-10 people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div>

        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <img src="/assets/food2.jpg">

            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package B - Family Feast</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A balanced meal with 2 appetizers, 3 main courses, 2 desserts, and drinks. Ideal for family celebrations. (Serves 10-15 people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div>

        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <img src="/assets/food3.jpg">

            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package C - Grand Banquet</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A lavish spread featuring 3 appetizers, 4 main courses, 3 desserts, and unlimited drinks. Great for large events. (Serves 20+ people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div> -->
        
        <!-- SECOND STYLE OPTION -->
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="/assets/food1.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package A - Classic Delight</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">Includes 1 appetizer, 2 main courses, 1 dessert, and drinks. Perfect for small gatherings.</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400"> (Serves 5-10 people)</p>
            <button @click="emit('openModal')" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show Details
            </button>
            
        </div>
        
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="/assets/food2.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package B - Family Feast</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A balanced meal with 2 appetizers, 3 main courses, 2 desserts, and drinks. Ideal for family celebrations. </p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400"> (Serves 10-15 people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show Details
            </button>
        </div>
        
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="/assets/food3.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package C - Grand Banquet</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A lavish spread featuring 3 appetizers, 4 main courses, 3 desserts, and unlimited drinks. Great for large events. (Serves 20+ people)</p>
            
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show Details
            </button>
        </div>

        
    </div>

    <div class="showallholder flex justify-center mt-3">
        <router-link to="/menu-all" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5  inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
            Show All
        </router-link>
    </div>

</template>