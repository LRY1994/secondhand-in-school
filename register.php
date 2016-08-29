<!DOCTYPE html>
<html lang="zh_cn">
<head>
	<meta charset="UTF-8">
	<title>购物互联网+</title>
	<style type="text/css">
	body{
		padding: 0;
		margin: 0;
	}
	.header{
		background-color: #EFF4FA;
		height: 62px;
		width: 960px;
		margin: 0px auto;
		border-bottom: 1px solid #D6DFEA;
	}
	.content {
    	width: 960px;
    	margin: 32px auto;
    	padding: 0px 24px;
    }
	.left_content{ 
		 height: 300px; 
		 width: 460px; 
		 float: left;
	}
	.login_form{
		 height: 500px;
		 width:400px;
		 margin-left: 500px;
		 border-radius: 10px;
		 border:1px solid #D6DFEA;
		 -moz-border-radius:2px;
		 -webkit-border-radius: 2px;
		 -ms-border-radius:20x;

	}
	.form_header{
		text-align: center;
		font-size: 20px;
		font-weight: 500;
		color:#f00;
		line-height: 60px;
		border-bottom: 1px solid #f00;
		height: 60px;
		margin-bottom: 26px;
	}
	.form_block{
		margin:0px auto ;
		width: 340px;
	}
	.form_block>div{
		height:36px; 
		border: 1px solid #000;
		border-radius: 5px;
	}
	.form_block input{
		border: 0px;
		display: block;
		width: 320px;
		height: 26px;
		margin: auto;
	}
	.form_block label{
		display: block;
		margin-top:5px;
		margin-bottom: 3px;
		font-size: 14px;
		height: 19px;
		color: #f00;
	}
	.disview{
		color: #fff;
	}
	.space{
		margin-top:10px;
	}
	#submit{
		font-size: 16px;
		font-weight: 500;
		margin-top: 20px;
		word-spacing: 1.5;
		margin-right: auto;
		margin-left: auto;
		display: block;
		width: 340px;
		background-color: #f00;
		line-height: 1.5;
		height: 40px;
		color: #fff;
		border-radius: 10px;
	}
	.footer{
		background-color: #EFF4FA;
		clear: both;
		/*margin-top: 180px;*/
		height: 40px;
		line-height: 1.5;
		font-size: 14px;
		text-align: center;
		padding: 12px;
		border-top: 1px solid #D6DFEA;
	}
	</style>
</head>
<body>
	<div class="header">
	<!-- 	<a href="login.html" alt="login.html"><img src="img/logo.png" alt="header_logo"/></a>
	 -->
	</div>

	<div class="content">
		<div class="left_content">
			<img src="img/decorate.jpg" alt="logo_page.png"/>
		</div>
		<div class="login_form">
			<form method="post" name="register" id="info" action="signup.php">
				<div class="form_header">亲，请完成你的注册信息</div>
				<div class="form_block">
					<div><input name="account" placeholder="请输入电子邮箱地址作为用户名" type="text" id="account" >
					</div>
					<label id="account_p"></label>
				</div>
				<div class="form_block">
					<div>
						<input type="password" placeholder="6-16位密码，区分大小写，不能用空格" name="password" id="password">
					</div>
					<label ></label>
				</div>
				<div class="form_block">
					<div>
						<input type="password" placeholder="确认密码" id="confirm" name="confirm">
					</div>
					<label  ></label>
				</div>
				<div class="form_block">
					<div>
						<input name="name" placeholder="昵称为2-18位，中英文、数字及下划线" type="text" id="name">
					</div>
					<label></label>
				</div>
				<div class="form_block">
					<div  class="space"><input type="text" placeholder="联系方式" name="tel" id="tel"></div>
					<label ></label>
				</div>
				<div class="form_block">
					<input type="submit" id="submit" value="提交">
				</div>
			</form>
		</div>
	</div>
	<div class="footer">
		<a href="about.html">关于我们 |</a>
		<a href="contact.html">联系我们 |</a>
		<span class="right">©2015 - 2017  All Rights Reserved.</span>
	</div>

	<script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.validate-1.13.1.js"></script>
	
	<script type="text/javascript" src="js/jquery-form.js"></script>
	<script type="text/javascript">
		$(function(){
			validator = $("#info").validate({
            rules: {
                account: {
                    required: true,
                    email:true
                },
                password: {
                    required: true
                },
                "confirm": {
                    equalTo: "#password"
                },
                tel:{
                	digits:true 
                }
            },
            messages: {
                account: {
                    required: "必须填写用户名",
                    email:"邮箱格式错误"
                },
                password: {
                    required: "必须填写密码",
                },
                "confirm": {
                    equalTo: "两次输入的密码不一致"
                },
                tel:{
                	digits:"联系方式格式错误"
                }
            },
            submitHandler: function (form) {
                // form.submit();s
                console.log("check");
                // $("#submit").click(function() {
                // 	console.log("submit");



                	$.ajax({
                			url: 'signup.php',
                			type: 'POST',
                			dataType: 'json',
                			data: {
                					'account': $("#account").val(),
                					'confirm':$("#confirm").val(),
                					'password':$("#password").val(),
                					"name":$("#name").val(),
                					"tel":$("#tel").val(),
                					},
                			success: function(data){
                				if(data.error){
                					
                					alert("用户名存在或者用户名不合法！");
                				}else{
                					// alert("index.html");
                					location.href="index.php";
                				}
                				//console.log($.parseJSON(data));
                			},
                			error: function(jqXHR){     
                			      alert("发生错误：" + jqXHR.status);
                              		}
                	});







                	console.log("end submit");
                // 	return false;
                // });//end  form.submit
            },//end submitHandler
            errorPlacement: function(error, element) {

					element.parent("div").parent("div").children('label')
					.css("color","#f00").text(error.text());
					console.log(error.text());
				},
			success:"disview",
            });
		});
	 

	</script>
</body>
</html>