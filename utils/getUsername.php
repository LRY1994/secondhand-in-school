<?php
/*************返回查询到的用户全部信息*************/
function getUsername($userID){
$conf = require_once $_SERVER['DOCUMENT_ROOT'].'/SecondHand/conf/db.php';
$connect = @mysql_connect($conf['host'],$conf['root'],"");
@mysql_select_db($conf['db']);
$user = @mysql_query("select account from user_info where userID=".$userID);
$userArray = @mysql_fetch_array($user);
@mysql_close($connect);
if($userArray){
    return $userArray['account'];
 }else return  "用户";
}
?>