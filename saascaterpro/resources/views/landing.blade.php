<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" /> 
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    

    <nav class="bg-red-500 border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex justify-between items-center p-4 mx-auto">
          
          <a href="#" class="flex items-center space-x-3">
              <img src="./images/saaslogo.png" class="h-12" alt="Saas Logo" />
              <!-- <span class="text-2xl font-semibold whitespace-nowrap dark:text-white">Saas - Food and Catering</span> -->
          </a>
    
          
          <div class="hidden md:flex space-x-8">
            <a href="#" class="text-white hover:text-blue-700 dark:text-white dark:hover:text-blue-500">Home</a>
            <a href="#" class="text-white hover:text-blue-700 dark:text-white dark:hover:text-blue-500">About Us</a>
            <a href="#" class="text-white hover:text-blue-700 dark:text-white dark:hover:text-blue-500">Menu</a>
          </div>
    
          
          <div class="w-12 flex items-center justify-center">
            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
              <path d="M351.9 329.506H206.81l-3.072-12.56H368.16l26.63-116.019-217.23-26.04-9.952-58.09h-50.4v21.946h31.894l35.233 191.246a32.927 32.927 0 1 0 36.363 21.462h100.244a32.825 32.825 0 1 0 30.957-21.945zM181.427 197.45l186.51 22.358-17.258 75.195H198.917z"/>
            </svg>
          </div>
    
        </div>
    </nav>

    

    <section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('./images/sectionhero.jpg'); min-height: 100vh;">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div> 
        <div class="relative z-10 py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <h1 class="text-8xl font-normal tracking-tight leading-tight text-white md:text-[16rem] lg:text-[24rem]">
                SAAS
            </h1>
            <p class="mb-4 text-lg font-medium tracking-tight leading-snug text-white md:text-2xl lg:text-3xl">
                CATERING AND FOOD SERVICES
            </p>
            <p class="mb-4 text-lg font-medium tracking-tight leading-snug text-white md:text-2xl lg:text-3xl">
                Offers an exquisite goodness taste of Halal Cuisine
            </p>
            
        </div>
    </section>

    <div class="cardholder flex p-4 mt-5 justify-center gap-4 ">
        
        <!-- FIRST STYLE OPTION -->
        <!-- <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <img src="./images/food1.jpg">

            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package A - Classic Delight</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">Includes 1 appetizer, 2 main courses, 1 dessert, and drinks. Perfect for small gatherings. (Serves 5-10 people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div>

        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <img src="./images/food2.jpg">

            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package B - Family Feast</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A balanced meal with 2 appetizers, 3 main courses, 2 desserts, and drinks. Ideal for family celebrations. (Serves 10-15 people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div>

        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <img src="./images/food3.jpg">

            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package C - Grand Banquet</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A lavish spread featuring 3 appetizers, 4 main courses, 3 desserts, and unlimited drinks. Great for large events. (Serves 20+ people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div> -->
       
        <!-- SECOND STYLE OPTION -->
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="./images/food1.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package A - Classic Delight</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">Includes 1 appetizer, 2 main courses, 1 dessert, and drinks. Perfect for small gatherings. (Serves 5-10 people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div>
        
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="./images/food2.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package B - Family Feast</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A balanced meal with 2 appetizers, 3 main courses, 2 desserts, and drinks. Ideal for family celebrations. (Serves 10-15 people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div>
        
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="./images/food3.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package C - Grand Banquet</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A lavish spread featuring 3 appetizers, 4 main courses, 3 desserts, and unlimited drinks. Great for large events. (Serves 20+ people)</p>
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show full information
            </button>
        </div>

        
    </div>

    <div class="showallholder flex justify-center mb-10">
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5  inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
            Show All
        </button>
    </div>

    <section class="flex pt-16 pb-16 pl-10 mb-10 flex-col items-center justify-center text-center bg-white min-h-screen ">
        <div class="max-w-xl">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-6">About Us</h2>
            <p class="text-lg text-gray-700 leading-relaxed ">
                Welcome to <span class="font-semibold text-blue-600">SaasCaterPro</span>, your premier choice for exquisite food catering services. 
                With a passion for flavors and a commitment to excellence, we specialize in crafting delicious, high-quality meals 
                tailored to your events. Whether it's a wedding, corporate gathering, or private party, our team ensures an 
                unforgettable dining experience. Let us bring the perfect taste to your special occasions!
            </p>
            
        </div>
    </section>

    
    

<footer class="bg-white rounded-lg shadow-sm dark:bg-gray-900 mt-8 pt-16">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="holder flex items-center">

                <img src="./images/saaslogo.png" class="h-12">
                <span class=" text-2xl font-semibold whitespace-nowrap dark:text-white">Saas - Catering and Food Services</span>
               
            </div>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025. All Rights Reserved.</span>
    </div>
</footer>


    
    
    


    
    

    
      


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>
</html>