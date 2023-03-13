<template>
  <nav-bar-component/>
  <keep-alive include="HomeView">
    <router-view/>
  </keep-alive>
</template>

<style lang="scss">

</style>
<script>
import NavBarComponent from "@/components/NavBarComponent";
export default {
  components: {
    NavBarComponent,
  }
}
</script>
