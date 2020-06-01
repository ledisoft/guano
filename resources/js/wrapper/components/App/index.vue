<template>
  <keep-alive>
    <transition name="fade" mode="out-in">
      <router-view />
    </transition>
  </keep-alive>
</template>

<script>
export default {
  name: 'App'
};
</script>

<style scoped>

</style>
