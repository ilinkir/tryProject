<template>
  <NewsList />
</template>

<script setup>
import NewsList from "@/components/shared/news/list.vue";
</script>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>