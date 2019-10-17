<?php

namespace app\index\controller;

use app\index\controller\Index;
use think\Request;
use think\Session;

class File extends Index
{
    public function getMyFiles(){

        require_once "conn.php";

        $uname = Session::get('user_id');

        $sql = "SELECT * FROM `files` WHERE `ofuser` = '$uname'";

        $res = mysqli_query($link, $sql);

        $data = $res->fetch_all(MYSQLI_ASSOC);

        echo json_encode($data);

    }

    public static function insertData($data){
        require_once "conn.php";

        $uname = Session::get('user_id');

        $sql = "insert into `files` (`ofuser`,`name`, `path`, `size`,`share`) values ('{$uname}','{$data['name']}', '{$data['path']}', {$data['size']},'0')";

        mysqli_query($link, $sql);

        mysqli_close($link);
    }

    public static function saveFile(){

        date_default_timezone_set("PRC");
        $uname = Session::get('user_id');

        // 按用户保存文件，为每个用户分配一个文件夹
        $user = "drive/uploads/$uname";
        // 用户文件夹里按日期保存文件
        $date = date("Y,m,d" ,time());
        // 存放文件的文件夹
        $save_dir = $user.'/'.$date;
        // 如果文件夹不存在就创建一个文件夹
        if (!is_dir($save_dir)) {
            mkdir($save_dir,0777,true);
        }

        // 用时间戳当做文件名的前缀，防止文件名重复
        $time = time();
        // 完整文件路径，大概是这样  ../uploads/lhw/20190923/1569215697.hw01.docx
        $dest = $user.'/'.$date.'/'.$time.'.'.$_FILES['my-file']['name'];
        // 保存文件，保存失败会返回false
        $res = move_uploaded_file($_FILES['my-file']['tmp_name'], $dest);
        if(!$res){
            echo "error";
            print_r($_FILES);
            die;
        }else{
            echo "<script>alert('success,back to home page');location.href='http://disktp.com'</script>";
        }

        return [
            'name'  =>  $_FILES['my-file']['name'],
            'path'  =>  $dest,
            'size'  =>  $_FILES['my-file']['size']
        ];
    }

    public static function Upload(){

        $data = self::saveFile();
        self::insertData($data);
        echo "<script>localStorage.removeItem('myFiles')</script>";
    }

    public static function Count(){
        require_once "conn.php";

        $uname = Session::get('user_id');

        $sql = "select COUNT(*) from `files` where `ofuser`='$uname'";

        $res = mysqli_query($link, $sql);

        $data = $res->fetch_all();

        echo json_encode($data);
    }

    public static function shareFileCount(){
        require_once "conn.php";

        $sql = "select COUNT(*) from `files` where `share`='1'";

        $res = mysqli_query($link, $sql);

        $data = $res->fetch_all();

        echo json_encode($data);
    }

    public static function Delete(){
        require_once "conn.php";

        $id = $_GET['id'];
        // 删除数据库中的信息
        $sql = "delete from `files` where `id` = {$id}";
        $res = mysqli_query($link, $sql);
        if ($res) {
            // 删除文件
            unlink($_GET['path']);
            echo "删除成功";
        }else{
            echo "删除失败";
        }
        mysqli_close($link);
    }

    public static function getShareFiles(){
        require_once "conn.php";

        $sql = "SELECT * FROM `files` WHERE `share` = '1'";

        $res = mysqli_query($link, $sql);

        $data = $res->fetch_all(MYSQLI_ASSOC);

        echo json_encode($data);
    }

    public static function shareFiles(){
        require_once "conn.php";

        $id = $_GET['id'];

        $sql = "select `share` from `files` where `Id` = '$id'";

        $res = mysqli_query($link,$sql);

        $ext = $res->fetch_all();
        $pd = $ext[0][0];
        if($pd == '1'){
            echo '文件已经分享,请勿重复操作!';
        }
        else{
            // 更新数据库中的信息
            $sql = "update `files` set `share`='1' where `id` = {$id}";
            $res = mysqli_query($link, $sql);
            if ($res) {
                echo "分享成功";
            }else{
                echo "分享失败";
            }
        }
        mysqli_close($link);
    }

    public static function cancelShare(){
        require_once "conn.php";

        $id = $_GET['id'];

        $sql = "select `ofuser` from `files` where `Id` = '$id'";
        $res = mysqli_query($link,$sql);
        $data = $res->fetch_all();
        $fileuser = $data[0][0];
        $uname = Session::get('user_id');
        if($fileuser != $uname){
            echo '你无权处理该文件（请选择自己的文件处理！）';
        }else{
            $sql = "select `share` from `files` where `Id` = '$id'";

            $res = mysqli_query($link,$sql);

            $ext = $res->fetch_all();
            $pd = $ext[0][0];
            if($pd == '0'){
                echo '文件已经被取消分享,请勿重复操作!';
            }
            else{
                // 更新数据库中的信息
                $sql = "update `files` set `share`='0' where `id` = {$id}";
                $res = mysqli_query($link, $sql);
                if ($res) {
                    echo "取消分享成功";
                }else{
                    echo "取消分享失败";
                }
            }
        }
        mysqli_close($link);
    }

    public static function usedRoom(){
        require_once "conn.php";

        $uname = Session::get('user_id');

        $sql = "select SUM(size) from `files` where `ofuser`='$uname'";

        $res = mysqli_query($link, $sql);

        $data = $res->fetch_all();

        echo json_encode($data);
    }

    public static function saveToMyFiles(){
        require_once "conn.php";
        //获取当前用户id
        $uname = Session::get('user_id');

        $id= $_GET['id'];

        //获取原文件地址
        $sql = "select `path` from `files` where `id`='$id'";
        $res = mysqli_query($link,$sql);
        $ext1 = $res->fetch_all();
        $fileUrl = $ext1[0][0];
//        print_r($fileUrl);

        //获取原文件名称
        $sql2 = "select `name` from `files` where `id`='$id'";
        $res2 = mysqli_query($link,$sql2);
        $ext2 = $res2->fetch_all();
        $filename = $ext2[0][0];
//        print_r($filename);

        //获取原文件大小
        $sql5 = "select `size` from `files` where `id`='$id'";
        $res5 = mysqli_query($link,$sql5);
        $ext3 = $res5->fetch_all();
        $fileSize = $ext3[0][0];
//        print_r($fileSize);

        $sql = "select * from `files` where `ofuser`='$uname' and `name`= '$filename'";
        $res = mysqli_query($link,$sql);
        $ext4 = $res->fetch_all();
        if($ext4){
            echo '该文件已在你的文件中,请勿重复操作！';
        }else{
            // 建立保存文件夹
            $user = "drive/uploads/$uname";
            // 用户文件夹里按日期保存文件
            $date = date("Y,m,d" ,time());
            // 存放文件的文件夹
            $save_dir = $user.'/'.$date;
            // 如果文件夹不存在就创建一个文件夹
            if (!is_dir($save_dir)) {
                mkdir($save_dir,0777,true);
            }

            // 用时间戳当做文件名的前缀，防止文件名重复
            $time = time();

            // 完整目标文件路径
            $aimUrl = $user.'/'.$date.'/'.$time.'.'.$filename;

            //复制文件

                $res4 = copy($fileUrl, $aimUrl);

                //写入数据库
                $sql6 = "insert into `files` (`ofuser`,`name`, `path`, `size`,`share`) values ('$uname','$filename', '$aimUrl', '$fileSize','0')";
                $res7 = mysqli_query($link, $sql6);
                if($res4 && $res7){
                    echo '转存成功!';
                }
                else{
                    echo '转存失败!';
                }
                mysqli_close($link);

        }
    }

}
