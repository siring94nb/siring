<?php

namespace app\api\controller;
use think\Config;
use think\Controller;
use think\Request;



/**
 * lilu
 * websocket
 */
class WebSocket extends Base
{
    /**
     * lilu
     */
    public function  web_send()
    {
        $data=[];
        $data['id']=123;
        $data['name']='lilu';
        $data=json_encode($data);
        $url="ws://119.23.79.230:9009"; //服务地址
        vendor("websocket.lib.Client");
        $client=new \WebSocket\Client($url); //实例化

        $client->send($data); //发送数据

        $result=$client->receive(); //接收数据
        halt($result);

        $client->close();//关闭连接

    }




}