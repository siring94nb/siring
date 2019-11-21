import Main from '@/views/Main.vue';

// 不作为Main组件的子页面展示的页面单独写，如下
export const loginRouter = {
    path: '/login',
    name: 'login',
    meta: {
        title: 'Login - 登录'
    },
    component: () => import('@/views/login.vue')
};

export const page404 = {
    path: '/*',
    name: 'error_404',
    meta: {
        title: '404-页面不存在'
    },
    component: () => import('@/views/error_page/404.vue')
};

export const page403 = {
    path: '/403',
    meta: {
        title: '403-权限不足'
    },
    name: 'error_403',
    component: () => import('@/views/error_page/403.vue')
};

export const page500 = {
    path: '/500',
    meta: {
        title: '500-服务端错误'
    },
    name: 'error_500',
    component: () => import('@/views/error_page/500.vue')
};

export const locking = {
    path: '/locking',
    name: 'locking',
    component: () => import('@/views/main_components/lock_screen/components/locking-page.vue')
};

// 作为Main组件的子页面展示但是不在左侧菜单显示的路由写在otherRouter里
export const otherRouter = {
    path: '/',
    name: 'otherRouter',
    redirect: '/home',
    component: Main,
    children: [
        {
            path: 'home',
            title: { i18n: 'home' },
            name: 'home_index',
            access: 'admin/OrderGoods/index',
            component: () => import('@/views/home/home.vue')
        },
        {
            path: 'own',
            title: '个人中心',
            name: 'own_index',
            component: () => import('@/views/own/index.vue')
        },
        {
            path: 'request/:hash',
            title: '请求参数',
            name: 'interface_request',
            component: () => import('@/views/interface/request.vue')
        },
        {
            path: 'response/:hash',
            title: '返回参数',
            name: 'interface_response',
            component: () => import('@/views/interface/response.vue')
        },
        {
            path: 'Relation/detail/:detail_id',
            name: 'relation_detail',
            title: '用户关系网详情',
            component: () => import('@/views/user/relation_detail.vue')
        },
        {
            path: 'Goods/add/:goods_id',
            name: 'goods_add',
            title: '开发商品添加',
            component: () => import('@/views/goods/goods_add.vue')
        },
        {
            path: 'NeedOrder/need_index/:id&:status',
            name: 'demand_order_detail',
            title: '定制需求订单详情',
            component: () => import('@/views/order/demand_order_detail.vue')
        },
        // {
        //     path: 'OrderGoods/detail/:detail_id',
        //     name: 'order_detail',
        //     title: '订单详情',
        //     component: () => import('@/views/ordergoods/order_detail.vue')
        // }

    ]
};

// 作为Main组件的子页面展示并且在左侧菜单显示的路由写在appRouter里
export const appRouter = [
    {
        path: '/system',
        icon: 'ios-build',
        name: 'system',
        title: '管理员管理',
        component: Main,
        children: [
            {
                path: 'user',
                icon: 'ios-people',
                name: 'user',
                access: 'admin/User/index',
                title: '管理员管理',
                component: () => import('@/views/system/user.vue')
            },
            {
                path: 'auth',
                icon: 'md-warning',
                name: 'auth',
                access: 'admin/Auth/index',
                title: '管理员组管理',
                component: () => import('@/views/system/auth.vue')
            },
            {
                path: 'menu',
                icon: 'md-menu',
                name: 'menu',
                access: 'admin/Menu/index',
                title: '权限管理',
                component: () => import('@/views/system/menu.vue')

            },
        ]
    },
    // {
    //     path: "/app",
    //     icon: 'md-globe',
    //     name: "app",
    //     title: "应用接入",
    //     component: Main,
    //     children: [
    //         {
    //             path: "group",
    //             icon: 'logo-buffer',
    //             name: "app_group",
    //             access: 'admin/AppGroup/index',
    //             title: "应用分组",
    //             component: () => import('@/views/app/group.vue')
    //         },
    //         {
    //             path: "index",
    //             icon: "md-code-working",
    //             name: "app_index",
    //             access: 'admin/App/index',
    //             title: "应用列表",
    //             component: () => import('@/views/app/list.vue')
    //         }
    //     ]
    // },
    // {
    //     path: "/interface",
    //     icon: "md-cube",
    //     name: "interface",
    //     title: "接口管理",
    //     component: Main,
    //     children: [
    //         {
    //             path: "group",
    //             icon: "ios-folder-open",
    //             name: "interface_group",
    //             access: 'admin/InterfaceGroup/index',
    //             title: "接口分组",
    //             component: () => import('@/views/interface/group.vue')
    //         },
    //         {
    //             path: "list",
    //             icon: "ios-document-outline",
    //             name: "interface_list",
    //             access: 'admin/InterfaceList/index',
    //             title: "接口列表",
    //             component: () => import('@/views/interface/list.vue')
    //         }
    //     ]
    // },
    {
        path: '/User',
        icon: 'ios-people',
        title: '会员管理',
        name: 'User',
        component: Main,
        children: [
            {
                path: 'index',
                icon: 'ios-contact',
                name: 'index',
                access: 'admin/UserManage/index',
                title: '会员列表',
                component: () => import('@/views/user/index.vue')
            },
            {
                path: 'partner',
                icon: 'ios-contacts',
                name: 'partner',
                access: 'admin/UserPartner/index',
                title: '合伙人列表',
                component: () => import('@/views/user/partner.vue')
            },
            {
                path: 'subcontractor',
                icon: 'md-contacts',
                name: 'subcontractor',
                access: 'admin/UserSubcontractor/index',
                title: '分包商列表',
                component: () => import('@/views/user/subcontractor.vue')
            },
            {
                path: 'feedback',
                icon: 'ios-color-wand-outline',
                name: 'feedback',
                access: 'admin/Feedback/index',
                title: '意见反馈',
                component: () => import('@/views/user/feedback.vue')
            },

        ]
    },
    {
        path: '/Goods',
        icon: 'md-basket',
        title: '商品管理',
        name: 'Goods',
        component: Main,
        children: [
            {
                path: 'goods',
                icon: 'ios-phone-portrait',
                name: 'goods',
                title: '软件/定制',
                component: () => import('@/views/goods/goodsMain.vue'),
                children: [
                    {
                        path: 'develop_goods',
                        icon: 'ios-pint',
                        name: 'develop_goods',
                        access: 'admin/Goods/index',
                        title: '软件/开发',
                        component: () => import('@/views/goods/goods.vue')
                    },
                    {
                        path: 'made_example',
                        icon: 'ios-pint',
                        name: 'made_example',
                        access: 'admin/Goods/made',
                        title: '定制案例',
                        component: () => import('@/views/goods/made.vue')
                    },
                    {
                        path: 'evaluate',
                        icon: 'ios-pint',
                        name: 'evaluate',
                        access: 'admin/Goods/evaluate',
                        title: '快捷估价',
                        component: () => import('@/views/goods/evaluate.vue'),
                    },
                ]
            },
            {
                path: 'applet',
                icon: 'md-ribbon',
                title: '小程序管理',
                name: 'applet',
                component: () => import('@/views/applet/appletMain.vue'),
                children: [
                    {
                        path: 'industryModule',
                        icon: 'ios-pint',
                        name: 'industryModule',
                        access: 'admin/AppletManage/index',
                        title: '行业模块',
                        component: () => import('@/views/applet/industryModule.vue'),
                    },
                    {
                        path: 'model_meal',
                        icon: 'ios-pint',
                        name: 'model_meal',
                        access: 'admin/AppletManage/model_meal',
                        title: '模板套餐',
                        component: () => import('@/views/applet/templatePackage.vue'),
                    }
                ]
            },

            {
                path: 'extension',
                icon: 'ios-hand',
                title: '推广运营',
                name: 'extension',
                access: 'admin/AppletManage/model_meal',
                component: () => import('@/views/goods/extension.vue'),
            },
            {
                path: 'app',
                icon: 'logo-usd',
                title: '投融介',
                name: 'app',
                component: () => import('@/views/goods/made.vue'),
                // children: [
                // {
                //     path: 'templete',
                //     icon: 'ios-pint',
                //     name: 'templete',
                //     access: 'admin/Goods/templete',
                //     title: '软件/定制',
                //     component: () => import('@/views/goods/goods.vue'),
                // },
                // {
                //     path: 'made',
                //     icon: 'ios-pint',
                //     name: 'made',
                //     access: 'admin/Goods/made',
                //     title: '定制案例',
                //     component: () => import('@/views/goods/made.vue'),
                // },
                // {
                //     path: 'evaluate',
                //     icon: 'ios-pint',
                //     name: 'evaluate',
                //     access: 'admin/Goods/evaluate',
                //     title: '快捷估价',
                //     component: () => import('@/views/goods/evaluate.vue'),
                // },
                // ]
            },

        ]
    },
    {
        path: '/Information',
        icon: 'logo-buffer',
        title: '订单管理',
        name: 'Information',
        component: Main,
        children: [
            {
                path: 'order',
                icon: 'ios-pint',
                name: 'order',
                title: '加盟/角色订单',
                component: () => import('@/views/order/order.vue'),
                children: [
                    {
                        path: 'member_order',
                        icon: 'ios-clipboard',
                        name: 'member_order',
                        access: 'admin/JoinOrder/index',
                        title: '会员订单',
                        component: () => import('@/views/order/index.vue')
                    },
                    {
                        path: 'partner_order',
                        icon: 'ios-clipboard',
                        name: 'partner_order',
                        access: 'admin/JoinOrder/partner',
                        title: '合伙人订单',
                        component: () => import('@/views/order/partner.vue')
                    },
                    {
                        path: 'merchant_order',
                        icon: 'ios-clipboard',
                        name: 'merchant_order',
                        access: 'admin/JoinOrder/merchant',
                        title: '分包商订单',
                        component: () => import('@/views/order/merchant.vue')
                    },
                ]
            },
            {
                path: 'made_order',
                icon: 'ios-pint',
                name: 'made_order',
                title: '软件/定制订单',
                component: () => import('@/views/order/order.vue'),
                children: [
                    {
                        path: 'need_order',
                        icon: 'ios-clipboard',
                        name: 'need_order',
                        access: 'admin/NeedOrder/need_index',
                        title: '定制需求订单',
                        component: () => import('@/views/order/demand_order.vue')
                    },
                ]
            },
            {
                path: 'saas_order',
                icon: 'ios-pint',
                name: 'saas_order',
                title: 'saas套餐订单',
                component: () => import('@/views/order/order.vue'),
                children: [
                    {
                        path: 'model_order',
                        icon: 'ios-clipboard',
                        name: 'model_order',
                        access: 'admin/ModelOrder/index',
                        title: '套餐订单',
                        component: () => import('@/views/order/model_order.vue')
                    },
                    {
                        path: 'adder_order',
                        icon: 'ios-clipboard',
                        name: 'adder_order',
                        access: 'admin/ModelOrder/index',
                        title: '增值服务订单',
                        component: () => import('@/views/order/index.vue')
                    },
                ]
            },

        ]
    },
    {
        path: '/Marketing',
        icon: 'md-pricetag',
        title: '营销管理',
        name: 'Marketing',
        component: Main,
        children: [
            {
                path: 'Discount',
                icon: 'logo-hackernews',
                name: 'Discount',
                access: 'admin/Discount/index',
                title: '优惠券管理',
                component: () => import('@/views/discount/index.vue')
            },
        ]
    },
    {
        path: '/General',
        icon: 'md-cog',
        title: '通用设置',
        name: 'General',
        component: Main,
        children: [
            {
                path: 'BackupSql',
                icon: 'md-construct',
                name: 'BackupSql',
                access: 'admin/BackupSql/index',
                title: '数据库管理',
                component: () => import('@/views/backup/index.vue')
            },
            {
                path: 'seo',
                icon: 'logo-windows',
                name: 'seo',
                access: 'admin/Seo/index',
                title: 'SEO设置',
                component: () => import('@/views/system/seo.vue')
            },
            {
                path: 'Treaty',
                icon: 'ios-globe-outline',
                name: 'Treaty',
                access: 'admin/Treaty/index',
                title: '网站协议',
                component: () => import('@/views/system/treaty.vue')
            },
            {
                path: 'log',
                icon: 'md-list-box',
                name: 'log',
                access: 'admin/Log/index',
                title: '日志管理',
                component: () => import('@/views/system/log.vue')
            },
            {
                path: 'vip',
                icon: 'ios-hammer',
                name: 'vip',
                title: '会员设置',
                component: () => import('@/views/vipsetting/index.vue'),
                // redirect: '/vip/vipLevel',
                children: [
                    {
                        path: 'vipLevel',
                        icon: 'ios-hammer',
                        name: 'vipLevel',
                        title: '会员等级',
                        access: 'admin/RoleJoin/member_index',
                        component: () => import('@/views/vipsetting/vipLevel.vue'),
                    },
                    {
                        path: 'settingCity',
                        icon: 'ios-hammer',
                        name: 'settingCity',
                        title: '城市等级',
                        access: 'admin/RoleJoin/city_index',
                        component: () => import('@/views/vipsetting/settingCity.vue'),
                    },
                    {
                        path: 'cityPartner',
                        icon: 'ios-hammer',
                        name: 'cityPartner',
                        title: '城市合伙人',
                        access: 'admin/RoleJoin/partner_index',
                        component: () => import('@/views/vipsetting/cityPartner.vue'),
                    },
                    {
                        path: 'fbs',
                        icon: 'ios-hammer',
                        name: 'fbs',
                        title: '分包商',
                        access: 'admin/RoleJoin/subcontractor_index',
                        component: () => import('@/views/vipsetting/fbs.vue'),
                    },

                ]
            }
        ]
    },
    {
        path: '/Setup',
        icon: 'md-build',
        title: '系统管理',
        name: 'Setup',
        component: Main,
        children: [
            {
                path: 'banner',
                icon: 'md-reverse-camera',
                name: 'banner',
                access: 'admin/Banner/index',
                title: 'banner管理',
                component: () => import('@/views/banner/list.vue')
            },
            {
                path: 'about',
                icon: 'ios-switch',
                name: 'about',
                access: 'admin/About/profitInfo',
                title: '关于我们',
                component: () => import('@/views/about/index.vue')
            },

            {
                path: 'contact',
                icon: 'ios-call',
                name: 'contact',
                access: 'admin/Contact/signInfo',
                title: '联系我们',
                component: () => import('@/views/contact/index.vue')

            }

        ]
    },


];

// 所有上面定义的路由都要写在下面的routers里
export const routers = [
    loginRouter,
    otherRouter,
    locking,
    ...appRouter,
    page500,
    page403,
    page404
];
