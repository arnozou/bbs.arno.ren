<template>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <router-link to="/home" class="navbar-brand">
          <img src="/" alt="Brand">
        </router-link>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><router-link to="/categories"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span></router-link></li>
          <li><a href=""><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></a></li>
          <li><a href=""><span class="glyphicon glyphicon-tags" aria-hidden="true"></span></a></li>
          <li><a href=""><span class="glyphicon glyphicon-fire" aria-hidden="true"></span></a></li>
          <li><a href=""><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li v-show="!logined"><router-link to="/login">登录</router-link></li>
          <li v-show="!logined"><router-link to="/register">注册</router-link></li>
          <li v-show="logined"><router-link :to="'/user/' + user.id" ><img class="avatar" :src="user.avatar_url" alt=""></router-link></li>
          <li v-show="logined"><router-link :to="'/user/' + user.id" v-text="nickname"></router-link></li>
          <li v-show="logined"><a @click="logout" >登出</a></li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
  export default{
    computed:{
      logined() {
        if (this.$store.state.login.id) {
          return true;
        } else {
          return false;
        }
      },
      nickname() {
        return this.$store.state.login.nick_name
      },
      user() {
        return this.$store.state.login
      }

    },
    methods:{
      logout() {
        axios.post('logout', {}).then((response) => {
          this.$store.commit('logout');
        }).catch((error) => {
          console.log('logout fail');
        })
      }
    },
    created() {
      axios.post('/relogin', {}).then((response) => {
        // console.log('relogin', response);
        if (response.status == 200 && response.data.data) {
          this.$store.commit('login', response.data.data);
        } else if (response.status == 204) {
          console.log('cannt get user info');
        }
      })
    }
  }
</script>

<style>
  li {
    list-style-type: none;
  }
  .avatar{
    border-radius: 50%;
  } 
</style>
<style scoped>
  .avatar{
    width: 30px;
    height: 30px;
  }
</style>