<script setup>
import BoardLayout from '../Layouts/BoardLayout.vue'

import { computed } from 'vue'
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

defineProps({
    errors: Object
})

const user = computed(() => usePage().props.value.auth.user) //get user data

//form data
const form = useForm({
    name:       user.value.name,
    //email:    user.value.email,
    website:    user.value.website,
    logo:       null,
})

//password change form data
const pass = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const passSubmit = () => {
    Inertia.post(route('passChange'), pass, {
        preserveScroll: true,
        onFinish: visit => { pass.reset() }
    })
}
</script>

<template>
    <Head title="Company Info" />

    <BoardLayout>

    <div class="grow bg-gray-50 px-3 md:px-6 overflow-auto">

        <form @submit.prevent="form.post(route('updateInfo'))">

            <div class="flex items-center justify-between border-b border-gray-200 py-3">
                <div class="text-gray-500">
                    <div class="text-lg">Company Info.</div>
                    <div class="text-sm">This post will be seen publicly so be careful what you type.</div>
                </div>

                <div class="sm:hidden">
                    <i class="la la-bars text-4xl text-sky-500 cursor-pointer" @click="$store.commit('toggleMenu')"></i>
                </div>
            </div>


            <div class="max-w-3xl">

                <div class="mt-2">
                    <p class="text-sm text-gray-500/90">The fields <span class="text-red-500">*</span> are required</p>
                </div>


                <div class="flex flex-col md:flex-row flex-wrap items-start py-3 sm:py-5 border-b border-gray-200">
                    <div class="mr-3 w-full md:flex-1 mb-1.5">
                        <div class="text-sm font-semibold text-gray-500">Company Name<span class="text-red-500">*</span></div>
                        <p class="text-gray-500/80 text-sm">Always stick to one name when posting jobs.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="form.errors.name" class="text-red-500/90 text-sm mb-0.5">{{form.errors.name}}</p>
                        <input
                            type="text"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': form.errors.name}" 
                            v-model="form.name"
                            maxlength="20"
                            placeholder="..."
                        >
                        <p class="text-right text-sm text-gray-500 py-0.5">Remaining {{20 - (form.name ?? '').length}} characters</p>
                    </div>
                </div>


                <div class="flex flex-col md:flex-row flex-wrap items-start py-3 sm:py-5 border-b border-gray-200">
                    <div class="mr-3 w-full md:flex-1 mb-1.5">
                        <div class="text-sm font-semibold text-gray-500">Company Logo<span class="text-red-500">*</span></div>
                        <p class="text-gray-500/80 text-sm">Please select a square size image with a 1:1 aspect ratio as images are cropped to this size before upload.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="form.errors.logo" class="text-red-500/90 text-sm mb-0.5">{{form.errors.logo}}</p>
                        
                        <div class="flex items-center mb-2">
                            <img :src="user.logo" v-if="user.logo" class="rounded-full w-12 h-12 mr-2">
                            <div v-else class="shrink-0 inline-flex items-center justify-center rounded-full w-12 h-12 mr-2 border bg-gray-200/80 text-2xl text-gray-400/80 font-semibold capitalize"><i class="la la-image"></i></div>
                            <input
                                type="file"
                                accept="image/png, image/jpeg, image/webp"
                                class="grow file:hidden text-gray-500 bg-white border border-gray-200 px-3 py-1.5 text-sm rounded focus:outline-none"
                                :class="{'border-red-300': form.errors.logo}" 
                                v-wave
                                @input="form.logo = $event.target.files[0]"
                            >
                        </div>
                    </div>
                </div>


                <div class="flex flex-col md:flex-row flex-wrap items-start py-3 sm:py-5 border-b border-gray-200" v-if="false">
                    <div class="mr-3 w-full md:flex-1 mb-1.5">
                        <div class="text-sm font-semibold text-gray-500">Company Email<span class="text-red-500">*</span></div>
                        <p class="text-gray-500/80 text-sm">This the email address where interested candidates of job postings will send their CV/Resume.</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="form.errors.email" class="text-red-500/90 text-sm mb-0.5">{{form.errors.email}}</p>
                        <input
                            type="email"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': form.errors.email}" 
                            v-model="form.email"
                            placeholder="@"
                        >
                    </div>
                </div>



                <div class="flex flex-col md:flex-row flex-wrap items-start py-3 sm:py-5 border-b border-gray-200">
                    <div class="mr-3 w-full md:flex-1 mb-1.5">
                        <div class="text-sm font-semibold text-gray-500">Company Website<span class="text-red-500">*</span></div>
                        <p class="text-gray-500/80 text-sm">Company website, social media link, or any link to where more info on company can be seen. Must be prefixed with https:// or http://</p>
                    </div>
                    <div class="flex-1 w-full">
                        <p v-if="form.errors.website" class="text-red-500/90 text-sm mb-0.5">{{form.errors.website}}</p>
                        <input
                            type="text"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': form.errors.website}" 
                            v-model="form.website"
                            placeholder="https://company.com"
                        >
                    </div>
                </div>
                

                <div class="flex justify-between items-end mt-1">
                    <p
                        v-if="$page.props.flashes && !$page.props.passChange"
                        class="text-green-500/90 font-semibold text-sm mt-2"
                        :class="{'text-red-500/80': $page.props.flashes.type == 'fail'}"
                    >
                        {{$page.props.flashes.msg}}
                    </p>
                    <p v-if="form.hasErrors" class="text-red-500/90 text-sm mt-2">Some errors found...</p>
                    <span v-else></span>
                    <button
                        type="submit" class="bg-sky-400 text-white text-sm font-semibold rounded px-3 py-1.5 hover:bg-sky-500"
                        v-wave="{initialOpacity:0.5}"
                        :disabled="form.processing"
                    >
                        <i class="la la-edit"></i> 
                        Update&nbsp;Info
                    </button>
                </div>

            </div>

        </form>


        <form @submit.prevent="passSubmit" autocomplete="off">
            <div class="max-w-3xl mt-7">
                <div class="flex flex-col md:flex-row flex-wrap items-start py-3 sm:py-5 border-b border-t border-gray-200">
                    <div class="mr-3 w-full md:flex-1 mb-1.5">
                        <div class="text-sm font-semibold text-gray-500">Change Password</div>
                        <p class="text-gray-500/80 text-sm">Passwords allow a minimum of 8 characters.</p>
                    </div>

                    <input type="password" class="hidden">
                    <div class="flex-1 w-full">
                        <p class="text-gray-500/90 text-sm font-semibold mb-0.5">Current Password</p>
                        <p v-if="errors.current_password" class="text-red-500/90 text-sm mb-0.5">{{errors.current_password}}</p>
                        <input
                            type="password"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.current_password}" 
                            v-model="pass.current_password"
                            minlength="8"
                            placeholder="********"
                        >

                        <p class="text-gray-500/90 text-sm font-semibold mt-4 mb-0.5">New Password</p>
                        <p v-if="errors.password" class="text-red-500/90 text-sm mb-0.5">{{errors.password}}</p>
                        <input
                            type="password"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.password}" 
                            v-model="pass.password"
                            minlength="8"
                            placeholder="********"
                        >


                        <p class="text-gray-500/90 text-sm font-semibold mt-4 mb-0.5">Password Confirm</p>
                        <p v-if="errors.password_confirmation" class="text-red-500/90 text-sm mb-0.5">{{errors.password_confirmation}}</p>
                        <input
                            type="password"
                            class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-500 w-full"
                            :class="{'border-red-300': errors.password_confirmation}" 
                            v-model="pass.password_confirmation"
                            minlength="8"
                            placeholder="********"
                        >
                    
                    </div>
                </div>

                <div class="flex justify-between items-end mt-1 mb-8">
                    <p
                        v-if="$page.props.flashes && $page.props.passChange"
                        class="text-green-500/90 text-sm font-bold mt-2"
                        :class="{'text-red-500/80': $page.props.flashes.type == 'fail'}"
                    >
                        {{$page.props.flashes.msg}}
                    </p>
                    <p v-if="Object.keys(errors).length && $page.props.passChange" class="text-red-500/80 text-sm font-bold mt-2">Some errors found...</p>
                    <span v-else></span>
                    <button
                        type="submit" class="bg-sky-400 text-white text-sm font-semibold rounded px-3 py-1.5 hover:bg-sky-500" 
                        v-wave="{initialOpacity:0.5}" 
                        :disabled="pass.processing"
                    >
                        Change&nbsp;Password
                    </button>
                </div>
            </div>
        </form>

    </div>

    </BoardLayout>
</template>