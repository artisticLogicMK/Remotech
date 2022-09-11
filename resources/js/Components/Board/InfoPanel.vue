<script setup>
import moment from 'moment'

const props = defineProps({
    job: Object
})

const job = props.job

const time = (time) => {
    return moment(time).format('MMM Do, YYYY')
}
</script>

<template>
<!--if infoPanelOverlap == true? '' : hidden lg:block-->
  <div
    class="bg-white w-full lg:w-[330px] xl:w-[400px] 2xl:w-3/12"
    :class="$store.state.infoPanelOverlap ? '' : 'hidden lg:block'"
  >
        <div class="absolute right-0 text-gray-600 text-3xl mr-8 mt-2 px-1 lg:hidden rounded-full hover:bg-gray-200 hover:scale-[1.2]" v-wave>
            <i class="la la-times cursor-pointer hover" @click="$store.commit('toggleInfoPanel', false)"></i>
        </div>

        <div v-if="job" class="flex flex-col w-full h-full">
            <div class="grow px-4 overflow-y-auto">
                <div class="text-center border-b py-5 lg:py-3">
                    <div class="mb-1">
                        <img v-if="job.user.logo" :src="job.user.logo" alt="" class="rounded-lg w-20 inline-block">

                        <div v-else class="inline-flex items-center justify-center rounded-lg w-20 h-20 bg-gray-100 text-4xl text-gray-400/80 font-semibold capitalize">{{job.companyName.charAt(0)}}</div>
                    </div>
        
                    <div class="text-gray-500/80 font-semibold text-lg">{{job.title}}</div>
    
                    <div class="text-gray-500/80 text-sm">{{job.companyName}}</div>
                </div>
    
                <div class="border-b py-5 lg:py-3">
                    <div class="text-gray-500 font-semibold text-sm mb-2">Job Details</div>
                    
                    <div class="flex flex-wrap items-center ml-2">
                        <div class="flex-1 text-gray-500/90 mb-2 mr-2">
                            <div class="font-semibold text-sm">Salary</div>
                            <div class="text-sm" v-if="job.salary">${{job.salary.toLocaleString()+'/'+(job.salary_interval ?? '')}}</div>
                            <div v-else>-</div>
                        </div>
    
                        <div class="flex-1 text-gray-500/90 mb-2">
                            <div class="font-semibold text-sm">Job Type</div>
                            <div class="text-sm" v-if="job.type">{{job.type}}</div>
                            <div v-else>-</div>
                        </div>
                    </div>
    
                    <div class="flex flex-wrap items-center ml-2">
                        <div class="flex-1 text-gray-500/90 mb-2 mr-2">
                            <div class="font-semibold text-sm">Posted On</div>
                            <div class="text-sm" v-if="job.created_at">{{time(job.created_at)}}</div>
                            <div v-else>-</div>
                        </div>
    
                        <div class="flex-1 text-gray-500/90 mb-2">
                            <div class="font-semibold text-sm">Closes On</div>
                            <div class="text-sm" v-if="job.close_date">{{time(job.close_date)}}</div>
                            <div v-else>-</div>
                        </div>
                    </div>

                    <div class="ml-2">
                        <div class="text-gray-500/90 font-semibold text-sm">Skills Needed</div>
                        <div
                            class="bg-sky-100 rounded-full px-2.5 py-1 text-sky-600 inline-block text-xs mr-1 mb-1"
                            v-for="skill in job.skills.split(' ')"
                            :key="skill"
                        >
                            {{skill}}
                        </div>
                        <div v-if="!job.skills.length">-</div>
                    </div>
                    
                </div>
    
                <div class="border-b py-5 lg:py-3" v-if="job.description">
                    <div class="text-gray-500 font-semibold text-sm">Job Description</div>
                    <p class="text-gray-500/90 text-sm whitespace-pre-wrap">{{job.description}}</p>
                </div>

                <div class="border-b py-5 lg:py-3" v-if="job.qualifications">
                    <div class="text-gray-500 font-semibold text-sm">Job Qualifications</div>
                    <p class="text-gray-500/90 text-sm whitespace-pre-wrap">{{job.qualifications}}</p>
                </div>
            </div>

            <div class="flex items-stretch justify-center bg-white text-center p-2">
                <a :href="'mailto: '+job.user.email" target="_blank" class="text-sm bg-sky-400 text-white font-semibold px-4 py-2 rounded-md mr-2 hover:bg-sky-500">Send CV/Resume</a>

                <a :href="job.user.website" target="_blank" class="text-xl bg-teal-400 text-white font-semibold px-3 py-1 rounded-md mr-2 hover:bg-teal-500"><i class="la la-globe"></i></a>
            </div>
        </div>

        <div v-else class="w-full h-full flex items-center justify-center text-gray-400/80 font-semibold text-xl">
            No Job to Show...
        </div>
    </div>

</template>