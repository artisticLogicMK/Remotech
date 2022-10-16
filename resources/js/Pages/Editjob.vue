<script setup>
import BoardLayout from '../Layouts/BoardLayout.vue'

import { computed, onMounted, ref } from 'vue'
import moment from 'moment'
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

const user = computed(() => usePage().props.value.auth.user) //get needed user data

const props = defineProps({
    errors: Object,
    job: Object
})


//skill tag operations
const skillDropdown = ref(false) //state of add skills dropdown menu
const skillInput = ref('') //text input for skill
const skills = ref([]) //array to store added skills

//add a skill
const addSkill = (value) => {
    if (value.split(" ").length > 1 ? false : true) { //only one word allowed
    
        skillDropdown.value = false //hide skill filter drop down
    
        //make sure this skill is 1. value not in skills array
                                //2. value not empty
                                //3. Skills array not > 6 max
                                //4. value length not > 15
        if(!skills.value.includes(value) && value.length && value.length < 16 && skills.value.length < 6) {
            skills.value.push(value) //add value to skills array
            skillInput.value = '' //clear input
        }

    }
}

//remove a skill
const removeSkill = (value) => {
    skills.value = skills.value.filter(s => s !== value)
}


//job pay operations
const salary = ref(null) //get salary num
const interval = ref(null) //get the time interval
//format salary e.g $70,000/yr
const pay = computed(() => {
    return salary.value && interval.value ? '$'+salary.value.toLocaleString()+'/'+interval.value : null
})


//get selected date from input eg. 04/07/2022
const date = ref(null)
const dateError = ref(false)
const formatedDate = computed(() => date.value ? moment(date.value).format('MMM Do, YYYY') : null) //e.g Sep 2nd, 2022

//make sure chosen date is later than today
const checkDate = (d) => {
    if (moment(d).unix() < moment().unix()) {
        date.value = ''
        dateError.value = true
    } else {
        dateError.value = false
    }
}

//form data
const form = useForm({
    title:           props.job?.title,
    description:     props.job?.description,
    type:            props.job?.type,
    skills:          computed(() => skills.value.length ? skills.value.join(' ') : null),
    qualifications:  props.job?.qualifications,
    salary:          salary,
    salary_interval: interval,
    close_date:      date ?? null,
    close_time:      computed(() => moment(date.value).unix()) ?? null, //get timestamp toooo..

    companyName:     user.value.name ?? null,
    user_id:         user.value.id ?? null,

    errors:          props.errors
})

const formSubmit = () => {
    Inertia.post(route('updateJob', props.job?.id), form, {
        preserveScroll: false,
        onFinish: visit => { document.body.scrollIntoView() }
    })
}

//state for toggling delete tab
const showDelete = ref(false)

//delete job form
const del = useForm({
    password: '',
    name: user.value.name
})

//submit delete req
const jobDelete = () => {
    Inertia.post(route('deleteJob', props.job?.id), del, {
        preserveScroll: true,
        replace: true,
        onFinish: visit => { del.reset() }
    })
}

onMounted(() => {
    skills.value = props.job ? props.job?.skills.split(' ') : []
    salary.value = props.job?.salary
    interval.value = props.job?.salary_interval
    date.value = props.job?.close_date
})
</script>

<template> 
    <Head title="Edit Job" />

    <BoardLayout>

    <div class="grow bg-gray-50 px-3 md:px-6 overflow-auto">

        <form @submit.prevent="formSubmit">

            <div class="flex items-center justify-between border-b border-gray-200 py-3">
                <div class="text-gray-500">
                    <div class="text-lg">Edit Job Listing.</div>
                    <div class="text-sm">This post will be seen publicly so be careful what you type.</div>
                </div>

                <div class="sm:hidden">
                    <i class="la la-bars text-4xl text-sky-500 cursor-pointer" @click="$store.commit('toggleMenu')"></i>
                </div>
            </div>


            <div class="max-w-4xl" v-if="props.job">

                <div class="mt-2">
                    <p class="text-sm text-gray-500/90">The fields <span class="text-red-500">*</span> are required</p>
                </div>


                <div class="jform">
                    <div class="con">
                        <div class="title">Job Title<span class="text-red-500">*</span></div>
                        <p class="dscr">Be specific. indicate the job position needed.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="errors.title" class="errors">{{errors.title}}</p>
                        <input
                            type="text"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.title}" 
                            v-model="form.title"
                            maxlength="35"
                            placeholder="Frontend Engineer"
                        >
                        <p class="rem py-0.5">Remaining {{35 - (form.title ?? '').length}} characters</p>
                    </div>
                </div>



                <div class="jform">
                    <div class="con">
                        <div class="title">Job Description<span class="text-red-500">*</span></div>
                        <p class="dscr">Information about the job. Write clearly what the job is about. Whitespaces allowed.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="errors.description" class="errors">{{errors.description}}</p>
                        <textarea
                            class="bg-white border border-gray-200 rounded px-3 py-1 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.description}"
                            v-model="form.description"
                            placeholder="....."
                            maxlength="1000"
                            rows="6"
                        >
                        </textarea>
                        <p class="rem py-0">Remaining {{1000 - (form.description ?? '').length}} characters</p>
                    </div>
                </div>



                <div class="jform">
                    <div class="con">
                        <div class="title">Job Type<span class="text-red-500">*</span></div>
                        <p class="dscr">Describes the nature of the job.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="errors.type" class="text-red-500/90 text-sm mb-0.5">{{errors.type}}</p>
                        <div class="mb-3">
                            <input type="radio" name="type" value="Full Time" v-model="form.type" id="ful" class="peer hidden"> 
                            <label for="ful" class="flex items-center text-gray-500 text-sm w-5 h-5 rounded-full border-4 border-gray-300 peer-checked:border-sky-400 relative">
                                <div class="ml-6 w-16 absolute">Full Time</div>
                            </label>
                        </div>

                        <div class="mb-3">
                            <input type="radio" name="type" value="Part Time" v-model="form.type" id="pt" class="peer hidden"> 
                            <label for="pt" class="flex items-center text-gray-500 text-sm w-5 h-5 rounded-full border-4 border-gray-300 peer-checked:border-sky-400 relative">
                                <div class="ml-6 w-16 absolute">Part Time</div>
                            </label>
                        </div>

                        <div>
                            <input type="radio" name="type" value="Contract" v-model="form.type" id="con" class="peer hidden"> 
                            <label for="con" class="flex items-center text-gray-500 text-sm w-5 h-5 rounded-full border-4 border-gray-300 peer-checked:border-sky-400 relative">
                                <div class="ml-6 w-16 absolute">Contract</div>
                            </label>
                        </div>
                    </div>
                </div>



                <div class="jform">
                    <div class="con">
                        <div class="title">Skills Needed<span class="text-red-500">*</span></div>
                        <p class="dscr">Please select 1-6 skills that the job requires. You can add new skills not in our database.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="errors.skills && !skills.length" class="errors">{{errors.skills}}</p>
                        <div class="flex">
                            <div
                                class="bg-white border border-gray-200 rounded pl-3 py-0 grow flex items-center mr-1 relative"
                                :class="{'border-red-300': errors.skills && !skills.length}"
                            >
                                <i class="la la-search text-sky-500 text-sm"></i>
                                <input type="text" class="grow bg-white text-sm border-none text-gray-500 pr-3 rounded" v-model="skillInput" placeholder="one word, 15 chars, no spaces" maxlength="15" @click="skillDropdown = !skillDropdown">

                                <div class="bg-white absolute min-w-[260px] max-w-full max-h-[230px] overflow-y-auto left-0 top-full border rounded mt-1 shadow-md text-sm text-gray-500" v-if="skillDropdown" @mouseleave="skillDropdown = false">
                                    <div
                                        class="px-3 py-1 border-b border-gray-100 last:border-none hover:bg-gray-100 cursor-pointer"
                                        v-for="skl in $store.state.skills"
                                        :key="skl"
                                        @click.stop="addSkill(skl)"
                                    >
                                        {{skl}}
                                    </div>
                                </div>
                            </div>
                            <button class="bg-none bg-sky-400 rounded-full px-3" v-wave @click.prevent="addSkill(skillInput)">
                                <i class="la la-plus text-white text-3jxl"></i>
                            </button>
                        </div>
                        <p class="rem py-0.5 mr-10">Remaining {{6 - (skills ?? '').length}} skills</p>

                        <div class="mt-1">
                            <div
                                class="inline-flex items-center bg-white border text-gray-500 rounded-full px-2 py-0 mr-0.5 mb-1"
                                v-for="skill in skills"
                                :key="skill"
                            >
                                <span class="text-xs">{{skill}}</span>
                                <i class="la la-times-circle text-lg ml-1 cursor-pointer" @click="removeSkill(skill)"></i>
                            </div>
                        </div>
                    </div>

                </div>




                <div class="jform">
                    <div class="con">
                        <div class="title">Job Qualifications</div>
                        <p class="dscr">Whitespaces or paragraphs are allowed.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="errors.qualifications" class="errors">{{errors.qualifications}}</p>
                        <textarea
                            class="bg-white border border-gray-200 rounded px-3 py-1 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.qualifications}"
                            v-model="form.qualifications"
                            placeholder="1. Must have/know..."
                            maxlength="600"
                            rows="6"
                        >
                        </textarea>
                        <p class="rem py-0">Remaining {{600 - (form.qualifications ?? '').length}} characters</p>
                    </div>
                </div>




                <div class="jform">
                    <div class="con">
                        <div class="title">Job Salary</div>
                        <p class="dscr">Amount to be payed for the job. You can stipulate the time interval.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="errors.salary_interval" class="errors">{{errors.salary_interval}}</p>
                        <div class="flex text-sm text-gray-500">
                            <input type="number" class="grow bg-white border border-gray-200 rounded px-3 py-1 mr-2" v-model="salary" placeholder="000">
                            <select class="bg-white border border-gray-200 rounded px-3 py-1" :class="{'border-red-300': errors.salary_interval}" v-model="interval">
                                <option value="hr">Hourly</option>
                                <option value="wk">Weekly</option>
                                <option value="m">Monthly</option>
                                <option value="yr">Yearly</option>
                            </select>
                        </div>
                        
                        <p class="text-sm text-gray-500 py-0.5">{{pay}}</p>
                    </div>
                </div>



                <div class="jform">
                    <div class="con">
                        <div class="title">Job active till<span class="text-red-500">*</span></div>
                        <p class="dscr">This job will be hidden from public view when the chosen date is reached. The date must be later than today.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="errors.close_date" class="errors">{{errors.close_date}}</p>&nbsp;
                        <p v-if="dateError" class="inline-block text-red-500/90 text-sm mb-0.5">Pick a date greater than today.</p>
                        <input
                            type="date"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.close_date}"
                            v-model="date"
                            @input="checkDate(date)"
                            placeholder="Pick date"
                        >
                        <p class="text-sm text-gray-500 py-0.5 text-right" v-if="date">{{formatedDate}}</p>
                    </div>
                </div>


                <div class="flex justify-between items-center mt-2">
                    <p v-if="Object.keys(errors).length && !showDelete" class="text-red-500/80 text-sm font-semibold mt-2">Some errors found...</p>
                    <p v-if="$page.props.flashes" class="text-green-500 text-sm font-semibold mt-2">{{$page.props.flashes.msg}}</p>
                    <span v-else></span>

                    <button type="submit" class="bg-sky-400 text-white text-sm font-semibold rounded px-3 py-1.5 hover:bg-sky-500 ml-2" v-wave="{initialOpacity:0.5}" :disabled="form.processing" v-if="props.job" @click="$store.commit('jobEdited', true)">
                        <i class="la la-edit"></i> 
                        Update&nbsp;Job
                    </button>
                </div>

                <p class="text-gray-500/80 text-base font-semibold underline cursor-pointer mt-4 mb-6" @click="showDelete = true" v-if="!showDelete">Want to delete this job.</p>

                <form @submit.prevent="jobDelete" class="flex flex-col md:flex-row flex-wrap items-start py-3 sm:py-5 pb-10 border-b border-gray-200 mb-8" v-if="showDelete">
                    <div class="mr-3 w-full md:flex-1 mb-1.5">
                        <div class="text-sm font-semibold text-gray-500">Delete Job</div>
                        <p class="text-gray-500/80 text-sm">This is an irreversible action, you sure to delete?</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p class="text-gray-500/90 text-sm font-semibold mb-0.5">Password</p>
                        <p v-if="errors.password" class="text-red-500/90 text-sm mb-0.5">{{errors.password}}</p>
                        <p v-if="$page.props.delJob" class="text-red-500/90 text-sm mb-0.5">{{$page.props.delJob}}</p>
                        <input
                            type="password"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.password}"
                            v-model="del.password"
                            placeholder="****"
                        >
                        <div class="text-right">
                            <button type="submit" class="bg-red-400 text-white text-sm font-semibold rounded px-3 py-1.5 hover:bg-red-500 ml-2 mt-2" v-wave="{initialOpacity:0.5}" :disabled="form.processing" v-if="props.job">
                                <i class="la la-trash"></i> 
                                Delete&nbsp;Job
                            </button>
                        </div>
                    </div>
                </form>


            </div>

            <div v-else class="text-xl font-semibold italic text-gray-400 my-5">You are Unauthorized to view this!</div>

        </form>

    </div>

    </BoardLayout>
</template>