<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});
</script>

<template>
  <header class="relative w-full max-w-2xl px-6 py-12 mx-auto lg:max-w-7xl">
    <nav class="flex justify-end">
      <Link
        :href="route('login')"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
      >
        Log in
      </Link>

      <Link
        v-if="canRegister"
        :href="route('register')"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
      >
        Register
      </Link>
    </nav>
  </header>
</template>
