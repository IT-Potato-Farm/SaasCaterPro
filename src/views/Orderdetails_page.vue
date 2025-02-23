<script setup>
    import Navbar1 from './landingfolder/Navbar1.vue';
</script>

<template>
    <Navbar1></Navbar1>

    <div class="holder pb-20 relative">
        <div class="titleholder flex items-center gap-5 pt-10 pl-20 pr-15 pb-5">
            <span class="text-3xl font-normal">SAAS |</span>
            <span class="text-2xl">Order Details</span>

        </div>

        <div class="block w-full max-w-9/10 p-6 bg-white border border-gray-200 rounded-sm shadow-sm dark:bg-gray-800 dark:border-gray-700 mx-auto">
        <!-- <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5> -->
        <!-- <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> -->
            <div class="toppart flex justify-between pr-5 pb-5">
                <div class="left">
                    <p class="text-xl">Cater Orders</p>
                    
                </div>

                <div class="right flex gap-20">
                    <span class="text-xl font-thin">Quantity</span>
                    <span class="text-xl font-thin">Subtotal</span>
                    <span class="text-xl font-thin">Status</span>
                
                </div>
            </div>

            <hr>

            <div class="holderone flex items-center gap-5 pt-5 pb-3">
                <span class="text-lg font-normal">Product Details |</span>
                <span class="text-lg">Chat now</span>
  
            </div>

            <div class="holdertwo flex mb-4">
                <div class="right">
                    <img src="/assets/Ultimatepackage.png" class="w-24">
                </div>

                <div class="left grow-3 pl-5">

                    <div class="toppart flex gap-10 mb-4">
    
                        <div class="issuedholder">
                            <p class="font-medium">Issued:</p>
                            <p class="font-light text-sm">14 Feb, 2025,1:30 pm</p>
                            <p class="font-medium">Due</p>
                            <p class="font-light text-sm">16 Feb, 2025</p>
        
                        </div>
        
                        <div class="billedholder">
                            <p class="font-medium">Billed to</p>
                            <p class="font-light text-sm">Saas Catering and Food Services</p>
                            <p class="font-light text-sm">01 Ayer Village,Sta Barbara 7000</p>
                            <p class="font-light text-sm">Zamboanga City, Philippines</p>
                            <p class="font-light text-sm">(63)937662584903</p>
        
                        </div>
        
                        <div class="fromholder">
                            <p class="font-medium">From</p>
                            <p class="font-light text-sm">Kendrick Serrano</p>
                            <p class="font-light text-sm">Social Hall, Western Mindano State</p>
                            <p class="font-light text-sm">University, Normal Road, Baliwasan</p>
                            <p class="font-light text-sm">Zamboanga City</p>
                            <p class="font-light text-sm">(63)989567984</p>
        
                        </div>
                    </div>

                    <div class="lowerpart flex justify-between">
                        <div class="left flex gap-10">
                            <p class="font-medium">Ultimate Package</p>
                            <p class="font-light">Variation: Duo1-Chicken</p>

                        </div>

                        <div class="right flex gap-30">
                            <p class="font-medium">1</p>
                            <p class="font-medium">P700</p>
                            <p class="font-medium">Pending</p>

                        </div>

                     

                        
                    </div>
                    
                    
                </div>
                
                
                
            </div>
            
            <hr class="mb-4">

            <textarea cols="50" rows="5" placeholder="review"></textarea>


            <button type="submit" class="absolute bottom-30 right-50 text-white bg-pink-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-sm text-sm px-10 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Back</button>

        </div>



    </div>


</template>