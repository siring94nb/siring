<?php

namespace app\data\model;

use think\Model;

/**
 * @author fyk
 * Class InvestmentProject
 * @package app\data\model
 */
class InvestmentProject extends Model
{
    protected $table = "investment_project";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';


    public function investment_add($param)
    {
        //pp($param);die;
        $data = new InvestmentProject;
        $data->save([
            'title' => $param['title'],
            'uid' => $param['uid'],
            'cid' => $param['cid'],
            'no' => $this->get_sn(),
            'reward' => $param['reward'],
            'location' =>$param['location'],
            'bright' => $param['bright'],
            'revenue' => $param['revenue'],
            'user_data' => $param['user_data'],
            'valuation' => $param['valuation'],
            'background' =>$param['background'],
            'advantage' => $param['advantage'],
            'bp_url' => $param['bp_url'],

        ]);

        return $data  ? $data : false;
    }


    /**
     * @return string
     */
    function get_sn() {
        return 'TR'.date('YmdHi').rand(100000, 999999);
    }
}
