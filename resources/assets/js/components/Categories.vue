<template>
  <ul>
    <li class="row clearfix" v-for="category in categories">
     



  <div class="content col-xs-12 col-md-7 col-sm-9">
    <div class="icon pull-left" :style="{'color':category.color, 'background-color':category.bg_color}">
      <span class="glyphicon" :class="[category.icon]" aria-hidden="true"></span>
    </div>

    <h2 class="title">
      <router-link :to=" '/categories/' + category.id">{{category.title}}</router-link>
      <br>
      <div class="description">
        <p>{{category.description}}</p>
      </div>
            <span class="category-children">
            <router-link :to="'/category/' + child.id" v-for="child in category.children" :key="child.id">
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
            <p>游戏平台：PSP游戏<br>
              类型：竞速游戏<br>
              语言：美版游戏<br>
              厂商：EA<br>
              发行时间：2009-9-15<br>
              更新时间：2013-10-23 16:09:27 16:09<br>
              游戏大小：929 MB<br>
              游戏汉化：暂无汉化<br>
            </p>
            <p><a href="https://www.pipipan.com/fs/14160278-217184527" rel="nofollow">立即下载</a></p>

          </div>
        </div>

        
      </div>
  </div>






    </li>
  </ul>
</template>

<script>



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
