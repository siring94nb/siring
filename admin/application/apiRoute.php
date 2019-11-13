<?php
/**
 * Api路由--前端接口
 */

use think\Route;

Route::group('api', function () {
    Route::miss('api/Miss/index');
//    Route::rule('new/:id','News/update','POST');
    //开始定义api路由接口

    //文件上传fyk
    Route::group('file', function () {
        Route::post('upload','api/File/img');
        Route::post('video','api/File/video');
        Route::post('qn_upload','api/File/qn_upload');//上传到七牛云
    });

    //用户接口接口fyk
    Route::group('User', function () {//'User' => 控制器
        Route::any('phone_code','api/User/code'); //('index =>方法','api/User/index' =>文件夹/控制器/方法)
        Route::any('register','api/User/register');//注册
        Route::any('login','api/User/login');//登录
        Route::any('forget','api/User/forget');//忘记密码
        Route::any('upd_phone','api/User/edit_phone');//修改手机号
        Route::any('logout','api/User/logout');//用户退出
    });

    //轮播接口接口fyk
    Route::group('Banner', function () {
        Route::any('banner_list','api/Banner/index'); //轮播列表
        Route::any('banner_save','api/Banner/save'); //测试

    });

    //网站基本接口fyk
    Route::group('Website', function () {
        Route::any('website_list','api/Website/website_list'); //关于我们
        Route::any('contact','api/Website/contact'); //联系我们
        Route::any('seo','api/Website/seo'); //SEO
    });

    //角色加盟fyk
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

    //角色加盟订单fyk
    Route::group('JoinOrder',function (){
        Route::any('city_order_add','api/JoinOrder/city_order_add'); //城市合伙人订单
        Route::any('member_order_add','api/JoinOrder/member_order_add'); //会员订单
        Route::any('join_order_add','api/JoinOrder/join_order_add'); //加盟商订单
        Route::any('get_pay','api/JoinOrder/get_pay'); //支付
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
        Route::any('meal_order_add','api/MealOrder/meal_order_add'); //下单
        Route::any('meal_order_pay','api/MealOrder/meal_order_pay'); //下单
    });

    //添加用户银行卡
    Route::group('UserCard',function(){
        Route::any('user_card_add','api/UserCard/user_card_add');  //添加/编辑银行卡
        Route::any('user_card_list','api/UserCard/user_card_list');  //银行卡列表
    });


    //角色加盟订单fyk
    Route::group('Software',function (){
        Route::any('soft_type','api/Software/soft_type'); //软件定制分类
        Route::any('soft_list','api/Software/soft_list'); //商品列表
        Route::any('soft_detail','api/Software/soft_detail'); //商品详情
        Route::any('soft_reviews','api/Software/soft_reviews'); //商品评论
        Route::any('soft_push','api/Software/soft_push'); //推荐商品
        Route::any('soft_demo','api/Software/soft_demo'); //商品演示
        Route::any('soft_order_add','api/Software/soft_order_add'); //软件定制订单
        Route::any('get_pay','api/Software/get_pay'); //软件定制订单支付
        Route::any('app_notice','api/Software/app_notice'); //支付回调
    });

    //用户优惠券fyk
    Route::group('UserDiscount',function(){
        Route::any('discount_list','api/UserDiscount/discount_list'); //用户优惠券
        Route::any('user_fund','api/UserDiscount/user_fund'); //用户余额
    });

    //用户优惠券fyk
    Route::group('Console',function(){
        Route::any('personal_information','api/Console/personal_information'); //用户信息
        Route::any('my_order','api/Console/my_order'); //用户订单
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
