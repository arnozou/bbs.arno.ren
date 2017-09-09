<template> 
  <div class="composer" v-show="showModel">
    <div class="composer-container">
      <div class="row title-container">
        <div class="col-lg-7 col-md-12">
          <input class="title form-control" tabindex="1" placeholder="在此输入您主题的标题..." v-model="title" type="text">
        </div>
        <div class="col-lg-3 col-md-6">
          <select name="category_id" v-model="categoryId" id="">
            <option v-for="category in categories" value="category.id" v-text="level(category.parent_id) + category.title"></option>
          </select>
        </div>
        <div class="col-lg-2 col-md-6">
          <button class="btn btn-default" @click="showModel = false">取消</button>
          <button class="btn btn-primary" @click="post">提交</button>
        </div>
      </div>
    </div>

   <markdown-editor v-model="body" preview-class="markdown-body" :configs="configs"></markdown-editor>
  </div>
   
</template>

<script>
  import markdownEditor from 'vue-simplemde/src/markdown-editor'
  import * as marked from 'marked'
  import * as _ from 'lodash'
  export default {
    data() {
      return {
        showModel: false,
        configs:{
          // placeholder:marked
          toolbar:['bold', 'italic', 'strikethrough', 'heading', '|', 'code', 'quote', 'unordered-list', 'ordered-list', '|', 'link', 'image', 'table', 'horizontal-rule', '|', 'preview', 'guide']
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
    created() {
      axios.get('categories', {
        params:{
          'parent_id': -1
        }
      }).then((response) => {
        this.categories = response.data.data;
      })
    },
    methods:{
      level(parentId) {
        var foundId
        var n = [];
        while (parentId) {
          n.push('  ');
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
          this.$router.push('/categories/'+this.categoryId);
        })
      }
    }
  }
</script>

<style scoped>
 .composer{
  top: 54.3307%;
  box-shadow: 0 6px 12px rgba(0,0,0,.5);
  padding-top: 30px;
  padding-left: 15px;
  padding-right: 15px;
  z-index: 1000;
  position: fixed;
  right: 0;
  left: 0;
  bottom: 0;
 } 
 @import '~simplemde/dist/simplemde.min.css';
 @import  '~github-markdown-css';
</style>