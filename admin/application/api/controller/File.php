<?php

namespace app\api\controller;
use think\Config;
use think\Controller;
use think\Request;
use Qiniu\Auth as Auth;
use Qiniu\Storage\UploadManager;
class File extends Controller
{

    private $accesskey = '3k_WRHSUz0z-fkYa5dCUJiusRjjs-8_C6UF0egvd';
    private $secrectkey = '_OR7I7xCiQs3kZmRKN61ELvhvoftqcZ73A31MftJ';
    public $bucket = 'siring';
    public $domain='http://qiniu.siring.com.cn';

    /**
     * 七牛云上传
     * @return array|\think\response\Json
     */
    public function qn_upload()
    {
        if(request()->isPost()){
            $file = request()->file('image');
            // 要上传图片的本地路径
            $filePath = $file->getRealPath();
            $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀

            // 上传到七牛后保存的文件名
            $key =substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
            // 需要填写你的 Access Key 和 Secret Key
            $accessKey1 = $this->accesskey;
            $secretKey1 = $this->secrectkey;
            // 构建鉴权对象
            $auth = new Auth($accessKey1, $secretKey1);

            // 要上传的空间
            $bucket = $this->bucket;
            //解析域名地址
            $domain1 =$this->domain;
            $token = $auth->uploadToken($bucket);
            // 初始化 UploadManager 对象并进行文件的上传
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 putFile 方法进行文件的上传
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
            if ($err !== null) {
                return ["code"=>0,"msg"=>$err,"data"=>""];
            } else {
                //返回图片的完整URL
                $data['fileName'] = $ret['key'];
                $data['filePath'] = $domain1 . '/'.$ret['key'];
                return json(['code'=>1,'msg'=>'上传成功','data' =>$data]);

            }
        }
    }


    /**
     * @time 2019/04/02
     * 图片上传
     * @param  \think\Request  $request
     * @return \think\Response
     * @author fyk
     */
    public function img(Request $request)
    {
        $file = $request->file('image');
        $imgPath = 'public' . DS . 'upload' . DS . 'image';
        $info =  $file->validate(['size'=>10485760,'ext'=>'jpg,png,gif,jpeg'])
        ->move(ROOT_PATH . $imgPath);
        if($info){
            $fileName = str_replace("\\","/",$info->getSaveName());
            //pp($fileName);die;
             //获取文件路径
             $filePath = Config::get('front_pic_domain').'upload/image/'.$fileName;
             $data['fileName'] = $fileName;
             $data['filePath'] = $filePath;
            return json(['code'=>1,'msg'=>'上传成功','data' =>$data]);           
        }else{
            // 上传失败获取错误信息
            return json(['code'=>0,'msg' => $file->getError()]);
        }
    }
    /**
     * @time 2019/04/02
     * 视频上传
     * @param  \think\Request  $request
     * @return \think\Response
     * @author fyk
     */
    public function video(Request $request)
    {
        $file = $request->file('video');
        $info =  $file->validate(['size'=>104857600,'ext'=>'flv,wmv,rmvb,mp4'])
        ->move( './upload/video');
        if($info){
            $fileName = str_replace("\\","/",$info->getSaveName());
            //pp($fileName);die;
            //获取文件路径
            $filePath = Config::get('front_pic_domain').'upload/video/'.$fileName;
            $data['fileName'] = $fileName;
            $data['filePath'] = $filePath;
            return json(['code'=>1,'msg'=>'上传成功','data' =>$data]);           
        }else{
            // 上传失败获取错误信息
            return json(['code'=>0,'msg' => $file->getError()]);
        }
    }

}
