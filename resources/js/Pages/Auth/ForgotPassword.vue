<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import LoginLayout from '../../Layouts/LoginLayout.vue'

defineProps({
    status: String,
    errors: Object
})

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('password.email'),  {
      onFinish: () => form.reset('email'),
    })
}
</script>

<template>
  <Head title="Forgot Password" />
  
  <LoginLayout>
    <div class="flex-1 bg-white xsm:rounded-b-xl md:rounded-none md:rounded-r-xl px-4 sm:px-5 py-3">
      
      <div class="text-gray-400/80 text-lg font-semibold">
        Forgot Password
      </div>
      <div class="my-2 text-sm text-gray-500 md:max-w-xs">You forgot your password? Everything is cool.<br/> Just type in the email of your registered account and we will send you a password reset link where you can set a new one. If you didn't receive the email in your inbox, check your spam.</div>
      
      <div v-if="status" class="mb-1 text-sm text-green-500 font-semibold">{{status}}</div>
  
      <form @submit.prevent="submit">
        <div v-if="errors.email" class="mb-1 font-medium text-sm text-red-400">
            {{ errors.email }}
        </div>
        
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Email</label>
          <input
            type="email"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.email"
            autofocus
          >
        </div>
  
        <div class="text-right mb-2">
          <button
            type="submit"
            class="bg-gradient-to-br from-sky-400 to-teal-400 font-semibold text-sm text-white/95 rounded-full px-3 py-1.5 hover:shadow-lg active:shadow-none"
            :class="{ 'opacity-75': form.processing }"
            :disabled="form.processing"
          >
            Send Reset Link 
            <i v-if="form.processing" class="la la-spinner la-spin"></i>
          </button>
        </div>
      </form>
    </div>
    
  </LoginLayout>
</template>