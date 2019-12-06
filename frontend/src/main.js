import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App.vue';
import router from './router';
import store from './store';
import '@/assets/style/index.scss';
import { Seo } from '@/api/api';
import './assets/iconfont/iconfont.css';
import qs from 'qs';
Vue.prototype.$qs = qs;
import VueClipboard from 'vue-clipboard2'
Vue.use( VueClipboard )
Vue.use(ElementUI);
// 城市联动
import vRegion from 'v-region';
Vue.use(vRegion);

router.beforeEach((to, from, next) => {
    Seo().then(res => {
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
            // if (userId == null && phone == null) {
            //     // 通过缓存，判断当前登录状态
            //     // next("/");
            // }
        }
    })
    next()
})

router.afterEach((to, from, next) => {
    window.scrollTo(0, 0);
    // let userId = JSON.parse(sessionStorage.getItem("user_id"));
    // let phone = JSON.parse(sessionStorage.getItem("phone"))
    // if (userId == null && phone == null) {
    //     // 通过缓存，判断当前登录状态
    //     next("/");
    // }
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')