<script setup>
import AOS from 'aos'
import { onMounted } from 'vue'

onMounted(() => {
  AOS.init()
})
</script>

<template>
  <div class="p-7">
    <div class="max-w-xl mx-auto text-center px-3 pb-10 sm:pb-7">
      
      <div class="text-[#3f3d56] text-2xl md:text-3xl font-semibold mb-4" data-aos="fade-down">Some great companies offering jobs on our platform.</div>
      
      <div data-aos="fade" data-aos-delay="250" data-aos-duration="1000">
        <div class="text-6xl md:text-7xl text-slate-300 mx-3 inline-block"><i class="la la-apple"></i></div>
        
        <div class="text-6xl md:text-7xl text-slate-300 mx-3 inline-block"><i class="la la-google"></i></div>
        
        <div class="text-6xl md:text-7xl text-slate-300 mx-3 inline-block"><i class="la la-amazon"></i></div>
        
        <div class="text-6xl md:text-7xl text-slate-300 mx-3 inline-block"><i class="la la-facebook-square"></i></div>
        
        <div class="text-6xl md:text-7xl text-slate-300 mx-3 inline-block"><i class="lab la-salesforce"></i></div>
        
        <div class="text-6xl md:text-7xl text-slate-300 mx-3 inline-block"><i class="lab la-adobe"></i></div>
        
        <div class="text-6xl md:text-7xl text-slate-300 mx-3 inline-block"><i class="lab la-airbnb"></i></div>
      </div>
      
    </div>
  </div>
</template>