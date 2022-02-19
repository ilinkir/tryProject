<template>
  <div class="about">
    <h1>This is an about page</h1>
    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
    <NewsList />
  </div>
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
