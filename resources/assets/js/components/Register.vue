<template>
  <div class="row" v-title="注册">
    <div class="col-md-5 col-md-offset-4">
      <div class="login-block">
        <form class="form-horizontal" @submit.prevent="login" role="form" action="post">

          <div class="form-group" :class="classObject.nick_name">
            <label class=" control-label" >称昵<span class="text-danger">*</span></label>
            <input class="form-control " type="text" @blur="checkForm('nick_name')" v-model="nick_name" placeholder="称昵">
            <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" v-show="feedback.nick_name == 1"></span>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" v-show="feedback.nick_name == 2"></span>
          </div>

          <div class="form-group" :class="classObject.mobile">
            <label class="control-label" >手机</label>
            <input  class="form-control " type="text" @blur="checkForm('mobile')" v-model="mobile" placeholder="手机">
            <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" v-show="feedback.mobile == 1"></span>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" v-show="feedback.mobile == 2"></span>
          </div>

          <div class="form-group" :class="classObject.email">
            <label class=" control-label" >邮箱</label>
            <input  class="form-control " type="text" @blur="checkForm('email')" v-model="email" placeholder="邮箱">
            <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" v-show="feedback.email == 1"></span>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" v-show="feedback.email == 2"></span>
          </div>
          
          <div class="form-group" :class="classObject.password">
            <label class=" control-label">密码<span class="text-danger">*</span></label>
            <input class="form-control" type="password" @keyup="checkForm('password')" v-model="password" placeholder="密码">
            <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" v-show="feedback.password == 1"></span>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" v-show="feedback.password == 2"></span>
          </div>
          <div class="form-group" :class="classObject.password_confirmation">
            <label class=" control-label"  >确认密码<span class="text-danger">*</span></label>
            <input class="form-control" type="password" @keyup="checkForm('password_confirmation')" v-model="password_confirmation" placeholder="重复密码">
            <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" v-show="feedback.password_confirmation == 1"></span>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" v-show="feedback.password_confirmation == 2"></span>
          </div>
          <div class="form-group">
            <button class="btn btn-lg btn-primary"  type="submit">注册</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

  import _ from 'lodash'

  export default {
    data() {
      return {
        nick_name:'',
        password:'',
        email:'',
        mobile:'',
        password_confirmation:'',
        classObject:{
          nick_name:{ 'has-success':false, 'has-error':false, 'has-feedback':false},
          mobile:{ 'has-success':false, 'has-error':false, 'has-feedback':false},
          email:{ 'has-success':false, 'has-error':false, 'has-feedback':false},
          password:{ 'has-success':false, 'has-error':false, 'has-feedback':false},
          password_confirmation:{ 'has-success':false, 'has-error':false, 'has-feedback':false},
        },
        regList:{
          nick_name:/^[a-zA-Z]{1,30}$/,
          mobile:/^0?(13[0-9]|15[012356789]|17[013678]|18[0-9]|14[57])[0-9]{8}$/,
          email:/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/,
          password:/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}/
        },
        feedback:{
          nick_name:0,
          mobile:0,
          email:0,
          password:0,
          password_confirmation:0,
        }
      }
    },
    computed:{
    },
    watch: {
    },
    methods: {
      login() {
        var data = {
          nick_name:this.nick_name,
          password:this.password,
          email:this.email,
          mobile:this.mobile,
          password_confirmation:this.password_confirmation,
        }
        axios.post('register', data).then((response) => {
          this.$store.commit('login', response.data.data)
          this.$router.push('home');
        }).catch(function(error) {
          if (error.response.status == 422) {
            console.log('error 422', error.response);
          }
          console.log(error.config);
        });
      },
      checkForm(inputType) {
        console.log('inputType', inputType);
        if (this[inputType] == '') {
          this.feedback[inputType] = 0
          for (var p in this.classObject[inputType]) {
            this.classObject[inputType][p] = false;
          }
        }
        if (inputType == 'password_confirmation') {
          this.setInputState(inputType, this.password == this.password_confirmation)
          return 
        }
        this.setInputState(inputType, this.regList[inputType].test(this[inputType]))
      },
      setInputState(inputType, $boolean) {
        if ($boolean) {
          this.classObject[inputType]['has-success'] = true
          this.classObject[inputType]['has-error'] = false
          this.feedback[inputType] = 1
        } else {
          this.classObject[inputType]['has-success'] = false
          this.classObject[inputType]['has-error'] = true
          this.feedback[inputType] = 2
        }
        this.classObject[inputType]['has-feedback'] = true
      }
    }
  }
</script>

<style scoped>
  /* .btn-lg {
    width:100%;
  } */
  .bg-success {
    background-color: #dff0d8;
  }
  .bg-danger {
    background-color: #f2dede;
  }


</style>
