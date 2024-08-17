import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store/store'

import Register from '../views/auth/RegisterComponent.vue'
import Login from '../views/auth/LoginComponent.vue'

import Acueille from '../views/AcueilleComponent.vue'
import Chat from '../views/ChatComponent.vue'



const routes = [
  {
    path: '/',
    name: 'acueille',
    component: Acueille
  },

  {
    path: '/register',
    name: 'register',
    component: Register
  },

  {
    path: '/login',
    name: 'login',
    component: Login
  },

  {
    path: '/chat',
    name: 'chat',
    component: Chat,
    meta: {
      auth: true
    }
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})


router.beforeEach((to, from, next) => {
 
  if(to.meta.auth && !store.state.token ){
    next({
      name: 'login'
    })

  }
  else {

    next()
      
  }


})


export default router
