<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/23
 * Time: 19:20
 */
return [
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => true,
    /**
     * 账号基本信息，请从微信公众平台/开放平台获取
     */

    'app_id'  => 'wxf0c67b5684405d44',         // AppID
    'secret'  => 'efbf672f147c397407b2267cf3d4253a',     // AppSecret
    'token'   => 'TOKEN',          // Token
    'aes_key' => '',                    // EncodingAESKey，安全模式下请一定要填写！！！

    /**
     * 日志配置
     *
     * level: 日志级别, 可选为：
     *         debug/info/notice/warning/error/critical/alert/emergency
     * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level'      => 'debug',
        'permission' => 0777,
        'file'       => ROOT_PATH . 'runtime/wechat/easywechat.log',
    ],
    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址
     */
    'oauth' => [
        'scopes'   => ['snsapi_userinfo'],
        'callback' => '/examples/oauth_callback.php',
    ],
    /**
     * 微信支付
     */
    'payment' => [
        'merchant_id'        => '1559227101',
        'key'                => 'Siring13922830809zhanghaiqing123',
//        'cert_path'          => ROOT_PATH . 'public/certs/wechat/apiclient_cert.pem', // XXX: 绝对路径！！！！
//        'key_path'           => ROOT_PATH . 'public/certs/wechat/apiclient_key.pem',      // XXX: 绝对路径！！！！
        'notify_url'       => '',
    ],
    /**
     * Guzzle 全局设置
     *
     */
    'guzzle' => [
        'timeout' => 3.0, // 超时时间（秒）
        //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
    ],
];