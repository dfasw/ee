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


$id=$_POST['id'];
$name=$_POST['name'];
$jiesao=$_POST['jiesao'];

$sql="update node set name = '$name' , jiesao = '$jiesao' where id = '$id'";

if (mysqli_query($conn,$sql)){
  	echo "<script>alert('修改成功',top.location='../node_tag.php?id=$id')</script>";
}