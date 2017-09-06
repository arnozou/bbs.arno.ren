<template>
  <div class="row">
    <div class="col-md-3">
      <div class="box">
        <div class="panding-md">
          <div class="list-group text-center">
            <router-link :to="'/user/' + user.id" class="list-group-item">
              <i class="text-md fa fa-list-alt" aria-hidden="true"></i>
              &nbsp;个人信息
            </router-link>
            <router-link :to="'/user/' + user.id + '/edit/avatar'" class="list-group-item">
              <i class="text-md fa fa-list-alt" aria-hidden="true"></i>
              &nbsp;修改头像
            </router-link>
            <router-link :to="'/user/' + user.id + '/edit/password'" class="list-group-item">
              <i class="text-md fa fa-list-alt" aria-hidden="true"></i>
              &nbsp;修改密码
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-9" v-show="editType == 'edit'">
      <div class="panel panel-default padding-md">
        <div class="panel-body">
          <form class="form-horizontal" action="">

            <div class="form-group">
              <label for="" class="col-sm-2 control-label">性别</label>
              <div class="col-sm-6">
                  <select class="form-control" v-model="user.gender" name="gender"><option value="unselected" selected="">未选择</option>
                    <option value="1">男</option>
                    <option value="0">女</option>
                  </select>
              </div>

              <div class="col-sm-4 help-block"></div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">称昵</label>
                <div class="col-sm-6">
                    <input class="form-control"  name="nick_name" v-model="user.nick_name" type="text">
                </div>

                <div class="col-sm-4 help-block">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">邮 箱</label>
                <div class="col-sm-6">
                    <input class="form-control" name="email" v-model="user.email" type="text">
                </div>
                <div class="col-sm-4 help-block">
                    如：name@website.com
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">真实姓名</label>
                <div class="col-sm-6">
                    <input class="form-control" name="real_name" v-model="user.real_name" type="text">
                </div>
                <div class="col-sm-4 help-block">
                    如：张三
                </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">个人简介</label>
              <div class="col-sm-6">
                  <textarea class="form-control" rows="3" name="intro" v-model="user.intro" cols="50" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 121px;"></textarea>
              </div>
              <div class="col-sm-4 help-block">
                    介绍下自己
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-6">
                <input class="btn btn-primary" @click="commit" value="应用修改" type="submit">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-9" v-show="editType == 'avatar'">
      <div class="panel panel-default padding-md">
        <div class="panel-body">
          <h2>请选择图片</h2>
          <form enctype="multipart/form-data" method="post" @submit.prevent="uploadAvatar" action="/api/users">
            <div class="image-preview">
              <label for="">请选择图片</label>
              <img :src="user.avatar_url" alt="">
    
            </div>
            <div class="form-group">
              <input type="file" name="avatar" accept="image/*" >
              <button class="btn btn-lg btn-primary"  type="submit">上传头像</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-9" v-show="editType == 'password'">
      <div class="panel panel-default padding-md">
        <div class="panel-body">
          <h2>修改密码</h2>
          
          <form class="form-horizontal" @submit.prevent="updatePass" method="post" action="/user">

            <div class="form-group">
              <label for="" class="col-sm-2 control-label">邮 箱</label>
              <div class="col-sm-6">
                  <input class="form-control " name="email" v-model="user.email" disabled type="text">
              </div>

              <div class="col-sm-4 help-block"></div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">密码</label>
              <div class="col-sm-6">
                  <input class="form-control " name="password" v-model="pass.password" type="password">
              </div>

              <div class="col-sm-4 help-block"></div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">重复密码</label>
              <div class="col-sm-6">
                  <input class="form-control " name="password_confirmation" v-model="pass.password_confirmation" type="password">
              </div>

              <div class="col-sm-4 help-block"></div>
            </div>
            <div class="form-group">
              <button class="btn btn-lg btn-primary"  type="submit">应用修改</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        user:{},
        editType:'edit',
        pass:{
          password:'',
          password_confirmation:'',
        }
      }
    },
    watch: {
      $route() {
        this.fetchData()
        switch(this.$route.params.edit_type)
        {
          case 'avatar':
            this.editType = 'avatar';
          break;
          case 'password':
            this.editType = 'password';
          break;
          default:
            this.editType = 'edit';
        }
        
      }
    },
    created() {

      this.fetchData();
    },
    methods:{
      fetchData() {
        if (!this.$store.state.login.id) {
          this.$router.push('/user/'+ this.$route.params.user_id);
        }
        axios.get('/users/edit').then((response) => {
          console.log(response.headers, 1);
          this.user = response.data.data
        })
      },
      commit(){
        axios.patch('/users').then((response) => {
          console.log('修改成功');

          setTimeout(() => {
            this.$route.push('/home');
          }, 2000);
        }).catch((error) => {
          console.log('修改失败');
        })
      },
      selectImg(){
        /*var formData = new FormData()
        formData.append('file', this.$refs.resource.files[0]);
        axios.post('/users/avatar', formData, {
          headers:{
            'Content-Type': 'multipart/form-data'
          }
        })*/
      },
      uploadAvatar:function(e) {
        var formData = new FormData(event.target)
        axios.post('/users/avatar', formData).then((response) => {
          this.user.avatar_url = response.data.url
          console.log('上传成功');
        }).catch((error) => {
          console.log('上传失败');
        })
      },
      updatePass:function() {
        
        axios.patch('/users/password', this.pass).then((response) => {
          console.log('修改密码成功')
        }).catch((error) => {
          console.log('修改密码失败');
        })
      }
    }
  }
</script>

<style scoped>
  .padding-md{
    padding: 15px;
  }
</style>