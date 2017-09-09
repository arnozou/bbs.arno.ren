<template>
  <ul>
    <li class="row clearfix" v-for="topic in topics">
     



  <div class="content col-xs-12 col-md-7 col-sm-9">
    <div class="avatar pull-left" title="">
      <router-link :to="'/user/' + topic.creator.id">
        <img class="user-icon" :src="topic.creator.avatar_url">      
      </router-link>
    </div>
    
    <h2 class="title">
      <router-link :to=" '/topic/' + topic.id" v-text="topic.title"></router-link>
      <br>
      <small class="hidden-xs">
        <span class="timeago" :title="topic.created_at" :datetime="topic.created_at" v-text="topic.created_humans"></span>
         • 
        <router-link :to="'/user/' + topic.creator.id" v-text="topic.creator.nick_name"></router-link>
      </small>
        <small class="visible-xs-inline">
          <span class="timeago" :title="topic.created_at" :datetime="topic.created_at" v-text="topic.created_humans"></span>
        </small>
    </h2>
  </div>

    <div class="col-md-1 hidden-sm hidden-xs stats">
    <span class="{children.unread-class} human-readable-number" title="topic.reply_count">{{topic.reply_count}}</span><br>
    <small>回复</small>
  </div>
  <div class="col-md-1 hidden-sm hidden-xs stats">
    <span class="{children.unread-class} human-readable-number" title="topic.vote_count">{{topic.vote_count}}</span><br>
    <small>赞</small>
  </div>
    <div class="col-md-3 col-sm-3 teaser hidden-xs" component="topic/teaser">
      <div class="card" style="border-color: #DC9656">

        <div component="category/posts" v-if="topic.last_reply">
              <p>
                <!-- <router-link :to="'/user/' +  lastReplierId(topic.last_reply)"> -->
                <router-link :to="'/user/' +  (topic.last_reply.creator ? topic.last_reply.creator.id : '')">
                  <img class="user-icon" :src="(topic.last_reply.creator ? topic.last_reply.creator.avatar_url : '')" alt="">
                </router-link>
                <router-link :to="'/topic/' + topic.id"><small :title="topic.last_reply.created_at" v-text="topic.updated_humans"></small></router-link>
                <!-- <a class="permalink" href="/topic/595/psp游戏-极品飞车13变速-美版/1">
                  <small class="timeago" title="2017年8月27日 下午12:26" datetime="2017-08-27T04:26:44.322Z">大约7小时之前</small>
                </a> -->
              </p>
          <!-- <div class="post-content">
            </p>
            <p><a href="https://www.pipipan.com/fs/14160278-217184527" rel="nofollow">立即下载</a></p>
          
          </div> -->
        </div>
        <div v-else>
          <p>尚无回复</p>
        </div>

        
      </div>
  </div>



    </li>
  </ul>
</template>

<script>

  export default {
    props:['topics'],
    data() {
      return {
      }
    },
    computed:{
    },  
    watch: {
    },
    methods: {
      lastReplierId(reply) {
        console.log(typeof reply);
        if (!reply) {
          return '';
        }

        return reply.creator.id;
      },
      lastReplierAvatar(reply) {
        if (!reply) {
          return '';
        }

        return reply.creator.avatar_url;
      },
      // lastReplierAvatar()
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
  .user-icon{
    border-radius: 50%;
    width: 46px;
    height: 46px;
    line-height: 46px;
    font-size: 2.4rem;
  }
  .card .user-icon{
    display: inline-block;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    line-height: 24px;
    font-size: 1.5rem;
  }
</style>
