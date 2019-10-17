<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/16
 * Time: 14:24
 */
namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Validate;

class Contact extends Base
{


    /**
     * @function 联系我们
     */
    public function signInfo()
    {
        $con = Db::table('contact')->find();
        if (empty($con)) {
            $con = new \ArrayObject();
        }


        return $this->buildSuccess([
            'con' => $con,
        ]);
    }

    /**
     * @function 联系我们更新
     */
    public function signUpd()
    {
        $request = Request::instance();
        $param = $request->param();
        $rules = [
            'con_a' => 'require',
            'con_b' => 'require',
            'con_c' => 'require',
            'con_d' => 'require',
        ];
        $message = [
            'con_a.require' => '请填写邮箱',
            'con_b.require' => '请填写地址',
            'con_c.require' => '请填写座机',
            'con_d.require' => '请填写热线',

        ];
        $validate = new Validate($rules, $message);
        if (!$validate->check($param)) {
            return $this->buildFailed(0, $validate->getError());
        }
        $data = [
            'tel'     => $param['con_c'],
            'phone'   => $param['con_d'],
            'email'   => $param['con_a'],
            'address' => $param['con_b'],
            'created_at' => time()
        ];
        $info = Db::table('contact')->find();
        if (empty($info)) {
            $insert = Db::table('contact')->insert($data);
            if (!$insert) {
                return $this->buildFailed(0, '操作失败');
            }
        } else {
            $id = $info['id'];
            $update = Db::table('contact')->where('id',$id)->update($data);
            if ($update === false) {
                return $this->buildFailed(0, '操作失败');
            }
        }

        return $this->buildSuccess([]);
    }

}