<template>
  <div class="bg-white">

    <NewsFilters>
      <div>
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
    </NewsFilters>
<!--    <Paginate-->
<!--        :page-count="20"-->
<!--        :page-range="3"-->
<!--        :margin-pages="2"-->
<!--        :click-handler="pageChange"-->
<!--        :prev-text="'Prev'"-->
<!--        :next-text="'Next'"-->
<!--        :container-class="'pagination'"-->
<!--        :page-class="'page-item'"-->
<!--    />-->

    <!--    <VuePaginationTw-->
<!--        :total-items="total"-->
<!--        :current-page="current_page"-->
<!--        :per-page="per_page"-->
<!--        @page-changed="pageChanged"-->
<!--        :go-button="false"-->
<!--        styled="centered"-->
<!--    />-->
    <Pagination v-if="has_pages" :current-page="current_page" :per-page="per_page" :total="total" :last-page="last_page" :each-side="3" />

  </div>
</template>

<script setup>
  import NewsFilters from "./filters.vue"
  import Pagination from "../pagination.vue";
  import { useStore } from '@/stores/news.ts'
  import { storeToRefs } from 'pinia'
  const store = useStore()
  store.loadNews()
  const { news, filters, last_page, per_page, has_pages, total, current_page } = storeToRefs(store)
</script>

<script>
export default {
  props:{
    example: {
      type    : Boolean,
      default : false,
    },
  },
  methods: {
    pageChange(page){
      console.log(page)
    }
  }
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