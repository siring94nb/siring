<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用命名空间
    'app_namespace'          => 'app',
    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'json',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',//过滤
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'api',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['adminRoute', 'apiRoute', 'wikiRoute'],
    // 是否强制使用路由
    'url_route_must'         => true,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,
    // 全局请求缓存排除规则
    'request_cache_except'   => [],

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件
    'exception_tmpl'         => THINK_PATH . 'tpl' . DS . 'think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别
        'level' => [],
    ],

    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

    'cache'                  => [
        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' => 'ApiAdmin_',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'think',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
        //设置过期时间
        'expire'         => 36000,//十分钟
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],

    'front_pic_domain' => 'http://localhost/siring/admin/public/',
    'back_pic_domain' => 'http://localhost/siring/admin/public',
    'goods_detail_domain' => 'https://www.siring.cn.com/siring/',

    //支付宝参数
    'alipay' => [
        'app_id' => '2018082861128764',
        'ali_public_key'        => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmKw/C4jHlGLUhpATv2yesGaZOSI9MmOuw5AMcB6odktNj19CSNDAmS5gDCKM4bJyVFOCFb3BNgvADvhoXHMPngGUkqHkJuRotGpvbr3A5UCyWLsF442cFnO7KZC5blKY59DmB/zZ7E9gRT5BhmQebJkkMls2PcVkvEUNTdQiorcNunhxOfsyUuYqsZP0yPoptR8YarmiWZVXwNxJ7Ha3zVzc7kVPqNYyDkCYtSfvVjOeutUh2dGsz1irsYUZpQP4Kra2YyhPlXpNS/KR3TSl1eLXxAQH6g1YWIsQ7/AZRi+Qv1mczwB9miYjQyPkEtjyYQkHVaItxeGW3fvsSvXy9QIDAQAB',
        'private_key'     => 'MIIEowIBAAKCAQEAydhpt8EHQWE6lv1ExOuWo9dOZ09v4i4zW2r0/ftC6lUVwkLwiXberMQl4GZd7CDnYL9Te5nhce1jJ2VerIhFn0pZmFZwjcRUBVGtZC39m4ziGrrTrdwrCVXvLzje2QXGfU2kf80NsWht3QEXBXs4yeAjJdscC+IXo8bopR9Gav7Byxt38thDErUGvX4Mw5e3eag4UGwDffp2q9SyWZaCZdOS3SuE2HM5baPyoyp6bjcMSi3p4pqr5YePc3BXAZ/AVKYblmhOe1oM+TjCinh+NdHhWvDOki9/Hb69dBKCxWMgjvikRw3b2QtOPLFIgU9GMdTRdnaV53wbPreLuJMNjQIDAQABAoIBABpfd3i19O+693/Q+dJNAfLIaAshmvnPlZBFSluBH/4kPeKTAoDDkla6jkRiu7Tlm7XNaegFdCqBnOoB2bvrVkV43noEGVK8q0nCoUgspi1T3Bsn/A6EbO8cVlMyOBPdKFEo+uxj630ZqvksckiaEBJ4gb8pgOGgmfwhOjaQ/o9uHGaS2ay58EXrG3gWC5ldA5N7Kd1EVf7x4H1Z+ymvjsyCcg1n3d0h7dNPHt/kXhlupbsQsuRu0QXOXc7ZP1YshQgMx1tVTFexzLEnnkU/qVnG6SM40/mksfTLGRJnOvKjJlkVOOqQlZfaXIq4aGiPDdm8Cyq7JEuirgSFFx4Np9UCgYEA9jU5McmfpiLXvMSePufbLLjj3MmQqJMvbPUcnuWakD/G714tp6jHgBCcM0qJaTkvX+JBuU7D/q2B56AKWvr/DpkIC2Y5PdgJz90XuLyQjO7ldORE+mrnbZ2uAn2v5W7VXGsN8z9gb6qVFhaAYWRNspT6p3ck+OSarsqGCuwpZk8CgYEA0d+CqLYLDSvLbe5s1VH1BHmXn2hqq0T2pLAoYU/3vvbtBY9B7eXsY/kehdNnsmmnlSfIYCNg17ZhkU6/dTZBpgbIJQ1lKBtINwrXAL/yVBIHkmXPlBobcgzI1ZW44leY41CfzUnDPfL4ULD//S13Dk/+GiEXlZLkAUzoHn71c2MCgYAGkwlB8RZYQ1nranynRV2u5gj/nkpElhmQGUN4Yr0r2OghACzL60/YdZkWLYlZy/Md5lbG8fl91XhAjR95qnYhF6kFVOd2ZUxtxoOZpT9e5Aowgt/sp+oiHTHGU0DdKYZ8/0bSFgEnOjDc9CDdeOYyPJQs4JuWIdSXkkTeCcxZNQKBgEHTE3zs09yGruBE1pe1g96qcFbL/iDHmYAfzBpxZWfctIx42RnPcmwMt3kLzEtV/fy3JI6aqgYeKs3TYBNYOBDlsaKFaAPDQswYt0SB73RUz1EoY4m1AoSr49WxhvJevRIWuHg/uV/Vs/JDAZcbymqPxkfVtzrvflm2EFt4QG23AoGBAJMUb4qxT4cIiQ5beUHD99mogeQzuLdd03jZy/udPRG0Q9fnIu4xR2V3UtedPF4h5jQGzy/HXjteBl+F3PRyBog3/EjlZ6fpxiaYtRTAPHFYpkk/CckHn4uzhx4snM1s69YSdn/ypisdqFO0AH3qTm12GeoAcWX/iO0VnEok6H7U',
    ],

];
