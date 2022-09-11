<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import LoginLayout from '../../Layouts/LoginLayout.vue'

const props = defineProps({
    email: String,
    token: String,
    errors: Object
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
  <Head title="Reset Password" />
  
  <LoginLayout>
    <div class="flex-1 bg-white xsm:rounded-b-xl md:rounded-none md:rounded-r-xl px-4 sm:px-5 py-3">
      <div class="text-gray-400/80 text-lg font-semibold">
        Reset Password
      </div>
      
      <form @submit.prevent="submit">
        
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Email</label>
          <input
            type="email"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.email"
          >
          <p v-if="errors.email" class="text-red-400 text-sm">{{errors.email}}</p>
        </div>
        
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Password</label>
          <input
            type="password"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.password"
            placeholder="minimum of 8 chars"
            autocomplete="new-password"
          >
          <p v-if="errors.password" class="text-red-400 text-sm">{{errors.password}}</p>
        </div>
        
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Password Confirmation</label>
          <input
            type="password"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            v-model="form.password_confirmation"
            autocomplete="new-password"
          >
        </div>
  
        <div class="text-right mb-2">
          <button
            type="submit"
            class="bg-gradient-to-br from-sky-400 to-teal-400 font-semibold text-sm text-white/95 rounded-full px-3 py-1.5 hover:shadow-lg active:shadow-none"
            :class="{ 'opacity-75': form.processing }"
            :disabled="form.processing"
          >
            Reset Password 
            <i v-if="form.processing" class="la la-spinner la-spin"></i>
          </button>
        </div>
      </form>
    </div>
    
  </LoginLayout>
</template>