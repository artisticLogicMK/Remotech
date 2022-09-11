<script setup>
import BoardLayout from '../Layouts/BoardLayout.vue'

import { ref, computed, onMounted } from 'vue'
import moment from 'moment'
import { useStore } from 'vuex'
import { useTippy } from "vue-tippy/composition"
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    companyJobs: Object
})

const jobs = computed(() => props.companyJobs)

//initialize tooltip
useTippy('.target', {
    theme: 'custom',
    arrow: true
})

//readable date
const time = (time) => {
    return moment(time).format('MMM Do, YYYY')
}

const compareTime = (time) => {
    return moment().unix() > time ? true : false
}

onMounted(() => {
    if(useStore().state.jobEdited) {
        Inertia.visit(route('listings'));
        useStore().commit('jobEdited', false)
    }
})
</script>

<template>
    <Head title="Job Listings" />

    <BoardLayout>
        <div class="grow bg-gray-50 px-3 md:px-6 overflow-auto">
            <div class="max-w-6xl py-3">
                
                <div class="flex justify-between items-center mb-2">
                    <div class="text-gray-500/80 text-xl font-semibold">Job Listings: {{$page.props.auth.user.name}}</div>

                    <div class="sm:hidden">
                        <i class="la la-bars text-4xl text-sky-500 cursor-pointer" @click="$store.commit('toggleMenu')"></i>
                    </div>
                </div>

                <div v-if="!jobs.data.length">
                    <div class="mb-5 italic text-gray-500/80">You haven't added any job listings yet...</div>
                    <Link :href="route('createJob')" class="bg-sky-400 text-white text-sm font-semibold rounded px-3 py-1.5 hover:bg-sky-500"><i class="la la-plus"></i> Create Job</Link>
                </div>

                <div class="flex flex-wrap">

                    <div
                        class="w-full md:w-[48%] flex justify-between items-center bg-white border rounded-lg p-3 text-gray-500/80 md:mr-2 mb-2"
                        v-for="list in jobs.data"
                        :key="list.id"
                    >
                        <div class="grow">
                            <p class="font-semibold text-base">{{list.title}}</p>
                            <p class="text-sm" v-if="!compareTime(list.close_time) && (list.close_date ?? false)">Closes on {{time(list.close_date)}}</p>
                            <p class="text-sm" v-if="compareTime(list.close_time)">Closed</p>
                        </div>
                        <div class="text-gray-400 text-right w-20 shrink-0 ml-2">
                            <Link :href="route('hideJob', list.id)" method="post">
                                <div
                                    class="target inline-flex justify-center items-center w-8 h-8 border border-gray-300 hover:border-gray-400 shadow-sm rounded-full cursor-pointer mt-1" v-wave
                                    data-tippy-content="Toggle Visibility"
                                >
                                    <i class="la text-xl" :class="list.hidden == 1 ? 'la-eye' : 'la-eye-slash'"></i>
                                </div>
                            </Link>

                            <Link :href="route('editJob', list.id)">
                                <div class="target inline-flex justify-center items-center w-8 h-8 border border-gray-300 hover:border-gray-400 shadow-sm rounded-full cursor-pointer ml-2 mt-1" v-wave data-tippy-content="Edit Job">
                                    <i class="la la-edit text-xl"></i>
                                </div>
                            </Link>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </BoardLayout>
</template>