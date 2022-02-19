<template>
  <div class="bg-white">

    <NewsFilters />

    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
      <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">News List</h2>

      <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="item in news" :key="item.id" class="group relative">
          <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
            <a :href="`/news/${item.code}`">
            <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-03.jpg" class="w-full h-full object-center object-cover lg:w-full lg:h-full" />
            </a>
          </div>
          <div class="mt-4">
            <div>
              <p class="mt-1 text-sm text-gray-500">{{ item.title }}</p>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ item.preview_text }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import NewsFilters from "./filters.vue"
  import { useStore } from '@/stores/news.ts'
  import { storeToRefs } from 'pinia'
  const store = useStore()
  store.loadNews()
  const { news, filters, last_page, per_page, has_pages, total } = storeToRefs(store)
</script>

<script>
export default {
  props:{
    example: {
      type    : Boolean,
      default : false,
    },
  },
}
</script>

<style lang="postcss" scoped>
.badge {
  @apply inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700;
    &:hover {
       @apply bg-gray-300;
     }
}
</style>