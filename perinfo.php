<?php
    session_start();
    //未登录则登录
    if(!isset($_SESSION['userID'])||!$_SESSION['userID']){
        header("location: login.php");
    }
    $res=require_once 'userinfo.php';
    $user=$res['user'];
    $order=$res['order'];
    $item=$res['item'];
    
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Two Fool`s Trade</title>
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="css/personalhomepage.css" type="text/css" />
        <style type="text/css">
        /*个人信息*/
            #home{
                border: 1px solid #bbb;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); 
                margin: 2px 10px 10px 10px;
                padding: 20px;
                height: 100%;
                /*color: #fff;*/
                font-size: 14px;
                font-weight: 500;
                border-radius: 20px;
                background-color:#EFF4FA;
            }
            .per_info{
                width: 70%;
                margin: 0 auto;
            }
            .per_info span{
                font-size: 20px;
                font-style: oblique;
                color:#F40;
            }
            /*侧栏*/
            #funpick >div{
                border: 1px solid #bbb;
                border-radius: 10px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            }
            #funpick ul>li>a{
                border-bottom: 1px solid #bbb;
            }

            /*订单信息*/
            #record tr{
                height: 38px;
            }
            #record tr th{
                 border: 1px solid #BBB;
            }
            #record tr td{
                border: 1px solid #BBB;

            }
            .panel-footer{
                border-top: 1px solid #CCC;
                background-color: #0000cd;
            }

            /*卖东西*/
            #goods{
                border: 1px solid #ccc;
                margin: 2px 10px;
                padding: 20px;
                height: 600px;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }
            #goods>form>div{
                margin-bottom: 20px;
            }

            /*jquery 校验成功*/
            .not_see{
                display: none;
            }

            /*返回顶部的按钮*/
            .toTop{
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
            .toTop:hover{
                background-color: #F40;
                color:#fff;
            }

        </style>

    </head>
    <body id="top">
        <div id="userhome">
            <div id="homepills">
                <div id="funpick" >
                    <div>
                        <ul class="nav nav-pills nav-stacked" role="tablist">
                            
                            <li role="presentation">
                                <a href="index.php" >返回购物主页</a>
                            </li>
                            <li role="presentation" class="active">
                                <a href="#home" id="home_tab" aria-controls="home" role="tab" 
                                data-toggle="tab">个人资料</a>
                            </li>
                            <li role="presentation">
                                <a href="#profile" id="profile_tab" aria-controls="profile" 
                                role="tab" data-toggle="tab">修改信息</a>
                            </li>
                            <li role="presentation">
                                <a href="#order" id="order_tab" 
                                aria-controls="messages" role="tab" data-toggle="tab">我的订单</a>
                            </li>
                            <li role="presentation">
                                <a href="#item" id="item_tab" aria-controls="messages" 
                                role="tab" data-toggle="tab">我的待卖商品</a>
                            </li>
                            <li role="presentation"><a href="#goods" id="goods_tab" 
                                aria-controls="settings" role="tab" data-toggle="tab">我要卖东西</a>
                            </li>
                            <li role="presentation">
                                <a href="logout.php" >退出</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="usercontent" class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="per_info">
                        <p>用户名：<span id="o_account"><?php echo $user['account'];?></span></p>
                        <p>昵称：<span id="o_name"><?php echo $user['name'];?></span></p>
                        <p>电话：<span id="o_tel"><?php echo $user['tel'];?></span>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
                    <div>
                        <blockquote>
                            <p>修改基本信息</p>
                        </blockquote>
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <form id="base">
                                    <div class="form-group">
                                        <label for="nameinput">昵称</label>
                                        <input type="text" class="form-control" id="nameinput" name="newname" placeholder="请输入新的昵称">
                                    </div>
                                    <div class="form-group">
                                        <label for="telinput">电话</label>
                                        <input type="tel" class="form-control" id="telinput" name="newtel" placeholder="请输入新的联系方式">
                                    </div>
                                    <button type="submit" class="btn btn-info" id="base_submit">确认修改</button>
                                </form>
                            </div>
                        </div>
                        <blockquote>
                            <p>修改密码</p>
                        </blockquote>
                        <div class="panel panel-warning">
                            <div class="panel-body">
                                <form>
                                    <div class="form-group">
                                        <label for="oldpswinput">旧密码</label>
                                        <input type="password" class="form-control" id="oldpswinput" placeholder="请输入旧密码">
                                    </div>
                                    <div class="form-group">
                                        <label for="newpswinput">新密码</label>
                                        <input type="password" class="form-control" id="newpswinput" placeholder="请输入新密码">
                                    </div>
                                    <div class="form-group">
                                        <label for="repeatpswinput">确认密码</label>
                                        <input type="password" class="form-control" id="repeatpswinput" placeholder="确认密码">
                                    </div>
                                    <button type="submit" class="btn btn-info" id="pwd_submit">确认修改</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="order">
                    <div id="ordertableframe">
                        <div class="panel panel-success">
                            <div class="panel-heading">订单详情</div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-bordered table-responsive" id="record">
                                    <tr>
                                        <th>订单号</th>
                                        <th>卖家</th>
                                        <th>买家</th>
                                        <th>物品名称</th>
                                        <th>购买数量</th>
                                        <th>总价</th>
                                       
                                    </tr>
                                    <?php 
                                        
                                        if($order!=null&&count($order)>0){
                                         $len=count($order);
                                         for($i=0;$i<$len;$i++){
                                    ?>
                                    <tr>
                                        <td><?php echo $order[$i]['orderID'];?></td>
                                        <td><?php echo $order[$i]['seller'];?></td>
                                        <td><?php echo $order[$i]['buyer'];?></td>
                                        <td><?php echo $order[$i]['item'];?></td>
                                        <td><?php echo $order[$i]['quantity'];?></td>
                                        <td><?php echo $order[$i]['price'];?></td>
                                    </tr>
                                    <?php 
                                        }
                                      }
                                ?>
                                </table>
                            </div>
                            <!--回到顶部-->
                            <a href="#top" class="toTop">回到顶部 </a>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="item">
                    <div id="ordertableframe">
                        <div class="panel panel-success">
                            <div class="panel-heading">物品详情</div>
                            <div class="panel-body">
                                <table class="table table-striped table-hover table-bordered table-responsive" id="record">
                                    <tr>
                                        <th>物品ID</th>
                                        <th>名称</th>
                                        <th>价格</th>
                                        <th>拥有者</th>
                                        <th>数量</th>
                                        <th>种类</th>
                                       <th>管理</th>
                                    </tr>
                                    <?php 
                                        
                                        if($item!=null&&count($item)>0){
                                         $len=count($item);
                                         for($i=0;$i<$len;$i++){
                                    ?>
                                    <tr>
                                        <td><?php echo $item[$i]['itemID'];?></td>
                                        <td><?php echo $item[$i]['name'];?></td>
                                        <td><?php echo $item[$i]['price'];?></td>
                                        <td><?php echo $item[$i]['owner'];?></td>
                                        <td><?php echo $item[$i]['quantity'];?></td>
                                        <td><?php echo $item[$i]['kind'];?></td>
                                        <td><?php if($item[$i]['quantity']>0){?>
                                            <a href="<?php echo "deleteItem.php?itemID=".$item[$i]['itemID']; ?>"  >删除</a>
                                            <?php  }else { ?>
                                            <span>已卖完</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        }
                                      }
                                ?>
                                </table>
                            </div>
                            <!--回到顶部-->
                            <a href="#top" class="toTop">回到顶部 </a>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="goods">
                    <form class="form-horizontal" id="upload"
                         enctype="multipart/form-data" method="post" name="upform">
                      <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">商品名称：</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="name" placeholder="请输入商品名称" name="name">
                        </div>

                      </div>
                      <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">价格:</label>
                        <div class="col-sm-7">
                            <div class="input-group">
                                <div class="input-group-addon">￥</div>
                                <input type="text" class="form-control" id="price" placeholder="请输入商品价格" name="price">
                            </div>
                        </div>
                     </div>
                      <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">商品数量：</label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="quantity" placeholder="请输入商品数量" name="quantity">
                                    <div class="input-group-addon">件</div>
                                </div>
                            </div>
                      </div>
                    <div class="form-group">
                        <label for="kind" class="col-sm-2 control-label">商品种类：</label>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" id="kind" placeholder="请输入商品种类" name="kind">
                        </div>

                      </div>
                      <div class="form-group">
                            <label for="quantity " class="col-sm-2 control-label">上传图片：</label>
                            <div class="col-sm-7">
                                <input type="file" class="form-control" id="upfile"  name="upfile">
                            </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                          <button type="submit" class="btn btn-default">提交</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate-1.13.1.js"></script>

        <script>
            $(function(){
                //获取锚点
                var thisId = window.location.hash+"_tab";
                // alert(thisId);
                $(thisId).tab("show");

                $("#base_submit").click(function(event) {
                    // alert("base_submit");
                    var newname=$("#nameinput").val();
                    // alert(newname);
                    // return false;
                    var newtel=$("#telinput").val();
                    // $("#o_tel").text("test");
                    // return false;
                    if(newname&&newtel){
                        if(!/^[0-9]+$/.test(newtel)){
                            alert("联系方式应该是数字组成");
                        }else{
                        $.getJSON("alterUser.php", {"name": newname,"tel":newtel}, function(json, textStatus) {
                            if(json.error){
                                // $("#o_name").val(newname);
                                // $("#o_tel").val(newtel);
                                alert("修改失败");
                            }else{

                                alert("修改成功");
                                // alert(json.name+json.tel);
                                $("#o_name").text(json.name);
                                $("#o_tel").text(json.tel);
                            }
                        });//end getJson

                     }

                    }else{
                        alert("名字或者联系方式为空");

                    }
                    return false;

                });//end $("base_submit").submit


                $("#pwd_submit").click(function(){
                    var oldpswinput=$("#oldpswinput").val();
                    var newpswinput=$("#newpswinput").val();
                    var repeatpswinput=$("#repeatpswinput").val();
                    if(oldpswinput&&newpswinput&&repeatpswinput){
                        if(repeatpswinput===newpswinput){


                            $.ajax({
                                    url: 'alterPassword.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data:{
                                            'oldPassword':oldpswinput,
                                            'newPassword':newpswinput,
                                            'rePassword':repeatpswinput
                                            },
                                    success: function(data){
                                        if(data.error){
                                            
                                             alert("修改失败");
                                        }else{
                                            // alert("index.html");
                                             alert("修改成功");
                                        }
                                        //console.log($.parseJSON(data));
                                    },
                                    error: function(jqXHR){     
                                          alert("发生错误：" + jqXHR.status);
                                            }
                            });//end  $.ajax()


                        }else{
                            alert("两次密码不一致");
                        }

                    }else{
                        alert("请检查是否有未填选项");
                    }

                    return  false;
                });//end $("#pwd_submit").submit

                //上传东西
                $("#upload").validate({
                    debug:true,
                    rules:{
                        name:{
                            required:true,
                        },
                        price:{
                            required:true,
                            number:true
                        },
                        quantity:{
                            required:true,
                            digits:true
                        },
                        upfile:{
                                required: true
                                // accept: "image/jpeg, image/pjpeg, image/jpg, image/png, image/gif, image/bmp, image/x-png"
                        },
                        kind:{
                            required:true
                        }
                    },//end rules

                    messages:{
                        name:{
                            required:"名字不能为空"
                        },
                        price:{
                            required:"价格不能为空",
                            number:"价格必须是数字"
                        },
                        quantity:{
                            required:"",
                            digits:"数量必须是整数"
                        },
                        upfile:{
                            required:"必须上传图片",
                            // accept:"上传类型不合适"
                        },
                        kind:{
                            required:"必须填写种类"
                        }
                    },//end messages 
                    errorPlacement: function(error,element){
                        error.css("color","#f00");
                        element.parents(".col-sm-7").append(error);
                    },
                    success:"not_see",
                    submitHandler:function(form){
                         var formData = new FormData($( "#upload" )[0]);
                         $.ajax({  
                                   url: 'upItem.php' ,  
                                   type: 'POST',  
                                   data: formData,  
                                   async: false,  
                                   cache: false,  
                                   contentType: false,  
                                   processData: false,  
                                   success: function (data) {  
                                       if(data.error==0) alert("上传成功");
                                       else if(data.error>0&&data.error<6){
                                        alert("图片上传失败");
                                       }else{
                                        alert("表单数据格式错误");
                                       }
                                   },  
                                   error: function (returndata) {  
                                       alert("error");  
                                   }  
                              });
                    }

                });//end $("#upload").validate
 
            });
        </script>
    </body>
</html>
