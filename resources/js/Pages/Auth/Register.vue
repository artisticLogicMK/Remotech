<script setup>
import RegisterLayout from '../../Layouts/RegisterLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3'

defineProps({
  errors: Object
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
})

const submit = () => {
  form.post(route('register'),
  { preserveScroll: true },
  {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <Head title="Register" />
  
  <RegisterLayout>
    <div class="flex-1 bg-white xsm:rounded-b-xl md:rounded-none md:rounded-r-xl px-4 sm:px-5 py-3">
      <div class="text-gray-400/80 text-2xl font-semibold mb-3">
        Sign Up
      </div>
      <div class="text-sm text-gray-400 mb-2">
        Already have an account? <Link :href="route('login')" class="text-sky-500">Login here.</Link>
      </div>
  
      <div class="hidden">
        <button class="flex items-center justify-center border rounded px-2 py-1.5 text-sm font-semibold text-center text-gray-500 mb-2 hover:bg-gray-100/80 active:bg-transparent w-full">
          <img src="https://cdn.cdnlogo.com/logos/g/35/google-icon.svg" class="w-3.5 inline mr-1">
          <span>Sign in with Google</span>
        </button>
        <button class="flex items-center justify-center border rounded px-2 py-1.5 text-sm font-semibold text-center text-gray-500 mb-2 hover:bg-gray-100/80 active:bg-transparent w-full">
          <img src="https://cdn.cdnlogo.com/logos/a/12/apple.svg" class="w-3.5 inline mr-1">
          <span>Sign in with Apple</span>
        </button>
      </div>
  
      <div class="text-sm font-semibold text-center text-gray-400 my-2 hidden">
        or
      </div>
  
      <form @submit.prevent="submit" autocomplete="off">
        
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Company name</label>
          <input
            type="text"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.name"
            placeholder="Enter company name"
            autocomplete="off"
          >
          <p v-if="errors.name" class="text-red-400 text-sm">{{errors.name}}</p>
        </div>
  
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Company email</label>
          <input
            type="email"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.email"
            placeholder="Your business email"
            autocomplete="off"
          >
          <p v-if="errors.email" class="text-red-400 text-sm">{{errors.email}}</p>
        </div>
  
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Password</label>
          <input
            type="password"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.password"
            placeholder="Password"
            autocomplete="off"
          >
          <p v-if="errors.password" class="text-red-400 text-sm">{{errors.password}}</p>
        </div>
  
        <div class="mb-3">
          <label class="text-sm text-gray-600">Password again</label>
          <input
            type="password"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.password_confirmation"
            autocomplete="off"
          >
        </div>
  
        <div class="text-right mb-2">
          <button
            type="submit"
            class="bg-gradient-to-br from-sky-400 to-teal-400 font-semibold text-sm text-white/90 rounded-full px-3 py-1.5 hover:shadow-lg active:shadow-none"
            :class="{ 'opacity-75': form.processing }"
            :disabled="form.processing"
          >
            Sign Up 
            <i class="la la-arrow-right" :class="{'la la-spinner la-spin': form.processing}"></i>
          </button>
        </div>
      </form>
    </div>
    
  </RegisterLayout>
</template>