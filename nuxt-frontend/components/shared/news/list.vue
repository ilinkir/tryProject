<template>
  <div>
    hrehberberher
  </div>
</template>

<script setup>
const news = await useFetch('/api/news')
</script>

<script>
export default {
  mounted() {
    console.log(this.news.data.value.data[0])
  }
}
</script>