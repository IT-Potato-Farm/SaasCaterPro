<script setup>
    import Navbar1 from './landingfolder/Navbar1.vue';
</script>

<template>

    <Navbar1></Navbar1>

    <div class="titleholder flex items-center gap-5 pt-10 pl-20 pr-15 pb-5">
                <span class="text-3xl font-normal">SAAS |</span>
                <span class="text-2xl">Checkout</span>

    </div>
    <div class="block w-full max-w-9/10 p-6 bg-white border border-gray-200 rounded-sm shadow-sm dark:bg-gray-800 dark:border-gray-700 mx-auto">
                <p class="text-xl inline-block font-medium mb-5">Booking Address</p>
                
                <div class="flex justify-between">
                    <div class="left flex gap-20">
                        <div class="customer">
                            <p class="font-medium">Kendrick Serrano</p>
                            <p class="font-medium">(63)9895679894</p>

                        </div>
                        <div class="location">
                            <p>Social Hall, Western Mindano State University,<br> Normal Road, Baliwasan, Zamboanga City, 7000</p>

                        </div>

                    </div>

                    <div class="right">
                        <button class=" text-white bg-gray-400 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-sm text-sm px-10 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">Change</button>

                    </div>

                   
                </div>
    </div>            

    <div class="holder pb-20 mt-10 relative">
        

        <div class="block w-full max-w-9/10 p-6 bg-white border border-gray-200 rounded-sm shadow-sm dark:bg-gray-800 dark:border-gray-700 mx-auto">
            <div class="toppart flex justify-between pr-5 pb-5">
                <div class="left">
                    <p class="text-xl">Cater Orders</p>
                    
                </div>

                <div class="right flex gap-20">
                    <span class="text-xl font-thin">Price</span>
                    <span class="text-xl font-thin">Quantity</span>
                    <span class="text-xl font-thin">Subtotal</span>
                
                </div>
            </div>

            <hr>

            <div class="holderone flex items-center gap-5 pt-5 pb-3">
                <span class="text-lg font-normal">Product Details |</span>
                <span class="text-lg">Chat now</span>
  
            </div>

            <div class="holdertwo flex mb-4">
                <div class="left">
                    <img src="/assets/Ultimatepackage.png" class="w-24">
                </div>

                <div class="right grow-3 pl-5">

                    
                    <div class="lowerpart flex justify-between ">
                        <div class="left flex gap-10">
                            <p class="font-medium">Ultimate Package</p>
                            <p class="font-light">Variation: Duo1-Chicken</p>

                        </div>

                        <div class="right flex gap-35">
                            <p class="font-medium">P700</p>
                            <p class="font-medium">1</p>
                            <p class="font-medium">P700</p>

                        </div>

                     

                        
                    </div>
                    
                    
                </div>
                
                
                
            </div>
            
            <hr class="mb-25">

        
            <button type="submit" class="absolute bottom-30 right-25 text-white bg-pink-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-sm text-sm px-10 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Book</button>

        </div>



    </div>

</template>