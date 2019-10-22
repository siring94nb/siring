<?php
/**
 * Api路由--前端接口
 */

use think\Route;

Route::group('api', function () {
    Route::miss('api/Miss/index');
//    Route::rule('new/:id','News/update','POST');
    //开始定义api路由接口

    //文件上传
    Route::group('file', function () {
        Route::post('upload','api/File/img');
        Route::post('video','api/File/video');
        Route::post('qn_upload','api/File/qn_upload');//上传到七牛云
    });

    //用户接口接口
    Route::group('User', function () {//'User' => 控制器
        Route::any('phone_code','api/User/code'); //('index =>方法','api/User/index' =>文件夹/控制器/方法)
        Route::any('register','api/User/register');//注册
        Route::any('login','api/User/login');//登录
        Route::any('forget','api/User/forget');//忘记密码
        Route::any('upd_phone','api/User/edit_phone');//修改手机号
    });

    //轮播接口接口
    Route::group('Banner', function () {
        Route::any('banner_list','api/Banner/index'); //轮播列表
        Route::any('banner_save','api/Banner/save'); //测试

    });

    //网站基本接口
    Route::group('Website', function () {
        Route::any('website_list','api/Website/website_list'); //关于我们
        Route::any('contact','api/Website/contact'); //联系我们
        Route::any('seo','api/Website/seo'); //SEO
    });

    //角色加盟
    Route::group('JoinRole',function (){
        Route::any('province_list','api/JoinRole/province_list'); //省份列表
        Route::any('city_list','api/JoinRole/city_list'); //城市列表
        Route::any('grade_list','api/JoinRole/grade_list'); //等级费用列表
    });

    //角色加盟订单
    Route::group('JoinOrder',function (){
        Route::any('city_order_add','api/JoinOrder/city_order_add'); //省份列表
        Route::any('city_list','api/JoinOrder/city_list'); //城市列表
        Route::any('grade_list','api/JoinOrder/grade_list'); //等级费用列表
    });

    
});
$afterBehavior = [
    '\app\api\behavior\ApiAuth',
    '\app\api\behavior\ApiPermission',
    '\app\api\behavior\RequestFilter'
];
// Route::rule('api/5c051ee3622e2','api/Problem/index', 'GET', ['after_behavior' => $afterBehavior]);Route::rule('api/5c063d2854725','api/Problem/add', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c07355145d9a','api/Problem/upd', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c0736bc45cac','api/Problem/del', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c0748240d1dc','api/Info/profitInfo', 'GET', ['after_behavior' => $afterBehavior]);Route::rule('api/5c074a3376deb','api/Info/profitUpd', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c076e2a1cc97','api/BuildToken/getAccessToken', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c0775d2e96a1','api/Suggest/index', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c079b19ca1ee','api/Suggest/del', '*', ['after_behavior' => $afterBehavior]);Route::rule('api/5c07b34a3edcf','api/UserManage/vip', '*', ['after_behavior' => $afterBehavior]);
