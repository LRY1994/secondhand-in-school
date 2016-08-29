<?php 
            
            require_once 'search.php';
            $res=search();
            $kind=$res['kind'];
            // var_dump($kind);
            $item=$res['item'];
            session_start();
            
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
     /*商品列表展示*/
     #show{
     	border: 1px solid #ddd;
     	padding: 10px;
     	border-radius: 30px;
     	margin-top:20px;
     	margin-bottom: 20px;
     	box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
     }
     
     #show>.row{
     	/*margin: 10px;*/
     	border: 1px solid #ddd;
     	box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
     	padding: 20px;
     	border-radius: 23px;
     	margin-left: 0px;
     	margin-bottom: 10px;
		
     }
     #show>.row>.span4{
     	margin-left: 0px;

     }
     #show>.row>.span5{
     	padding-left: 30px;

     }
     #show>.row img{
     	padding: 1px;
     	box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
     	display: inline-block;
     	height: 190px;
     	width: 300px;

     }
     .info_sign{
     	font-size: 20px;
     	color: #F40;
     }
	/*返回顶部的按钮*/
	#toTop{
		position: fixed;
		display: block;
		float: left;
		top:500px;
		left: 87%;
		width: 47px;
		font-size: 16px;
		line-height: 26px;
		text-align: center;
		height: 60px;
		/*background-color: #f00;*/
		margin-bottom: 100px;
		margin-right: 100px;
		text-decoration: none;
		border: 1px solid #bbb;
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		color: #F40;
	}
	#toTop:hover{
		background-color: #F40;
		color:#fff;
	}

  /*图片预览*/
  #img-modal{
    z-index: -1000;
  }
  #img-modal img{
    display: block;
    width: 600px;
    height: 400px;
    margin: 0 auto;
  }

      /*footer*/
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
      <div class="row header" id="top">
        <p class="p_inline">欢迎访问互联网+购物网</p>
        <p class="pull-right p_space"><a href="register.php">注册</a></p>
<?php   
    if(isset($_SESSION['userID'])){
?>
        <p class="pull-right">欢迎您，用户：<span class="redcolor">
<?php 
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
                $len=count($kind);
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
            <a class="brand" href="#">互联网购物</a>
            <ul class="nav">
              <li class="active"><a href="index.php">首页</a></li>
              <!-- <li><a href="#buy" data-tab="<?php //echo $kind[0];?>">我要买东西</a></li> -->
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

      <!-- 商品列表展示-->
      <div class="row" id="show">
            <?php

                
            if($item==null||count($item)==0){
          ?>
            <div class="row" >
            <div class="span4">
               
                <img  alt="Firefox" src="img/besorry.png"  class="img-polaroid">
               
            </div>
            <div class="span5" >
  
                <h2 >没有找到相关的商品</h2>
                <p>
                   <a href="index.php">返回首页</a>
                </p>
            </div>
          </div>
            <?php
            }else{
                $len=count($item);
                for($i=0;$i<$len;$i++){    
            ?>
            <div class="row" >
      			<div class="span4">
      			    <a href="#" class="img_view" value="<?php echo $i;?>">
      			    <img id="<?php echo "img".$i;?>" alt="Firefox"
      			    src="<?php echo "img/".$item[$i]['pic'];?>"  class="img-polaroid">
      			    </a>
      			</div>
      			<div class="span5" >
	
      			    <h2 ><?php echo $item[$i]['name'];?></h2>
	
      			    <p>价格： ￥
      			       <span class="info_sign"><?php echo $item[$i]['price'];?></span>
      			    </p>
      			    <p>卖家：
      			       <span class="info_sign"><?php echo $item[$i]['owner'];?></span>
      			    </p>
      			    <p>联系方式：
      			       <span class="info_sign"><?php echo $item[$i]['tel'];?></span>
      			    </p>
      			    <p>剩余数量：
      			       <span class="info_sign"><?php echo $item[$i]['quantity'];?></span> &nbsp;件
      			    </p>
      			    <p>
      			       <a href="<?php echo "showItem.php?itemID=".$item[$i]['itemID'];?>">去看看</a>
      			    </p>
      			</div>
      		</div>
          <?php }
        }
          ?>

      </div>
      
      <!-- footer -->
      <div class="footer">
        <a href="about.html">关于我们 |</a>
        <a href="contact.html">联系我们 |</a>
        <span class="right">©2015 - 2017  All Rights Reserved.</span>
      </div>
    </div>
   <!--回到顶部-->
   <a href="#top" id="toTop">回到顶部 </a>
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

    <!-- 图片预览 -->
    <div class="modal fade" id="img-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label"
        aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-body">
                  <img src="img/4.png" alt="图片预览" id="bigimg"/>
             </div>     
           </div>
       </div>
   </div>

   

   
   
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    
   
    <script type="text/javascript">

      $(document).ready(function(){
        // 搜索栏函数
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

          $(".img_view").click(function(){

            var id="#img"+$(this).attr("value");
            // alert(id);
            var src=$(id).attr("src");
            $("#bigimg").attr("src",src);
            $("#img-modal").css("z-index",1050);
            $("#img-modal").modal();
            $("#img-modal").click(function(){
              $("#img-modal").css("z-index",-1000);
              $(this).modal("hide");
            });
          })

          

      });
    </script>
  </body>
</html>