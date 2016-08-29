<?php
/**********修改用户信息（可修改内容：昵称、电话）**********/
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: application/json;charset=utf-8");
$userID = $_SESSION['userID'];
$name = $_GET["name"];
$tel =$_GET["tel"];
$name_pattern = "/^\w+$/";    //数字、字母和下划线组成的字符串
$tel_pattern = "/^[0-9]*[1-9][0-9]*$/";   //正整数
if(preg_match($name_pattern, $name) &&
    preg_match($tel_pattern, $tel))
{
    $conf = require_once 'conf/db.php';
    $connect = @mysql_connect($conf['host'],$conf['root'],"");
    @mysql_select_db($conf['db']);
    $newName = @mysql_query("update user_info set name='".$name."' where userID=".$userID);
    $newTel = @mysql_query("update user_info set tel='".$tel."' where userID=".$userID);
    if(!$newName || !$newTel)
    {
        //更新失败引起的错误
        //$_POST["error"]=true;
        //json_encode($_POST);
        $request['error']=true;

    }
    else {
        //更新成功
        //$res = @mysql_query("select account,userID,name,tel,permission from user_info where userID=".$userID);
        //$resArray = @mysql_fetch_array($res);
        //after update,the latest info would be shown
        /*
        return [
            "userID"=>$resArray["userID"],
            "account"=>$resArray["account"],
            "name"=>$resArray["name"],
            "tel"=>$resArray["tel"]
        ];
        */
        $request['error']=false;
        $request['name']=$name;
        $request['tel']=$tel;
    }
    @mysql_close($connect);
}
else
{
    //正则表达式不匹配引起的错误
    //$_POST["error"]=true;
    //json_encode($_POST);
    $request['error']=true;
}
echo json_encode($request);
?>