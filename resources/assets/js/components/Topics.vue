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
      <router-link :to=" '/topics/' + topic.id">{{topic.title}}</router-link>
      <br>
      <small class="hidden-xs">
        <span class="timeago" title="2017年8月11日 上午9:18" :datetime="topic.created_at">23天之前</span>
         • 
        <router-link :to="'/user/' + topic.creator.id" :text="topic.creator.nick_name"></router-link>
      </small>
        <small class="visible-xs-inline">
          <span class="timeago" title="2017年8月22日 下午7:17" :datetime="topic.created_at">12天之前</span>
        </small>
    </h2>
  </div>

    <div class="col-md-1 hidden-sm hidden-xs stats">
    <span class="{children.unread-class} human-readable-number" title="topic.reply_count">{{topic.reply_count}}</span><br>
    <small>主题</small>
  </div>
  <div class="col-md-1 hidden-sm hidden-xs stats">
    <span class="{children.unread-class} human-readable-number" title="topic.reply_count">{{topic.vote_count}}</span><br>
    <small>帖子</small>
  </div>
    <div class="col-md-3 col-sm-3 teaser hidden-xs" component="topic/teaser">
          <div class="card" style="border-color: #DC9656">

            <div component="category/posts">
          <p>
            <a href="/user/izzq920817">
                      <span class="user-icon user-img" title="" style="background-color: #673ab7;" data-original-title="iZzq920817">I</span>
            </a>
            <a class="permalink" href="/topic/595/psp游戏-极品飞车13变速-美版/1">
              <small class="timeago" title="2017年8月27日 下午12:26" datetime="2017-08-27T04:26:44.322Z">大约7小时之前</small>
            </a>
          </p>
          <div class="post-content">
            </p>
            <p><a href="https://www.pipipan.com/fs/14160278-217184527" rel="nofollow">立即下载</a></p>

          </div>
        </div>

        
      </div>
  </div>


  



 <!--  <li component="category/topic" class="row clearfix category-item pinned" data-tid="475" data-index="0" data-cid="3" itemprop="itemListElement"> -->
    <meta itemprop="name" content="【求助资源】在这里求助任何资源">

    <div class="col-md-7 col-sm-9 col-xs-10 content">
      <div class="avatar pull-left" title="" data-original-title="iZzq920817">
        

                <a href="/user/izzq920817" class="pull-left">
                              <div class="user-icon" style="background-color: #673ab7;" data-original-title="" title="">I</div>
        </a>

      </div>

      <h2 component="topic/header" class="title">
        <i component="topic/pinned" class="fa fa-thumb-tack " title="已固定"></i>
        <i component="topic/locked" class="fa fa-lock hide" title="已锁定"></i>
        <i component="topic/moved" class="fa fa-arrow-circle-right hide" title="已移动"></i>
        

                <a href="/topic/475/求助资源-在这里求助任何资源/16" itemprop="url">【求助资源】在这里求助任何资源</a><br>

        

        

        <small class="hidden-xs"><span class="timeago" title="2017年8月11日 上午9:18" datetime="2017-08-11T01:18:07.771Z">23天之前</span> • <a href="/user/izzq920817">iZzq920817</a></small>
        <small class="visible-xs-inline">
                    <span class="timeago" title="2017年8月22日 下午7:17" datetime="2017-08-22T11:17:58.938Z">12天之前</span>
        </small>
      </h2>
    </div>

    <div class="mobile-stat col-xs-2 visible-xs text-right">
      <span class="human-readable-number">35</span> <a href="/topic/475/求助资源-在这里求助任何资源/35"><i class="fa fa-arrow-circle-right"></i></a>
    </div>

    <div class="col-md-1 hidden-sm hidden-xs stats">
      <span class="human-readable-number" title="35">35</span><br>
      <small>帖子</small>
    </div>

    <div class="col-md-1 hidden-sm hidden-xs stats">
      <span class="human-readable-number" title="2089">2.1k</span><br>
      <small>浏览</small>
    </div>

    <div class="col-md-3 col-sm-3 teaser hidden-xs" component="topic/teaser">
      <div class="card" style="border-color: #86ba4b">
                        <p>
          <a href="/user/izzq920817">
                        <span title="" class="user-icon user-img" style="background-color: #673ab7;" data-original-title="iZzq920817">I</span>
          </a>
          <a class="permalink" href="/topic/475/求助资源-在这里求助任何资源/35">
            <span class="timeago" title="2017年8月22日 下午7:17" datetime="2017-08-22T11:17:58.938Z">12天之前</span>
          </a>
        </p>
        <div class="post-content">
          <p><a class="plugin-mentions-a" href="http://ppsspp.cn/uid/536">@无痕</a> .。。。</p>

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
