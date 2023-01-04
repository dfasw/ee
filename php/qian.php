<?php
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');

$id = $_SESSION['userid'];
$jin=rand(10,40);
$qd = date("Ymd");
$day = time();

$my = mysqli_query($conn,"select * from user where id = $id");
$my = mysqli_fetch_assoc($my);
$myqd=$my['qd'];
$myjinbi=$my['jinbi'];

if ($my['isadmin']=="2") {
  	echo "<script>alert('对不起，您的账号存在异常！',top.location='../index.php')</script>";
    exit;
}

if ($qd==$myqd) {
	echo "<script>alert('今天已经签到过了',top.location='../index.php')</script>";
	exit;
}

$sql = "update user set jinbi = jinbi+'{$jin}' , qd = '$qd'  where id = $id";

if (mysqli_query($conn,$sql)){
  	$jinbi=basename($jin);
  	$sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('每日签到：+$jinbi','{$id}','{$day}')");
	echo "<script>alert('签到成功',top.location='../bill.php')</script>";
}