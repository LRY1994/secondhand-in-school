<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: application/json;charset=utf-8");
// $_SESSION['userID']=3;
// echo json_encode($_SESSION);
// die();
$account = $_POST["account"];
//$account = '114@111.com';
$password = $_POST["password"];
//$password='123';
$confirm = $_POST['confirm'];
//$confirm='123';
$name = $_POST["name"];
//$name='123';
$tel = $_POST["tel"];
//$tel=123;
/*
echo $account;
echo $password;
echo $confirm;
echo $name;
echo $tel;*/
$request['error']=false;
$account_pattern = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";   //emailadddress
$password_pattern = "/^[A-Za-z0-9]+$/";    //number+letter
$name_pattern = "/^\w+$/";    //数字、字母和下划线组成的字符串
$tel_pattern = "/^[0-9]*[1-9][0-9]*$/";   //正整数
if(preg_match($account_pattern, $account) &&
    preg_match($password_pattern, $password) &&
    preg_match($password_pattern, $confirm) &&
    preg_match($name_pattern, $name) &&
    preg_match($tel_pattern, $tel))
{
    if($password != $confirm)
    {
        $_POST['error']=true;
    }
    else {
        $conf = require_once 'conf/db.php';
        $connect = @mysql_connect($conf['host'],$conf['root'],"");

        @mysql_select_db($conf['db']);
        $res = @mysql_query("select account,userID,name,tel,permission from user_info where account='".$account."'");
        $resArray = @mysql_fetch_array($res);
        if($resArray != NULL)
        {
            //echo '已存在该账号';
            //$_POST["error"] = true;
            //json_encode($_POST);
            $request['error']=true;
        }
        else
        {
            $insert = @mysql_query("insert into user_info value('".
            $account."',NULL,'".
            $name."','".
            $password."','".
            $tel."',2);");
            //echo $insert;    //$insert=1
            //print_r($insert);
if($insert){
            //$_POST['error']=false ;

            $ID = @mysql_query("select userID,name ,account from user_info where account='".$account."';");
            $IDarray=@mysql_fetch_array($ID);
//             print_r($IDarray);
            $_SESSION['userID']=$IDarray['userID'];
             $_SESSION['name']=$IDarray['name'];
             setcookie('username',$IDarray['account'],time()+24*60*60*7);
             // $_COOKIE['username']=$IDarray['account'];
            //echo $_SESSION['userID'];
            //print_r($_SESSION);
             // echo $_COOKIE['username'];
            $request['error']=false;
}
    }
    mysql_close($connect);
    }
}
else
{
    //$_POST["error"]=true;
    $request['error']=true;

}
//print_r($request);
// $_SESSION['error']=$request['error'];
// echo json_encode($_SESSION);
echo json_encode($request);
?>