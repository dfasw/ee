<?php 
$lifeTime = 999 * 3600;
session_set_cookie_params($lifeTime); 
session_start();
require_once('conn.php');
$username=$_POST['username'];
$password=md5($_POST['password']);
$verify = $_POST["verify"];

if ($username=="" or $password=="d41d8cd98f00b204e9800998ecf8427e" ) {
  	echo "<script>alert('不能为空',top.location='../login.php')</script>";
	exit;
}
$sql="select * from user where username='{$username}' and password ='{$password}'";
$rst= mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($rst);


if(strtolower($_SESSION["verifyimg"]) == strtolower($verify)){
	$_SESSION["verify"] = "";
		if ($row) {
			$_SESSION['username']=$username;
			$_SESSION['userid']=$row['id'];
			echo "<script>alert('登录成功',top.location='../index.php')</script>";
		}else{
          	echo "<script>alert('账号或密码不正确',top.location='../login.php')</script>";
		}
}else{
  	echo "<script>alert('验证码错误',top.location='../login.php')</script>";
}

?>