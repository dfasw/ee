<?php 
session_start();
$id = $_SESSION['userid'];
require_once('../php/conn.php');

$my = mysqli_query($conn,"select * from user where id = $id");
$my = mysqli_fetch_assoc($my);
if ($my['isadmin']!="1") {
    echo "<script>location='index.php'</script>";
    exit;
}

$id = $_GET['id'];
if ($id=="1"){
	echo "<script>alert('创始人不能封禁！')</script>";
	exit;
}

$my = mysqli_query($conn,"select * from user where id = $id");
$my = mysqli_fetch_assoc($my);
$wode=$my['isadmin'];

if ($wode=="0"){
	$sql= "update user set isadmin = 2 where id = $id";
	if (mysqli_query($conn,$sql)){
		echo "<script>top.location='../user.php?id=$id'</script>";
	}
}else{
	$sql= "update user set isadmin = 0 where id = $id";
	if (mysqli_query($conn,$sql)){
		echo "<script>top.location='../user.php?id=$id'</script>";
	}
}