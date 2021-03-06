<?php
/**
 * Api路由--前端接口
 */

use think\Route;

Route::group('api', function () {
    Route::miss('api/Miss/index');
//    Route::rule('new/:id','News/update','POST');
    //开始定义api路由接口
    Route::post('sendMassage','api/SendMassage/sendMassage'); //短信中转

    //文件上传 fyk
    Route::group('file', function () {
        Route::post('upload','api/File/img');
        Route::post('video','api/File/video');
        Route::post('qn_upload','api/File/qn_upload');//上传到七牛云
    });

    //用户接口接口 fyk
    Route::group('User', function () {//'User' => 控制器
        Route::any('phone_code','api/User/code'); //('index =>方法','api/User/index' =>文件夹/控制器/方法)
        Route::post('register','api/User/register');//注册
        Route::post('login','api/User/login');//登录
        Route::post('forget','api/User/forget');//忘记密码
        Route::post('upd_phone','api/User/edit_phone');//修改手机号
        Route::post('balance_password','api/User/balance_password');//用户修改余额密码
        Route::post('share_code','api/User/share_code');//用户分享邀请码
        Route::post('lnvitation_record','api/User/lnvitation_record');//用户分享邀请记录
        Route::any('logout','api/User/logout');//用户退出
        Route::post('user_updating','api/User/user_updating');//用户资料更新
        Route::post('enterprise_add','api/User/enterprise_add');//添加企业身份
        Route::any('enterprise_list','api/User/enterprise_list');//企业身份列表
        Route::post('enterprise_edit','api/User/enterprise_edit');//企业身份编辑
        Route::post('enterprise_del','api/User/enterprise_del');//企业身份删除
        Route::post('collect','api/User/collect');//用户关注、收藏
    });

    //轮播接口接口 fyk
    Route::group('Banner', function () {
        Route::any('banner_list','api/Banner/index'); //轮播列表
        Route::any('banner_save','api/Banner/save'); //测试

    });

    //网站基本接口 fyk
    Route::group('Website', function () {
        Route::any('website_list','api/Website/website_list'); //关于我们
        Route::any('contact','api/Website/contact'); //联系我们
        Route::any('seo','api/Website/seo'); //SEO
        Route::any('custom_case','api/Website/custom_case'); //软件定制案例
        Route::any('member','api/Website/member'); //核心成员
        Route::any('honor','api/Website/honor'); //荣誉证书
        Route::any('course','api/Website/course'); //发展历程
    });

    //角色加盟 fyk
    Route::group('JoinRole',function (){
        Route::any('province_list','api/JoinRole/province_list'); //省份列表
        Route::any('city_list','api/JoinRole/city_list'); //城市列表
        Route::any('grade_list','api/JoinRole/grade_list'); //等级费用列表
        Route::any('member_list','api/JoinRole/member_list'); //会员费用列表
        Route::any('join_list','api/JoinRole/join_list'); //分包商费用列表
        Route::any('profit','api/JoinRole/profit'); //收益预测
        Route::any('discount','api/JoinRole/discount'); //会员折扣
        Route::any('join_class','api/JoinRole/join_class'); //分包商分类
    });

    //角色加盟订单 fyk
    Route::group('JoinOrder',function (){
        Route::post('city_order_add','api/JoinOrder/city_order_add'); //城市合伙人订单
        Route::post('member_order_add','api/JoinOrder/member_order_add'); //会员订单
        Route::post('join_order_add','api/JoinOrder/join_order_add'); //加盟商订单
        Route::post('get_pay','api/JoinOrder/get_pay'); //支付
        Route::any('app_notice','api/JoinOrder/app_notice'); //支付回调
    });

    //快捷估价
    Route::group('Evaluate',function(){
        Route::any('get_plate_form','api/Evaluate/get_plate_form'); //获取快捷平台的list
        Route::any('get_plate_list','api/Evaluate/get_plate_list'); //获取快捷平台的list
    });

    //Saas行业模板
    Route::group('AppletManage',function(){
        Route::any('get_model_list','api/AppletManage/get_model_list'); //获取行业模板的list
    });
    //Saas模板套餐
    Route::group('ModelMeal',function(){
        Route::any('model_meal_list','api/ModelMeal/model_meal_list'); //获取模板套餐
    });
    //行业模板订单
    Route::group('MealOrder',function(){
        Route::post('meal_order_add','api/MealOrder/meal_order_add'); //下单
        Route::post('meal_order_pay','api/MealOrder/meal_order_pay'); //下单
    });

    //添加用户银行卡
    Route::group('UserCard',function(){
        Route::post('user_card_add','api/UserCard/user_card_add');  //添加/编辑银行卡
        Route::any('user_card_list','api/UserCard/user_card_list');  //银行卡列表
    });


    //角色加盟订单 fyk
    Route::group('Software',function (){
        Route::any('soft_type','api/Software/soft_type'); //软件定制分类
        Route::any('soft_list','api/Software/soft_list'); //商品列表
        Route::post('soft_detail','api/Software/soft_detail'); //商品详情
        Route::any('soft_reviews','api/Software/soft_reviews'); //商品评论
        Route::any('soft_push','api/Software/soft_push'); //推荐商品
        Route::post('soft_demo','api/Software/soft_demo'); //商品演示
        Route::post('soft_order_add','api/Software/soft_order_add'); //软件定制订单
        Route::post('get_pay','api/Software/get_pay'); //软件定制订单支付
        Route::any('app_notice','api/Software/app_notice'); //支付回调
    });
    //用户优惠券 fyk
    Route::group('UserDiscount',function(){
        Route::any('discount_list','api/UserDiscount/discount_list'); //用户优惠券
        Route::any('user_fund','api/UserDiscount/user_fund'); //用户余额
    });

    //控制台 fyk
    Route::group('Console',function(){
        Route::any('personal_information','api/Console/personal_information'); //用户信息
        Route::any('my_order','api/Console/my_order'); //用户订单
        Route::any('pending_payment','api/Console/pending_payment'); //待付款订单
        Route::any('pending_disposal','api/Console/pending_disposal'); //待处理订单
        Route::any('after_service','api/Console/after_service'); //待处理后续服务订单
    });

    //AI推广引擎 fyk
    Route::group('Manuscript',function(){
        Route::post('demand_add','api/Manuscript/demand_add'); //用户信息
        Route::post('get_pay','api/Manuscript/get_pay'); //支付
        Route::any('app_notice','api/Manuscript/app_notice'); //支付回调
        Route::any('set_meal','api/Manuscript/set_meal'); //套餐列表
    });

    //投融界 fyk
    Route::group('Investment',function(){
        Route::post('finance_add','api/Investment/finance_add'); //我要融资
        Route::any('industry_field','api/Investment/industry_field'); //行业领域
        Route::any('industry_cost','api/Investment/industry_cost'); //行业领域分类费用
        Route::any('industry_list','api/Investment/industry_list'); //列表
        Route::post('project_details','api/Investment/project_details'); //项目详情

        Route::any('console_list','api/Investment/console_list'); //控制台-我的投融列表
        Route::post('investment_details','api/Investment/investment_details'); //控制台-我的投融详情
        Route::post('investment_status','api/Investment/investment_status'); //控制台-我的投融修改状态
        Route::any('activities','api/Investment/activities'); //控制台-我的投融见面会
    });

    //定制需求
    Route::group('NeedOrder',function(){
        Route::post('need_order_add','api/NeedOrder/need_order_add'); //定制需求下单
        Route::any('need_order_list','api/NeedOrder/need_order_list'); //定制需求列表
        Route::post('change_status','api/NeedOrder/change_status'); //中止需求或确定需求
        Route::post('confirm_need_order','api/NeedOrder/confirm_need_order'); //需求确认修改
        Route::post('need_order_detail','api/NeedOrder/need_order_detail'); //需求订单详情
        Route::post('need_comment','api/NeedOrder/need_comment'); //评价
        Route::post('get_pay','api/NeedOrder/get_pay'); //支付

        Route::any('qd_notify','api/NeedOrder/qd_notify'); //签订合同异步回调-支付宝
        Route::any('qd_notice','api/NeedOrder/qd_notice'); //签订合同异步回调-微信

        Route::any('yx_notify','api/NeedOrder/yx_notify'); //原型确认异步回调-支付宝
        Route::any('yx_notice','api/NeedOrder/yx_notice'); //原型确认异步回调-微信

        Route::any('sx_notify','api/NeedOrder/sx_notify'); //项目上线异步回调-支付宝
        Route::any('sx_notice','api/NeedOrder/sx_notice'); //项目上线异步回调-微信

        Route::any('ys_notify','api/NeedOrder/ys_notify'); //项目验收异步回调-支付宝
        Route::any('ys_notice','api/NeedOrder/ys_notice'); //项目验收异步回调-微信
    });

    //微信第三方路由
    Route::group('WxThree',function(){
        Route::any('receive_ticket','api/WxThree/receive_ticket'); //获取ticket
        Route::any('callback','api/WxThree/callback'); //回调信息获取
    });

    //控制台-AI推广套餐 fyk
    Route::group('Promotion',function(){
        Route::any('manuscript_list','api/Promotion/manuscript_list'); //订单列表
        Route::post('promotion_details','api/Promotion/promotion_details'); //订单详情
        Route::post('promotion_upd','api/Promotion/promotion_upd'); //订单修改
        Route::post('promotion_status','api/Promotion/promotion_status'); //订单状态确认
        Route::post('manuscripts_upd','api/Promotion/manuscripts_upd'); //修改稿件
    });

    //控制台-角色中心 fyk
    Route::group('RoleCenter',function(){
        Route::any('city_partner','api/RoleCenter/city_partner'); //合伙人列表
        Route::any('city_total','api/RoleCenter/city_total'); //合伙人统计总数
        Route::any('member_partner','api/RoleCenter/member_partner'); //会员列表
        Route::any('member_total','api/RoleCenter/member_total'); //会员统计总数
        Route::any('tips','api/RoleCenter/tips'); //会员提示信息
        Route::any('subcontract_partner','api/RoleCenter/subcontract_partner'); //分包商列表
        Route::any('subcontract_total','api/RoleCenter/subcontract_total'); //分包商统计
        Route::any('sub_view','api/RoleCenter/sub_view'); //分包项目视窗
        Route::any('receipt','api/RoleCenter/receipt'); //接单
    });

    //控制台-资金管理
    Route::group('Capital',function(){
        Route::post('capital_detailed','api/Capital/capital_detailed'); //资金明细
        Route::post('invoice_amount','api/Capital/invoice_amount'); //剩余开票金额
        Route::post('my_invoice','api/Capital/my_invoice'); //开票
        Route::post('recharge','api/Capital/recharge'); //充值
        Route::post('get_pay','api/Capital/get_pay'); //支付
        Route::post('cash_with','api/Capital/cash_with'); //提现
        Route::post('cash_details','api/Capital/cash_details'); //提现页面详情
        Route::any('bankcard_list','api/Capital/bankcard_list'); //银行卡列表
        Route::post('bankcard_add','api/Capital/bankcard_add'); //银行卡新增
        Route::post('bankcard_del','api/Capital/bankcard_del'); //银行卡删除
        Route::any('coupon','api/Capital/coupon'); //优惠券列表
    });

    //控制台-资金管理
    Route::group('Saas',function(){
        Route::any('saas_list','api/Saas/saas_list'); //订单列表
        Route::post('saas_cancel','api/Saas/saas_cancel'); //订单取消
    });

    //支付页面参数
    Route::group('Payment',function(){
        Route::post('coupou','api/Payment/coupou'); //优惠卷列表
        Route::post('balance','api/Payment/balance'); //用户余额
        Route::post('discount','api/Payment/discount'); //用户折扣
        Route::post('get_pay','api/Payment/get_pay'); //支付接口
        Route::post('pay_status','api/Payment/pay_status'); //支付订单状态
    });

    //支付回调
    Route::group('Callback',function(){
        Route::any('software_return','api/Callback/software_return'); //软件定制同步回调-支付宝
        Route::any('software_notify','api/Callback/software_notify'); //软件定制异步回调-支付宝
        Route::any('app_notice','api/Callback/app_notice'); //异步回调-微信

        Route::any('partner_return','api/Callback/partner_return'); //合伙人同步回调-支付宝
        Route::any('partner_notify','api/Callback/partner_notify'); //合伙人异步回调-支付宝
        Route::any('partner_notice','api/Callback/partner_notice'); //合伙人异步回调-微信

        Route::any('sub_return','api/Callback/sub_return'); //分包商同步回调-支付宝
        Route::any('sub_notify','api/Callback/sub_notify'); //分包商异步回调-支付宝
        Route::any('sub_notice','api/Callback/sub_notice'); //分包商异步回调-微信

        Route::any('balance_return','api/Callback/balance_return'); //余额同步回调-支付宝
        Route::any('balance_notify','api/Callback/balance_notify'); //余额异步回调-支付宝
        Route::any('balance_notice','api/Callback/balance_notice'); //余额异步回调-微信

        Route::any('grade_return','api/Callback/grade_return'); //等级会员同步回调-支付宝
        Route::any('grade_notify','api/Callback/grade_notify'); //等级会员异步回调-支付宝
        Route::any('grade_notice','api/Callback/grade_notice'); //等级会员异步回调-微信

    });

    //消息留言
    Route::group('Chat',function (){
        Route::post('msg_add','api/Chat/add_message');//新增留言
        Route::post('msg_list','api/Chat/msg_list');//留言列表
        Route::post('msg_read','api/Chat/msg_read');//读取消息
        Route::post('MessageFeedback','api/Chat/MessageFeedback');//反馈留言
    });

    //微信二维码
    Route::group('WxQrcode',function (){
        Route::post('code_add','api/WxQrcode/code_add');//生成带参数二维码
        Route::post('serve','api/WxQrcode/serve');//服务器返回
        Route::post('wx_accredit','api/WxQrcode/wx_accredit');//生成带参数二维码
        Route::post('wx_code','api/WxQrcode/wx_code');//服务器返回

    });


});

$afterBehavior = [
    '\app\api\behavior\ApiAuth',
    '\app\api\behavior\ApiPermission',
    '\app\api\behavior\RequestFilter'
];
// Route::rule('api/5c051ee3622e2','api/Problem/index', 'GET', ['after_behavior' => $afterBehavior]);Route::rule('api/5c063d2854725','api/Problem/add', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c07355145d9a','api/Problem/upd', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c0736bc45cac','api/Problem/del', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c0748240d1dc','api/Info/profitInfo', 'GET', ['after_behavior' => $afterBehavior]);Route::rule('api/5c074a3376deb','api/Info/profitUpd', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c076e2a1cc97','api/BuildToken/getAccessToken', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c0775d2e96a1','api/Suggest/index', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c079b19ca1ee','api/Suggest/del', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c07b34a3edcf','api/UserManage/vip', '*', ['after_behavior' => $afterBehavior]);
//
//
//
//
//
//
//                              _ooOoo_
//                             o8888888o
//                             88" . "88
//                             (| -_- |)
//                             O\  =  /O
//                          ____/`---'\____
//                        .'  \\|     |//  `.
//                       /  \\|||  :  |||//  \
//                      /  _||||| -:- |||||-  \
//                      |   | \\\  -  /// |   |
//                      | \_|  ''\---/''  |   |
//                      \  .-\__  `-`  ___/-. /
//                    ___`. .'  /--.--\  `. . __
//                  ."" '<  `.___\_<|>_/___.'  >'"".
//                | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//                \  \ `-.   \_ __\ /__ _/   .-` /  /
//           ======`-.____`-.___\_____/___.-`____.-'======
//                              `=---='
//           ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//
//                      -望佛祖保佑永远无BUG!-
//
//
//
//
