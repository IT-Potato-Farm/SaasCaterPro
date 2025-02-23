

<template>
    <div>


        <section class="bg-red-100 dark:bg-gray-900 min-h-screen">
            
            <div class="flex flex-col items-center justify-center px-0   py-8 mx-auto  lg:py-3 relative top-15">
                <img src="/assets/saaslogo.png" class="absolute bottom-110 w-30">
                
                <div class="w-96 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8 relative">
                        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
                            <h1 class="text-3xl font-bold   text-gray-900 md:text-l dark:text-white">
                        
                                Welcome Back!  
                            </h1>
    
    
                        </div>
                        <h1 class="text-xl font-normal leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white ">
                            Login your account
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="#">
                           
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Address</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com">
                            </div>   
                            <div class="mb-0">
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                            
                            <div class="flex justify-end">
                                <a class=" font-light text-gray-500 dark:text-gray-300  text-primary-600 hover:underline dark:text-primary-500" href="#">Forgot password</a>
                            </div>
                            <button type="submit" class="w-full text-white bg-pink-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">Login</button>
                            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                Don't have an account? <router-link to="/register" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up here</router-link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        
    </div>


</template>