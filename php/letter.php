<?php
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
$zid=$_POST['id'];
$uid = $_SESSION['userid'];
$reply=$_POST['reply'];
$day = time();

$my = mysqli_query($conn,"select * from user where id = $uid");
$my = mysqli_fetch_assoc($my);
$jinbi=$my['jinbi'];

if ($jinbi<=5) {
	echo "<script>alert('金币不足，签到可以得金币哦！',top.location='../user.php?id=$zid')</script>";
	exit;
}

if ($reply=="") {
	echo "<script>alert('内容不能为空',top.location='../user.php?id=$zid')</script>";
	exit;
}

$sql= "insert into notice (zid,uid,reply,day) values ('{$zid}','{$uid}','{$reply}','{$day}')";
if (mysqli_query($conn,$sql)){
	$sql= mysqli_query ($conn,"update user set usermsg = usermsg+1 where id = $zid");
	$sql= mysqli_query ($conn,"update user set jinbi = jinbi-5 where id = $uid");
	$sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('私信消息：-5','{$uid}','{$day}')");
	echo "<script>alert('发送成功',top.location='../user.php?id=$zid')</script>";
}
