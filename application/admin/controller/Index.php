<?php
namespace app\admin\controller;

use app\admin\common\Base;

class Index extends Base
{
    public function index()
    {
//        return $this-> view ->fetch('index');
        return $this->fetch('index');
    }
    public function welcome()
    {
        return $this->fetch('welcome');
    }
}
