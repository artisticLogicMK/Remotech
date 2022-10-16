<template>
  <div class="bg-cover bg-center w-full h-full" style="background-image: url('/images/patternpad.png')">

    <div class="table h-screen w-full md:w-auto mx-auto bg-white xsm:bg-transparent">
      <div class="table-cell align-top sm:align-middle">

        <div class="md:flex w-full xsm:w-11/12 sm:w-5/6 md:w-auto mx-auto xsm:my-5 items-stretch justify-center shadow-none xsm:shadow-lg rounded-xl md:min-w-[680px]">

          <div class="flex-1 flex flex-col max-w-auto md:max-w-xs bg-gradient-to-br from-sky-400 to-teal-400 xsm:rounded-t-xl md:rounded-none md:rounded-l-xl p-3">
            <div class="text-3xl md:text-2xl text-white/90 font-semibold leading-[0]">
              <Link :href="route('home')"><i class="la la-wifi"></i>Remotech</Link>
            </div>
            <div class="grow flex items-center justify-center mt-5 md:mt-0">
              <div v-if="$page.component == 'Auth/Login' || $page.component ==  'Auth/ForgotPassword' || $page.component ==  'Auth/ResetPassword'">
                <div class="text-white/80 text-base sm:text-lg font-semibold text-center mb-2">
                  Log in to post a job. <br class="md:hidden"/>Job listing made easy!
                </div>
                <img src="/images/login.svg" class="w-64 mx-auto">
              </div>

              <div v-if="$page.component == 'Auth/Register'">
                <div class="text-white/80 text-base sm:text-lg font-semibold text-center mb-2">
                  Job listing has never been made easier and faster.
                </div>
                <img src="/images/signup.svg" class="w-64 mx-auto">
              </div>
            </div>
          </div>

          <slot />
          
        </div>

      </div>
    </div>
  </div>
</template>