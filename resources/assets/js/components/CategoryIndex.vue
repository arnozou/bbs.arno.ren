<template>
  <categories :categories="categories"></categories>
</template>

<script>

  import Categories from './Categories.vue'

  export default {
    data() {
      return {
       categories:[], 
      }
    },
    computed:{
    },  
    watch: {
      $route() {
        console.log('路由改变');
      }
    },
    methods: {
    },
    created() {
      axios.get('categories').then((response) => {
        this.categories = response.data.data
        console.log('success get categories');
      }).catch((error) => {
        console.log('error get categories')
      })
    },
    mounted() {
      console.log('mounted');
    },
    components:{
      categories:Categories
    }
  }
</script>

<style scoped>
  .glyphicon {
    left:2px;
  }
</style>
