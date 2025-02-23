<template>
    <div>
        <nav class="bg-red-600 border-gray-200 dark:bg-gray-900">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                    <a href="#" class="flex items-center space-x-3">
                        <img src="/assets/saaslogo.png" class="h-12" alt="Saas Logo" />
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
    
</template>

<script>
export default {
    methods: {
        scrollToSection(id) {
            const element = document.getElementById(id);
            if (element) {
                const targetPos = element.getBoundingClientRect().top + window.scrollY; // updated
                const startPos = window.scrollY; // updated
                const distance = targetPos - startPos;
                const duration = 600; // ms
                let startTime = null;
                function easeInOutQuad(t) { 
                    return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t; 
                }
                function animate(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    const timeElapsed = currentTime - startTime;
                    const progress = Math.min(timeElapsed / duration, 1);
                    const easing = easeInOutQuad(progress);
                    window.scrollTo(0, startPos + distance * easing);
                    if (timeElapsed < duration) {
                        requestAnimationFrame(animate);
                    }
                }
                requestAnimationFrame(animate);
            }
        }
    }
}
</script>