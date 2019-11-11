import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App.vue'
import router from './router'
import store from './store'
import '@/assets/style/index.scss'


import qs from 'qs';
Vue.prototype.$qs = qs;

Vue.use(ElementUI);

// router.beforeEach((to, from, next) => {

// })

router.afterEach((to,from,next) => {
  window.scrollTo(0,0);
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
