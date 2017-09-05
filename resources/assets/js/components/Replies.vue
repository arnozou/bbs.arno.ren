<template>
  <div class="replies">
    <ul class="list-group">
      <li class="list-group-item" v-for="(reply, index) in replies">
        <div class="authorInfo">
          <router-link :to="'/user/' + reply.creator.id">
            <img class="user-icon" :src="reply.creator.avatar_url" :alt="reply.creator.nick_name">      
          </router-link>
          <router-link :to="'/user/' + reply.creator.id" v-text="reply.creator.nick_name"></router-link>

          <span v-text="moment(reply.created_at).fromNow()"></span>
        </div>

        <div class="voters" v-if="reply.vote_count"><span>{{reply.vote_count}}个赞</span></div>
        <div class="reply-body" v-html="reply.body"></div>

        <div class="reply-actions">
          <span>
            <button class="btn btn-sm" :class="{'btn-default': !reply.is_voted, 'btn-primary': reply.is_voted}" @click="vote(index)">{{reply.vote_count}}赞</button>
          </span>
        </div>
      </li>
    </ul>
    
  </div>
</template>

<script>
  import * as moment from 'moment'

  export default{
    props:['initialReplies'],
    data(){
      return {
        replies:this.initialReplies
      }
    },
    watch:{
      initialReplies() {
        this.replies = this.initialReplies
      }
    },
    methods:{
      moment(date) {
        return moment(date)
      },
      vote(index) {
        if (this.replies[index].is_voted === null) {
          // 跳到登录
          alert('请登录');
        } else if (this.replies[index].is_voted === true) {
          let method = 'post'
        } else {
          let method = 'delete'
        }
        axios({
          method:method,
          url:'/topics/replies/' + this.replies[index].id + '/vote'
        }).then((response) => {
          this.replies[index].is_voted = !this.replies[index].is_voted
          this.replies[index].vote_count = response.data.vote_count
        })

      }
    }
  }
</script>

<style>
  .voters {
    color: #8590a6;
  }
  .replies {
    background-color: white;
  }
  .user-icon{
    border-radius: 50%;
    width: 46px;
    height: 46px;
    line-height: 46px;
    font-size: 2.4rem;
  }
</style>
