<template>
  <div class="p-4">
    <div class="max-w-sm rounded overflow-hidden shadow-lg mb-4">
      <img
          class="w-full"
          src="https://tailwindcss.com/img/card-top.jpg"
          alt="Sunset in the mountains"
      >
      <div class="px-6 py-4 pb-2">
        <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
        <p
            class="text-gray-700 text-base"
        >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.</p>
      </div>
      <div class="px-6 py-4">
        <span class="badge mr-2">#photography</span>
        <span class="badge mr-2">#travel</span>
        <span class="badge">#winter</span>
      </div>
    </div>
    <NuxtLink to="/news">
      About
    </NuxtLink>
    <div>
      {{ filters }}
    </div>
  </div>
</template>

<script setup>
  import { useStore } from '@/store/news.ts'
  import { storeToRefs } from 'pinia'
  const store = useStore()
  store.loadNews()
  const { news, filters, last_page, per_page, has_pages, total } = storeToRefs(store)
</script>

<script>
import { mapState } from 'pinia'
import { useStore } from '@/store/news.ts'

export default {
  props:{
    example: {
      type    : Boolean,
      default : false,
    },
  },
  computed:{
    ...mapState(useStore, ['total'])
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