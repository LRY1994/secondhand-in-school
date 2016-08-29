<?php
header("Content-Type: application/json;charset=utf-8"); 
$account = $_POST["username"];
$password = $_POST["password"];
//echo $account.$password;
if($account=="abc"&&$password=="123456"){
    $_POST['error']=true;
   // echo "error";
}else{
    $_POST['error']=false;
   // echo "true";
}
echo json_encode($_POST);