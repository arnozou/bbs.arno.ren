<template> 
  <div class="composer" v-show="showModel">
    <div class="composer-container">
      <div class="row title-container">
        <div class="col-lg-7 col-md-12">
          <input class="title form-control" tabindex="1" placeholder="在此输入您主题的标题..." v-model="title" type="text">
        </div>
        <div class="col-lg-3 col-md-6">
          <select class="form-control" name="category_id" v-model="categoryId" id="">
            <option v-for="category in categories" :value="category.id" v-text="level(category.parent_id) + category.title"></option>
          </select>
        </div>
        <div class="col-lg-2 col-md-6">
          <button class="btn btn-default" @click="close()">取消</button>
          <button class="btn btn-primary" @click="post">提交</button>
        </div>
      </div>
    </div>

   <markdown-editor v-model="body" preview-class="markdown-body" :configs="configs"></markdown-editor>
   <!-- <markdown-editor v-model="body" preview-class="markdown-body" :configs="configs"></markdown-editor> -->
  </div>
   
</template>

<script>
  import markdownEditor from 'vue-simplemde/src/markdown-editor'
  import * as marked from 'marked'
  import * as _ from 'lodash'
  import bus from './Bus'

  export default {
    // props:['showModel'],
    data() {
      return {
        // showModel: false,
        configs:{
          // placeholder:marked
          parsingConfig:{
            allowAtxHeaderWithoutSpace:false,
            strikethrough:false,
            underscoresBreakWords:false
          },
          renderingConfig:{
            singleLineBreaks:false
          },
          toolbar:['bold', 'italic', 'strikethrough', 'heading', '|', 'code', 'quote', 'unordered-list', 'ordered-list', '|', 'link', 'image', 'table', 'horizontal-rule', '|', 'preview', 'guide', 'side-by-side', 'fullscreen']
        },
        title:'',
        body:'',
        categories:[],
        categoryId:0,
      }
    },
    components: {
      markdownEditor
    },
    computed:{
      showModel(){
        return this.$store.state.showWriter
      }
    },
    created() {
      axios.get('categories', {
        params:{
          'parent_id': -1
        }
      }).then((response) => {
        this.categories = response.data.data;
      })

    },
    /*mounted() {
      bus.$on('showModel', () => {
        console.log('get event');
        if (this.$store.state.login.id) {
          this.showModel = true
        }
      })
    },*/
    watch:{
      $route(){
        this.close()
      }
    },
    methods:{
      level(parentId) {
        var foundId
        var n = [];
        while (parentId) {
          n.push('--');
          foundId = _.findIndex(this.categories, function(item) {
            return item.id == parentId
          })
          parentId = this.categories[foundId].parent_id;
        }
        n.push('*');

        return n.join('');
      },
      post() {
        if (this.title.length < 2 || this.body.length < 10) {
          console.log('内容不能\'太\'简介了');
          return 
        }
        axios.post('categories/'+ this.categoryId +'/topics', {
          title:this.title,
          body:this.body
        }).then((response) => {
          this.showModel = false
          this.$router.push('/categories/'+this.categoryId);
        }).catch((error) => {
          if (error.response.status == 401) {
            alert('请登录');
            this.$router.push('/login');
          }
        })
      },
      close(){
        this.$store.commit('showWriter', false);
      }
    },

  }
</script>

<style scoped>
 .composer{
  top: 54.3307%;
  box-shadow: 0 6px 12px rgba(0,0,0,.5);
  padding-top: 30px;
  padding-left: 15px;
  padding-right: 15px;
  z-index: 1050;
  position: fixed;
  right: 0;
  left: 0;
  bottom: 0;
 } 
 @import '~simplemde/dist/simplemde.min.css';
 @import  '~github-markdown-css';
</style>