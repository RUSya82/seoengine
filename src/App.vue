<template>
  <nav-bar-component/>
  <router-view/>
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
