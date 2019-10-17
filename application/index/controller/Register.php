<?php

namespace app\index\controller;

use app\index\common\Base;
use app\index\model\User;
use think\Controller;
use think\Request;

class Register extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch('register');
    }

    public function register(Request $request){
        $status = 0;
        $info = $request->param();


        $uname = $info['username'];// 用户名
        $upwd = md5($info['password']);// 密码
        $uemail = $info['email']; // 邮箱

        if(!empty($uname)&&!empty($upwd)&&!empty($uemail)){
            // 判断该用户是否已经注册

            $map = ['username'=> $uname];
            $user = User::get($map);

            if($user){// 如果存在该用户

                $this->redirect('../index/login','',3,'该用户名已经注册，请直接登录!...页面跳转中...');
            }
            // 注册
            $data=array('Id'=>NULL,'username'=>$uname,'password'=>$upwd,'email'=>$uemail,);

            $insert = User::create($data);

            if($insert){// 如果注册成功
                $status = 1;

                $message = '注册成功，即将跳转登陆页面~~';

            }else{// 如果注册失败
                $status = 0;
                $message = '注册失败，请重试!';

            }

        }
        else{
            $status = 0;
            $message = '必填项不能为空!';
        }
        return ['status'=> $status,'message'=> $message];

    }

}
