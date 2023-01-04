<?php
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
require_once('suof.php');
$uid = $_SESSION['userid'];
$name = $_SESSION['username'];
$content=($_POST['content']);
$day = time();
$imgsrc=$_FILES['img']['tmp_name'];
$lian=$_POST['lian'];
$node=$_POST['node'];
$jiage=$_POST['jiage'];

if ($content=="") {
	echo "<script>alert('内容不能为空',top.location='../add.php')</script>";
	exit;
}


$stop=array('滚','去死','妈逼','你妈的','他妈的');
$blacklist="/".implode("|",$stop)."/i";
if(preg_match($blacklist,$content)){ 
	echo "<script>alert('发布的内容含有违规内容!',top.location='../add.php')</script>";
	exit; 
} 


if ($lian=="") {
	if ($jiage!="") {
		echo "<script>alert('没有任何资源不允许设置回复金币',top.location='../add.php')</script>";
		exit;
	}else{
		$jiage="0";
	}
}


if ($imgsrc=="") {
	$sql = "insert into msg (uid,name,content,day,byday,lian,node,jiage) values ('{$uid}','{$name}','{$content}','{$day}','{$day}','{$lian}','{$node}','{$jiage}')";
	if (mysqli_query($conn,$sql)){
		echo "<script>alert('发布成功！',top.location='../index.php')</script>";
	}
}else{
	$lei = ['jpg','png','jpeg','gif','jfif'];
	$src=$_FILES['img']['tmp_name'];
	$imgname=$_FILES['img']['name'];
	$ext= array_pop(explode('.', $imgname));
	if (!in_array($ext, $lei)){ 
		echo "<script>alert('请上传图片jpg、png、jpeg格式的图片',top.location='../add.php')</script>";
		exit;
	}
	$dst='../upload/'.time().mt_rand().'.'.$ext;
	if(move_uploaded_file($src,$dst)){
    thumb($dst,900,400);
	$img=basename($dst);
		$sql = "insert into msg (uid,name,content,upload,day,byday,lian,node,jiage) values ('{$uid}','{$name}','{$content}','{$img}','{$day}','{$day}','{$lian}','{$node}','{$jiage}')";
		if (mysqli_query($conn,$sql)){
			echo "<script>alert('发布成功！',top.location='../index.php')</script>";	
		}
	}
}
?>	