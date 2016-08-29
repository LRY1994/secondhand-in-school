<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: application/json;charset=utf-8");
$userID = $_SESSION['userID'];
if($userID == NULL){

}
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];
$rePassword = $_POST['rePassword'];
$password_pattern = "/^[A-Za-z0-9]+$/";    //number+letter
if(preg_match($password_pattern, $oldPassword) &&
    preg_match($password_pattern, $newPassword) &&
    preg_match($password_pattern, $rePassword))
{
    $conf = require_once 'conf/db.php';
    $connect = @mysql_connect($conf['host'],$conf['root'],"");
    @mysql_select_db($conf['db']);
    $res = @mysql_query("select * from user_info where userID=".$userID);
    $resArray = @mysql_fetch_array($res);
    if($resArray["password"] != $oldPassword)
    {
        //错误密码引起的错误
        //echo '密码错误';
        $request['error']=true;
    }
    elseif($newPassword != $rePassword)
    {
        //密码不一致引起的错误
        //echo '两次输入密码不一致';
        $request['error']=true;
    }
    else
    {
        $update = @mysql_query("update user_info set password='".$newPassword."' where userID=".$userID);
        if(!$update)
        {
            //更新失败引起的错误
            //$_POST["error"]=true;
            //json_encode($_POST);
            $request['error']=true;
        }
        else {
            //修改成功
            //echo '修改成功';
            $request['error']=false;
        }
    }
    @mysql_close($connect);
}
else {
    //正则表达式不匹配引起的错误
    //$_POST["error"]=true;
    //json_encode($_POST);
    $request['error']=true;
}
echo json_encode($request);
?>