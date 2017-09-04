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
       category: 0,
       // category: 1,
      }
    },
    watch: {
      $route() {
        console.log('路由改变');
        this.fetchData();
      }
    },
    methods: {
      fetchData() {
        console.log('category_id', this.$route.params['categories_id']);
        this.category = this.$route.params['categories_id'] ? this.$route.params['categories_id'] : 0;
        let categoryUrl = 'categories' + (this.category ? '/' + this.category : '')
        axios.get(categoryUrl).then((response) => {
          this.categories = response.data.data
          console.log('success get categories');
        }).catch((error) => {
          console.log('error get categories')
        })

        if (!this.category) {
          return
        }
        axios.get('categories/'+ this.category + '/topics').then((response) => {
          this.topics = response.data.data
          console.log('data topics', response.data);
        }).catch((error) => {
          console.log('error get topics list');
        })
      }
    },
    created() {
      this.fetchData();
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
