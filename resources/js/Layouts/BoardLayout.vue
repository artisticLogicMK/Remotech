<script setup>
import { computed, onMounted, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

const params = new URLSearchParams(window.location.search)

let viewBookmarks = () => {
  Inertia.visit('/board', {
    method: 'get',
    data: { bk: localStorage.getItem('bookmarks') },
  })
}

const flashes = computed(() => usePage().props.value.flashes)

const flash = ref(false)

onMounted(() => {
  flash.value = true
  setTimeout(() => flash.value = false, 5000)
})
</script>

<template>

  <Transition
    enter-active-class="animate__animated animate__slideInUp animate__fast"
    leave-active-class="animate__animated animate__fadeOutDown animate__fast"
  >
    <div class="absolute w-full text-center z-10 bottom-[25%]" v-if="flash && flashes">
      <div
        class="shadow-md rounded-md text-sm px-3 py-1.5 inline-block"
        :class="flashes.type == 'success' ? 'bg-gradient-to-br from-sky-400 to-teal-400 text-white' : 'bg-red-50 border border-red-400 text-red-500'"
      >
        {{flashes.msg}}
      </div>
    </div>
  </Transition>



  <div class="flex w-full h-screen items-stretch">
    
    <div
      class="fixed w-full h-full bg-white/[.14] backdrop-blur-[3px] backdrop-saturate-[171%] z-10"
      :class="$store.state.menuToggle ? 'block sm:hidden' : 'hidden'"
      @click="$store.commit('toggleMenu')"
    >
    </div>
    
    <!--menu nav-->
    <nav
      class="bg-gradient-to-br from-sky-400 to-teal-400 shrink-0 w-[200px] sm:w-auto lg:w-[200px] xl:w-2/12 max-w-xs p-4 py-2 sm:px-0 lg:p-4 z-10"
      :class="$store.state.menuToggle ? 'block fixed w-[240px] h-screen sm:static sm:w-auto sm:h-auto shadow-2xl sm:shadow-none' : 'hidden sm:block'"
    >
      <div class="flex flex-col h-full overflow-y-auto">
        <div class="grow">
          
          <div class="hidden sm:hidden text-right z-10">
            <i class="la la-times text-3xl text-white/90" @click="$store.commit('toggleMenu')"></i>
          </div>
          
          <Link
          :href="route('info')"
            class="tabs"
            :class="{'active': $page.component == 'CompanyInfo'}"
            v-if="$page.props.auth.user"
            @click="$store.commit('toggleMenu');$store.commit('toggleInfoPanel', false)"
          >
            <img v-if="$page.props.auth.user.logo" :src="$page.props.auth.user.logo" class="bg-gray-50 rounded-full w-10 mr-2 sm:mr-0 lg:mr-2">

            <div v-else class="shrink-0 inline-flex items-center justify-center rounded-full w-10 h-10 mr-2 sm:mr-0 lg:mr-2 bg-gray-100 text-xl text-gray-400/80 font-semibold capitalize">{{$page.props.auth.user.name.charAt(0)}}</div>

            <div class="grow truncate text-white/95 text-base sm:hidden lg:inline-block font-semibold">
               {{$page.props.auth.user.name}}
            </div>
          </Link>
  
  
          <!--tabs-->
          <div class="mt-10 md:mt-14 text-white/90">
            <Link
              :href="route('dashboard')"
              class="tabs act"
              :class="{'active': $page.component == 'Dashboard' && !params.get('bk')}"
              @click="$store.commit('toggleMenu');$store.commit('toggleInfoPanel', false)"
            >
              <i class="la la-home"></i>
              <span>Home</span>
            </Link>
  

            <Link
              :href="route('listings')"
              class="tabs act"
              :class="{'active': $page.component == 'Listings' || $page.component == 'Editjob'}"
              v-if="$page.props.auth.user"
              @click="$store.commit('toggleMenu');$store.commit('toggleInfoPanel', false)"
            >
              <i class="la la-clipboard"></i>
              <span>Job Listings</span>
            </Link>
  
            <Link
              :href="route('createJob')"
              class="tabs act"
              :class="{'active': $page.component == 'Postjob'}"
              @click="$store.commit('toggleMenu');$store.commit('toggleInfoPanel', false)"
            >
              <i class="la la-edit"></i>
              <span>Post a Job</span>
            </Link>
  

            <div
              class="tabs act"
              @click.stop="$store.commit('toggleMenu');viewBookmarks();$store.commit('toggleInfoPanel', false)"
              :class="{'active': params.get('bk')}"
            >
              <i class="la la-bookmark"></i>
              <span>Bookmarks</span>
            </div>
          </div>
        </div>
  

        <div class="text-white/90">
          <Link
            :href="route('logout')"
            class="tabs act"
            v-if="$page.props.auth.user"
            @click="$store.commit('toggleMenu');$store.commit('toggleInfoPanel', false)"
          >
            <i class="la la-door-open"></i>
            <span>Logout</span>
          </Link>
          
          <Link
            :href="route('login')"
            class="tabs act"
            v-else
            @click="$store.commit('toggleMenu');$store.commit('toggleInfoPanel', false)"
          >
            <i class="la la-door-open"></i>
            <span>Login</span>
          </Link>
        </div>
      </div>
    </nav>
      
    <slot />
      
  </div>
</template>