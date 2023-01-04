<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
$id = $_SESSION['userid'];
$username=$_POST['username'];
$day = time();


$my = mysqli_query($conn,"select * from user where id = $id");
$my = mysqli_fetch_assoc($my);
$jinbi=$my['jinbi'];

if ($jinbi<=500) {
  echo "<script>alert('金币不足！',top.location='../setup.php')</script>";
  exit;
}

if ($username=="") {
	echo "<script>alert('不能为空',top.location='../setup.php')</script>";
	exit;
}


$sql="select id from user where username='$username' limit 1";
  if ($check = mysqli_query($conn,$sql)){
  if(mysqli_fetch_array($check)){
  echo "<script>alert('用户名已经存在',top.location='../setup.php')</script>";
  exit;
  }
}

$sql="update user set  username = '$username' where id = '$id'";
if (mysqli_query($conn,$sql)){
    $sql= mysqli_query ($conn,"update user set jinbi = jinbi-500 where id = $id");
    $sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('修改用户名：-500','{$id}','{$day}')");
    echo "<script>alert('修改成功！',top.location='../setup.php')</script>";
}