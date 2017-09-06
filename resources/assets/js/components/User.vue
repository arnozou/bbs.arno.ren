<template>
  <div class="row">
    <div class="col-md-3">
      <div class="box">

        <div class="media">
          <div class="media-left">
            <div class="image">
              <img class="media-object avatar-100 avatar img-thumbnail" :src="user.avatar_url">
            </div>

            <div class="role-label">
              <!-- <a class="label label-success role" href="https://laravel-china.org/roles/1">创始人</a> -->
            </div>
          
          </div>
          <div class="media-body">
            <h3 class="media-heading" v-text="user.nick_name">
            </h3>
            <div class="item" v-text="gender[user.gender]">
            </div>
            <div class="item" >
              第 {{user.id}} 位会员
            </div>
            <div class="item number">
              注册于 <span data-toggle="tooltip" data-placement="top" v-text="moment(user.created_at).fromNow()" :title="user.created_at"></span>
            </div>

            <!-- <div class="item number">
              活跃于 <span class="timeago popover-with-html" data-toggle="tooltip" data-placement="top" title=""></span>
            </div> -->
          </div>

        </div>

        <div class="follow-info row">
          <!-- <div class="col-xs-4">
            <a class="counter" href="https://laravel-china.org/users/1/followers">1012</a>
            <a class="text" href="https://laravel-china.org/users/1/followers">关注者</a>
          </div> -->

          <div class="col-xs-offset-2 col-xs-5">
              <router-link class="counter" :to="'/user/' + user.id + '/replies'">2288</router-link>
              <router-link class="text" :to="'/user/' + user.id + '/replies'">讨论</router-link>
          </div>
          <div class="col-xs-5">
              <router-link class="counter"  :to="'/user/' + user.id + '/topics'">18</router-link>
              <router-link class="text" :to="'/user/' + user.id + '/topics'">文章</router-link>
          </div>
        </div>
        <router-link class="btn btn-primary btn-block" :to="'/user/' + user.id + '/edit'" v-show="user.id == $store.state.login.id">
            <i class="fa fa-edit"></i> 编辑个人资料
        </router-link>
      </div>
    </div>


    <div class="col-md-9">

      <div class="panel panel-default">
        <div class="panel-heading">
          主题
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item" v-for="topic in userTopics">

              <router-link :to="'/topic/' + topic.id" v-text="topic.title"></router-link>              

              <span class="meta">
                <router-link :to="'/categories/' + topic.category_id" v-text="topic.category_name">></router-link>
                <span> ⋅ </span>
                {{topic.vote_count}} 点赞
                <span> ⋅ </span>
                {{topic.reply_count}} 回复
                <span> ⋅ </span>
                <span  data-toggle="tooltip" data-placement="top" :title="topic.created_at" v-text="moment(topic.created_at).fromNow()"></span>
              </span>
            </li>
            <li class="list-group-item" v-show="userTopics.length == 0">
              暂无主题
            </li>
          </ul>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          评论
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item" v-for="reply in userReplies">

                <router-link :to="'/topic/' + reply.topic_id" v-text="reply.topic_title"></router-link>
                <span class="meta">
                   at 
                   <span data-toggle="tooltip" data-placement="top" :title="reply.created_at" v-text="moment(reply.created_at).fromNow()"></span>
                </span>

                <div class="reply-body markdown-reply content-body" v-html="reply.body">
                </div>
            </li>
            <li class="list-group-item" v-show="userReplies.length == 0">
              暂无评论
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  import * as moment from 'moment'

  export default {
    data() {
      return {
        user:{},
        gender:{0:'female',1:'male'},
        userTopics:[],
        userReplies:[],
      }
    },
    watch:{
      $route() {
        this.fetchData();
      }
    },
    created(){
      this.fetchData();
    },
    methods:{
      fetchData() {
        axios.get('/users/' + this.$route.params.user_id).then((response) => {
          this.user = response.data.data
          axios.all([this.fetchUserTopics(), this.fetchUserReplies()])
        }).catch((error) => {
          this.user = {}
          console.log('error get user');
        })
      },
      fetchUserTopics(){
        return axios.get('/users/' + this.$route.params.user_id + '/topics').then((response) => {
          
          this.userTopics = response.data.data ? response.data.data : [];
          console.log('success get userTopics');
        }).catch((error) => {
          this.userTopics = []
          console.log('error get userTopics');
        })
      },
      fetchUserReplies()
      {
        return axios.get('/users/' + this.$route.params.user_id + '/replies').then((response) => {
          this.userReplies = response.data.data ? response.data.data: [];
        }).catch((error) => {
          this.userReplies = []
        })
      },
      moment(date) {
        return moment(date)
      }
    }
  }
  
</script>

<style>
  .box {
    background-color: #fff;
    padding: 10px;
    margin: 0 0 20px 0;
    box-shadow: 0 .2em 0 0 #ddd,0 0 0 1px #ddd;
  }
  .avatar-100 {
    width:100px;
    height:100px;
  }
</style>