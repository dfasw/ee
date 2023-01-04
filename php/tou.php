<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
require_once('suof.php');

$id = $_SESSION['userid'];
$my = mysqli_query($conn,"select * from user where id = $id");
$my = mysqli_fetch_assoc($my);
$tou = '../img/'.$my['tou'];


if ($tou!="../img/tou.jpg") {
	$lei = ['jpg','jpeg','png'];
	$src=$_FILES['img']['tmp_name'];
	$name=$_FILES['img']['name'];
	$ext= array_pop(explode('.', $name));
	if (!in_array($ext, $lei)){ 
		echo "<script>alert('请上传图片格式的头像')</script>";
		exit;
	}
	$dst='../img/'.time().mt_rand().'.'.$ext;
	if(move_uploaded_file($src,$dst)){
	thumb($dst,300,300);
	$img=basename($dst);
	$sql="update user set tou='$img' where id = $id";
	if (mysqli_query($conn,$sql)){
		unlink($tou);
      	echo "<script>alert('头像保存成功',top.location='../setup.php')</script>";
	}

	}
}else{
	$lei = ['jpg','jpeg','png'];
	$src=$_FILES['img']['tmp_name'];
	$name=$_FILES['img']['name'];
	$ext= array_pop(explode('.', $name));
	if (!in_array($ext, $lei)){ 
		echo "<script>alert('请上传图片格式的头像')</script>";
		exit;
	}
	$dst='../img/'.time().mt_rand().'.'.$ext;
	if(move_uploaded_file($src,$dst)){
	thumb($dst,300,300);
	$img=basename($dst);
	$sql="update user set tou='$img' where id = $id";
	if (mysqli_query($conn,$sql)){
		$sql= mysql_query ("update user set jinbi = jinbi+30 where id = $id");
		echo "<script>alert('头像保存成功',top.location='../setup.php')</script>";
	}

	}
}