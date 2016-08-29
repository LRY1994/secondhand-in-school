<!DOCTYPE html>
<html lang="en">
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
		 height: 460px;
		 width:400px;
		 margin-left: 500px;
		 border-radius: 10px;
		 border:1px solid #D6DFEA;
		 -moz-border-radius:2px;
		 -webkit-border-radius: 2px;
		 -ms-border-radius:20x;

	}
	.login_header{
		font-size: 20px;
		font-weight: 500;
		text-align: center;
		border-bottom: 1px solid #D6DFEA;
		line-height: 1.5;
		background-color: #F9FBFE;
	}
	.login{
		margin:20px 20px  20px 30px;
		font-size: 20px;
		line-height: 1.5;
	}
	.err_msg{
		font-size:14px;
		text-align:center;
		line-height:1.5;
		color:#fff;
	}
	.login>input{
		width: 250px;
		height:30px;
	}
	.login_remember >input{
		display: inline-block;
		border: 1px solid #D6DFEA;
		width: 13px;
		height: 13px;
	}
	.login_remember{
		font-size: 14px;
		color: #00f;
	}
	.login_submit>input{
		font-size: 20px;
		color:#fff;
		background-color: #0000ee;
		line-height: 1.5;
		padding:10px;
		display:block;
		height: 50px;
		width: 350px;
		borser:1px solid #0000ee;
		 border-radius: 5px;
		 border:1px solid #D6DFEA;
		 -moz-border-radius:5px;
		 -webkit-border-radius: 5px;
		 -ms-border-radius:5px;
		margin-left: auto;
		margin-right: auto;
	}
	.login_help{
		text-align: right;
		margin-right: 20px;
		margin-top: 50px;
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
		<!--  <a href="login.php" alt="login.php">
		    <img src="img/logo.png" alt="header_logo"/></a> -->
	</div>

	<div class="content">
		<div class="left_content">
			<img src="img/decorate.jpg" alt="logo_page.png"/>
		</div>
		<div class="login_form">
<!-- 		action="doLogin.php" -->
			<form  method="post" name="login">
				<div class="login_header"><p>登陆有惊喜</p></div>
				<div class="err_msg">账号或者密码错误</div>
				<div class="login">
					<label for="username">用户名：</label>
					<input type="text" name="username" id="username" checked/>
			    </div>
				<div class="login">
					<label for="password">密码&nbsp;&nbsp;：</label>
					<input type="password" name="password" id="password"/>
			    </div>
			    <div class="login_remember login">
			    	<!--<span id="is_checked"></span>-->
			    	<input name="love" type="checkbox" id="is_checked" />
			    	<label for="is_checked">下次自动登录</label>
			    </div>
			    <div class="login_submit login">
			    	<input type="button" value="提交" id="submit">
			    </div>
			    <div class="login_help">
			    	<a href="lookfor_password.html">忘记密码?</a>
			    	<a href="register.html">注册新用户</a>
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
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript">
	   $(function(){
 		 
 		 //自动登录
 		var username=$.cookie("username");
 		var password=$.cookie("password");
 		//alert(""+username+password);
 		if(username&&password){


 			$.ajax({
		   		url: 'doLogin.php',
		   		type: 'POST',
		   		dataType: 'json',
		   		data: {
		   				'username': username,
		   				'password':password
		   				},
		   		success: function(data){
		   			if(data.error){
		   				if(username) $.cookie("username",username,{ expires: -1});
		   				if(password) $.cookie("password",password,{expires: -1});
		   				//location.href="login.php";
		   				
		   			}else{
		   			    $.cookie("username",username,{ expires: 7});
		   			    $.cookie("password",password,{expires: 7});
		   				location.href="index.php";
		   			}
		   		},
		   		error: function(jqXHR){     
			          alert("发生错误：" + jqXHR.status);
			          if(jqXHR.status==404){
			        	  location.href="error.html"; 
					}
				}
		   	});

		}//end if;

	   	$("#submit").click(function(){
 			
 			var username=$("#username").val();
 			var password=$('#password').val();

 			if($("#is_checked").prop('checked')){
 				$.cookie("username",username,{ expires: 7});
		   		$.cookie("password",password,{expires: 7});
			}else{
				// $.cookie("username",username,{ expires: -1});
		   		// $.cookie("password",password,{expires: -1});
		   		//alert("hello2");
			}
		   	$.ajax({
		   		url: 'doLogin.php',
		   		type: 'POST',
		   		dataType: 'json',
		   		data: {
		   				'username': username,
		   				'password':password
		   				},
		   		success: function(data){
		   			if(data.error){
		   				//alert(data);
		   				$(".err_msg").css({
		   					color:"#f00"
		   				});
		   				$('#password').val("");
		   				
		   			}else{
		   				//alert(" no error");
		   				//  $.cookie("username",username,{ expires: 7});
		   				// $.cookie("password",password,{expires: 7});
		   				location.href="index.php";
		   			}
		   		},
		   		error: function(jqXHR){     
			          alert("发生错误：" + jqXHR.status);
			          if(jqXHR.status==404){
			        	  location.href="error.html"; 
					}
				}
		   	});//end ajax()
		   	
		   });//end click()
	   });//end $();
	 
		  
	</script>
</body>
</html>