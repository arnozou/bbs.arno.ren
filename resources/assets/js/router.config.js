
import Example from './components/Example.vue'
import Body from './components/Body.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import CategoryIndex from './components/CategoryIndex.vue'
export default {
  routes:[
    {path:'/example', component: Example},
    {
      path:'/home',
      component: Body,
    },
    {path:'/login', component: Login},
    {path:'/register', component: Register},
    {path:'/categories', component: CategoryIndex},
    {path:'/categories/*', component: CategoryIndex}
    // {path:'*', redirect: '/home'},
  ]
}