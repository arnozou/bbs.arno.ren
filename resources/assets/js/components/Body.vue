<template>
  <div id="content" class="container">
    <breadcrumb></breadcrumb>
    <!-- <router-link to='/login'>2</router-link>
    <br>
    <p>Child router path: {{ $route.fullPath }}</p> -->
    <router-view></router-view>
  </div>
</template>

<script>
  import Breadcrumb from './Breadcrumb.vue'
  import ContentBody from './ContentBody.vue'
  /*import VueRouter from 'vue-router'
  import Login from './Login.vue'
  
  const ChildrenRouter = new VueRouter({
    mode: 'abstract',
    routes: [
      {path:'/exam', component: ContentBody},
    ]
  })*/
  export default {
    // router: ChildrenRouter,
    components: {
      'breadcrumb' : Breadcrumb,
      // 'row' : ContentBody,
    },
  }
</script>

<style>
  #content{
    padding-top: 80px;
  }
</style>