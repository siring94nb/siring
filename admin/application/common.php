<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 把返回的数据集转换成Tree
 * @param $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param string $root
 * @return array
 */
function listToTree($list, $pk='id', $pid = 'fid', $child = '_child', $root = '0') {
    $tree = array();
    if(is_array($list)) {
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}

function formatTree($list, $lv = 0, $title = 'name'){
    $formatTree = array();
    foreach($list as $key => $val){
        $title_prefix = '';
        for( $i=0;$i<$lv;$i++ ){
            $title_prefix .= "|---";
        }
        $val['lv'] = $lv;
        $val['namePrefix'] = $lv == 0 ? '' : $title_prefix;
        $val['showName'] = $lv == 0 ? $val[$title] : $title_prefix.$val[$title];
        if(!array_key_exists('_child', $val)){
            array_push($formatTree, $val);
        }else{
            $child = $val['_child'];
            unset($val['_child']);
            array_push($formatTree, $val);
            $middle = formatTree($child, $lv+1, $title); //进行下一层递归
            $formatTree = array_merge($formatTree, $middle);
        }
    }
    return $formatTree;
}

/**
* @function 发送消息
* @param int type    类型：0系统消息；1订单发货；2收货签收；3退货通知；4会员升级；5提现到账；6公告消息
* @param int user_id 用户
* @param str con     内容
* @param str data    绑定数据
*/
function addMsg($type = 0,$user_id = 0,$con = '',$data = ''){
    $param['type'] = $type;
    $param['user_id'] = $user_id;
    $param['con'] = $con;
    $param['have_read'] = 0;
    $param['data'] = $data;
    $param['created_at'] = date('Y-m-d H:i:s');
    $param['updated_at'] = '';
    $param['deleted_at'] = null;
    return db('msg')->insert($param);
}

/**
 * 输出
 * [pp description]
 * @param  boolean $bool [description]
 * @return [type]        [description]
 * 作者：fyk
 */
function pp($bool=false){
    list($callee) = debug_backtrace();
    $arguments = func_get_args();
    $totalArguments = count($arguments);

    echo "<fieldset class='dump'>" . PHP_EOL .
        "<legend>{$callee['file']} @ line: {$callee['line']}</legend>" . PHP_EOL .
        '<pre>';

    $i = 0;
    foreach ($arguments as $argument) {
        echo '<br /><strong>Debug #' . (++$i) . " of {$totalArguments}</strong>: ";

        if (! empty($argument)
            && (is_array($argument) || is_object($argument))
        ) {
            print_r($argument);
        } else {
            var_dump($argument);
        }
    }

    echo '</pre>' . PHP_EOL .
        '</fieldset>' . PHP_EOL;
    if(!$bool){

    }
}

/**
 * 输出json数据
 * @param $code
 * @param $msg
 * @param null $data
 * @param null $page
 */
function    returnJson($code,$msg,$data = null,$page = null){
    $json = array(
        'code' => $code,
        'msg' => $msg,
    );
    $json['data'] = $data??'';
    if($page)$json['page'] = $page;
    echo json_encode($json);exit;
}

/**
 * 判断是否有值
 * @param $data
 */
function returnArray($data){
     $data ? $data->toArray() : returnJson(0,'数据有误');
}

/**
 * @param string $content  短信内容
 * @param string $mobile   手机号
 * @return 成功时返回，其他抛异常
 */
function sendMessage($content,$mobile)
{
    $api_code = "922001";//对接协议中的账号
    $api_secret = "7EbH6z";//对接协议中的密码
    $extno = 1069012345;
    $con = urlencode($content);
    //$sign = md5($api_secret.$extno.$con.$mobile);//md加密后短信内容+API密码
    $url = "http://117.48.217.182:7862/sms?action=send&account=".$api_code."&password=".$api_secret."&mobile=".$mobile."&content=".$con."&extno=".$extno."&rt=json";//请求URL
    $curl = curl_init();
    // 设置url路径
    curl_setopt($curl, CURLOPT_URL, $url);
    // 将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
    // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
    // 执行
    $data = curl_exec($curl);
    // 关闭连接
    curl_close($curl);

    return $data;
}

//function sendMessage($content,$mobile)
//{
//    // $content = '【智慧茶仓】短信内容';//带签名的短息内容
//    // $mobile = '18309224319';//手机号
//    $url = "http://117.48.217.182:8860/sendSms";//请求URL
//    $api_code = "240001";//对接协议中的API代码
//    $api_secret = "4SFE6PW1GL";//对接协议中的API密码
//    $sign = md5($content.$api_secret);//md加密后短信内容+API密码 获得签名
//    $bodys = [
//        'cust_code'=>$api_code,
//        'content' => $content,
//        'destMobiles' => $mobile,
//        'sign' => $sign,
//    ];
//    $data_string = json_encode($bodys);
//    if (!function_exists('curl_init'))
//    {
//        return '';
//    }
//    //设置url
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//
//    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: text/html'));// 文本提交方式，必须声明请求头
//    $data = curl_exec($ch);
//    if($data === false){
//        var_dump(curl_error($ch));
//    }else{
//        curl_close($ch);
//    }
//    return $data;
//}


/**
 * 生成当前数据库唯一码
 * @return bool|string
 */

function create_invite_code()
{
    $a = "ABCDEFGHIGKLMNOPQRSTUVWXYZ";
    $d = $a[rand(0,25)].substr(base_convert(md5(uniqid(md5(microtime(true)),true)), 16, 10), 0, 5);
    $w['invitation'] = array('eq', $d);
    $user_info = db('user')->field("id")->where($w)->find();
    if ($user_info) {
        $this->create_invite_code();
    }

    return $d;
}

/**
 * 转换文件大小单位
 * @param $size
 * @return string
 */
function formatBytes($size){
    $units = array('字节','K','M','G','T');
    $i = 0;
    for( ; $size>=1024 && $i<count($units); $i++){
        $size /= 1024;
    }
    return round($size,2).$units[$i];

}

/**
 *  调用淘宝API根据IP查询地址
 */
function ip_address($ip)
{
    $durl = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
    // 初始化
    $curl = curl_init();
    // 设置url路径
    curl_setopt($curl, CURLOPT_URL, $durl);
    // 将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
    // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
    // 执行
    $data = curl_exec($curl);
    // 关闭连接
    curl_close($curl);
    // 返回数据
    return $data;
}
