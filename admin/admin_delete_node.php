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

$id=$_GET['id'];
$sql="delete from node where id=$id";
if (mysqli_query($conn,$sql)){
	echo "<script>top.location='../node.php'</script>";
}

?>