<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import AOS from 'aos'
import { onMounted } from 'vue'

defineProps({
  canLogin: Boolean,
  canRegister: Boolean
})

const search = useForm({
  kw: ''
})

onMounted(() => {
  AOS.init({
    offset: 120
  })
})
</script>

<template>
  
  <header class="relative hio-96">
     
     <div class="w-full h-full absolute bg-gradient-to-br from-sky-600 to-teal-600">
       <div class="drop top-[10%] left-[20%] h-24 w-24"></div>
       <div class="drop right-[10%] bottom-[5%] h-24 w-28"></div>
       <div class="drop bg-gradient-to-br from-sky-600 to-teal-600 top-[2%] right-[27%] h-20 w-16"></div>
       <div class="drop bottom-[10%] left-[5%] h-12 w-12"></div>
       <div class="drop bottom-[30%] left-[40%] h-12 w-10"></div>
     </div>
     
    
    <div class="w-full h-full absolute bg-white/[.34] backdrop-blur-[10px] backdrop-saturate-[171%]">
      <div class="drop top-32 left-4 h-20 w-16 scale-50 opacity-30 md:opacity-60"></div>
      <div class="drop top-52 left-9 h-16 w-16 opacity-30 md:opacity-60"></div>
      <div class="drop bottom-[25%] right-7 h-12 w-16 scale-75 opacity-30 md:opacity-60"></div>
      <div class="drop top-[0%] left-[40%] h-14 w-10 scale-50 opacity-30 md:opacity-60"></div>
      
      <img src="/images/waves1.svg" alt="waves.svg" class="absolute bottom-0 rotate-[180deg] opacity-20">
      <img src="/images/waves2.svg" alt="waves.svg" class="absolute bottom-0 roate-[180deg] h-1h0 -mb- lg:-mb-3 w-full">
    </div>
    
    
    <div class="h-full w-full relative px-2 sm:px-3">
      
      <div class="mx-auto">
        
        <nav class="max-w-7xl mx-auto flex flex-wrap items-center justify-between text-white/90 py-3 w-full text-center">
        
          <div class="text-3xl md:text-4xl font-semibold leading-[0] mb-3" data-aos="fade-right">
            <i class="la la-wifi"></i>Remotech
          </div>
          
          <div
          class="relative group"
            v-if="$page.props.auth.user"
            data-aos="fade-left"
          >
            <div>
              <img v-if="$page.props.auth.user.logo" :src="$page.props.auth.user.logo" class="w-9 rounded-full hover:border"/>

              <div v-else class="inline-flex items-center justify-center rounded-full w-9 h-9 bg-gray-100 text-xl text-gray-400/80 font-semibold capitalize">{{$page.props.auth.user.name.charAt(0)}}</div>
            </div>


            <div class="absolute top-full right-0 w-52 rounded-md mt-1 bg-white/[.20] backdrop-blur-[10px] scale-y-0 group-hover:scale-y-100 origin-top text-left font-semibold text-sm">
            <div class="px-3 py-1.5">
                <span>Email</span>
                <br/>
                <span class="font-normal">{{$page.props.auth.user.email}}</span>
              </div>
              <Link :href="route('dashboard')" class="border-t border-white/20 flex items-center px-3 py-1.5 cursor-pointer hover:bg-black/5">
                <i class="la la-chalkboard text-xl mr-3.5"></i> Job Board
              </Link>
              <Link :href="route('logoutInHome')" class="border-t border-white/20 flex items-center px-3 py-1.5 cursor-pointer hover:bg-black/5">
                <i class="la la-door-open text-xl mr-3.5"></i> Logout
              </Link>
            </div>
          </div>

          
          <div class="text-base mb-3" data-aos="fade-left" v-else>
            <Link v-if="canLogin" :href="route('login')"><button class="rounded border border-white px-3 py-1 font-semibold hover:bg-white/[.20] mr-1.5 sm:mr-3">Login</button></Link>
            <Link v-if="canRegister" :href="route('register')"><button class="rounded border border-white px-3 py-1 font-semibold hover:bg-white/[.20]">Sign Up</button></Link>
          </div>
          
        </nav>
        
        
        <div class="max-w-4xl mx-auto sm:flex items-center justify-center py-3">
          
          <div class="mr-3 mt-4 sm:mt-0" data-aos="fade-right" data-aos-delay="500">
            <h1 class="font-bold text-white/[.67] text-4xl md:text-5xl mb-3">Get the tech remote job you dream of.</h1>
            <p class="text-lg md:text-xl text-white/90 mb-3">Remotech offers a platform for finding the best and suitable tech jobs, posted here by tech companies from all around the globe.</p>
            <Link :href="route('dashboard')">
              <button class="rounded border border-white/60 text-white font-bold text-base opacity-[.85] px-3 py-1 hover:bg-white/25 active:bg-transparent mr-2">Find Job</button>
            </Link>
            <Link :href="route('createJob')">
              <button class="rounded border border-white/60 text-white font-bold text-base opacity-[.85] px-3 py-1 hover:bg-white/25 active:bg-transparent">Post a Job</button>
            </Link>
          </div>
          
          <div class="mt-5 sm:mt-0" data-aos="zoom-in" data-aos-delay="700">
            <img src="/images/proud.svg" class="w-[70%] mx-auto sm:w-auto">
          </div>
          
        </div>
        
        <!--search-->
        <div class="text-center pb-11 lg:pb-8" data-aos="zoom-in-up" data-aos-delay="1000">
          <div class="text-white/[.69] font-semibold text-3xl md:text-4xl mb-2.5">
            What job are you looking for?
          </div>
          
          <div class="max-w-[95%] sm:max-w-lg mx-auto rounded-full bg-white/20 border border-white/25 p-2">
            <form @submit.prevent="search.get(route('dashboard'))" class="flex justify-center w-full text-base">
              <input type="search" class="grow rounded-l-full py-2 px-3 text-zinc-500 border-none" v-model="search.kw" placeholder="Search on job title, company, skills...">
              <button type="submit" class="rounded-r-full py-2 pl-2 pr-4 font-semibold bg-gradient-to-br to-sky-400 from-teal-400 hover:to-teal-400 hover:from-sky-400 text-white">
                <i class="la la-search"></i> <span class="hidden sm:inline-block">Search</span>
              </button>
            </form >
          </div>
          
        </div>
        
      </div>
    </div>
    
  </header>
  
</template>