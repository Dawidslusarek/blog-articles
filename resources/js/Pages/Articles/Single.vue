<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UnauthenticatedLayout from "@/Layouts/UnauthenticatedLayout.vue";
import CommentForm from "@/Components/Form/CommentForm.vue";

import { Head, Link } from "@inertiajs/vue3";
import { useArticle } from "@/composables/useArticle";

const {
  user,
  article,
  comments,
  modalShown,
  form,
  handleModal,
  submit,
  formatDate,
} = useArticle();
</script>

<template>
  <Head :title="`Article - ${article.title}`" />

  <AuthenticatedLayout v-if="user">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Articles</h2>
    </template>
  </AuthenticatedLayout>
  <UnauthenticatedLayout v-else></UnauthenticatedLayout>
  <div class="py-12">
    <div class="mx-auto bg-white shadow-sm max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
      <Link
        class="block py-4 underline"
        :href="route('articles-list')"
        :active="route().current('articles-list')"
      >
        Back to articles
      </Link>
      <h1 class="pb-3 text-3xl font-bold border-b border-b-black">{{ article.title }}</h1>
      <div class="p-10 text-lg">{{ article.content }}</div>
    </div>
    <div
      class="p-10 mx-auto mt-6 bg-white shadow-sm max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg"
    >
      <div class="flex items-center justify-between">
        <h2>Comments</h2>
        <button
          v-if="user"
          type="button"
          @click="handleModal()"
          class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
        >
          Add comment
        </button>
      </div>
      <div v-if="user">
        <div v-if="comments.length > 0" v-for="comment in comments">
          <div class="flex items-center mb-4 border-b gap-x-6 border-b-gray-400">
            {{ comment.body }}
            <span class="text-xs text-gray-500">
              {{ comment.name }}, {{ formatDate(comment.created_at) }}</span
            >
          </div>
        </div>
        <div class="py-6" v-else>No comments yet, add first!</div>
      </div>
      <div class="py-6" v-else>
        <Link class="underline" :href="route('login')"> Log in </Link>

        to see comments
      </div>
    </div>
  </div>
  <CommentForm
    :form="form"
    :user="user"
    :isOpen="modalShown"
    @modal-close="handleModal"
    @submit="submit"
  ></CommentForm>
</template>
