<?php  
$lifeTime = 999 * 3600;
session_set_cookie_params($lifeTime); 
session_start();

require_once('conn.php');
$username=$_POST['username'];
$password=md5($_POST['password']);
$verify = $_POST["verify"];
$day = time();

if ($username=="" or $password=="d41d8cd98f00b204e9800998ecf8427e" ) {
  	echo "<script>alert('不能为空')</script>";
	exit;
}

$sql="select id from user where username='$username' limit 1";
if ($check = mysqli_query($conn,$sql)){
    if(mysqli_fetch_array($check)){
  		echo "<script>alert('用户名已经存在')</script>";
        exit;
    }
}


if(strtolower($_SESSION["verifyimg"]) == strtolower($verify)){
	$_SESSION["verify"] = "";
	$sql = "insert into user (username,password,day) values ('{$username}','{$password}','{$day}')";
	if (mysqli_query($conn,$sql)){
	  $_SESSION['username']=$username;
	  $_SESSION['userid']= mysqli_insert_id();
	  echo "<script>alert('注册成功',top.location='../login.php')</script>";
	}
}else{
  	echo "<script>alert('验证码错误',top.location='../register.php')</script>";
}