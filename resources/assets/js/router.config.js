
import Example from './components/Example.vue'
import Body from './components/Body.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import CategoryIndex from './components/CategoryIndex.vue'
import Topic from './components/Topic.vue'
import User from './components/User.vue'
import UserEdit from './components/UserEdit.vue'
export default {
  routes:[
    {path:'/example', component: Example},
    {
      path:'/home',
      component: CategoryIndex,
    },
    {path:'/', component:CategoryIndex},
    {path:'/login', component: Login},
    {path:'/register', component: Register},
    {path:'/categories', component: CategoryIndex},
    {path:'/categories/:categories_id', component: CategoryIndex},
    {path:'/topic/:topic_id', component: Topic},
    {path:'/user/:user_id', component: User},
    {path:'/user/:user_id/edit', component: UserEdit},
    {path:'/user/:user_id/edit/:edit_type', component: UserEdit},
    // {path:'*', redirect: '/home'},
  ]
}