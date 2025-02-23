<script setup>
   import Navbar1 from './landingfolder/Navbar1.vue';
   import Hero_Section from './landingfolder/Hero_section.vue';
   import Menu_Section from './landingfolder/Menu_section.vue';
   import Menu_modal from './landingfolder/Menu_modal.vue';
   import Whychooseus_Section from './landingfolder/Whychooseus_section.vue';
   import Rating_Section from './landingfolder/Rating_section.vue';
   import Aboutus_Section from './landingfolder/Aboutus_section.vue';
   import Footer1 from './landingfolder/Footer1.vue';

   import { ref } from "vue";

   const showModal = ref(false);

   const openModal = () => showModal.value = true;
   const closeModal = () => showModal.value = false;

</script>

<template>
   <Navbar1></Navbar1>
   <Hero_Section></Hero_Section>
   <Menu_Section @openModal="openModal" ></Menu_Section>
   <Menu_modal :showModal = "showModal" @closeModal="closeModal"></Menu_modal>
   <Whychooseus_Section></Whychooseus_Section>
   <Rating_Section></Rating_Section>
   <Aboutus_Section></Aboutus_Section>
   <Footer1></Footer1>     

</template>

<style>
   
</style>
