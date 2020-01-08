<?php

namespace app\api\controller;
use app\data\model\UserEnterprise;
use app\data\model\UserGrade;
use app\data\model\UserFund;
use think\Request;
use app\data\model\User as UserAll;
use think\Validate;
use think\Controller;
use think\captcha\Captcha;
use think\Session;
use think\Db;
/**
 * Class User登录 注册
 * @package app\api\controller
 * @time 2019/10/10
 */
class User extends Base
{
    /**
     * 获取验证码
     * @return array
     * @author fyk
     */
    public function code()
    {

        $request = Request::instance();
        $data = $request->param();
        // 验证
        $rules = [
            'phone' => 'require|regex:\d{11}',
        ];
        $msg = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
        ];
        $valid = new Validate($rules, $msg);
        if (!$valid->check($data)) {
            return json(['code' => 0,'msg' => $valid->getError()]);
        }

        $mobileCode = rand(100000, 999999);
        $mobile = $data['phone'];
        //存入session中
        if (strlen($mobileCode)> 0){
            Session::set('mobileCode',$mobileCode);
            Session::set('mobile',$mobile);
        }
        $content = "【Siring思锐】验证码:{$mobileCode}，(一站式移动互联网开发·运营·推广·赋能平台)十分钟内有效";
        $output = sendMessage($content,$mobile);

        return $output  ? returnJson(1,'发送成功',$output) : returnJson(0,'发送失败');
    }

    /**
     * 注册
     * @return array
     * @author fyk
     * Db::transaction
     */
    public function register(){
        $request = Request::instance();
        $ip = $request->ip();
       // $ip = '61.145.156.60';
        $param = $request->param();

        $rules = [
            'phone' => 'require|regex:\d{11}|unique:user',
            'password'=>'require|alphaNum|confirm|length:6,16',
            'code'=>'require',
            'pid'=>'require',
            'cid'=>'require',
        ];
        $message = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'phone.unique' => '该用户已存在,请前往登录,如有问题请联系管理员',
            'password.require'=>'密码不能为空',
            'password.length' => '密码长度必须在6~16位之间',
            'password.confirm' => '两次密码输入不一致',
            'code.require'=>'验证码不能为空',
            'pid.require' => '省份ID不能为空',
            'cid.require' => '城市ID不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }

        if (Session::get('mobileCode') != $param['code']) {
            return json(['code'=>0,'msg'=>$param['code']."验证码不正确"]);
        }
        //判断邀请码
        if(empty($param['invitation'])){
            $param['invitation'] = '';
        }else{
            $user = new UserAll();
            $user->invitation($param['invitation']);
        }

        //验证
        $param['salt'] = substr(uniqid(rand()),-6);
        //生成密码
        $param['cipher'] = password_hash($param['password'],PASSWORD_DEFAULT);

        //调取生成个人邀请码
        $param['my_code'] = create_invite_code();

        //根据省份获取ip
        $all_ip = ip_address($ip);
        $ip_data = json_decode($all_ip,true);
        $param['ip'] = $ip_data['data']['ip'];
        $param['region'] = $ip_data['data']['region'];

        // 储存
        $result = Db::transaction(function()use ( $param ){
            //用户表
            $user = new UserAll();
            $data = $user->add($param);
            $uid = $data->id;
            //等级表
            $user_grade = new UserGrade();
            $user_data = $user_grade->add($uid);
            //资金表
            $user_fund = new UserFund();
            $user_fund_data = $user_fund->add($uid);

            return $data && $user_data && $user_fund_data ? true : false;

        });


        return $result  ? returnJson(1,'注册成功') : returnJson(0,'注册失败');

    }


    /**
     * 登录
     * @author fyk
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function login()
    {
        $request = Request::instance();
        $data = $request->param();
        // 验证
        $rules = [
            'phone' => 'require|regex:\d{11}',
            'password' => 'alphaNum|require|length:6,16',
//            'captcha|验证码'=>'require|captcha'
        ];
        $msg = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'password.require' => '密码不能为空',
            'password.length' => '密码长度必须在6~16位之间'
        ];
        $valid = new Validate($rules, $msg);
        if (!$valid->check($data)) {
            return json(['code' => 0,'msg' => $valid->getError()]);
        }
        // 查询判断
        $user = UserAll::phone($data['phone']);
        if($user['status'] == 2 && $user['delect_at'] !== null )returnJson(0,'该账号已禁止，请联系管理员处理');

        // 判断密码是否正确
        if (password_verify($data['password'] ,$user['password'])) {
            //更新openID
            if(!empty($data['open_id'])){
                db('user') ->where('id',$user['id']) ->update(['openid'=>$data['open_id']]);
            }
                Session::set('uid',$user['id']);
                Session::set('user_salt',$user['salt']);

            $res = [
                'user_id'=>$user['id'],
                'phone' =>$user['phone'],
                'user_img' =>$user['img'],
            ];
            return json(['code'=>1,'msg'=>'登录成功','data'=>$res]);
        }else {
            return json(['code'=>0,'msg'=>'密码错误']);
        }

    }


    /**
     * 验证码
     * @return array
     * @author fyk
     */
    public function vs_code(){
        //引用
        $captcha = new Captcha();
        $captcha->fontSize = 30;
        $captcha->length   = 4;
        $captcha->useNoise = false;
        return $captcha->entry();
    }

    /**
     * 忘记密码
     * @return array
     * @author fyk
     */
    public function forget(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'phone' => 'require|regex:\d{11}',
            'password'=>'require|alphaNum|confirm|length:6,16',
            'code'=>'require',
        ];
        $message = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'password.require'=>'密码不能为空',
            'password.confirm' => '两次密码输入不一致',
            'password.length' => '密码长度必须在6~16位之间',
            'code.require'=>'验证码不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }

        if (Session::get('mobileCode') != $param['code']) {
            return json(['code'=>0,'msg'=>$param['code']."验证码不正确"]);
        }

        $password = password_hash($param['password'],PASSWORD_DEFAULT);

        // 储存
        $user = new UserAll();
        $result = $user->editPassword($param['phone'],$password);

        return $result !== false ? returnJson(1,'修改密码成功') : returnJson(0,'修改密码失败');

    }

    /**
     * 修改手机号
     * @author fyk
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit_phone(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'user_id' => 'require',
            'new_phone' =>'require|regex:\d{11}',
            'new_code'=>'require',
            'password'=>'require',
        ];
        $message = [
            'new_phone.require' => '请输入新手机号',
            'new_phone.regex' => '新手机号格式不正确',
            'new_code.require'=>'新手机验证码不能为空',
            'password.require'=>'原密码不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }

        if (Session::get('mobileCode') != $param['new_code']) {
            return json(['code'=>0,'msg'=>$param['new_code']."验证码不正确"]);
        }
        $user = db('user') ->where('id',$param['user_id']) ->find();
        if ($user['phone'] === $param['new_phone']) {
            return json(['code'=>0,'msg'=>$param['new_phone']."该手机已注册"]);
        }
        if (password_verify($param['password'] ,$user['password'])) {
            // 储存
            $user = new UserAll();
            $result = $user->edit_tel($param['user_id'],$param['new_phone']);

            $res = $result ? ['code' => 1,'msg' => '修改手机号成功'] : ['code' => 0,'msg' => '修改手机号失败'];
            return json($res);

        }else {
            return json(['code'=>0,'msg'=>'密码错误']);
        }

    }

    /**
     * 退出
     */
    public function logout(){
        //销毁session
        Session::clear();

       returnJson(1,'退出成功');exit();

    }

    /**
     * 用户更新
     */
    public function user_updating()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['name','require','姓名必须'],
            ['id_card', 'require|length:18', '身份证不能为空|身份证有误'],
            ['id_card_just','require','身份证正面必须'],
            ['id_card_back','require','身份证反面必须'],
            ['province','require','省份必须'],
            ['city','require','城市必须'],
            ['area','require','县市区必须'],
            ['address','require|max:50','详细地址必须|名称最多不能超过50个字符'],
            ['enterprise_id','require','企业必须'],
            ['sex','require','性别必须'],
            ['img','require','头像必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        //判断个人id
        $user_id = Session::get("uid");
        if($user_id){
            $param["uid"] = Session::get("uid");
        }else{
            $param["uid"] = $param["user_id"];
        }
        //判断邀请码
        if(empty($param['invitation'])){
            $param['invitation'] = '';
        }else{
            $user = new UserAll();
            $user->invitation($param['invitation']);
        }

        $result = Db::transaction(function()use ( $param ){
            //用户表
            $user_data = [
                'realname'=>$param['name'],
                'id_card'=>$param['id_card'],
                'id_card_just'=>$param['id_card_just'],
                'id_card_back'=>$param['id_card_back'],
                'add_province'=>$param['province'],
                'add_city'=>$param['city'],
                'add_area'=>$param['area'],
                'address'=>$param['address'],
                'enterprise_id'=>$param['enterprise_id'],
                'sex'=>$param['sex'],
                'img'=>$param['img'],
                'other_code'=>$param['invitation'],
                'updated_at'=>time()
            ];
            $user = new UserAll();
            $data = $user::where('id', $param["uid"])->update($user_data);

            return $data  ? true : false;

        });


        return $result !== false ? returnJson(1,'更新成功') : returnJson(0,'更新失败');
    }

    /**
     * 企业新增
     */
    public function enterprise_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['title','require','企业名称必须'],
            ['duty', 'require|length:15,20|unique:UserEnterprise', '税号不能为空|税号有误|税号已存在'],
            ['business_license','require','营业执照必须'],
            ['id_card_just','require','身份证正面必须'],
            ['id_card_back','require','身份证反面必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        //判断个人id
        $user_id = Session::get("uid");
        if($user_id){
            $param["uid"] = Session::get("uid");
        }else{
            $param["uid"] = $param["user_id"];
        }
        //保存
        $user_all = new UserEnterprise();

        $result = $user_all -> add($param);



        return $result  ? returnJson(1,'新增成功') : returnJson(0,'新增失败');
    }


    /**
     * 企业列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function enterprise_list()
    {
        $request = Request::instance();
        $param = $request->param();
        //判断个人id
        $user_id = Session::get("uid");
        if($user_id){
            $param["uid"] = Session::get("uid");
        }else{
            $param["uid"] = $param["user_id"];
        }

        $data = (new UserEnterprise()) ->where('user_id',$param['uid']) ->select()->toArray();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * 企业修改
     */
    public function enterprise_edit()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id','require','修改主键id必须'],
            ['title','require','企业名称必须'],
            ['duty', 'require|length:15,20', '税号不能为空|税号有误'],
            ['business_license','require','营业执照必须'],
            ['id_card_just','require','身份证正面必须'],
            ['id_card_back','require','身份证反面必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        //判断个人id
        $user_id = Session::get("uid");
        if($user_id){
            $param["uid"] = Session::get("uid");
        }else{
            $param["uid"] = $param["user_id"];
        }
        //保存
        $user_all = new UserEnterprise();

        $result = $user_all -> edit($param);



        return $result  !==false ? returnJson(1,'修改成功') : returnJson(0,'修改失败');
    }

    /**
     * 删除企业身份
     */
    public function enterprise_del()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id','require','主键id必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }

        $result = UserEnterprise::destroy($param['id']);


        return $result  !==false ? returnJson(1,'删除成功') : returnJson(0,'删除失败');
    }


    /**
     * 余额密码
     * @return array
     * @author fyk
     */
    public function balance_password(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'password'=>'require|alphaNum|confirm|length:6,16',
            'code'=>'require',
        ];
        $message = [
            'password.require'=>'密码不能为空',
            'password.confirm' => '两次密码输入不一致',
            'password.length' => '密码长度必须在6~16位之间',
            'code.require'=>'验证码不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }
        //判断个人id
        $user_id = Session::get("uid");
        if($user_id){
            $param["uid"] = Session::get("uid");
        }else{
            $param["uid"] = $param["user_id"];
        }
        if (Session::get('mobileCode') != $param['code']) {
            return json(['code'=>0,'msg'=>$param['code']."验证码不正确"]);
        }

        $password = password_hash($param['password'],PASSWORD_DEFAULT);

        // 储存
        $user = new UserFund();
        $result = $user->editPassword($param["uid"],$password);

        return $result  ? returnJson(1,'设置密码成功') : returnJson(0,'设置密码失败');

    }

    /**
     * 分享邀请码
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function share_code(){
        $request = Request::instance();
        $param = $request->param();

        //判断个人id
        $user_id = Session::get("uid");
        if($user_id){
            $param["uid"] = Session::get("uid");
        }else{
            $param["uid"] = $param["user_id"];
        }

        // 储存
        $data = (new UserAll()) ->where('id',$param['uid'])->field('invitation')->find();

        return $data  ? returnJson(1,'成功',$data) : returnJson(0,'失败',$data);

    }

    /**
     * 分享邀请记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lnvitation_record()
    {
        $request = Request::instance();
        $param = $request->param();

        //判断个人id
        $user_id = Session::get("uid");
        if($user_id){
            $param["uid"] = Session::get("uid");
        }else{
            $param["uid"] = $param["user_id"];
        }

        // 储存
        $user = (new UserAll()) ->where('id',$param['uid'])->field('invitation')->find()->toArray();

        $data = (new UserAll()) ->where('other_code',$user['invitation'])->field('id,invitation,phone,img')->select();

        return $data  ? returnJson(1,'成功',$data) : returnJson(0,'失败',$data);
    }

    /**
     * 软件收藏、项目关注
     * @author fyk
     * @time   2019/11/28
     */
    public function collect()
    {
        $request = Request::instance();
        $param  = $request->param();//获取所有参数，最全
        $validate = new Validate([
            ['pid','require','产品id必须'],
            ['type','require','1为软件定制商品收藏；2投融界关注'],
            ['user_id','require','用户id必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $db2 = db('collection');
        //查询是否有这条记录
        $user = $db2 ->where(['pro_id' => $param['pid'], 'user_id' => $param['user_id'],'type'=>$param['type']])->find();

        if ($user) {
            $result = $db2 ->delete (['id' => $user['id']]);

            return $result  ? returnJson(1,'取消关注成功') : returnJson(0,'取消关注失败');
        } else {
            $insert  = [
                'pro_id'  => $param['pid'],
                'type'    => $param['type'],
                'user_id'    => $param['user_id'],
                'time' =>time()
            ];
            $result = $db2 ->insert($insert);

            return $result  ? returnJson(1,'关注成功') : returnJson(0,'关注失败');
        }
    }
}
