<template>
  <div class="row">
    <div class="col-lg-9 col-sm-12">
      <div class="loading" v-if="loading">
        loading....
      </div>

      <div class="error" v-if="error">
        error
      </div>

      <div class="topic" v-if="topic">
        <div class="topic-header">
          <h1 class="hidden-xs">
            <span class="topic-title" v-text="topic.title"></span>
          </h1>
          <router-link :to="'/categories/' + topic.category_id">分类名</router-link>
          <router-link :to="'/user/' + topic.creator.id" v-text="topic.creator.nick_name"></router-link>
          于
          <router-link :to="'/topic/' + topic.id" v-text="moment(topic.created_at).fromNow()"></router-link>
          last reply: 
          <router-link :to="'/user/' + topic.last_reply.creator.id" v-text="topic.last_reply.creator.nick_name"></router-link>
          <router-link :to="'/topic/' + topic.id" v-text="moment(topic.last_reply.created_at).fromNow()"></router-link>
        </div>
        
        <div class="topic-body" v-html="topic.body"></div>
        
        <replies :initial-replies="replies"></replies>
        <replying :topic="topic"></replying>
      </div>
      
      
    </div>
    <div class="col-lg-3 col-sm-12 hidden"></div>
  </div>
</template>

<script>

  import Replies from './Replies.vue'
  import Replying from './Replying.vue'
  import * as moment from 'moment'

  export default{
    data() {
      return {
        loading:false,
        error:null,
        errororigin:null,
        topic:null,
        replies:null,
      }
    },
    created(){
      this.fetchData();
    },
    watch: {
      // 如果路由有变化，会再次执行该方法
      '$route': 'fetchData'
    },
    methods:{
      fetchData () {

        this.loading = true;
        axios.get('topics/' + this.$route.params.topic_id).then((response) => {
          this.topic = response.data.data
          this.loading = false
          console.log('success get topic');
        }).catch((error) => {
          this.error = error.response.data
          this.errororigin = error
          console.log('error get categories')
        })

        axios.get('topics/' + this.$route.params.topic_id + '/replies').then((response) => {
          this.replies = response.data.data
          this.loading = false
          console.log('success get replies');
        }).catch((error) => {
          this.error = error.response.data
          this.errororigin = error
          console.log('error get categories')
        })
      },
      moment(date) {
        return moment(date)
      }
    },

    components:{
      replies: Replies,
      replying: Replying
    }
  }
</script>

<style scoped>
  .topic-title{
    text-transform: initial;
    word-wrap: break-word;
    font-size: 28px;
    color: inherit;
    line-height: 32px;
    overflow: hidden;
    margin-top: 8px;
    display: inline-block;
    font-weight: 700;
  }
  .topic-header{
    border-bottom: 1px solid #716a6a;
  }
  .topic-header, .topic-body{
    background-color: white;
  }
</style>