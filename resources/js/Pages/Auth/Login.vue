<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import LoginLayout from '../../Layouts/LoginLayout.vue'

defineProps({
  canResetPassword: Boolean,
  errors: Object
})

const form = useForm({
  email: '',
  password: '',
  remember: false
})

const submit = () => {
  form.post(route('login'),
  { preserveScroll: true },
  {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Log in" />
  <LoginLayout>

    <div class="flex-1 bg-white xsm:rounded-b-xl md:rounded-none md:rounded-r-xl px-4 sm:px-5 py-3">
      <div class="text-gray-400/80 text-2xl font-semibold mb-3">
        Login
      </div>
      <div class="text-sm text-gray-400 mb-2">
        Don't have an account? <Link :href="route('register')" class="text-sky-500">Register here.</Link>
      </div>

      <div class="hidden">
        <Link :href="route('loginWithGoogle')" method="post" class="flex items-center justify-center border rounded px-2 py-1.5 text-sm font-semibold text-center text-gray-500 mb-2 hover:bg-gray-100/80 active:bg-transparent w-full">
          <img src="https://cdn.cdnlogo.com/logos/g/35/google-icon.svg" class="w-3.5 inline mr-1">
          <span>Login with Google</span>
        </Link>
        <button class="flex items-center justify-center border rounded px-2 py-1.5 text-sm font-semibold text-center text-gray-500 mb-2 hover:bg-gray-100/80 active:bg-transparent w-full">
          <img src="https://cdn.cdnlogo.com/logos/a/12/apple.svg" class="w-3.5 inline mr-1">
          <span>Login with Apple</span>
        </button>
      </div>

      <div class="text-sm font-semibold text-center text-gray-400 my-2 hidden">
        or
      </div>

      <form @submit.prevent="submit">
        <div v-if="errors" class="mb-1 font-medium text-sm text-red-400">
            {{ errors.email }}
        </div>
        
        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Company email</label>
          <input
            type="email"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            placeholder="Your business email"
            v-model="form.email"
          >
        </div>

        <div class="mb-3 md:mb-2.5">
          <label class="text-sm text-gray-600">Password</label>
          <input
            type="password"
            class="border-gray-200 rounded text-gray-500 text-sm w-full px-2 py-1.5 mt-0.5"
            placeholder="Password"
            v-model="form.password"
          >
        </div>

        <div class="mb-3 md:mb-2.5">
          <input type="checkbox" id="rem" class="peer hidden" v-model="form.remember">
          <label for="rem" class="inline-flex items-center text-gray-400/90 peer-checked:text-sky-500">
            <i class="la la-check-circle text-2xl sm:text-2xl mr-1"></i>
            <span class="text-gray-500 text-sm">Remember me</span>
          </label>

        </div>

        <div class="mb-2 text-right">
          <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-gray-500 underline">Forgot password?</Link>
          
          <button
            type="submit"
            class="bg-gradient-to-br from-sky-400 to-teal-400 font-semibold text-sm text-white/95 rounded-full px-3 py-1.5 hover:shadow-lg active:shadow-none ml-1"
            :class="{ 'opacity-75': form.processing }"
            :disabled="form.processing"
          >
            Login 
            <i class="la la-arrow-right" :class="{'la la-spinner la-spin': form.processing}"></i>
            </button>
        </div>
      </form>
    </div>

</LoginLayout>
</template>