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
$tid=$_GET['tid'];
$sql="delete from reply where id=$id";
if (mysqli_query($conn,$sql)){
	$sql= mysqli_query ($conn,"update msg set pid = pid-1 where id = $tid");
	echo "<script>top.location='../msg.php?id=$tid'</script>";
}
?>