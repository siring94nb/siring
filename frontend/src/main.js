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
Vue.use(VueClipboard)
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
            // 全局路由守卫，当前不完善，需要修改，当前仅能拦截控制台路由
            // to.meta.requireAut路由守卫开启标识
            if (to.meta.requireAuth == true) {
                let userId = sessionStorage.getItem("user_id");
                if (userId == null) {
                    next("/");
                    // 路由守卫，登录提示处理延时出现，否则先行执行alert阻断页面跳转
                    setTimeout(function(){
                        alert("请先行登录")
                    },500)
                } else {
                    next()
                }
            }
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