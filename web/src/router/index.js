import Vue from 'vue';
import iView from 'iview';
import Util from '../libs/util';
import VueRouter from 'vue-router';
import {routers} from './router';
import config from '../../build/config';
import axios from 'axios';

Vue.use(VueRouter);

// 路由配置
const RouterConfig = {
    routes: routers
};

export const router = new VueRouter(RouterConfig);

router.beforeEach((to, from, next) => {
    let apiAuth = sessionStorage.getItem('apiAuth');
    iView.LoadingBar.start();
    Util.title(to.meta.title);
    if (sessionStorage.getItem('locking') === '1' && to.name !== 'locking') { // 判断当前是否是锁定状态
        next({
            replace: true,
            name: 'locking'
        });
    } else if (sessionStorage.getItem('locking') === '0' && to.name === 'locking') {
        next(false);
    } else {
        if (!apiAuth && to.name !== 'login') { // 判断是否已经登录且前往的页面不是登录页
            next({
                name: 'login'
            });
        } else if (apiAuth && to.name === 'login') { // 判断是否已经登录且前往的是登录页
            Util.title();
            next({
                name: 'home_index'
            });
        } else {
            // 统一处理请求的UserToken
            axios.defaults.baseURL = config.baseUrl;
            axios.interceptors.request.use(function (config) {
                config.headers['ApiAuth'] = sessionStorage.getItem('apiAuth');
                return config;
            });
            Util.toDefaultPage([...routers], to.name, router, next);
        }
    }
});

router.afterEach((to) => {
    Util.openNewPage(router.app, to.name, to.params, to.query);
    iView.LoadingBar.finish();
    window.scrollTo(0, 0);
});
