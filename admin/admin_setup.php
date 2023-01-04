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


$title=$_POST['title'];
$jiesao=$_POST['jiesao'];

$sql="update setup set title = '$title',jiesao = '$jiesao'";
if (mysqli_query($conn,$sql)){
    echo "<script>alert('修改成功！',top.location='../admin.php')</script>";
}