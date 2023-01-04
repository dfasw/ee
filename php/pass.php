<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
$id = $_SESSION['userid'];
$password=md5($_POST['password']);
$rpassword=md5($_POST['rpassword']);

if ($password=="d41d8cd98f00b204e9800998ecf8427e" or $rpassword=="d41d8cd98f00b204e9800998ecf8427e") {
	echo "<script>alert('不能为空')</script>";
	exit;
}

if ($password==$rpassword){
	$sql="update user set password = '$password' where id = '$id'";
    if (mysqli_query($conn,$sql)){
        echo "<script>alert('修改成功',top.location='logout.php')</script>";
    }
}else{
	echo "<script>alert('两次密码不一致')</script>";
}

?>