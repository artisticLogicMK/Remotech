<script setup>
import Header from '../Components/Homepage/Header.vue'
import Testimonials from '../Components/Homepage/Testimonials.vue'
import Features from '../Components/Homepage/Features.vue'
import Company from '../Components/Homepage/Company.vue'
import Footer from '../Components/Homepage/Footer.vue'

defineProps({
  canLogin: Boolean,
  canRegister: Boolean
})
</script>

<template>
  <Header :canLogin="canLogin" :canRegister="canRegister" />
  
  <main>
    <Testimonials />
    <Features />
    <Company />
  </main>
  
  <footer>
    <Footer />
  </footer>
</template>