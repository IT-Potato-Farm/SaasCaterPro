<script>

</script>

<template>
    <div class="bg-red-100 min-h-screen pb-20">
       <div class="bg-red-600 pt-5 py-5 pr-15 flex justify-end gap-10 ">
            <a href="#" class="text-white">Dashboard</a>
            <a href="#" class="text-white">Inbox</a>
            <a href="#" class="text-white">Calendars</a>
            <a href="#" class="text-white">Listing</a>
       </div>

       <div class="holder flex justify-between items-center p-10">
           <div class="left flex  justify-between items-center gap-10">
                <div class="a">
                    <img class="w-20 h-20 mb-3 rounded-full shadow-lg" src="/assets/pic.jpg" alt="Bonnie image"/>
                    
                </div>
                <div class="b">
                    <p class="font-medium text-xl">Good Morning</p>
                    <p class="font-light">Here's an overview of your properties</p>

                </div>

           </div>

           <div class="right flex gap-3">
                <button type="submit" class=" text-white bg-pink-600 hover:bg-primary-700  focus:outline-none font-normal rounded-full text-sm px-10 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">Back</button>

                <button type="submit" class=" text-white bg-pink-600 hover:bg-primary-700  focus:outline-none font-normal rounded-full text-sm px-10 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">Back</button>
            </div>
        </div>

       

       <div class="grid grid-cols-4 gap-4  pl-10 pr-10">
        <!-- First Row -->
            <div class="box1 flex flex-col gap-5 border-2 py-2 pl-5 pr-20 min-w-60 rounded-sm">
                <p class="font-normal">Complete Orders</p>
                <p class="font-normal">10</p>

            </div>

            <div class="box1 flex flex-col gap-5 border-2 py-2 pl-5 pr-20 min-w-60 rounded-sm">
                    <p class="font-normal">Total Revenue</p>
                    <p class="font-normal">4.5k</p>

            </div>

            <div class="box1 flex flex-col gap-5 border-2 py-2 pl-5 pr-20 min-w-60 rounded-sm">
                <p class="font-normal">Pending Orders</p>
                <p class="font-normal">3 orders</p>

            </div>

            <div class="box1 flex flex-col gap-5 border-2 py-2 pl-5 pr-20 min-w-60 rounded-sm">
                <p class="font-normal">Reviews</p>
                <p class="font-normal">4.5</p>

            </div>

            <!-- Second Row -->
            <div class="box1 flex flex-col justify-end border-2 py-2 pl-5 pr-20 mt-10 min-w-60 rounded-sm">
                <img src="/src/assets/pen.svg" class="w-8 bg-white rounded-sm p-2 mb-3">
                <div class=" text-base font-normal dark:text-white">Setup your calendar</div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
                    <div class="bg-red-600 h-1.5 rounded-full dark:bg-red-500" style="width: 65%"></div>
                </div>

            </div>
            <div class="box1 flex flex-col justify-end border-2 py-2 pl-5 pr-20 mt-10 min-w-60 rounded-sm">
                <img src="/src/assets/bitcoin.svg" class="w-8 rounded-sm mb-3">
                <div class=" text-base font-normal dark:text-white">Increase your bookings</div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
                    <div class="bg-purple-600 h-1.5 rounded-full dark:bg-purple-500" style="width: 45%"></div>
                </div>

            </div>
            <div class="box1 flex flex-col gap-5 border-2 py-2 pl-5 pr-20 mt-10 min-w-60 rounded-sm col-span-2  row-span-2">
                <div class="holder flex  justify-between w-full px-10 mb-3 pt-3">
                    <div>
                        <img src="/assets/food1.jpg" class="w-15 rounded-full">

                    </div>
                    <div>
                        <p class="font-medium text-xl">Kendrick Serrano</p>
                        <p class="font-normal">3h Ago Social Hall, Wmsu</p>
                        <button type="submit" class=" text-white bg-pink-600 hover:bg-primary-700  focus:outline-none font-normal rounded-sm text-sm px-2.5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">Order Details</button>

                    </div>

                    <div>
                        <p class="font-normal">P700.00</p>

                    </div>
                </div>

                <div class="holder flex justify-between w-full px-10 mb-3">
                    <div>
                        <img src="/assets/food1.jpg" class="w-15 rounded-full">

                    </div>
                    <div>
                        <p class="font-medium text-xl">Kendrick Serrano</p>
                        <p class="font-normal">3h Ago Social Hall, Wmsu</p>
                        <button type="submit" class=" text-white bg-pink-600 hover:bg-primary-700  focus:outline-none font-normal rounded-sm text-sm px-2.5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">Order Details</button>

                    </div>

                    <div>
                        <p class="font-normal">P700.00</p>

                    </div>
                </div>

                <div class="holder flex justify-between w-full px-10 mb-3">
                    <div>
                        <img src="/assets/food1.jpg" class="w-15 rounded-full">

                    </div>
                    <div>
                        <p class="font-medium text-xl">Kendrick Serrano</p>
                        <p class="font-normal">3h Ago Social Hall, Wmsu</p>
                        <button type="submit" class=" text-white bg-pink-600 hover:bg-primary-700  focus:outline-none font-normal rounded-sm text-sm px-2.5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 cursor-pointer">Order Details</button>

                    </div>

                    <div>
                        <p class="font-normal">P700.00</p>

                    </div>
                </div>


            </div>

            <!-- Third Row -->
            <div class="box1 flex flex-col gap-5   mt-20 min-w-60  col-span-2 ">
                <img src="/assets/produce_monthly.png" class="h-50 rounded-lg">


            </div>

</div>





    </div>



</template>