<template>
  <component :is="layout">
    <RouterView/>
  </component>
</template>

<script>
export default {
  computed: {
    layout() {
      return this.$route.meta.layout || 'default-layout'
    }
  }
}
</script>

<style>
@import "@/assets/base.css";
</style>
