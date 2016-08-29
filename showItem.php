<?php 
            
            $res=require_once 'itemInfo.php';
            $kind=$res['kind'];
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


/*商品信息展示*/
     .show{
      margin-top: 20px;
     }

     /*图片预览*/
      .preview_img{
        border: 1px dashed #000;
        width: 380px;
        height: 380px;
        position: relative;
        top:-397px;
        left: 363px;
        float: left;
        z-index:10;
        display: none;
        background-color: #fff;
        background-repeat:no-repeat;
        /*display: none;*/
        /*background-color: #f00;*/
        /*background-image: url(img/4.png);*/
      }
      .show .span5{
        margin-left: -20px;
        margin-right: 0px;
      }
      .show .span5 img{
        width: 380px;
        height: 380px;
        /*background-color: #000;*/
        display: inline-block;
        border:1px solid #EFF4FA;

      }
      .show .span7 h2{
        text-align: center;

      }
      .show .span7 .info{
        background-color: #FFD9BC;
        width: 540px;
        height: 170px;
      }
      .show .span7 div p{
      padding: 10px 20px 0;
      font-size: 14px;
      font-weight: 200;

      }
      .show .span7 div p span{
        font-size: 24px;
        color: #F40;
      }
    /*  .show .span7 a{
        display: inline-block;
        margin-top: -28px;
        margin-right:30px;
        font-size: 18px;
        float: right;

      }*/
      .feature-divider{
        border-top-width: 2px;
        clear: both;
        background-color: #BBB;
      }
      .count{
        margin-top:10px;
        text-align: center;
      }
      .buy_aciton div{
        height: 38px;
        width:100px;
        border: 1px solid #F40;
        float: left;
        text-align: center;
        margin: -15px 60px 20px 50px;
        font-size: 18px;
        color: #F40;
        background-color: #fff;
        line-height: 38px;
      }
      .buy_aciton div:hover{
        background-color: #F40;
        color: #fff;
      }
      .promt{
        color: #f00;
        padding-left: 20px;
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

      /*购买商品*/
      #buy_modal{
        z-index: -1000;
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
                          if($item&&$item['itemID']){
                            $location="showItem.php?itemID=".$item['itemID'];
                          }else{
                            $location="index.php";
                          }
                      ?>
                      <li><a href="<?php echo "logout.php?location=".$location;?>">退出</a></li>
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
      <!-- 商品信息展示 -->
      <div class="row show">
              <div class="span5">
                  <img src="<?php echo "img/".$item['pic'];?>" alt="物品图片" id="image_o">
              </div>
              <div class="span7">
                  <h2 id="itemID" value="<?php echo $item['itemID'];?>">
                    <?php echo $item['name'];?>
                  </h2>
                  <div class="info">
                    <p>价格：<span>￥<?php echo $item['price'];?></span></p>
                    <!-- <a href="#">查看评价</a> -->
                    <p>剩余数量： <span id="quantity"><?php echo $item['quantity'];?></span> </p>
                    <p>卖家：<span><?php echo $item['owner'];?></span></p>
                    <p>联系方式：<span><?php echo $item['tel'];?></span></p>
                   </div>
                  <div class="count">
                    <form>
                      <fieldset>
                        <input id="count"type="text" placeholder="输入要购买的数量"><span style="font-size: 18px"> 件</span>
                      </fieldset>
                    </form>
                  </div>
                  <div class="buy_aciton">
                    <div id="buy">立即购买</div>
                    <div id="report">我要举报</div>
                  </div>
                  <hr class="feature-divider">
                  <p class="promt">提醒：请核实买家身份!</p>
              </div>
               <div class="preview_img"></div>
          </div>
      </div>
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

   <!--购买商品-->
   <div class="modal fade" id="buy_modal" tabindex="-1" role="dialog" aria-labelledby="modal-label"
        aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal"><span
                           aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                   <h4 class="modal-title" id="modal-label">欢迎购买</h4>
               </div>
               <div class="modal-body">
                   <p><label for="#account">支付账号：</label>
                      <input type="text" name="account" id="account">
                   </p>
                   <p><label for="#pwd">密码：</label>
                      <input type="password" name="pwd" id="pwd">
                   </p>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" id="purchase" >购买</button>
               </div>
           </div>
       </div>
   </div>

   
   
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    
   
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


          //图片预览
          $("#image_o").hover(function(e){
            var img_e=$(this).offset();
            var img_ex=img_e.top;
            var img_ex=img_e.left;
            var source=$(this).attr("src");
            //alert(source);
            $(".preview_img").css({
              // display:"block",
             "background-image": "url("+source+")",
             // "background-position":"-23px -100px"
            });
          
            $("#image_o").mousemove(function(e){
              var dx=e.pageX-img_ex;
              var dy=e.pageY-img_ex;
              $(".preview_img").css({
                  display:"block",
                  // "background-image": "url("+source+")",
                  "background-position":""+(-dx)+"px "+(-dy)+"px"

            });
                // $(".promt").text("dx="+dx+",dy="+dy);
            });
             // $("#span1").text(x.left);
             // $("#span2").text(x.top);
             
          },function(){
            $(".preview_img").css({
                display:"none",
              });
          });

        //购买
        $("#buy").click(function(){
          var count=parseInt($("#count").val());
          // alert(count);
          if(count==NaN) {
            // alert($("#itemID").attr("value"));
            alert("必须填写数量");
            return false;
          }
          if(!/^[1-9]\d*$/.test(count)){
              // alert($("#itemID").attr("value"));
              alert("数量必须为整数");
              return false;
            }
          var quantity=parseInt($("#quantity").text());
          // var count=parseInt($)
          //alert(count);
          if(count>quantity){
            alert("购买数量不能超过已有数量");
            $("#count").val("");
          }else{
            // 检查是否登录
            var username=$.cookie("username");
            if(username==null){
              alert("请登录！");
              location.href="login.php";
            }

            
            $("#buy_modal").css("z-index",1050);
            $("#buy_modal").modal();
            $("#purchase").click(function(event) {
              //检查购买条件
              var account=$("#account").val();
              var pwd=$("#pwd").val();
              if(account==null||pwd==null){
                alert("账号或者密码不能为空！");
                return false;
              }
              
              $("buy_modal").css("z-index",-1000);
              $("#buy_modal").modal("hide");
              var itemID=$("#itemID").attr("value");
             // var quantity=$("#quantity").text();
              /*undo 购买东西
              */
              $.ajax({
                url: "buy.php?itemID="+itemID+"&&num="+count,
                type: 'GET',
                success:function(data){
                    if(data.error){
                      alert("购买失败！请检查是否超购没有登录！");
                    }else{
                      alert("购买成功！");
                      location.href="index.php";
                    }
                },
                error:function(jqXHR){
                  alert("发生错误：" + jqXHR.status);
                  if(jqXHR.status==404){
                  location.href="error.html"; 
                  }
                }

              });//end ajax



            });//end $("#purchase").click

          }//end else

        });//end  $("#buy").click

        //举报
        $("#report").click(function(){
          alert("举报成功！");
          
        });

      });
    </script>
  </body>
</html>