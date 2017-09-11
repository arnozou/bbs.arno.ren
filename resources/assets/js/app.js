
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import Body from './components/Body.vue'
import Header from './components/Header.vue'
import Writer from './components/Writer.vue'
import routerConfig from './router.config.js'
// import bus from './components/Bus'
Vue.use(VueRouter)
Vue.use(Vuex)

Vue.directive('title', {
  update: function (el, binding) {
    document.title = binding.value
    // document.getElementById('title').innerText = document.title
  }
})


const router = new VueRouter(routerConfig)

const store = new Vuex.Store({
  state:{
    token:'',
    login:{
      id:0,
      nick_name:'',
      avatar_url:'',
    },
    categories:[],
    showWriter:false,
  },
  mutations:{
    login (state, payload) {
      state.login = payload
      state.token = 'Bearer ' + payload.token
      window.axios.defaults.headers.common['Authorization'] = state.token;
    },
    logout (state) {
      state.login = {
        id:0,
        nick_name:'',
        avatar_url:'',
      }
      state.token = '';
      window.axios.defaults.headers.common['Authorization'] = null;
    },
    categories(state, categories) {
      state.categories = categories;
    },
    showWriter(state, toggle)
    {
      state.showWriter = toggle
    }
  }
})

const rm = new Vue({
    el: '#app',
    router: router,
    store,
    data:{
      showWriter:false
    },
    /*mounted(){
      bus.$on('showWriter', () => {
        console.log('get event');
          this.showWriter = true

        if (this.$store.state.login.id) {
          this.showModel = true
        }
      })
    },*/
    components:{
      'top-header': Header,
      'contents': Body,
      'writer': Writer
    }
});

axios.interceptors.response.use(function(response){
     //对响应数据做些事
    // console.log('对响应数据做些事', response);
    let token
    // console.log('headers', response.headers, token = response.headers['token']);
    if (token = response.headers['token']) {
      // console.log('token', token, token == 'Refresh');
      if (token == 'Expiring') {
        window.axios.defaults.headers.common['Token'] = 'Refresh';
      } else if (token == 'Refresh') {
        delete(axios.defaults.headers.common['Token']);
        window.axios.defaults.headers.common['Authorization'] = response.headers['authorization'];
      }

    }
      return response;
   });

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
