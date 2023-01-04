<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
$id = $_SESSION['userid'];
$name=$_SESSION['username'];
$jiesao=$_POST['jiesao'];

if ( $jiesao=="") {
	echo "<script>alert('不能为空',top.location='../setup.php')</script>";
	exit;
}


$sql="update user set  jiesao = '$jiesao' where id = '$id'";
if (mysqli_query($conn,$sql)){
    echo "<script>alert('修改成功！',top.location='../setup.php')</script>";
}