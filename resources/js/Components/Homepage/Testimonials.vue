<script setup>
import { ref, onMounted } from 'vue'
import AOS from 'aos'

//Note: testiminials text copied from the internet
const testimos = ref([
  { no: '1', name: 'Mike Epps', company: 'HR Manager, StarTech', msg: 'Great platform for posting jobs and it is very easy to do so. Also have had good luck finding candidates for jobs.' },
  { no: '2', name: 'MK MilkyWay', company: 'Tech Lead, ArtisticLogic', msg:'Overall, Remotech is super easy to use and user friendly. I love that they were able to offer me specific choices of what I companies that I wanted to work for.' },
  { no: '3', name: 'Joe Wood', company: 'Support Manager, Facebook', msg: 'This is hands down my favorite job platform available. The ease of use, and the exclusive tools it has to help job applicants are unrivaled.' }
])

const selected = ref(testimos.value[1])

onMounted(() => {
  AOS.init()
})
</script>

<template>
  <div class="relative overflow-hidden max-w-6xl mx-auto">
    
    <div class="w-full h-full absolute">
      <div class="drop bottom-12 left-14 h-28 w-28 scale-50 opacity-60 bg-gradient-to-r from-sky-300 to-teal-300"></div>
      <div class="drop top-12 right-14 h-16 w-16 scale-50 opacity-60 bg-gradient-to-r from-sky-300 to-teal-300"></div>
    </div>
    
    <div class="w-full h-full absolute bg-white/[.34] backdrop-blur-[10px] backdrop-saturate-[171%]" data-aos="slide-left" data-aos-duration="1000">

      <div class="relative sm:static -left-24 -top-3 scale-[.7] sm:scale-100" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="600">
        <img src="/images/dove.svg" class="w-12 absolute left-20">
        <img src="/images/dove.svg" class="w-9 absolute left-14 top-10">
        <img src="/images/dove.svg" class="w-9 absolute left-20 top-9">
        <img src="/images/dove.svg" class="w-9 absolute left-10 top-7">
        <img src="/images/dove.svg" class="w-8 absolute left-8 top-16">
      </div>

      <img src="/images/dots_worldmap.png" class="w-[1000%] lg:w-4/6 mx-w-4xl mx-auto opacity-[.35]">
      
      <div>
        <img src="/images/dove_left.svg" class="w-16 absolute right-16 bottom-16">
        <img src="/images/dove_left.svg" class="w-12 absolute right-14 bottom-10">
        <img src="/images/dove_left.svg" class="w-12 absolute right-20 bottom-9">
        <img src="/images/dove_left.svg" class="w-12 absolute right-10 bottom-7">
        <img src="/images/dove_left.svg" class="w-11 absolute right-8 bottom-16">
      </div>
      
    </div>
    
    <div class="h-full w-full relative px-3 py-10">
      
      <div class="text-[#3f3d56] text-3xl md:text-4xl font-bold text-center mb-2" data-aos="slide-down">
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-500 to-teal-500">Reviews</span> from Satisfied Clients
      </div>
      
      <div data-aos="zoom-in" data-aos-delay="300">
        <div class="flex justify-center items-center sm:max-w-lg md:max-w-xl mx-auto">
          <div class="text-5xl sm:text-7xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-sky-500 -mb-6 mr-2">“</div>

          <div class="bg-white rounded-2xl p-3 sm:p-5 border text-base text-center shadow-lg text-[#3f3d56]/80">
            <p>{{selected.msg}}</p>
            <p class="font-semibold text-[#3f3d56]/90 mt-2 text-sm">{{selected.name}}</p>
            <p class="text-sm">{{selected.company}}</p>
          </div>

          <div class="text-5xl sm:text-7xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-500 to-sky-500 -mb-6 ml-2">”</div>
        </div>
        
        <div class="flex justify-center items-center mt-4 h-12">
          
          <img src="/images/reviews/p1.jpg" class="w-8 rounded-full inline-block mx-1 border-4 border-transparent cursor-pointer" :class="{'border-sky-400 w-12 shadow-lg': selected.no == '1'}" @click="selected = testimos[0]">

        
          <img src="/images/reviews/p2.png" class="w-8 rounded-full inline-block mx-1 border-4 border-transparent cursor-pointer" :class="{'border-sky-400 w-12 shadow-lg': selected.no == '2'}" @click="selected = testimos[1]">
        

          <img src="/images/reviews/p3.png" class="w-8 rounded-full inline-block mx-1 border-4 border-transparent cursor-pointer" :class="{'border-sky-400 w-12 shadow-lg': selected.no == '3'}" @click="selected = testimos[2]">
          
        </div>
      </div>

    </div>

  </div>
</template>