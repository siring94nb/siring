import Vue from 'vue'
import Router from 'vue-router'
import store from './store.js'

Vue.use(Router)

/*
 * 刷新页面时，重新赋值user_id
 */
const userid = sessionStorage.getItem('user_id');
const phone = sessionStorage.getItem('phone');
const originalPush = Router.prototype.push;
Router.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err)
}
if (userid) {
    store.commit('login', {
        id: userid,
        phone: phone
    });
}

export default new Router({
    routes: [{
            path: '/',
            name: 'home',
            component: () =>
                import ('@/views/Home'),
            redirect: 'index'
        },
        {
            path: '/index',
            name: 'index',
            component: () =>
                import ('@/views/index')
        },
        {
            path: '/city',
            name: 'city',
            component: () =>
                import ('@/views/join/city')
        },
        {
            path: '/member',
            name: 'member',
            component: () =>
                import ('@/views/join/member')
        },
        {
            path: '/contractor',
            name: 'contractor',
            component: () =>
                import ('@/views/join/contractor')
        },
        {
            path: '/quickValuation',
            name: 'quickValuation',
            component: () =>
                import ('@/views/tailorMade/quickValuation')
        },
        {
            path: '/selectFunction',
            name: 'selectFunction',
            component: () =>
                import ('@/views/tailorMade/selectFunction')
        },
        {
            path: '/fillDemand',
            name: 'fillDemand',
            component: () =>
                import ('@/views/tailorDemand/fillDemand')

        },
        {
            path: '/goods',
            name: 'goods',
            component: () =>
                import ('@/views/goods/goods')
        },
        {
            path: '/goods-detail/:id',
            name: 'goods-detail',
            component: () =>
                import ('@/views/goods/goods-detail')
        },
        {
            path: '/demonstration/:id',
            name: 'demonstration',
            component: () =>
                import ('@/views/goods/demonstration')
        },
        {
            path: '/ai-promotion',
            name: 'ai-promotion',
            component: () =>
                import ('@/views/ai/ai-promotion')
        },
        {
            path: '/investment',
            name: 'investment',
            component: () =>
                import ('@/views/investment/index')
        },
        {
            path: '/aboutUs',
            name: 'aboutUs',
            component: () =>
                import ('@/views/aboutUs')
        },
        {
            path: '/programSaaS',
            name: 'programSaaS',
            component: () =>
                import ('@/views/programSaaS/index')
        },
        {
            path: '/selectCombo',
            name: 'selectCombo',
            component: () =>
                import ('@/views/programSaaS/selectCombo')
        },
        {
            path: '/comboPay',
            name: 'comboPay',
            component: () =>
                import ('@/views/programSaaS/comboPay')
        },
        //登录后的路由
        {
            path: '/afterLoggin',
            name: 'afterLoggin',
            component: () =>
                import ('@/views/afterLoggin/afterLoggin'),
            // import ('@/components/dingDan')
            children: [{
                    path: "/afterLogginR",
                    name: "afterLogginR",
                    component: () =>
                        import ('@/views/afterLoggin/afterLogginR'),
                },
                {
                    path: "/memberInformation",
                    name: "memberInformation",
                    component: () =>
                        import ('@/views/afterLoggin/memberInformation'),
                },
                {
                    path: "/addEnterprise",
                    name: "addEnterprise",
                    component: () =>
                        import ('@/views/afterLoggin/addEnterprise'),
                },
                {
                    path: "/enterpriseList",
                    name: "enterpriseList",
                    component: () =>
                        import ('@/views/afterLoggin/enterpriseList'),
                },
                {
                    path: "/securityCenterIndex",
                    name: "securityCenterIndex",
                    component: () =>
                        import ('@/views/afterLoggin/securityCenter/securityCenterIndex'),
                },
                {
                    path: "/safetyTabControl",
                    name: "safetyTabControl",
                    component: () =>
                        import ('@/views/afterLoggin/securityCenter/safetyTabControl'),
                },
                {
                    path: "/invitationX",
                    name: "invitationX",
                    component: () =>
                        import ('@/views/afterLoggin/securityCenter/invitationX'),
                },
                {
                    path: "/partnerCityX",
                    name: "partnerCityX",
                    component: () =>
                        import ('@/views/afterLoggin/partnerCity/partnerCityX'),
                }

            ]
        },
    ]
})