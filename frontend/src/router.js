import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/*
* 刷新页面时，重新赋值user_id
*/
const userid = sessionStorage.getItem('user_id');
if(userid){
  store.commit('setUserId', userid);
}

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/Home'),
      redirect: 'index'
    },
    {
      path: '/index',
      name: 'index',
      component: () => import('@/views/index')
    },
    {
      path: '/join',
      name: 'join',
      component: () => import('@/views/join')
    },
    {
      path: '/quickValuation',
      name: 'quickValuation',
      component: () => import('@/views/tailorMade/quickValuation')
    },
    {
      path: '/selectFunction',
      name: 'selectFunction',
      component: () => import('@/views/tailorMade/selectFunction')
    },
    {
      path: '/aboutUs',
      name: 'aboutUs',
      component: () => import('@/views/aboutUs')
    }
  ]
})
