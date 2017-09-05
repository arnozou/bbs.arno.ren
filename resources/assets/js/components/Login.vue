<template>
  <div class="row">
    <div class="col-md-4 col-md-offset-4 ">
      <div class="login-block">
        <form class="form-horizontal" role="form" action="post">

          <div class="form-group" v-show="loginType == 'username'">
            <label class="control-label"  for="username">手机/邮箱</label>
            <input id="username" class="form-control" type="text" name="username" v-model="username" placeholder="手机/邮箱">
            <!-- <div class="input-group">
            </div> -->
            <span class="help-text">{{usernameState}}</span>
          </div>

          <div class="form-group" v-show="loginType == 'username'">
            <label class="control-label"  for="password">密码</label>
            <input id="password" class="form-control" type="password" name="password" v-model="password" placeholder="密码">
          </div>

          <div class="form-group" v-show="loginType == 'mobile'">
            <label class="control-label"  for="mobile">手机</label>
            <input id="mobile" class="form-control" type="number" name="mobile" v-model="username" placeholder="手机">
            <!-- <div class="input-group">
            </div> -->
            <span class="help-text">{{mobileState}}</span>
          </div>
          <div class="form-group" v-show="loginType == 'mobile'">
            <label class="control-label"  for="mobile_code">验证码</label>
            <div class="input-group">
              <input id="mobile_code" class="form-control " type="password" name="mobile_code" v-model="mobileCode" placeholder="验证码">
              <span class="input-group-btn">
                <button  role="button" class="btn " :class="{disabled: mobile.leftSeconds}" @click.prevent="sendMobile" v-text="sendMobileTxt"></button>
              </span>
              
            </div>
            
          </div>
          
          <div class="form-group ">
            <div class="">
              <button class="btn btn-primary" :class="{disabled: !usernameType}" @click.prevent="login">登录</button>
              <span>没有账号？<router-link to="/register">注册</router-link></span>
              <a v-show="loginType == 'username'" @click="loginType = 'mobile'">手机验证码登录</a>
              <a v-show="loginType == 'mobile'" @click="loginType = 'username'">密码登录</a>
              <router-link to="/reset">忘记密码</router-link>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

  // import _ from 'lodash'

  export default {
    data() {
      return {
        username:'',
        password:'',
        loginType:'username',
        usernameIsDirty:false,
        isCalculating:false,
        mobileCode:'',
        mobile:{
          timer:0,
          leftSeconds:0,
        },
        mobileState:'',
        error:'',
      }
    },
    computed:{
      usernameState() {
        if (this.isCalculating) {
          return '⟳ Fetching new results'
        } else if (this.searchQueryIsDirty) {
          return '... Typing'
        } else {
          if (this.usernameType) {
            return '✓ Done'
          }
          return 'not a phone number or a email'
        }
      },
      usernameType() {
        if (this.isCalculating || this.searchQueryIsDirty) {
          return '';
        } else if (/^0?(13[0-9]|15[012356789]|17[013678]|18[0-9]|14[57])[0-9]{8}$/.test(this.username)) {
          return 'mobile';
        } else if (/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(this.username)) {
          return 'email';
        }
      },
      sendMobileTxt() {
        if (this.mobile.leftSeconds) {
          return this.mobile.leftSeconds + 's 已发送'
        } else {
          return '发送'
        }
      }
    },  
    watch: {
      username: function () {
        this.usernameIsDirty = true
        this.expensiveOperation()
      }
    },
    methods: {
      login() {
        if (this.loginType == 'mobile') {
          this.loginMobile()
          return;
        }
        if (!this.usernameType) {
          return 
        }

        let data = {password:this.password}
        data[this.usernameType] = this.username
        axios.post('login', data).then((response) => {
          this.$store.commit('login', response.data.data);
          this.$router.push('/home');

        }).catch(function(error) {
          if (error.response) {
          // 请求已发出，但服务器响应的状态码不在 2xx 范围内
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log('Error', error.message);
        }
        console.log(error.config);
            });
      },
      expensiveOperation() {
      },
      sendMobile() {
        window._.debounce(function(){
        console.log('in debounce');
       }, 150)
        if (this.mobile.leftSeconds) {
          console.log('sendMobile.if fail');
          return
        }
        this.mobile.leftSeconds = 60
        this.mobile.timer = setInterval(() => {
          this.mobile.leftSeconds --
          if (this.mobile.leftSeconds == 0) {
            clearInterval(this.mobile.timer);
          }
        }, 1000);
        console.log('sendMobile.timer pass');
        let data = {
          mobile: this.username
        }
        axios.post('captcha/send/mobile', data,{
          baseURL:'https://bbs.arno.ren/api/',
          auth:this.$store.state.token,
        }).then((response) => {
          console.log(response.status);
          console.log('发送成功');
        }).catch((error) => {
          console.log('发送失败');
        })
      },
      loginMobile() {
        axios.post('login/mobile', {
          mobile:this.username,
          code:mobileCode
        }).then((response) => {
          this.$store.commit('login', response.data.data);
          this.$router.push('/home');
        }).catch(function(error) {
          if (error.response.status == 403) {
            this.error = error.response.data.message
          }
        })
      }
    }
  }
</script>

<style scoped>
  /* .btn-lg {
    width:100%;
  } */
</style>
