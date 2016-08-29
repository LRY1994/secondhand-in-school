<?php 
         session_start();
         $res=require_once 'GalleryAndCategory.php';
         $gallery=$res['gallery'];
         $kind=$res['kind'];
         $item=$res['item'];
        // echo "userID=".$_SESSION['userID'];;
 ?>
<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8"/>
    <title>互联网+</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- <link rel="stylesheet" type="text/css" href="dev.css"> -->
    <style type="text/css">
    /*全局属性*/
      body{
        padding-top:10px;
      }


      /*网页头*/
      .header{
        background-color: #EFF4FA;
        margin-bottom: 20px;
      }
      .container>.row p{
         font-size: 16px;
      }
      .redcolor{
      	color:#f00;
      }
      .p_inline{
        display: inline-block;
        margin-left: 20px;
      }
      .p_space{
        margin-left: 10px;
      }

      /*搜索框*/
      .header_second{
        margin-bottom: 20px;
      }
      .form_block{
        width: 340px;
        height:36px; 
        border: 1px solid #000;
        border-radius: 5px;
      }
      .form_block input{
        border: 0px;
        display: inline-block;
        width: 184px;
        height: 26px;
      }
      .div_search{
        height:34px; 
        display: inline-block;
      }
      #search{
        width: 92px;
        float: right;
      }
      .dropdown-menu .li_padding{
        padding: 10px 0 10px 10px;
      }
      .dropdown-menu li:hover{
        background-color: #EFF4FA;
      }
      .dropdown-menu .divider {
          margin: 0px 1px;
      }
      .div_search>a{
        height:28px; 
        background-image:none;
/*        border-left: 1px solid #BBB;*/
        background-color: #fff;
        border: 0px;
        margin-top: -5px;
      }
      #head_search>a{
          margin-top: 0px;
          background-color: #EFF4FA;
      }
      #head_search{
        float: right;
      }

      .div_nav{
        height: 42px;
      }

      /*导航栏*/
      .nav>ul li>a{
        display: block;
      }

      /*广告轮播*/
      .carousel-inner>.item{
        height: 350px;
      }
      .carousel-inner>.item img{
        width: 80%;
        margin: 0 auto;
        height: 250px;
      }
      .carousel-indicators {
          top: 220px;
          right: 470px;
      }

      /*商品推荐*/
      .recommende>span{
        font-size: 20px;
        font-weight: 500;
        color: #000;
      }
      .nav-tabs {
          border-bottom: 2px solid #DDD;
      }
      .feature-divider{
        margin-top: 14px;
        border-bottom: 2px solid #DDD;
      }

      .tab-content>.tab-pane>ul{
        border-top: 1px solid #DDD;
        border-left: 1px solid #DDD;
      }
      .tab-content>.tab-pane li{
        float: left;
        text-align: center;
        padding: 40px;
        width: 15%;
        border-bottom: 1px solid #DDD;
        border-right: 1px solid #DDD;
        list-style: none;
      }
      .tab-content>.tab-pane li img{
          height: 130px;
          width: 130px;
          margin-bottom: 10px;
      } 
      .tab-content>.tab-pane a p{
          color: #f00;
          font-size: 15px;
          text-decoration: none;
      }
      .tab-content>.tab-pane a:hover{
          text-decoration: none;
      }

      .tab-content>.tab-pane a:hover p{
          color: #00f;
          font-size: 16px;
      }

      .footer{
        background-color: #EFF4FA;
        clear: both;
      	margin-top:20px;
        margin-left: -22px;
        height: 40px;
        line-height: 1.5;
        font-size: 14px;
        text-align: center;
        padding: 12px;
        border-top: 1px solid #D6DFEA;
      }

      /*关于*/
      #about-modal p{
        text-indent: 2em;
        font-size: 16px;
        line-height: 1.5;

      }

    </style>

  </head>
  <body>
    <div class="container">
      <!-- 顶部登录信息 -->
      <div class="row header">
        <p class="p_inline">欢迎访问互联网+购物网</p>
        <p class="pull-right p_space"><a href="register.php">注册</a></p>
<?php   
    if(isset($_SESSION['userID'])&&$_SESSION['userID']){
?>
        <p class="pull-right">欢迎您，用户：<span class="redcolor">
<?php 
    // require_once 'utils/getUsername.php';
    // echo 
    echo $_SESSION['name'];
    echo "</span></p>";
    }else{ ?>

     <p class="pull-right"><a href="login.php">登录</a></p>
<?php  } ?> 
       
      
      </div>
      <!--中部搜索栏 -->
      <div class="row header_second">
        <div class="span5">
          <img src="img/logo.png">
        </div>
        <div class="span7">
          <div class="form_block pull-right">
              <input name="search_word" placeholder="请输入关键词" type="text" ><div class="btn-group div_search">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                  <span id="catagary">商品类型</span>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" id="search">
                  <li  class="li_padding">商品类型</li>
                  <li class="divider"></li>
                <?php 
                $len=count($gallery);
                for($i=0;$i<$len-1;$i++){
                ?>
                  <li  class="li_padding"><?php echo $kind[$i];?></li>
                  <li class="divider"></li>
                <?php }
                   if($len>0){
                ?>
                 <li  class="li_padding"><?php echo $kind[$i];?></li>
                <?php }?> 
                </ul>
              </div><!--end dropdown--><div class="div_search" id="head_search">
                <a class="btn" href="#">搜索</a>
              </div>
          </div>
        </div>
      </div>
      <!-- 导航条 -->
      <div class="row div_nav">
        <div class="navbar navbar-inverse">
          <div class="navbar-inner">
            <a class="brand" href="index.php">互联网购物</a>
            <ul class="nav">
              <li class="active"><a href="index.php">首页</a></li>
              <li><a href="#buy" data-tab="<?php echo $kind[0];?>">我要买东西</a></li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">我的账号<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                      <li><a href="perinfo.php#home" >我的信息</a></li>
                       <li class="divider"></li>
                      <li><a href="perinfo.php#order" >我的订单</a></li>
                       <li class="divider"></li>
                      <li><a href="perinfo.php#goods" >我要卖东西</a></li>
                       <li class="divider"></li>
                      <?php   
                        if(isset($_SESSION['userID'])){
                      ?>
                      <li><a href="logout.php?location=\"index.php\"">退出</a></li>
                      <?php }else{?>
                      <li><a href="login.php">登录</a></li>
                      <?php }?>
                  </ul>
              </li>
              <li><a href="#" data-toggle="modal" data-target="#about-modal">关于</a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- 广告轮播 -->
      <div class="row">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">

 <?php 
          //$len=3;
         for($i=0;$i<$len;$i++){
             
             echo "<li data-target=\"#myCarousel\" data-slide-to=\"".
  	    $i."\"".($i==0?" class=\"active\"":NULL)."></li>";
         }
         
         echo "</ol>";
         
         //<!-- Carousel items -->
         echo "<div class=\"carousel-inner\">";
         for($i=0;$i<$len;$i++){
           echo  "<div class=\"".($i==0?"active":NULL)." item\">";
          echo   "<a href=\"showItem.php?itemID=".$gallery[$i]['itemID']."\">";
           echo " <img src=\"img/".$gallery[$i]['pic']."\" alt=\"商品\" ></a>
             </div>";
         }
         echo " </div>";
?>
          
          <!-- Carousel nav -->
          <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
          <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
      </div>
      <!-- 产品列表 -->
      <div class="row">
        <div class="recommende">
          <span >商品推荐</span>
          <ul class="nav nav-tabs pull-right" id="buy">
         <?php
           // $res=require_once 'category.php';

           // print_r($kind);
           // die();

//             print_r($item);
//             die();
            $len=count($kind);
            for($i=0;$i<$len;$i++){
         ?>
            <li <?php if($i==0) echo "class=\"active\"";?> >
            <a href="<?php echo "#kind$i";?>" role="tab" data-toggle="tab">
             <?php echo $kind[$i]?>
             </a>
            </li>
          <?php }?>
          </ul>
          <hr class="feature-divider">
          <div class="tab-content">
<?php 
           for($i=0;$i<$len;$i++){
?>
            <div class="tab-pane<?php if($i==0) echo " active";?>" 
              id="<?php echo "kind$i";?>">
              <ul>
              <?php 
                   foreach ($item[$kind[$i]] as $one){
                            //输出每一个物品信息
               ?>
                <li>
                  <a href="showItem.php?itemID=<?php echo $one['itemID'];?>">
                  <img src="img/<?php echo $one['pic'];?>">
                  <p><?php echo $one['name'];?></p>
                  <p><?php echo $one['price'];?></p>
                  </a>
                </li>
               <?php }?>
                </ul>
            </div>
<?php }?>   
          </div><!--end tab-content-->
        </div>
      </div><!--end 产品列表-->



      <!-- footer -->
      <div class="footer">
        <a href="about.html">关于我们 |</a>
        <a href="contact.html">联系我们 |</a>
        <span class="right">©2015 - 2017  All Rights Reserved.</span>
      </div>
    </div>
   
   <!-- 关于 -->
   <div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label"
        aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal"><span
                           aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                   <h4 class="modal-title" id="modal-label">关于我们</h4>
               </div>
               <div class="modal-body">
                   <p>本次课程设计我们组的成员有邓毓枫，张煌彬，杜金波，李康晓，陈麒昌，总共5人。
                    其中邓毓枫大神认为我们太渣了，决定独自一个人完成一份课程设计，其他4人完成。张煌彬负责页面的编写，以及处理来自后台的数据，
                    李康晓同学完成用户模块功能，杜金波完成后台逻辑，陈麒昌完成数据库数据插入以及素材收集。
                    为我们的毓枫大神喝彩！</p>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">了解了</button>
               </div>
           </div>
       </div>
   </div>
   
   
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    
   
    <script type="text/javascript">

      $(document).ready(function(){
          $("#myCarousel").carousel();
          $("#search").children("li").each(function(){
            $(this).click(function(event) {
              var val=$(this).text();
             $("#catagary").text(val);
            });
          });
          
          $("#head_search>a").click(function(){
           
            var catagary=$("#catagary").text()==="商品类型"?"":$("#catagary").text();
            var keywordx=$("input[name='search_word']").val();
            var keyword=(keywordx==null||keywordx=="")?"":keywordx;
            location.href="dosearch.php?catagary="+catagary+"&&keyword="+keyword;
          });

      });
    </script>
  </body>
</html>