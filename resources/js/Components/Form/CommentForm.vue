<script setup>
const props = defineProps({
  isOpen: Boolean,
  form: Object,
  user: Object,
});

const emit = defineEmits(["modal-close"]);
</script>
<template>
  <div
    v-if="isOpen"
    class="fixed top-0 left-0 z-10 flex items-center justify-center w-full h-full backdrop-blur-md"
  >
    <div class="flex flex-col w-full max-w-lg px-10 py-6 bg-white rounded-lg shadow-md">
      <div class="flex justify-end">
        <button
          @click="emit('modal-close')"
          type="button"
          class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
        >
          <span class="sr-only">Close menu</span>
          <!-- Heroicon name: outline/x -->
          <svg
            class="w-6 h-6"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="red"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
      <h1 class="py-6">Add comment</h1>
      <form @submit.prevent="submit" class="w-full mx-auto">
        <div class="mb-5">
          <label for="body" class="block mb-2 text-sm font-medium text-gray-900"
            >Comment body</label
          >
          <textarea
            v-model="form.body"
            type="text"
            id="body"
            class="shadow-sm border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
            placeholder="Example description"
            required
          />
        </div>
        <input type="hidden" v-model="form.user_id" />
        <input type="hidden" v-model="form.article_slug" />
        <button
          type="submit"
          class="block ml-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          Add
        </button>
      </form>
    </div>
  </div>
</template>
