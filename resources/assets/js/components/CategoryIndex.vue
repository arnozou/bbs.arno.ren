<template>
  <div>
    <categories :categories="categories"></categories>
    <topics :topics="topics"></topics>
  </div>
</template>

<script>

  import Categories from './Categories.vue'
  import Topics from './Topics.vue'

  export default {
    data() {
      return {
       categories:[], 
       topics:[],
       // category: 0,
       category: 1,
      }
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


      axios.get('categories/'+ this.category +'/topics').then((response) => {
        this.topics = response.data.data
        console.log('data topics', response.data);
      }).catch((error) => {
        console.log('error get topics list');
      })
    },
    mounted() {
      console.log('mounted');
    },
    components:{
      categories:Categories,
      topics:Topics
    }
  }
</script>

<style scoped>
  .glyphicon {
    left:2px;
  }
</style>
