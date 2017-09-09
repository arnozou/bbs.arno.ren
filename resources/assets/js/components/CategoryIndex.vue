<template>
  <div>
    
    <categories :categories="categories" v-title="title" :data-title="title"></categories>
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
       title:''
      }
    },
    watch: {
      $route() {
        // console.log('路由改变');
        this.topics = [];
        this.fetchData();

        // 改标题
        // console.log('改标题', this.$route.params.categories_id)
        if (this.$route.params.categories_id) {
          var i = this.$store.state.categories.length
          while (i--)
          {
            if (this.$store.state.categories[i].id - 0 === this.$route.params.categories_id - 0) {
              this.title = this.$store.state.categories[i].title
            }
            
          }
        } else {
          this.title = '分类';
        }
      }
    },
    methods: {
      fetchData() {
        console.log('category_id', this.$route.params['categories_id']);
        this.category = this.$route.params['categories_id'] ? this.$route.params['categories_id'] : 0;
        let categoryUrl = 'categories' + (this.category ? '/' + this.category : '')
        axios.get(categoryUrl).then((response) => {
          this.categories = response.data.data

          var categories = this.$store.state.categories.concat(this.categories)
          categories.sort(function(a, b) {
           return a.id - b.id
          })
          var i = categories.length
          while(--i)
          {
            if (categories[i].id === categories[i-1].id) {
              categories.splice(i, 1)
            }
          }
          this.$store.commit('categories', categories)
          console.log('success get categories');
        }).catch((error) => {
          console.log(error);
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
