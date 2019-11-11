import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App.vue'
import router from './router'
import store from './store'
import '@/assets/style/index.scss'
import { Seo } from '@/api/api'

import qs from 'qs';
Vue.prototype.$qs = qs;

Vue.use(ElementUI);

router.beforeEach((to, from, next) => {
  Seo().then(res => {
    console.log(res.data)
    const data = res.data;
    if (data.code === 1) {
      document.title = data.data.name;
      let head = document.getElementsByTagName('head');
      let meta = document.createElement('meta');
      let meta2 = document.createElement('meta');
      meta.name = 'description';
      meta.content = data.data.con;
      meta2.name = 'keywords';
      meta2.content = data.data.tag;
      head[0].appendChild(meta)
      head[0].appendChild(meta2)
    }
  })
  next()
})

router.afterEach((to, from, next) => {
  window.scrollTo(0, 0);
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
