<template>
  <ul>
    <li class="row clearfix" v-for="category in categories">
     



  <div class="content col-xs-12 col-md-7 col-sm-9">
    <div class="icon pull-left" :style="{'color':category.color, 'background-color':category.bg_color}">
      <span class="glyphicon" :class="[category.icon]" aria-hidden="true"></span>
    </div>

    <h2 class="title">
      <router-link :to=" '/categories/' + category.id" >{{category.title}}</router-link>
      <br>
      <div class="description">
        <p>{{category.description}}</p>
      </div>
            <span class="category-children">
            <router-link :to="'/categories/' + child.id" v-for="child in category.children" :key="child.id">
              <span class="child-icon" :style="{'color':child.color, 'background-color':child.bg_color}">
                <span class="glyphicon" :class="[child.icon]" aria-hidden="true"></span>
              </span>
              <small>{{child.title}}</small>
            </router-link>

            </span>
    </h2>
    <span class="visible-xs pull-right">
      
    </span>
  </div>

    <div class="col-md-1 hidden-sm hidden-xs stats">
    <span class="{children.unread-class} human-readable-number" title="150" v-text="category.topic_count"></span><br>
    <small>主题</small>
  </div>
  <!-- <div class="col-md-1 hidden-sm hidden-xs stats">
    <span class="{children.unread-class} human-readable-number" v-text="category.topic_count">233</span><br>
    <small>帖子</small>
  </div> -->
    <div class="col-md-3 col-sm-3 teaser hidden-xs" component="topic/teaser">
      <div class="card" style="border-color: #DC9656" v-if="category.last_reply">

        <div component="category/posts" >
          <p>
            <router-link :to="'/user/' + creator(category.last_reply).id">
              <img class="avatar avatar-20" :src="creator(category.last_reply).avatar_url" alt="">
            </router-link>
            <router-link :to="'/topic/' + category.last_reply.topic_name" >
              <small class="timeago" title="category.last_reply.created_at" datetime="2017-08-27T04:26:44.322Z" v-text="moment(category.last_reply.created_at).fromNow()"></small>
            </router-link>
          </p>
          <div class="post-content" v-html="category.last_reply.body">
            
          </div>
        </div>

      </div>
      <div class="card" style="border-color: #DC9656" v-else>
        <div>
          暂无回复
        </div>
      </div>
  </div>






    </li>
  </ul>
</template>

<script>

  import * as moment from 'moment'

  export default {
    props:['categories'],
    data() {
      return {
      }
    },
    computed:{
    },  
    watch: {
    },
    methods: {
      moment(data) {
        return moment(data)
      },
      creator(item) {
        if (item.creator) {
          return item.creator
        }

        return {}
      }
    },
  }
</script>

<style scoped>
  li {
    padding-top: 10px;
    padding-bottom: 10px;
    min-height: 53px;
  }
  .icon{
    font-size: 17px;
    line-height: 17px;
    padding: 13px;
    border-radius: 50%;
    margin-right: 15px;
    min-width: 46px;
    min-height: 46px;
    margin-top: 2px;
  }
  .child-icon{
    font-size: 10px;
    padding: 3px;
    border-radius: 50%;
    margin-right: 2px;
  }
  h2 {
    display: block;
    word-wrap: break-word;
    overflow: hidden;
    font-size: 18px;
    line-height: 22px;
    margin: 0 0 0 62px;
  }
  .glyphicon {
    left:1px;
  }
  li .card {
    border-left: 4px solid #ccc;
    border-left-color: rgb(204, 204, 204);
    text-align: left;
    margin-top: 2px;
    overflow: hidden;
    height: 53px;
    font-size: 12px;
    line-height: 14px;
  }
</style>
<style scoped>
  .avatar-20 {
    width: 20px;
    height:20px;
  }
</style>
