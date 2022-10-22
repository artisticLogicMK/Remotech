<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

defineProps({
  errors: Object
})

const sub = useForm({
  email: ''
})
</script>

<template>
  <footer>
    <div class="relative bg-gradient-to-b to-[#282736] from-[#3f3d56] py-10">
      <img src="/images/footcurve.svg" class="h-5 w-full absolute top-0">
      
      <div class="max-w-xl mx-auto">
        
        <div class="absolute -top-10 sm:-top-5 left-0 w-full text-center" data-aos="zoom-in">
          <div class="inine-block sm:inline-flex flex-wrap items-center justify-center rounded-lg sm:rounded-full bg-white py-3 px-3 shadow-lg border w-11/12 sm:w-auto mx-auto">
            <div class="text-xl md:text-2xl text-[#3f3d56] font-semibold mb-1 sm:mb-0 mr-2">
              Want to Catch All
              <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-500 to-teal-500">Job News?</span>
            </div>
            <div class="inlne-block rounded-full text-base border">
              <form class="flex" @submit.prevent="sub.post(route('subscribe'))">
                <input type="email" v-model="sub.email" class="border-none px-2.5 py-1.5 rounded-l-full text-gray-500 w-[220px] sm:w-auto grow" placeholder="Your email...">
                <button type="submit" class="py-1.5 px-3 sm:px-2 font-semibold text-white/90 bg-sky-400 rounded-r-full">
                  <i class="la la-send text-2xl -rotate-45 sm:hidden"></i>
                  <span class="hidden sm:inline-block">Subscribe</span>
                </button>
              </form>
            </div>
          </div>
        </div>

        <div class="text-base text-red-400 text-center mt-8 sm:mt-3" :class="{'text-green-400': $page.props.errors.sent}" v-if="$page.props.errors">{{$page.props.errors.email ?? $page.props.errors.sent}}</div>
        
        <div class="pt-8 pb-2 text-center" data-aos="fade-up" data-aos-delay="250">
          <div class="text-4xl font-semibold text-white/95 mb-3"><i class="la la-wifi text-4xl"></i>Remotech</div>
          
          <div class="text-white/95 text-base inline-block mb-3">
            <Link :href="route('dashboard')" class="mx-2 hover:underline">Find Jobs</Link>
            <Link :href="route('login')" class="mx-2 hover:underline" v-if="!$page.props.auth.user">Login</Link>
            <Link :href="route('register')" class="mx-2 hover:underline" v-if="!$page.props.auth.user">Sign Up</Link>            
          </div>
          
          <div class="text-white/95 text-xl">
            <a class="border border-white/95 w-8 h-8 rounded-full inline-block mx-2 pt-0.5 hover:bg-white/20 cursor-pointer">
              <i class="la la-twitter inline-block"></i>
            </a>
            <a class="border border-white/95 w-8 h-8 rounded-full inline-block mx-2 pt-0.5 hover:bg-white/20 cursor-pointer">
              <i class="la la-facebook inline-block"></i>
            </a>
            <a class="border border-white/95 w-8 h-8 rounded-full inline-block mx-2 pt-0.5 hover:bg-white/20 cursor-pointer">
              <i class="la la-linkedin inline-block"></i>
            </a>
          </div>

          <div class="text-sm text-white text-center underline pt-2">
            <a href="https://artisticlogicmk.one" target="_blank" class="mr-2.5">
              <i class="la la-globe"></i> ArtisticLogicMK
            </a>
            <a href="https://github.com/artisticLogicMK/Remotech" target="_blank">
              <i class="la la-github"></i> See code at Github 
            </a>
          </div>
        </div>
        
      </div>
    </div>
  </footer>
</template>