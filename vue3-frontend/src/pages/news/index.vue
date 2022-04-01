<template>
  <NewsList />
</template>

<script>
import NewsList from "@/components/shared/news/list.vue";

export default {
  components: {
    NewsList,
  },
  mounted() {
    Echo.channel('helloWorld')
        .listen('TestEvent', (e) => {
          alert(e.message)
        });
    // https://vk.com/dev/using_longpoll https://ru.stackoverflow.com/questions/240025/%D0%9A%D0%BE%D0%BD%D1%82%D0%B0%D0%BA%D1%82-%D0%BD%D0%B0-%D1%81%D0%BE%D0%BA%D0%B5%D1%82%D0%B0%D1%85-%D0%B8%D0%BB%D0%B8
    // https://medium.com/@ggdev/gg-websocket-%EF%B8%8F-258e7aff8aa7
  }
}
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