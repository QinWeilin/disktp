<?php

namespace app\index\controller;

use app\index\common\Base;
use think\Session;

class Index extends Base
{
    public function index()
    {
        $this-> isLogin();
        return $this->fetch('index');
    }

    public static function lastLogin(){
        require_once "conn.php";
        //获取当前用户id
        $uname = Session::get('user_id');
        $sql = "select `last_login` from `user` where `username`='$uname'";
        $res = mysqli_query($link,$sql);
        $theTime = date('Y-m-d',$res->fetch_all()[0][0]);
        echo $theTime;
    }

}
