@extends('layouts.default')

@section('title')
Landing Page
@endsection

@section('header')
    <div>
        <nav class="bg-red-600 border-gray-200 dark:bg-gray-900">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                    <a href="#" class="flex items-center space-x-3">
                        <img src="../images/saaslogo.png" class="h-12" alt="Saas Logo" />
                        <span class="text-2xl font-semibold whitespace-nowrap  text-white dark:text-white">SaasCaterPro</span>
                    </a>
                <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
                
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                    <ul class="font-medium flex flex-col items-center p-4 md:p-0 mt-4 border border-green-100 rounded-lg bg-red-600 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-red-600 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <router-link to="/" class="block py-2 px-3  text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-amber-300 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</router-link>
                    </li>
                    <li>
                        <a href="#" @click.prevent="scrollToSection('aboutus')" class="block py-2 px-3  text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-amber-300 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">About Us</a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="scrollToSection('menu')" class="block py-2 px-3 text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-amber-300 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Menu</a>
                    </li>
                    <li>
                        <router-link to="/cart" class="flex items-center space-x-2 text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">
                            Cart  
                            <svg class="w-6 h-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                <path d="M351.9 329.506H206.81l-3.072-12.56H368.16l26.63-116.019-217.23-26.04-9.952-58.09h-50.4v21.946h31.894l35.233 191.246a32.927 32.927 0 1 0 36.363 21.462h100.244a32.825 32.825 0 1 0 30.957-21.945zM181.427 197.45l186.51 22.358-17.258 75.195H198.917z"/>
                            </svg>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/login" class="text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">
                            Login
                        </router-link>
                    </li>
    
    
                    </ul>
                </div>
                </div>
            </nav>

    </div>
@endsection

@section('maincontent')
    <section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('../images/sectionhero.jpg');  min-height: 100vh;">
            <div class="absolute   bg-black bg-opacity-50"></div> 
            <div class="relative z-10  px-4 mx-auto max-w-screen-xl text-center lg:py-16">
                <h1 class="text-8xl font-normal tracking-tight  text-white md:text-[16rem] lg:text-[14rem]">
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

    <h2 id="menu" class="text-center font-bold text-6xl mt-20">MENU</h2>
    <div class="cardholder flex p-4 mt-5 justify-center gap-8 ">
        
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="../images/food1.jpg" alt="" />
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
                <img class="rounded-t-lg" src="../images/food2.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package B - Family Feast</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A balanced meal with 2 appetizers, 3 main courses, 2 desserts, and drinks. Ideal for family celebrations. </p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400"> (Serves 10-15 people)</p>
            <button @click="emit('openModal')" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show Details
            </button>
        </div>
        
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="../images/food3.jpg" alt="" />
            </a>
            <p class="mt-5 ml-3 font-extrabold text-gray-700 dark:text-gray-400">Package C - Grand Banquet</p>
            <p class="mt-2 ml-3 font-normal text-gray-700 dark:text-gray-400">A lavish spread featuring 3 appetizers, 4 main courses, 3 desserts, and unlimited drinks. Great for large events. (Serves 20+ people)</p>
            
            <button @click="emit('openModal')" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-8 ml-3 inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
                Show Details
            </button>
        </div>

        
    </div>

    <div class="showallholder flex justify-center mt-3">
        <router-link to="/menu-all" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5  inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">  
            Show All
        </router-link>
    </div>

    <section class="flex pt-4 mt-30 flex-col items-center justify-center text-center bg-white ">
        <div class="max-w-3/4">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-6">WHY CHOOSE US</h2>
            <h3 class="text-5xl font-normal text-gray-900 mb-6">The all-in-one solution for effortless order tracking, and customer engagement services in Zamboanga City</h3>
            <p class="text-lg text-gray-700 leading-relaxed ">
                We are more than just your typical catering company at Saas, we committied to turning your visions into reality. Our goal is to help create an incomparable experience by going above and beyond through our food offerings,service, and styling that us tailored to your taste and budget without scriming on quality.
            </p>
            
        </div>
    </section>

    <div class="ratingcardholder flex p-4 mt-5 justify-center gap-8 min-h-[50vh] ">
            
            
            <div class="block max-w-sm p-6 h-48 w-65  bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center mb-2">
                    <img src="/src/assets/star.svg" class="h-8">
                </div>
               
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Consistent Customer Satisfaction</h5>
                
            </div>

            <div class="block max-w-sm p-6 h-48 w-65  bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center mb-2">
                    <img src="/src/assets/star.svg" class="h-8">
                </div>
               
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">High Quality Ingredient</h5>
                
            </div>

            <div class="block max-w-sm p-6 h-48 w-65  bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center mb-2">
                    <img src="/src/assets/star.svg" class="h-8">
                </div>
               
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Excellent Customer Service</h5>
                
            </div>

            <div class="block max-w-sm p-6 h-48 w-65  bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center mb-2">
                    <img src="/src/assets/star.svg" class="h-8">
                </div>
               
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Over 100 Delighted Dishes</h5>
                
            </div>

            <div class="block max-w-sm p-6 h-48 w-65  bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-center mb-2">
                    <img src="/src/assets/star.svg" class="h-8">
                </div>
               
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">Health And Safety Compliance</h5>
                
            </div>

        </div>

        <section id="aboutus" class="flex flex-col items-center justify-center text-center bg-white min-h-[50vh]">
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
@endsection    

@section('footer')

<div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="holder flex items-center">

                    <img src="../images/saaslogo.png" class="h-12">
                    <span class=" text-2xl font-semibold whitespace-nowrap dark:text-white">Saas - Catering and Food Services</span>
                  
                </div>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    
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

@endsection