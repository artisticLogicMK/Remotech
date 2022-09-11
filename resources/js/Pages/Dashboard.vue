<script setup>
import BoardLayout from '../Layouts/BoardLayout.vue'
import InfoPanel from '../Components/Board/InfoPanel.vue'
import Jobs from '../Components/Board/Jobs.vue'

import { usePage } from '@inertiajs/inertia-vue3'

const props = defineProps({
  jobs: Object,
  jobview: Object
})

</script>

<template>
  <Head title="Job Board" />

  <BoardLayout>

    <Jobs :jobs="props.jobs" />
    <InfoPanel :job="props.jobview" />

  </BoardLayout>

  <!--
    For BoardLayout: v-if="$page.props.auth.user ? $page.props.auth.user.email_verified_at : true"
  <div class="h-screen w-full bg-white flex items-center justify-center" v-if="$page.props.auth.user && !$page.props.auth.user.email_verified_at">
    <div class="text-center">
      <img src="/images/undraw_festivities_tvvj.svg" class="inline-block w-64 xsm:w-72 sm:w-96 mb-2">
      <div class="text-sky-400 font-semibold text-2xl mb-2">Welcome to Remotech!</div>
      <div class="text-gray-500 text-base mb-5">An email verification is required to continue on our platform.<br/>Click on the link we've emailed to you to verify your account.</div>
      <p
        v-if="$page.props.flashes"
        class="text-green-500/90 text-sm font-bold mb-2"
        :class="{'text-red-500/80': $page.props.flashes.type == 'fail'}"
      >
          {{$page.props.flashes.msg}}
      </p>
      <div class="mb-3.5">
        <Link class="rounded-md text-white bg-sky-400 px-3 py-1.5 mr-2" :href="route('dashboard')" v-wave><i class="la la-check-circle"></i> I Have Veified</Link>
        <Link class="rounded-md text-white bg-[#3f3d56] px-3 py-1.5" :href="route('sendMail')" v-wave><i class="la la-send -rotate-45"></i> Send Again</Link>
      </div>

      <div class="mb-5">
        <Link :href="route('logout')" class="text-gray-500/90 underline text-xl font-semibold">Or continue browsing offline.</Link>
      </div>
    </div>
  </div>
  -->
</template>