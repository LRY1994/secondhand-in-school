<?php
$itemID = $_GET['itemID'];      //从session获取物品ID
if($itemID==null){
	header("location: error.html");
	return null;
}
//$itemID=35;
$conf = require_once 'conf/db.php';
$connect = @mysql_connect($conf['host'],$conf['root'],"");
@mysql_select_db($conf['db']);
/*******ADD KIND LIST******/

$kind = @mysql_query("select kind from item_info group by kind having count(kind)>0");
$kind_num = @mysql_num_rows($kind);     //获得种类的数量
$i=0;
while($kindArray = @mysql_fetch_array($kind))
{
    //$kindList是二维数组，存放kind，取出方法为$kindList[$i]['kind']
    $kindList[$i++] = $kindArray['kind'];
}
/******KIND LIST END*******/

$item = @mysql_query("select * from item_info where itemID=".$itemID);
$itemArray = @mysql_fetch_array($item);
if($itemArray==null){
	mysql_close($connect);
	header("location: error.html");
	return null;
}
$owner = $itemArray['owner'];       //物品持有者
$seller = @mysql_query("select account,userID,name,tel,permission from user_info where userID=".$owner);
$sellerArray = @mysql_fetch_array($seller);
$arr = Array();
$arr[0] = $itemArray;
$arr[1] = $sellerArray;
@mysql_close($connect);
/***********PUT THE RESULT INTO $RES*************/
$res['itemID']=$itemArray['itemID'];
$res['name']=$itemArray['name'];
$res['price']=$itemArray['price'];
$res['quantity']=$itemArray['quantity'];
$res['kind']=$itemArray['kind'];
$res['pic']=$itemArray['pic'];
$res['owner']=(($sellerArray['name']==null||$sellerArray['name']=='')?$sellerArray['account']:$sellerArray['name']);
$res['tel']=$sellerArray['tel'];

//print_r($kindList);
//print_r($res);
return [
    'kind'=>$kindList,
    'item'=>$res
];
//可用
?>