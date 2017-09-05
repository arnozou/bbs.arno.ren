
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
import routerConfig from './router.config.js'
Vue.use(VueRouter)
Vue.use(Vuex)


const router = new VueRouter(routerConfig)

const store = new Vuex.Store({
  state:{
    token:'',
    login:{
      id:0,
      nick_name:'',
      avatar_url:'',
    },
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
    }
  }
})

const rm = new Vue({
    el: '#app',
    router: router,
    store,
    components:{
      'top-header': Header,
      'contents': Body
    }
});

axios.interceptors.response.use(function(response){
     //对响应数据做些事
    // console.log('对响应数据做些事', response);
    let token
    // console.log('headers', response.headers, token = response.headers['token']);
    if (token = response.headers['token']) {
      // console.log('token', token, token == 'Expiring');
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
