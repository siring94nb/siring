<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/18
 * Time: 9:45
 */
namespace app\data\model;

use think\Model;

class Invoice extends Model
{

    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $table = "invoice";
    protected $resultSetType = 'collection';

    /**
     * @author fyk
     * 新增开票
     */
    public function add_invoice($uid,$type, $status, $email, $rise ,$duty, $price, $tel, $address)
    {
        return $this->save([
            'user_id' => $uid,
            'no'=> $this->get_sn(),
            'type' => $type,
            'status' => $status,
            'email' =>$email,
            'rise' =>$rise,
            'duty' =>$duty,
            'price' =>$price,
            'phone'=>$tel,
            'address'=>$address,
            'invoiceLine'=>'p',
            'state' =>1,
            'create_time' => time(),


        ]);
    }

    /**
     * @return string
     */
    function get_sn() {
        return 'FP'.date('YmdHis').rand(100000, 999999);
    }

}
