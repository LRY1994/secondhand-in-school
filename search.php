<?php
function search(){
error_reporting(E_ALL ^ E_DEPRECATED);

if(isset($_GET['keyword'])){
    $keyword = $_GET['keyword'];    //搜索栏输入的内容:关键字
    
}else{
    $keyword=null;
}
// $keyword='衣';
if(isset($_GET['catagary'])){
    $kind = $_GET['catagary'];
}else{
    $kind=null;
}
// echo "\$keyword=$keyword";
// echo "\$kind=$kind";
// $kind='衣服';
//$content = '厨具';

//按价格排序，$order取消
//$order = $_GET['order'];       //选择按哪一种方式排序
//$order = 'price';
$conf = require_once 'conf/db.php';
$connect = @mysql_connect($conf['host'],$conf['root'],"");
@mysql_select_db($conf['db']);

/*********KIND LIST**********/

$allkind = @mysql_query("select kind from item_info group by kind having count(kind)>0");
$kind_num = @mysql_num_rows($allkind);     //获得种类的数量
$i=0;
while($kindArray = @mysql_fetch_array($allkind))
{
    //$kindList是二维数组，存放kind，取出方法为$kindList[$i]['kind']
    $kindList[$i++] = $kindArray['kind'];
}

/********KIND LIST END********/

//无关键字无种类搜索
if(($keyword==NULL||$keyword=="") && ($kind==NULL||$kind==""))
{   
// echo "无关键字无种类搜索";
    $select = @mysql_query("select * from item_info where quantity>0 order by price asc");

    
}
//无关键字有种类搜索
else if(($keyword==NULL||$keyword=="") && ($kind!=NULL&&$kind!="")){

//     echo "//无关键字有种类搜索";
    $select = @mysql_query("select * from item_info where  quantity>0 and kind like '%".$kind."%' order by price asc");
      
}
//有关键字无种类搜索
else if(($keyword!=NULL&&$keyword!="") && ($kind==NULL||$kind=="")){
    
//     echo "有关键字无种类搜索";
    $select = @mysql_query("select * from item_info where quantity>0 and (kind like '%".$keyword."%' or name like '%".$keyword."%') order by price asc");
}
//有关键字有种类搜索
else if(($keyword!=NULL&&$keyword!="") && ($kind!=NULL&&$kind!="")){
//     echo "有关键字有种类搜索";
    $select = @mysql_query("select * from item_info where quantity>0 and kind='".$kind."' and name like '%".$keyword."%' order by price asc");
}
/*
//查询所有名称或种类带有$content的商品，按照价格降序排序
$res = @mysql_query("select * from item_info where name like '%".$content.
                    "%' or kind like '%".$content.
                    "%' order by ".$order." desc");
$res_num = @mysql_num_rows($res);        //查询到的结果数量
*/
/*
while($resArray = @mysql_fetch_array($res))
{
    $arr[] = $resArray;
}
*/
$item = Array();
$item_num = @mysql_num_rows($select);
for($i=0;$i<$item_num;$i++)
{
    $item[$i]=Array();
}
$i=0;
while($i<$item_num  )
{
    $resArray = @mysql_fetch_array($select);
    //先查到物品拥有者的信息
    $ownerID = $resArray['owner'];
    $owner = @mysql_query("select name,tel from user_info where userID=".$ownerID);
    $ownerArray = @mysql_fetch_array($owner);
    $item[$i]['itemID']=$resArray['itemID'];
    $item[$i]['name']=$resArray['name'];
    $item[$i]['price']=$resArray['price'];
    $item[$i]['quantity']=$resArray['quantity'];
    $item[$i]['pic']=$resArray['pic'];
    $item[$i]['owner']=$ownerArray['name'];
    $item[$i]['tel']=$ownerArray['tel'];
    $i++;
}
@mysql_close($connect);
$keyword=null;
$kind=null;
//print_r($kindList);
//print_r($item);
return [
    'kind'=>$kindList,
    'item'=>$item
];
//达到效果
}
?>