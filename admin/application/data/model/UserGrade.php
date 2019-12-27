<?php

namespace app\data\model;

use think\Model;

class UserGrade extends Model
{
    /**
     * 用户等级model
     * @var string
     */
    protected $table = "user_grade";
    protected $resultSetType = 'collection';

    //新增
    public function add($uid)
    {
        $user = new UserGrade;
        $data =  $user->save([
            'user_id' => $uid,
            'grade' =>0,
        ]);
        return $data ? $data : returnJson(0,'新增用户等级失败');
    }


}
