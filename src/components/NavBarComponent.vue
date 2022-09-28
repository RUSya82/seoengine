<template>
  <div class="container">
  <nav class="navbar navbar-expand-lg bg-light mb-2 border border-primary rounded p-3">
<!--    <div class="container">-->
      <a class="navbar-brand" href="#">HeaderSeacher</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link to="/" class="nav-link" >Home</router-link>
<!--            <a class="nav-link active" aria-current="page" href="#">Home</a>-->
          </li>
          <li class="nav-item">
            <router-link to="/result" class="nav-link" v-slot="{isActive}">Result</router-link>
<!--            <a class="nav-link" href="#">Result</a>-->
          </li>

        </ul>
      </div>
<!--    </div>-->
  </nav>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>

</style>