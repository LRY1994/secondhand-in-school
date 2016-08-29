<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$conf = require_once 'conf/db.php';
$connect = @mysql_connect($conf['host'],$conf['root'],"");
@mysql_select_db($conf['db']);

/***************Gallery Start****************/
$all = @mysql_query("select * from item_info where quantity>0");
$amount = @mysql_num_rows($all); //$amount代表有多少行查询结果
$i=0;
while($allArray = @mysql_fetch_array($all))
{
    $temp[$i++] = $allArray;
}

$num_item = 10;     //先显示30件物品
if($amount < $num_item)
{
    $num_item = $amount;        //不足30个的时候则取最大值
}

$Garr=array();
//$count = 0;
//$chosen = array();  //将被选中的数字放入一个数组
/*
 for ($ci=0;$count < $num_item;$ci++)  //未获取到30个随机数时进行循环
 {
 $chosen[$ci] = mt_rand(0, $amount-1);   //在0到amount-1间取得随机数
 $chosen = array_flip(array_flip($chosen));
 $count = count($chosen);
 }*/
$randArray = range(0,$amount-1);
shuffle($randArray);
$chosen = array_slice($randArray,0,$num_item);

for($i=0;$i<$num_item;$i++)     //将结果放在arr中
{
    /*
     if(!isset($chosen[$i]))
     {
     $num_item++;
     continue;
     }*/
    $Garr[$i] = $temp[$chosen[$i]];
}

/******************Gallery End*******************/

/****************Category Start******************/
$kind = @mysql_query("select kind from item_info where quantity>0 group by kind having count(kind)>0");
$kind_num = @mysql_num_rows($kind);     //获得种类的数量
$i=0;
while($kindArray = @mysql_fetch_array($kind))
{
    //$kindList是二维数组，存放kind，取出方法为$kindList[$i]['kind']
    $kindList[$i++] = $kindArray['kind'];
}
//print_r($kindList);
/*for($k=0;$k<$kind_num;$k++)
 {
 echo $kindList[$k]['kind'];
 }*/


$all = @mysql_query("select * from item_info where quantity>0");        //找出所有数量大于0的物品
$amount = @mysql_num_rows($all);     //代表该种类的查询结果有多少行

$temp = Array();
/* 会空出一半的空间所以不这样建
 for($ti=0;$ti<$kind_num;$ti++)
 {
 //建立一个二维数组
 $temp[$ti] = Array();
 //$temp[$ti][0]=$kindList[$ti];
}*/
//print_r($temp);
//$allList = Array();
//temp[allArray['kind']][]=
while($allArray = @mysql_fetch_array($all))
{
    //$allList[] = $allArray;        //将查询到的结果暂放在一个二位数组中
    for($i=0;$i<$kind_num;$i++)
    {
        //echo $allArray['kind'];
        if($allArray['kind'] == $kindList[$i])  //对物品的kind逐一进行比较，kind一致时放入对应下标的数组
        {
            //将查出的所有信息放入temp
            $temp[$allArray['kind']][] = $allArray;
            //echo 'true';
        }
        else continue;
    }
}
//print_r($temp);
/*************以下部分是为了让每个kind随机选30个物品出来**************/

$Carr = Array();
/*
 for($ai=0;$ai<$kind_num;$ai++)
 {
 //放结果的二维数组
 $arr[$ai] = Array();
 }
*/
$count = Array();
/*
 for($ci=0;$ci<$kind_num;$ci++)
 {
 $count[$ci] = count($temp[$ci]);
}*/
$i=0;
while($i<$kind_num)
{
    $count[$i] = count($temp[$kindList[$i]]);
    $i++;
}
//print_r($count);

for($i=0;$i<$kind_num;$i++)
{
    //$num_item = 30;      //暂定30个，可根据需要修改
    $num_item = 8;        //这一行是为了测试，不然输出太多看不完
    if($count[$i]<$num_item)
    {
        $num_item=$count[$i];       //如果某一种类的数量不足30个则取最大值
    }
    //$randCount = 0;     //随机数计数器
    // $chosen = Array();
    /*$ri = 0;
     while($randCount < $num_item)
     {
     $chosen[$ri] = mt_rand(0, $count[$i]-1);   //生成0到n-1的随机数，作用：作为下标
     $chosen = array_flip(array_flip($chosen));
     $randCount = count($chosen);
     $ri++;
     }*/
    $randArray = range(0,$count[$i]-1);
    shuffle($randArray);
    $chosen = array_slice($randArray,0,$num_item);
    //print_r($chosen);
    for($j=0;$j<$num_item;$j++)
    {
        /*
         if(!isset($chosen[$j]))         //这个循环同样是因为会出现下标丢失的问题，但是总数不变
         {
         $num_item++;
         continue;
         }*/
        $Carr[$kindList[$i]][$j] =$temp[$kindList[$i]][$chosen[$j]];
    }
}

/* 这一段暂时没用，但是上边的代码是参考下边的这一段来写的
 $num_item = 30;
 if ($amount < $num_item)
     $num_item = $amount;    //如果不足30个则取最大

     $arr=array();
     $count = 0;
     $chosen = array();  //将被选中的数字放入一个数组
     while ($count < $num_item)  //未获取到30个随机数时进行循环
     {
     $chosen[] = mt_rand(0, $amount-1);   //在1到num间取得随机数
     $chosen = array_flip(array_flip($chosen));
     $count = count($chosen);
     }

     for($i=0;$i<$num_item;$i++)     //将结果放在arr中
     {
     //从0开始,从随机数组$chosen[]中取出随机数$chosen[$i],令该随机数为temp[]的下标,存放在arr[]中
     $arr[$i] = $temp[$chosen[$i]];
     }*/
 //@mysql_close($connect);
 //print_r($arr);
 //注意：如果需要全部信息，则只要把return中的$arr改为$temp即可

@mysql_close($connect);
return [
    'gallery'=>$Garr,
    'kind'=>$kindList,
    'item'=>$Carr
];

?>