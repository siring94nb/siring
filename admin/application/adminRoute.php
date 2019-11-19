<?php

use think\Route;

$afterBehavior = [
    '\app\admin\behavior\ApiAuth',
    '\app\admin\behavior\ApiPermission',
    '\app\admin\behavior\AdminLog'
];

Route::group('admin', function () use ($afterBehavior) {
    //一些带有特殊参数的路由写到这里
    Route::rule([
        'Login/index'  => [
            'admin/Login/index',
            ['method' => 'post']
        ],
        'Index/upload' => [
            'admin/Index/upload',
            [
                'method'         => 'post',
                'after_behavior' => [
                    '\app\admin\behavior\ApiAuth',
                    '\app\admin\behavior\AdminLog'
                ]
            ]
        ],
        'Login/logout' => [
            'admin/Login/logout',
            [
                'method'         => 'get',
                'after_behavior' => [
                    '\app\admin\behavior\ApiAuth',
                    '\app\admin\behavior\AdminLog'
                ]
            ]
        ],
        // 'Goods/msg' => [
        //     'admin/Goods/msg',
        //     [
        //         'method'         => 'get',
        //         'after_behavior' => [
        //             '\app\admin\behavior\ApiAuth',
        //             '\app\admin\behavior\AdminLog'
        //         ]
        //     ]
        // ],
    ]);
    Route::miss('admin/Miss/index');
    //大部分控制器的路由都以分组的形式写到这里

    Route::group('Menu', [
        'index'        => [
            'admin/Menu/index',
            ['method' => 'get']
        ],
        'changeStatus' => [
            'admin/Menu/changeStatus',
            ['method' => 'get']
        ],
        'add'          => [
            'admin/Menu/add',
            ['method' => 'post']
        ],
        'edit'         => [
            'admin/Menu/edit',
            ['method' => 'post']
        ],
        'del'          => [
            'admin/Menu/del',
            ['method' => 'get']
        ]
    ], ['after_behavior' => $afterBehavior]);

    /**用户管理 */
    Route::group('User', [
        'index'        => [
            'admin/User/index',
            ['method' => 'get']
        ],
        'getUsers'     => [
            'admin/User/getUsers',
            ['method' => 'get']
        ],
        'changeStatus' => [
            'admin/User/changeStatus',
            ['method' => 'get']
        ],
        'add'          => [
            'admin/User/add',
            ['method' => 'post']
        ],
        'own'          => [
            'admin/User/own',
            ['method' => 'post']
        ],
        'edit'         => [
            'admin/User/edit',
            ['method' => 'post']
        ],
        'del'          => [
            'admin/User/del',
            ['method' => 'get']
        ],
    ], ['after_behavior' => $afterBehavior]);

    /**授权 */
    Route::group('Auth', [
        'index'        => [
            'admin/Auth/index',
            ['method' => 'get']
        ],
        'changeStatus' => [
            'admin/Auth/changeStatus',
            ['method' => 'get']
        ],
        'add'          => [
            'admin/Auth/add',
            ['method' => 'post']
        ],
        'delMember'    => [
            'admin/Auth/delMember',
            ['method' => 'get']
        ],
        'edit'         => [
            'admin/Auth/edit',
            ['method' => 'post']
        ],
        'del'          => [
            'admin/Auth/del',
            ['method' => 'get']
        ],
        'getGroups'    => [
            'admin/Auth/getGroups',
            ['method' => 'get']
        ],
        'getRuleList'  => [
            'admin/Auth/getRuleList',
            ['method' => 'get']
        ]
    ], ['after_behavior' => $afterBehavior]);

    /** */
    Route::group('App', [
        'index'            => [
            'admin/App/index',
            ['method' => 'get']
        ],
        'refreshAppSecret' => [
            'admin/App/refreshAppSecret',
            ['method' => 'get']
        ],
        'changeStatus'     => [
            'admin/App/changeStatus',
            ['method' => 'get']
        ],
        'add'              => [
            'admin/App/add',
            ['method' => 'post']
        ],
        'getAppInfo'       => [
            'admin/App/getAppInfo',
            ['method' => 'get']
        ],
        'edit'             => [
            'admin/App/edit',
            ['method' => 'post']
        ],
        'del'              => [
            'admin/App/del',
            ['method' => 'get']
        ]
    ], ['after_behavior' => $afterBehavior]);


    Route::group('InterfaceList', [
        'index'        => [
            'admin/InterfaceList/index',
            ['method' => 'get']
        ],
        'changeStatus' => [
            'admin/InterfaceList/changeStatus',
            ['method' => 'get']
        ],
        'add'          => [
            'admin/InterfaceList/add',
            ['method' => 'post']
        ],
        'refresh'      => [
            'admin/InterfaceList/refresh',
            ['method' => 'get']
        ],
        'edit'         => [
            'admin/InterfaceList/edit',
            ['method' => 'post']
        ],
        'del'          => [
            'admin/InterfaceList/del',
            ['method' => 'get']
        ],
        'getHash'      => [
            'admin/InterfaceList/getHash',
            ['method' => 'get']
        ]
    ], ['after_behavior' => $afterBehavior]);


    Route::group('Fields', [
        'index'    => [
            'admin/Fields/index',
            ['method' => 'get']
        ],
        'request'  => [
            'admin/Fields/request',
            ['method' => 'get']
        ],
        'add'      => [
            'admin/Fields/add',
            ['method' => 'post']
        ],
        'response' => [
            'admin/Fields/response',
            ['method' => 'get']
        ],
        'edit'     => [
            'admin/Fields/edit',
            ['method' => 'post']
        ],
        'del'      => [
            'admin/Fields/del',
            ['method' => 'get']
        ],
        'upload'   => [
            'admin/Fields/upload',
            ['method' => 'post']
        ]
    ], ['after_behavior' => $afterBehavior]);


    Route::group('InterfaceGroup', [
        'index'        => [
            'admin/InterfaceGroup/index',
            ['method' => 'get']
        ],
        'getAll'       => [
            'admin/InterfaceGroup/getAll',
            ['method' => 'get']
        ],
        'add'          => [
            'admin/InterfaceGroup/add',
            ['method' => 'post']
        ],
        'changeStatus' => [
            'admin/InterfaceGroup/changeStatus',
            ['method' => 'get']
        ],
        'edit'         => [
            'admin/InterfaceGroup/edit',
            ['method' => 'post']
        ],
        'del'          => [
            'admin/InterfaceGroup/del',
            ['method' => 'get']
        ]
    ], ['after_behavior' => $afterBehavior]);


    Route::group('AppGroup', [
        'index'        => [
            'admin/AppGroup/index',
            ['method' => 'get']
        ],
        'getAll'       => [
            'admin/AppGroup/getAll',
            ['method' => 'get']
        ],
        'add'          => [
            'admin/AppGroup/add',
            ['method' => 'post']
        ],
        'changeStatus' => [
            'admin/AppGroup/changeStatus',
            ['method' => 'get']
        ],
        'edit'         => [
            'admin/AppGroup/edit',
            ['method' => 'post']
        ],
        'del'          => [
            'admin/AppGroup/del',
            ['method' => 'get']
        ]
    ], ['after_behavior' => $afterBehavior]);
    Route::group('Log', [
        'index' => [
            'admin/Log/index',
            ['method' => 'get']
        ],
        'del'   => [
            'admin/Log/del',
            ['method' => 'get']
        ]
    ], ['after_behavior' => $afterBehavior]);

    //合伙人
    Route::group('UserPartner', [
        'index' => [
            'admin/UserPartner/index',
            ['method' => 'get']
        ],
        // 'upload' => [
        //     'admin/Lecturer/upload',
        //     ['method' => 'post']
        // ],
        'Delete' => [
            'admin/UserPartner/Delete',
            ['method' => 'post']
        ],
        'Add' => [
            'admin/UserPartner/Add',
            ['method' => 'post']
        ],
        'Edit' => [
            'admin/UserPartner/Edit',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //分包商管理
    Route::group('UserSubcontractor', [
        'index' => [
            'admin/UserSubcontractor/index',
            ['method' => 'get']
        ],
        'Delete' => [
            'admin/UserSubcontractor/Delete',
            ['method' => 'post']
        ],
        'Add' => [
            'admin/UserSubcontractor/Add',
            ['method' => 'post']
        ],
        'Edit' => [
            'admin/UserSubcontractor/Edit',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //会员管理
    Route::group('UserManage', [
        'index' => [
            'admin/UserManage/index',
            ['method' => 'get']
        ],
        'upload' => [
            'admin/UserManage/upload',
            ['method' => 'post']
        ],
        'Delete' => [
            'admin/UserManage/Delete',
            ['method' => 'post']
        ],
        'Add' => [
            'admin/UserManage/Add',
            ['method' => 'post']
        ],
        'Edit' => [
            'admin/UserManage/Edit',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //意见反馈
    Route::group('Feedback', [
        'index' => [
            'admin/Feedback/index',
            ['method' => 'get']
        ],
        'Delete' => [
            'admin/Feedback/Delete',
            ['method' => 'post']
        ],
        'Add' => [
            'admin/Feedback/Add',
            ['method' => 'post']
        ],
        'Edit' => [
            'admin/Feedback/Edit',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

     //角色订单审核管理
     Route::group('JoinOrder', [
         //会员订单
        'index' => [
            'admin/JoinOrder/index',
            ['method' => 'get']
        ],
         'upd'   => [
             'admin/JoinOrder/upd',
             ['method' => 'post']
         ],
        //合伙人订单
        'partner' => [
            'admin/JoinOrder/partner',
            ['method' => 'get']
        ],
        'partner_upd'   => [
            'admin/JoinOrder/partner_upd',
            ['method' => 'post']
        ],
         //加盟商订单
         'merchant' => [
             'admin/JoinOrder/merchant',
             ['method' => 'get']
         ],
         'merchant_upd'   => [
             'admin/JoinOrder/merchant_upd',
             ['method' => 'post']
         ],

    ], ['after_behavior' => $afterBehavior]);

     /**
      * lilu
      *软件定制订单--定制需求订单
      */
     Route::group('NeedOrder', [
        'index' => [                        //定制需求订单列表      
            'admin/NeedOrder/index',
            ['method' => 'get']
        ],
         'need_detail'   => [                //定制需求
             'admin/NeedOrder/need_detail',
             ['method' => 'post']
         ],
         'proposal_upload'   => [                //上传报价单
             'admin/NeedOrder/proposal_upload',
             ['method' => 'post']
         ],
         'proposal_upload'   => [                //上传报价单
             'admin/NeedOrder/proposal_upload',
             ['method' => 'post']
         ],
         'proposal_verify'   => [                //上传报价单审核
             'admin/NeedOrder/proposal_verify',
             ['method' => 'post']
         ],
    ], ['after_behavior' => $afterBehavior]);
    /**
     * lilu
     * 套餐订单
     */
    Route::group('ModelOrder',[
        'index'=>[                      //套餐订单列表
            'admin/ModelOrder/index',
            ['method'=>'get']
        ]

    ],['after_behavior' => $afterBehavior]);

    //消息管理
    Route::group('Msg', [
        'index' => [
            'admin/Msg/index',
            ['method' => 'get']
        ],
        'add'   => [
            'admin/Msg/add',
            ['method' => 'post']
        ],
        'del'   => [
            'admin/Msg/del',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //banner图管理
    Route::group( 'Banner' , [
        'index' => [
            'admin/Banner/index',
            ['method' => 'get']
        ],
        'add' => [
            'admin/Banner/add',
            ['method' => 'post']
        ],
        'edit' => [
            'admin/Banner/edit',
            ['method' => 'post']
        ],
        'del' => [
            'admin/Banner/del',
            ['method' => 'post']
        ],
    ] , ['after_behavior' => $afterBehavior] );

    //关于我们
    Route::group('About', [
        'profitInfo' => [
            'admin/About/profitInfo',
            ['method' => 'get']
        ],
        'profitUpd'   => [
            'admin/About/profitUpd',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //角色加盟管理
    Route::group( 'RoleJoin' , [
        //会员设置
        'member_index' => [
            'admin/RoleJoin/member_index',
            ['method' => 'get']
        ],
        'member_read' => [
            'admin/RoleJoin/member_read',
            ['method' => 'get']
        ],
        'member_create' => [
            'admin/RoleJoin/member_create',
            ['method' => 'post']
        ],
        'member_save' => [
            'admin/RoleJoin/member_save',
            ['method' => 'post']
        ],
        'member_delete' => [
            'admin/RoleJoin/member_delete',
            ['method' => 'post']
        ],
        //合伙人设置
        'partner_index' => [
            'admin/RoleJoin/partner_index',
            ['method' => 'get']
        ],
        'partner_create' => [
            'admin/RoleJoin/partner_create',
            ['method' => 'post']
        ],
        'partner_save' => [
            'admin/RoleJoin/partner_save',
            ['method' => 'post']
        ],
        'partner_delete' => [
            'admin/RoleJoin/partner_delete',
            ['method' => 'post']
        ],
        //分包商设置
        'subcontractor_index' => [
            'admin/RoleJoin/subcontractor_index',
            ['method' => 'get']
        ],
        'subcontractor_create' => [
            'admin/RoleJoin/subcontractor_create',
            ['method' => 'post']
        ],
        'subcontractor_save' => [
            'admin/RoleJoin/subcontractor_save',
            ['method' => 'post']
        ],
        'subcontractor_delete' => [
            'admin/RoleJoin/subcontractor_delete',
            ['method' => 'post']
        ],
        //城市等级设置
        'city_index' => [
            'admin/RoleJoin/city_index',
            ['method' => 'get']
        ],
        'city_create' => [
            'admin/RoleJoin/city_create',
            ['method' => 'post']
        ],
        'city_screen' => [
            'admin/RoleJoin/city_screen',
            ['method' => 'post']
        ],
        'city_delete' => [
            'admin/RoleJoin/city_delete',
            ['method' => 'post']
        ],
        'city_move' => [
            'admin/RoleJoin/city_move',
            ['method' => 'post']
        ],
    ] , ['after_behavior' => $afterBehavior] );

    //优惠券管理
    Route::group('Discount', [
        'index' => [
            'admin/Discount/index',
            ['method' => 'get']
        ],
        'add'   => [
            'admin/Discount/add',
            ['method' => 'post']
        ],
        'upd'   => [
            'admin/Discount/upd',
            ['method' => 'post']
        ],
        'del'   => [
            'admin/Discount/del',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);
    //商品管理--软件/定制商品
    Route::group('Goods', [
        'index' => [                    //软件/开发商品列表
            'admin/Goods/index',
            ['method' => 'get']
        ],
        'add'   => [                    //软件/开发商品添加
            'admin/Goods/add',
            ['method' => 'post']
        ],
        'search'   => [
            'admin/Goods/search',        //软件/开发商品检索
            ['method' => 'post']
        ],
        'edit'   => [
            'admin/Goods/edit',         //编辑
            ['method' => 'post']
        ],
        'copy'   => [
            'admin/Goods/copy',         //赋值
            ['method' => 'post']
        ],
        'del'   => [
            'admin/Goods/del',          //软件开发商品删除
            ['method' => 'post']
        ],
        'add_comment'   => [
            'admin/Goods/add_comment',        //添加评论
            ['method' => 'post']
        ],
        'comment_list'   => [
            'admin/Goods/comment_list',        //历史评论
            ['method' => 'post']
        ],
        'comment_del'   => [
            'admin/Goods/comment_del',        //历史评论删除
            ['method' => 'post']
        ],
        'made'   => [
            'admin/Goods/made',           //定制案列列表
            ['method' => 'post']
        ],
        'made_edit'   => [
            'admin/Goods/made_edit',           //定制案列编辑
            ['method' => 'post']
        ],
        'made_del'   => [
            'admin/Goods/made_del',           //定制案列删除
            ['method' => 'post']
        ],
        'evaluate'   => [
            'admin/Goods/evaluate',        //快捷评估
            ['method' => 'post']
        ],
        'category_index' => [
            'admin/Goods/category_index',
            ['method' => 'post']
        ],
        'category_add' => [
            'admin/Goods/category_add',
            ['method' => 'post']
        ],
        'category_edit' => [
            'admin/Goods/category_edit',
            ['method' => 'post']
        ],
        'category_del' => [
            'admin/Goods/category_del',
            ['method' => 'post']
        ],
        'get_goods' => [
            'admin/Goods/get_goods',     //获取软件商品信息（id）
            ['method' => 'post']
        ],
        'made_add' => [
            'admin/Goods/made_add',      //定制商品添加
            ['method' => 'post']
        ],
        'made_edit' => [
            'admin/Goods/made_edit',      //定制商品编辑
            ['method' => 'post']
        ],
        'made_del' => [
            'admin/Goods/made_del',      //定制商品编辑
            ['method' => 'post']
        ],
        'get_horse_member' => [
            'admin/Goods/get_horse_member',  //马甲会员列表
            ['method' => 'post']
        ],
        'change_goods_status' => [
            'admin/Goods/change_goods_status',  //马甲会员列表
            ['method' => 'post']
        ],
        'goods_special_del' => [
            'admin/Goods/goods_special_del',  //软件开发商品规格删除
            ['method' => 'post']
        ],
        'change_goods_rank' => [
            'admin/Goods/change_goods_rank',  //软件开发商品排序
            ['method' => 'post']
        ],

    ], ['after_behavior' => $afterBehavior]);
    //商品管理--SaaS小程序管理
    Route::group('AppletManage', [
        'index' => [                        //行业模板列表
            'admin/AppletManage/index',
            ['method' => 'post']
        ],
        'add'   => [                        //行业模版添加
            'admin/AppletManage/add',
            ['method' => 'post']
        ],
        'edit'   => [
            'admin/AppletManage/edit',
            ['method' => 'post']
        ],
        'del'   => [
            'admin/AppletManage/del',
            ['method' => 'post']
        ],
        'change_model_status'   => [         //切换模板展示状态
            'admin/AppletManage/change_model_status',
            ['method' => 'post']
        ],
        'model_meal'   => [                  //模板套餐
            'admin/AppletManage/model_meal',
            ['method' => 'get']
        ],
        'model_meal_add'   => [                  //模板套餐
            'admin/AppletManage/model_meal_add',
            ['method' => 'post']
        ],
        'model_meal_edit'   => [                  //模板套餐
            'admin/AppletManage/model_meal_edit',
            ['method' => 'post']
        ],
        'model_meal_del'   => [                  //模板套餐
            'admin/AppletManage/model_meal_del',
            ['method' => 'post']
        ],
        'change_model_rank'   => [                  //行业模板-更改当前行业模板的排序
            'admin/AppletManage/change_model_rank',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);
    //商品管理--推广运营
    Route::group('Extension', [
        'index' => [
            'admin/Extension/index',
            ['method' => 'get']
        ],
        'add'   => [
            'admin/Extension/add',
            ['method' => 'post']
        ],
        'upd'   => [
            'admin/Extension/upd',
            ['method' => 'post']
        ],
        'del'   => [
            'admin/Extension/del',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //备份数据库
    Route::group('BackupSql', [
        'index' => [
            'admin/BackupSql/index',
            ['method' => 'get']
        ],
        'create'   => [
            'admin/BackupSql/create',
            ['method' => 'post']
        ],
        'save'   => [
            'admin/BackupSql/save',
            ['method' => 'post']
        ],
        'del'   => [
            'admin/BackupSql/del',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //联系我们
    Route::group('Contact', [
        'signInfo' => [
            'admin/Contact/signInfo',
            ['method' => 'get']
        ],
        'signUpd'   => [
            'admin/Contact/signUpd',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //SEO设置
    Route::group('Seo', [
        'index' => [
            'admin/Seo/index',
            ['method' => 'get']
        ],
        'Upd'   => [
            'admin/Seo/Upd',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);

    //网站协议设置
    Route::group('Treaty', [
        'index' => [
            'admin/Treaty/index',
            ['method' => 'get']
        ],
        'Upd'   => [
            'admin/Treaty/Upd',
            ['method' => 'post']
        ],
    ], ['after_behavior' => $afterBehavior]);
    //商品分类列表
    Route::group('Category', [

    ], ['after_behavior' => $afterBehavior]);

});

//<!--
// *
// *                    .::::.
// *                  .::::::::.
// *                 :::::::::::
// *             ..:::::::::::'
// *           '::::::::::::'
// *             .::::::::::
// *        '::::::::::::::..
// *             ..::::::::::::.
// *           ``::::::::::::::::
// *            ::::``:::::::::'        .:::.
// *           ::::'   ':::::'       .::::::::.
// *         .::::'      ::::     .:::::::'::::.
// *        .:::'       :::::  .:::::::::' ':::::.
// *       .::'        :::::.:::::::::'      ':::::.
// *      .::'         ::::::::::::::'         ``::::.
// *  ...:::           ::::::::::::'              ``::.
// * ```` ':.          ':::::::::'                  ::::..
// *                    '.:::::'                    ':'````..
// *
// *
// *
// * -------- 每个成功的男人背后，是不是都有一个女人 --------
// *
//-->
