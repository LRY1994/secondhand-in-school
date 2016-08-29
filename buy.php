<?php
session_start();
header("Content-Type: application/json;charset=utf-8");
error_reporting(E_ALL ^ E_DEPRECATED);
$userID = $_SESSION['userID'];      //从session获取ID
//$userID=25;
$itemID = $_GET['itemID'];
//$itemID=7;

$num = $_GET['num'];   //选择要购买的数量
//$num = 4;

//$request['error']="false";

$conf = require_once 'conf/db.php';
$connect = @mysql_connect($conf['host'],$conf['root'],"");
@mysql_select_db($conf['db']);
$user = @mysql_query("select account,userID,name,tel,permission from user_info where userID=".$userID);
$userArray = @mysql_fetch_array($user);
$permission = $userArray['permission'];
$item = @mysql_query("select * from item_info where itemID=".$itemID);
$itemArray = @mysql_fetch_array($item);
$quantity = $itemArray['quantity'];
$seller = $itemArray['owner'];
$price = $itemArray['price'];
//当物品数量大于0的时候才可以购买,且不能超过最大数量，输入的数字必须是正整数
if($quantity>0 && $quantity-$num>=0 && preg_match($conf['tel_pattern'], $num))
{
    if($permission < 1)
    {       //当不能买不能卖的时候交易失败
       // $_GET['type']='failed';//这两句看情况修改
        //echo json_encode($_GET);
        //echo 'no permission';
        $request['error']=true;
    }
    else if($permission >=1 && $permission <=2)
    {
        //$_GET['type']='success';//这两句看情况修改
        //echo json_encode($_GET);
        //echo 'success';
        $update = @mysql_query("update item_info set quantity=".($quantity-$num)." where itemID=".$itemID);
        $insert = @mysql_query("insert into order_info value(NULL,".$seller.
        ",".$userID.
        ",".$itemID.
        ",".$num.
        ",".($num*$price).")");
        if($update && $insert)
        {
            $request['error']=false;
        }
    }
    else {
        //$_GET['type']='error';//这两句看情况修改
        //echo json_encode($_GET);
        //echo 'no quantity';
        $request['error']=true;
    }
}
else {
    //$_GET['type']='failed';//这两句看情况修改
    //echo json_encode($_GET);
    //echo 'system error';
    $request['error']=true;
}
@mysql_close($connect);
//echo json_encode($_GET);
//print_r($request);
echo json_encode($request);
?>