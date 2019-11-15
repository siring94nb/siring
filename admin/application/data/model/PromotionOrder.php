<?php

namespace app\data\model;

use think\Model;

class PromotionOrder extends Model
{
    protected $table = "promotion_order";
    protected $resultSetType = 'collection';


    public function order_add($role_type,$uid,$title,$object,$num,$yid,$tid,$ask,$money,$grade,$con,$resume,$url)
    {

        $data = new PromotionOrder;
        $data->save([
            'role_type' => $role_type,
            'user_id' => $uid,
            'title' => $title,
            'object' => $object,
            'no' => $this->get_sn(),
            'num' => $num,
            'money' => $money,
            'tid' => $tid,
            'ask'=>$ask,
            'yid' => $yid,
            'grade' => $grade,
            'con' => $con,
            'resume' => $resume,
            'url'=>$url,
            'status' =>1,
            'created_at'=>time(),

        ]);

        return $data !== false ? $data : false;
    }

    /**
     * 生成单号
     * @return string
     */
    function get_sn() {
        return 'TG'.date('YmdHi').rand(100000, 999999);
    }
}
