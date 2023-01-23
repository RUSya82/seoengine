<template>
  <div class="container">
<!--  <nav class="navbar navbar-expand-lg bg-light mb-2 border border-primary rounded p-3">-->
<!--&lt;!&ndash;    <div class="container">&ndash;&gt;-->
<!--      <a class="navbar-brand" href="#">HeaderSeacher</a>-->

<!--      <div class="collapse navbar-collapse" id="navbarSupportedContent">-->
<!--        <ul class="navbar-nav me-auto mb-2 mb-lg-0">-->
<!--          <li class="nav-item">-->
<!--            <router-link to="/" class="nav-link" >Home</router-link>-->
<!--          </li>-->
<!--          <li class="nav-item">-->
<!--            <router-link to="/result" class="nav-link" v-slot="{isActive}">Result</router-link>-->
<!--          </li>-->

<!--        </ul>-->
<!--      </div>-->
<!--  </nav>-->
    <b-navbar toggleable="md" type="dark" class="navbar navbar-expand-lg bg-light mb-2 border border-primary rounded p-3">
      <!--    <div class="container">-->
      <b-navbar-brand  to="/">HeaderSeacher</b-navbar-brand>
      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav class="ml-auto mb-2 ">
<!--        <ul class="navbar-nav me-auto mb-2 mb-lg-0">-->
<!--          <li class="nav-item">-->
<!--            <router-link to="/" class="nav-link" >Home</router-link>-->
<!--          </li>-->
          <b-nav-item to="/" exact exact-active-class="active border-bottom border-3 border-primary border-opacity-75">Home</b-nav-item>
          <b-nav-item to="/result" exact exact-active-class="active border-bottom border-3 border-primary border-opacity-75">Result</b-nav-item>
<!--          <li class="nav-item">-->
<!--            <router-link to="/result" class="nav-link" v-slot="{isActive}">Result</router-link>-->
<!--          </li>-->

<!--        </ul>-->
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>

</style>