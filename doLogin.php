<?php
@session_start();
header("Content-Type: application/json;charset=utf-8");
@error_reporting(E_ALL ^ E_DEPRECATED);  //cancel reporting error

$account = $_POST["username"];
$password = $_POST["password"];

$account_pattern = "/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/";   //emailadddress
$password_pattern = "/^[A-Za-z0-9]+$/";    //number+letter
if(preg_match($account_pattern, $account) &&
    preg_match($password_pattern, $password))
{
    $conf = require_once 'conf/db.php';
    @$connect = mysql_connect($conf["host"],$conf["root"],"");
    @mysql_select_db($conf["db"]);
    $res = mysql_query("select * from user_info where account='".$account."'");
    if(!$res){

        die();
    }
    $resArray = mysql_fetch_array($res);
    if($resArray == NULL)
    {
        $result["error"]=true;
    }
    elseif($password != $resArray["password"]){
        $result["error"]=true;
    }
    elseif($password == $resArray["password"]){
        $_SESSION['userID'] = $resArray["userID"];  //将userID放入session
        $_SESSION['name']=$resArray['name']==null?$resArray['account']:$resArray['name'];
        // $_COOKIE['username']=$resArray['account'];
        setcookie('username',$resArray['account'],time()+24*60*60*7);
        $result["error"]=false;
    }
    mysql_close($connect);
}
else
{
    $result["error"]=true;

}
echo  json_encode($result);
?>