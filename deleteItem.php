<?php
/**************删除物品，但是物品的图片还会保存在服务器***************/
header("Content-Type: application/json;charset=utf-8");
$itemID = $_GET['itemID'];
//$itemID = 70;

$conf = require_once 'conf/db.php';

$connect = @mysql_connect($conf['host'],$conf['root'],"");
@mysql_select_db($conf['db']);
$delete = @mysql_query("delete from item_info where itemID=".$itemID);
if($delete)
{
    $request['error']=false;
}
else {
    $request['error']=true;
}
//print_r($request);
// echo json_encode($request);
header("location:perinfo.php?#order");
?>