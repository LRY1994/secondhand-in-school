<?php
session_start();
if($_SESSION['userID']) unset($_SESSION['userID']);
if($_SESSION['name'])   unset($_SESSION['name']);
if($_COOKIE['username']) setcookie('username',$resArray['account'],time()-3600*48);
 //unset($_COOKIE['username']);
if($_SESSION) session_destroy();
// if(isset($_COOKIE['username']))  unset()
$location=$_GET['location'];
if(!$_location) $location="index.php";
header("location:".$location);
?>

