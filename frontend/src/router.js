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
            import('@/views/Home'),
        redirect: 'index'//重定向
    },
    {
        path: '/index',
        name: 'index',
        component: () =>
            import('@/views/index')
    },
    {
        path: '/city',
        name: 'city',
        component: () =>
            import('@/views/join/city')
    },
    {
        path: '/member',
        name: 'member',
        component: () =>
            import('@/views/join/member')
    },
    {
        path: '/contractor',
        name: 'contractor',
        component: () =>
            import('@/views/join/contractor')
    },
    {
        path: '/quickValuation',
        name: 'quickValuation',
        component: () =>
            import('@/views/tailorMade/quickValuation')
    },
    {
        path: '/selectFunction',
        name: 'selectFunction',
        component: () =>
            import('@/views/tailorMade/selectFunction')
    },
    {
        path: '/fillDemand',
        name: 'fillDemand',
        component: () =>
            import('@/views/tailorDemand/fillDemand')

    },
    {
        path: '/goods',
        name: 'goods',
        component: () =>
            import('@/views/goods/goods')
    },
    {
        path: '/goods-detail/:id',
        name: 'goods-detail',
        component: () =>
            import('@/views/goods/goods-detail')
    },
    {
        path: '/demonstration/:id',
        name: 'demonstration',
        component: () =>
            import('@/views/goods/demonstration')
    },
    {
        path: '/ai-promotion',
        name: 'ai-promotion',
        component: () =>
            import('@/views/ai/ai-promotion')
    },
    {
        path: '/investment',
        name: 'investment',
        component: () =>
            import('@/views/investment/index')
    },
    {
        path: '/aboutUs',
        name: 'aboutUs',
        component: () =>
            import('@/views/aboutUs')
    },
    {
        path: '/programSaaS',
        name: 'programSaaS',
        component: () =>
            import('@/views/programSaaS/index')
    },
    {
        path: '/selectCombo',
        name: 'selectCombo',
        component: () =>
            import('@/views/programSaaS/selectCombo')
    },
    {
        path: '/comboPay',
        name: 'comboPay',
        component: () =>
            import('@/views/programSaaS/comboPay')
    },
    //登录后的路由
    {
        path: '/afterLoggin',
        name: 'afterLoggin',
        meta:{requireAuth:true},//路由守卫开启标识
        props: true,
        component: () =>
            import('@/views/afterLoggin/afterLoggin'),
        children: [{
            path: "/afterLogginR",
            name: "afterLogginR",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/afterLogginR'),
        },
        {
            path: "/memberInformation",
            name: "memberInformation",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/memberInformation'),
        },{
            path: "/recharge",
            name: "recharge",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import ('@/views/afterLoggin/financialDetails/recharge'),
        },
        {
            path: "/addEnterprise",
            name: "addEnterprise",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/addEnterprise'),
        },
        {
            path: "/enterpriseList",
            name: "enterpriseList",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/enterpriseList'),
        },
        {
            path: "/securityCenterIndex",
            name: "securityCenterIndex",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/securityCenter/securityCenterIndex'),
        },
        {
            path: "/safetyTabControl",
            name: "safetyTabControl",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/securityCenter/safetyTabControl'),
        },
        {
            path: "/invitationX",
            name: "invitationX",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/securityCenter/invitationX'),
        },
        {
            path: "/partnerCityX",
            name: "partnerCityX",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/partnerCity/partnerCityX'),
        },
        {
            path: "/CityPartner",
            name: "CityPartner",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/partnerCity/CityPartner'),
        },
        {
            path: "/ClassMembersX",
            name: "ClassMembersX",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/ClassMembers/ClassMembersX'),
        },
        {
            path: "/ClassMembersA",
            name: "ClassMembersA",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/ClassMembers/ClassMembersA'),
        },
        {
            path: "/demand_order",
            name: "demand_order",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/demand_order/demand_order'),
        },
        {
            path: "/order_detail",
            name: "order_detail",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/demand_order/order_detail'),
        },
        {
            path: "/subContractorIndex",
            name: "subContractorIndex",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/subContractor/subContractorIndex'),
        },
        {
            path: "/subContractorSm1",
            name: "subContractorSm1",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/subContractor/subContractorSm1'),
        },
        {
            path: "/financialDetailsI",
            name: "financialDetailsI",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/financialDetails/financialDetailsI'),
        },{
            path: "/withdraw",
            name: "withdraw",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/financialDetails/withdraw'),
        },
        {
            path: "/withdrawX",
            name: "withdrawX",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/financialDetails/withdrawX'),
        },
        {
            path: "/CardManagement",
            name: "CardManagement",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/financialDetails/CardManagement'),
        },
        {
            path: "/discountCoupon",
            name: "discountCoupon",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/financialDetails/discountCoupon'),
        },
        {
            path: "/generalizeIndex",
            name: "generalizeIndex",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/generalize/generalizeIndex'),
        },
        {   //小程序SaaS（小程序管理）
            path: "/storeIndex",
            name: "storeIndex",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/appletSaaS/storeIndex'),
        },
        {   //小程序SaaS（增值服务订单）
            path: "/appreciationIndex",
            name: "appreciationIndex",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/appletSaaS/appreciationIndex'),
        },
        {   //ai推广流程
            path: "/flowIndex",
            name: "flowIndex",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/generalize/flowIndex'),
        },
        {   //投融介
            path: "/forMelting",
            name: "forMelting",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/forMelting/index'),
        },
        {   //投融界推广流程
            path: "/flowIndex1",
            name: "flowIndex1",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/forMelting/flowIndex1'),
        },
        {//中止项目
            path: "/zhongzhi",
            name: "zhongzhi",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/forMelting/zhongzhi'),
        }
        ,
        {//中止项目
            path: "/ceshi",
            name: "ceshi",
            meta:{requireAuth:true},//路由守卫开启标识
            props: true,
            component: () =>
                import('@/views/afterLoggin/ceshi'),
        }
        ]
    },
    {
        //备用支付页
        path: "/order",
        name: "order",
        meta:{requireAuth:true},//路由守卫开启标识
        props: true,
        component: () =>
            import('@/views/order'),
    },
    {
        // 添加投融项目路由
        path:"/addForMelting",
        name:"addForMelting",
        meta:{requireAuth:true},
        props:true,
        component:() => 
            import('@/views/afterLoggin/forMelting/addForMelting')
    },
    {
        path: "/alipay",
        name: "alipay",
        meta:{requireAuth:true},//路由守卫开启标识
        props: true,
        component: () =>
            import('@/views/alipay'),
    },
    // 添加新稿件
    {
        path: "/newManuscript",
        name: "newManuscript",
        meta:{requireAuth:true},//路由守卫开启标识
        props: true,
        component: () =>
            import('@/views/newManuscript/index'),
    },
    // 新投资，新融资
    {
        path: "/newInvestment",
        name: "newInvestment",
        meta:{requireAuth:true},//路由守卫开启标识
        props: true,
        component: () =>
            import('@/views/newManuscript/investment'),
    }
]
})