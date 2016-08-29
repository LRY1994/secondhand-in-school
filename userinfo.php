<?php
/*************返回查询到的用户全部信息*************/
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
$userID = $_SESSION['userID'];
//$userID=40;

$conf = require_once 'conf/db.php';
$connect = @mysql_connect($conf['host'],$conf['root'],"");
@mysql_select_db($conf['db']);
$user = @mysql_query("select * from user_info where userID=".$userID);
$item = @mysql_query("select * from item_info where owner=".$userID);
$order = @mysql_query("select * from order_info where seller=".$userID." or buyer=".$userID);
//$arr = Array();
$userArray = @mysql_fetch_array($user);
$userList = $userArray;
while($itemArray = @mysql_fetch_array($item))
{
    $itemList[] = $itemArray;
}
while($orderArray = @mysql_fetch_array($order))
{
    $orderList[] = $orderArray;
}
@mysql_close($connect);
return [
    "user"=>$userList,
    "item"=>$itemList,
    "order"=>$orderList
];
//print_r($userList);
//print_r($itemList);
//print_r($orderList);
?>