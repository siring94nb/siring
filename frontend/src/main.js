import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App.vue';
import router from './router';
import store from './store';
import '@/assets/style/index.scss';
import { Seo } from '@/api/api';
import './assets/iconfont/iconfont.css';
import './assets/iconfont1/iconfont.css';
import qs from 'qs';
Vue.prototype.$qs = qs;
import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)
Vue.use(ElementUI);
// 城市联动
import vRegion from 'v-region';
Vue.use(vRegion);

router.beforeEach((to, from, next) => {
    let that = this;
    // function open4() {
    //     that .$message.error('错了哦，这是一条错误消息');
    //   }
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
        }
    })
    // 全局路由守卫，当前不完善，需要修改，当前仅能拦截控制台路由
    // to.meta.requireAut路由守卫开启标识 

    if (to.meta.requireAuth == true && sessionStorage.getItem("user_id") == null) {
        let rou = from.path;
        next(rou);
        // 修改弹出窗口样式
        alert("请先行登录");
        // open4();
        // console.log(that)
    } else {
        next()
    }
})

router.afterEach((to, from, next) => {
    window.scrollTo(0, 0);
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')