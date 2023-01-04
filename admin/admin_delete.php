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
$uid=$_SESSION['userid'];

$sql="delete from msg where id=$id";
$sc = mysqli_query($conn,"select * from msg where id = $id");
$sc = mysqli_fetch_assoc($sc);
$qwe='../'.'upload/'.$sc['upload'];
unlink($qwe);

if (mysqli_query($conn,$sql)){
	$sql=mysqli_query($conn,"delete from notice where tid=$id");
	$sql="delete from reply where tid=$id";
	if (mysqli_query($conn,$sql)){
		$sql= mysqli_query ($conn,"update stat set msg = msg-1");
		echo "<script>top.location='javascript:history.back();'</script>";
	}
}

?>