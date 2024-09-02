<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UnauthenticatedLayout from "@/Layouts/UnauthenticatedLayout.vue";
import ArticleForm from "@/Components/Form/ArticleForm.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useArticles } from "@/composables/useArticles";

const {
  articles,
  handleModal,
  user,
  modalShown,
  submit,
  form,
  editArticle,
  deleteArticle,
  limit,
  handleArticles,
} = useArticles();

</script>

<template>
  <Head title="Articles" />

  <AuthenticatedLayout v-if="user">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Articles</h2>
    </template>
  </AuthenticatedLayout>
  <UnauthenticatedLayout v-else></UnauthenticatedLayout>
  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex justify-end w-full py-5 gap-x-5">
        <div class="flex w-full max-w-[180px] items-center gap-x-4">
          <label for="underline_select" class="text-gray-500">Posts per page</label>
          <select
            v-model="limit"
            @change="handleArticles"
            id="underline_select"
            class="block py-2.5 px-0 w-full max-w-[50px] text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 focus:outline-none focus:ring-0 focus:border-gray-600 peer"
          >
            <option selected value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
          </select>
        </div>
        <button
          v-if="user"
          type="button"
          @click="handleModal()"
          class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
        >
          Add article
        </button>
      </div>
      <div class="p-4 overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <ul class="grid grid-cols-3 gap-4">
          <li
            class="h-auto"
            v-if="articles.length > 0"
            v-for="article in articles"
            :key="article.id"
          >
            <Link
              class="block h-full p-6 duration-200 bg-white rounded-lg shadow-md cursor-pointer hover:bg-gray-100"
              :href="`articles/${article.slug}`"
            >
              <div class="flex items-start justify-between gap-x-3">
                <div class="w-full mb-4 text-2xl font-bold">
                  {{ article.title }}
                </div>
                <div v-if="user" class="flex items-center justify-center gap-x-3">
                  <button
                    @click.prevent="editArticle(article)"
                    class="flex p-1.5 bg-blue-700 rounded-xl hover:rounded-3xl hover:bg-blue-300 transition-all duration-300 text-white"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-4 h-4"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                      />
                    </svg>
                  </button>
                  <button
                    @click.prevent="deleteArticle(article)"
                    class="flex p-1.5 bg-red-700 rounded-xl hover:rounded-3xl hover:bg-red-300 transition-all duration-300 text-white"
                  >
                    <span>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-4 h-4"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                        />
                      </svg>
                    </span>
                  </button>
                </div>
              </div>
              <p>{{ article.content.substring(0, 30) }}...</p>
            </Link>
          </li>
          <li v-else>No blog posts for now. Add first!</li>
        </ul>
      </div>
    </div>
  </div>
  <ArticleForm
    :form="form"
    :user="user"
    :isOpen="modalShown"
    @modal-close="handleModal"
    @submit="submit"
  ></ArticleForm>
</template>
