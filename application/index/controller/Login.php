<?php

namespace app\index\controller;

use app\index\common\Base;
use app\index\model\User;
use http\Message;
use think\Request;
use think\Session;

class Login extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $this->alreadyLogin();
        return $this->fetch('login');
    }

    public function check(Request $request){
        //设置status
        $status = 0;

        //获取表单提交的数据，并保存在变量
        $data = $request -> param();
        $username = $data['username'];
        $password = md5($data['password']);

        //在user表中查询
        $map = ['username'=> $username];
        $user = User::get($map);

        //将用户名与密码分开验证

        //如果未查询到该用户
        if(is_null($user)){

            //设置返回信息
            $message = '用户名不正确';
        }elseif ($user->password != $password) {

            //设置密码不正确的提示信息
            $message = '密码错误';
        }else{

            //如果用户名密码都通过验证了，说明是合法用户
            //设置返回信息
            $status =1;
            $message = '验证通过，请等待跳转...';

            //更新表里数据
            $user -> setInc('login_count');
            $user ->save(['last_login'=>time()]);

            //将用户登录信息保存到session中
            Session::set('user_id',$username);
            Session::set('user_info',$data);


        }
        return ['status'=> $status, 'message'=> $message];

    }

    public function logout(){

        //删除session值
        Session::delete('user_id');
        Session::delete('user_info');

        //成功，返回界面
        $this->success('注销成功，正在返回...','../index/login');
    }

    public function getUserName(){

        $uname = Session::get('user_id');
        return $uname;
    }

}
