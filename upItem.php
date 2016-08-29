<?php
session_start();
error_reporting(E_ALL & E_NOTICE ^ E_DEPRECATED);     //正文中basename 和 tmp_name会导致Notice
header("Content-Type: application/json;charset=utf-8");
$userID = $_SESSION['userID'];      //会作为onwer
// $userID = 70;
$name = $_POST['name'];      //商品名称：任意字符串
// $name = '火腿肠';
$price = $_POST['price'];        //商品价格：浮点数
// $price = 2.0;
$quantity = $_POST['quantity'];      //商品数量：正整数
// $quantity = 40;
$kind = $_POST['kind'];      //商品种类：任意字符串
// $kind = '食品';

$conf = require_once 'conf/db.php';    //需要在conf.php增加"$price_pattern"=>"/^\d+(\.\d+)?$/";     //正则表达式：非负浮点数
//$request作为返回，不同数字代表不同阶段的错误
/*
$request[0]=false;
$request[1]=false;
$request[2]=false;
$request[3]=false;
$request[4]=false;
$request[5]=false;
$request[6]=false;
*/
$request['error']=0;

if(preg_match($conf['price_pattern'],$price) &&
    preg_match($conf['tel_pattern'], $quantity))
{
    /*****************图片格式、大小等信息的定义*****************/
    $uptypes = array(
        'image/jpg',
        'image/jpeg',
        'image/png',
        'image/pjpeg',
        'image/gif',
        'image/bmp',
        'image/x-png'
    );

    $max_file_size = 2000000;  //上传文件大小限制，单位BYTE
    $destination_folder = "img/";/*$_SERVER['document']."SecondHand/img/"; */  //上传文件路径
    $watermark = 1;      //是否附加水印(1为加水印,其他为不加水印);
    $watertype = 1;      //水印类型(1为文字,2为图片)
    $waterposition = 1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
    $waterstring=null;  //水印字符串
    $waterimg=null;    //水印图片
    $imgpreview=0;      //是否生成预览图(1为生成,其他为不生成);
    $imgpreviewsize=1/2;    //缩略图比例

    /*****************开始上传********************/

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // var_dump($_FILES['upfile']);
        if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
        //是否存在文件
        {
            //echo "图片不存在!";
            //exit;
            $request['error']=1;

        }

        $file = $_FILES["upfile"];
        if($max_file_size < $file["size"])
        //检查文件大小
        {
            //echo "文件太大!";
            //exit;
            $request['error']=2;
        }

        if(!in_array($file["type"], $uptypes))
        //检查文件类型
        {
            //echo "文件类型不符!".$file["type"];
            //exit;
            $request['error']=3;
        }

        if(!file_exists($destination_folder))       //如果不存在路径则创建
        {
            mkdir($destination_folder);
        }

        $filename=$file["tmp_name"];
        $image_size = getimagesize($filename);
        $pinfo=pathinfo($file["name"]);
        $ftype=$pinfo['extension'];
        $destination = $destination_folder.time().".".$ftype;
        if (file_exists($destination) && $overwrite != true)
        {
            //echo "同名文件已经存在了";
            //exit;
            $request['error']=4;
        }

        if(!move_uploaded_file ($filename, $destination))
        {
            //echo "移动文件出错";
            //exit;
            $request['error']=5;
        }

        $pinfo=pathinfo($destination);
        $fname=$pinfo['basename'];
        //echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";
        //echo " 宽度:".$image_size[0];
        //echo " 长度:".$image_size[1];
        //echo "<br> 大小:".$file["size"]." bytes";
        //echo date("yy年mm月dd日H时i分s秒",1445771993);

        //  以下为水印部分
        if($watermark==1)
        {
            $iinfo=getimagesize($destination,$iinfo);
            $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
            $white=imagecolorallocate($nimage,255,255,255);
            $black=imagecolorallocate($nimage,0,0,0);
            $red=imagecolorallocate($nimage,255,0,0);
            imagefill($nimage,0,0,$white);
            switch ($iinfo[2])
            {
                case 1:
                    $simage =imagecreatefromgif($destination);
                    break;
                case 2:
                    $simage =imagecreatefromjpeg($destination);
                    break;
                case 3:
                    $simage =imagecreatefrompng($destination);
                    break;
                case 6:
                    $simage =imagecreatefromwbmp($destination);
                    break;
                default:
                    //die("不支持的文件类型");
                    $request['error']=6;
                    exit;
            }

            imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
            imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);

            switch($watertype)
            {
                case 1:   //加水印字符串
                    imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
                    break;
                case 2:   //加水印图片
                    $simage1 =imagecreatefromgif("xplore.gif");
                    imagecopy($nimage,$simage1,0,0,0,0,85,15);
                    imagedestroy($simage1);
                    break;
            }

            switch ($iinfo[2])
            {
                case 1:
                    //imagegif($nimage, $destination);
                    imagejpeg($nimage, $destination);
                    break;
                case 2:
                    imagejpeg($nimage, $destination);
                    break;
                case 3:
                    imagepng($nimage, $destination);
                    break;
                case 6:
                    imagewbmp($nimage, $destination);
                    //imagejpeg($nimage, $destination);
                    break;
            }

            //覆盖原上传文件
            imagedestroy($nimage);
            imagedestroy($simage);
        }
    /*  以下为图片预览部分
        if($imgpreview==1)
        {
            echo "<br>图片预览:<br>";
            echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
            echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";
        }
        */
    }
    /******************以上定义暂时告一段落********************/

    /*******************以下为数据库操作***********************/
    //$fname = '70.jpg';
    if($fname!=NULL){
    $connect = @mysql_connect($conf['host'],$conf['root'],"");
    @mysql_select_db($conf['db']);
    $insert = @mysql_query("insert into item_info value(NULL,'".
                            $name."',".
                            $price.",".
                            $userID.",".
                            $quantity.",'".
                            $kind."','".
                            $fname."')");
    if($insert)
    {       //当成功插入新数据时，所有错误都没发生
        //echo 'success';
    }
}

}
else
{
    $request['error']=7;
}
echo json_encode($request);
?>
