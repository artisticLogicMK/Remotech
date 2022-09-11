<script setup>
import { ref, computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import moment from 'moment'
import { useTippy } from "vue-tippy/composition"
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  jobs: Object
})

useTippy('.target', {
    theme: 'custom',
    arrow: true
})

const store = useStore()

const params = new URLSearchParams(window.location.search)

//get search query params passed from backend
const q = computed(() => usePage().props.value.searchParams)

//intermediate var to store skills as computed() has no write access
const skills = q.value.skills

//search data to be sent to backend
const search = useForm({
  kw: q.value.keyword,
  sk: skills.join(' '),

  //search overides job view query param when set
  //so add job view query param along with search post
  jb: params.get('jb')
})

//function for appending query params to pagination links
const setLink = (data, url) => {
  if (url !== null) {
    Inertia.visit(url, {
      method: 'get',
      data: data
    })
  }
}

//the active pagination link
const active = props.jobs.links.filter(l => l.active)[0]

//the active job in view
const jobSelected = ref(null)

//method to scroll selected job to view
const jobToView = (id) => {
  if (document.getElementById('j'+id)) {
    document.getElementById('j'+id).scrollIntoView({block: "center"})
  }
}

//view job on click
const viewJob = (data, id) => {
  Inertia.visit('/board', {
    method: 'get',
    data: data,
    onFinish: visit => {
      jobToView(id)
      store.commit('toggleInfoPanel', true)
    }
  })
}

//state of skill filter dropdown
const skillDrop = ref(false)

//input for skill search
const skillinput = ref('')

//skill Push specifically. I hate repition
const skillPush = (value) => {
  if(!skills.includes(value) && value.length ) {
    skills.push(value) //add value to skills array
    search.sk = skills.join(' ') //update form data
  }
}

//populate serch when companyName or skill is clicked in jobs list
const popSearch = (val, ifSkill) => {
  if (ifSkill) {
    skillPush(val)
  } else {
    search.kw = val
  }

  document.getElementById('search').scrollIntoView()
}

//add a skill to search filter
const addSkill = (value) => {
  if (value.split(" ").length > 1 ? false : true) { //only one word allowed
    
    skillDrop.value = false //hide skill filter drop down
    
    //make sure this skill is not already in skill array
    skillPush(value)
  }
}

//remove a skill from search filter
const removeSkill = (skill) => {
  //get position of selected element in skills array
  let i = skills.indexOf(skill)
  
  //if the element is the first
  if (i == 0) {
    skills.shift()
  }
  //if
  else {
    skills.splice(i, i)
  }
  
  //then update form data with new skills array
  search.sk = skills.join(' ')
}

//remove all skills from search filter
const clearSkills = () => {
  skills.splice(0,skills.length)
  search.sk = '' //update search data
}

//clear search entirely
const clearSearch = () => {
  search.kw = ''
  search.sk = ''
  skills.splice(0,skills.length)
  
  //clear search query params from url
  window.location.search = ''
}

const time = (time) => {
    return moment(time).format('MMM Do, YYYY')
}

//store bookmarks here after save to indicate bookmark saved in job list
const bookmarked = ref([])

//we store bookmarks in localStorage
const bookmark = (id) => {
  let list = localStorage.getItem('bookmarks')
  if (list == null) {
    localStorage.setItem('bookmarks', `${id}`)
  } else {
    if (bookmarked.value.includes(id.toString())) {
      bookmarked.value = bookmarked.value.filter(b => b !== id.toString())
      localStorage.setItem('bookmarks', `${bookmarked.value.join(',')}`)
    } else {
      localStorage.setItem('bookmarks', `${list+','+id}`)
      bookmarked.value.push(id.toString())
    } 
  }
}

const notfound = ref(true)

onMounted(() => {
  //set selected job state
  jobSelected.value = params.get('jb') ?? (usePage().props.value.jobview ? usePage().props.value.jobview.id : null)

  //scroll active job into view after page load
  setTimeout(() => jobToView(jobSelected.value), 1500)

  //set bookmarked jobs
  let bk = localStorage.getItem('bookmarks')
  bookmarked.value = bk.split(',')

  //auto hide job not found alert after 4s
  setTimeout(() => notfound.value = false, 4000)
})
</script>

<template>

  <div
    class="grow bg-gray-100 p-3 px-2 sm:px-3 relative h-full overflow-y-auto"
    :class="$store.state.infoPanelOverlap ? 'hidden lg:block' : ''"
  >
    
    <div class="flex justify-between">
      <div class="text-3xl bg-clip-text text-transparent bg-gradient-to-r from-sky-500 to-teal-400 font-semibold mb-3">
        <Link :href="route('home')"><i class="la la-wifi text-sky-500"></i>Remotech</Link>
      </div>
      
      <div class="sm:hidden">
        <i class="la la-bars text-4xl text-sky-500 cursor-pointer" @click="$store.commit('toggleMenu')"></i>
      </div>
    </div>

    <!--search-->
    <form @submit.prevent="search.get(route('dashboard'))" id="search">
      <div class="flex flex-wrap">
        <div class="grow flex items-center rounded-md bg-white px-2 sm:px-4 mr-2 mb-1 border shadow-sm">
          <i class="la la-search text-sky-500 text-xl"></i>
          <input type="search" class="grow border-none ml-1.5 sm:ml-3 p-0 my-2 placeholder:italic text-gray-400 text-sm" v-model="search.kw" placeholder="Keywords..">
        </div>
        
        <div class="flex items-center rounded-md bg-white px-3 py-0.5 border shadow-sm mr-2 mb-1 hover:shadow-lg relative" v-wave="{color: '#999'}">
          <div class="absolute left-0 w-full h-full bg-transparent" @click="skillDrop = !skillDrop"></div>
          
          <i class="la la-tools text-sky-500 text-xl mr-1"></i>
          <span type="text" class="italic text-gray-400 text-sm p-0 border-none">Skill</span>
          
          
          <div class="absolute w-[230px] -right-0 top-full shadow-md rounded-md mt-1" v-if="skillDrop" @mouseleave="skillDrop = !skillDrop">
            <div class="flex w-full border border-b-0 rounded-t-md overflow-hidden">
              <input type="text" class="grow border-none py-1 px-2 w-36 text-gray-500 text-sm" v-model="skillinput" placeholder="search or add(one word)"/>
              <div class="bg-sky-400 text-white px-3 py-1 hover:bg-sky-500 cursor-pointer" v-wave @click="addSkill(skillinput)"><i class="la la-plus"></i></div>
            </div>
            <div class="bg-white border text-sm text-gray-500 rounded-b-md max-h-[230px] overflow-y-auto">

              <div
                class="px-3 py-1.5 border-b border-gray-100 last:border-none hover:bg-gray-100 cursor-pointer w-full text-center truncate"
                v-for="skl in $store.state.skills"
                :key="skl"
                @click="addSkill(skl)"
              >
                {{skl}}
              </div>
            </div>
          </div>
          
        </div>


        <div
          class="target rounded-md bg-white py-0.5 px-2 mb-1 mr-2 border shadow-sm text-sky-500 hover:shadow-lg cursor-pointer"
          v-show="search.kw.length || search.sk.length"
          @click="clearSearch"
          data-tippy-content="Clear search"
        >
          <i class="la la-times text-lg"></i>
        </div>
        
        <Component
          :is="search.kw.length || search.sk.length ? 'button' : 'div'"
          type="submit" class="flex items-center rounded-md bg-gradient-to-br from-sky-400 to-teal-400 hover:shadow-lg py-0.5 px-3 mb-1 shadow-sm text-white/95"
          v-wave="{initialOpacity: 0.5}"
          :disabled="search.processing"
        >
          <span class="text-sm font-semibold">Search</span>
          <i class="la la-arrow-right text-lg ml-2"></i>
        </Component>
      </div>

      <div>
        <button
          class="inline-flex items-center bg-white border rounded-full px-2 py-0 mr-1 mt-1"
          v-for="sk in skills"
          :key="sk"
        >
          <span class="text-gray-500 text-xs truncate max-w-[80px]">{{sk}}</span>
          <i class="la la-times-circle text-lg ml-1 text-sky-400" @click.prevent="removeSkill(sk)"></i>
        </button>

        <div class="text-sm text-gray-500 inline cursor-pointer" @click="clearSkills" v-if="search.sk.length">
          Clear
        </div>
      </div>
    </form>


    <div v-if="$page.props.notfound && notfound" class="notfound w-fit min-w-[200px] mt-2 opacity-90 border border-red-300 bg-red-50 rounded-md p-2 text-sm text-red-500">
      {{$page.props.notfound}}
    </div>


    <!--jobs-->
    <div class="mt-4" v-if="props.jobs.data.length">

      <div v-if="params.get('bk')" class="text-gray-500/80 text-base italic pb-1">
        Displaying your bookmarked jobs...
      </div>

      <div
        class="flex items-start sm:items-center rounded-xl border bg-white px-2 sm:px-4 py-3 mb-3 shadow-sm hover:border-sky-300 cursor-pointer overflow-x-hidden"
        v-for="job in props.jobs.data"
        :key="job.id"
        @click="viewJob({page: active.label,kw: params.get('kw'), sk: params.get('sk'), bk: params.get('bk'), jb: job.id}, job.id)"
        :class="{'border-b-2 border-sky-500 shadow-lg hover:border-sky-500': jobSelected == job.id}"
        :id="'j'+job.id"
      >
        <div class="mr-1.5 sm:mr-3">
          <img v-if="job.companyLogo" :src="job.companyLogo" class="inline-block w-8 mic:w-10 sm:w-14 rounded-lg -mb-7 md:mb-0">

          <div v-else class="inline-flex items-center justify-center rounded-lg w-8 h-8 mic:w-10 mic:h-10 sm:w-14 sm:h-14 bg-gray-100 text-xl mic:text-2xl sm:text-3xl text-gray-400/80 font-semibold capitalize mt-2 md:mb-0">{{job.companyName.charAt(0)}}</div>
        </div>

        <div class="flex-1">
          <div class="flex items-center justify-between w-full">
            <div class="font-bold text-base text-gray-500/80">
              {{job.title}}
            </div>
            <i
              class="target la la-bookmark text-xl text-gray-400/80 cursor-pointer"
              @click.stop="bookmark(job.id)"
              :class="{'text-yellow-400': bookmarked.includes(job.id.toString())}"
              data-tippy-content="Bookmark"
            >
            </i>
          </div>

          <div class="text-sm">
            <div
              class="target inline-block text-gray-500/80 text-sm mb-1 mr-1 hover:underline"
              @click.stop="popSearch(job.companyName)"
              data-tippy-content="Search on"
            >
              {{job.companyName}}
            </div>

            <div class="inline-flex items-center bg-gray-100 rounded px-2 py-0 text-gray-500 mr-1" v-if="job.type">
              <i class="la la-briefcase text-base mr-1"></i>
              <span>{{job.type}}</span>
            </div>

            <div class="inline-flex items-center bg-gray-100 rounded px-2 py-0 text-gray-500" v-if="job.salary">
              <i class="la la-money-bill text-base mr-1"></i>
              <span>${{job.salary.toLocaleString()+'/'+(job.salary_interval ?? '')}}</span>
            </div>
          </div>

          <div>
            <div class="inline-flex items-center text-gray-500/80 text-sm mr-2.5">
              <i class="la la-clock text-base mr-0.5"></i>
              <span>Closes {{time(job.close_date)}}</span>
            </div>

            <div class="inline-flex items-center text-gray-500/80 text-sm" v-if="job.skills.length">
              <i class="la la-tools text-base mr-0.5"></i>
              <div class="inline-block">
                <span
                  v-for="skill in job.skills"
                  :key="skill"
                  class="target mr-1.5 hover:underline"
                  @click.stop="popSearch(skill, true)"
                  data-tippy-content="Search on"
                >
                  {{skill}}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div v-else class="mt-10 text-gray-400 text-2xl text-center italic">{{((params.get('kw') ?? false) || (params.has('sk')  ?? false)) ? 'No result found for your search..' : 'No Jobs Here...'}}</div>

    <!--pagination-->
    <div class="page text-right mb-3" v-if="jobs.total > 9">
      <div
        v-for="link in jobs.links"
        :key="link"
        v-html="link.label"
        @click="setLink({kw: params.get('kw'), sk: params.get('sk'), bk: params.get('bk'), jb: jobSelected}, link.url)"
        class="border text-sm text-gray-500 rounded px-2 py-1 sm:py-0.5 mr-1 mb-1 bg-white hover:border-gray-400/90 hidden sm:inline-block first:inline-block last:inline-block cursor-pointer"
        :class="{'bg-sky-400 text-white': link.active}"
        :style="!link.url ? 'color: #ccc;border:1px solid #e1e1e1' : ''"
      >
      </div>
    </div>
  </div>

</template>