<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}

require_once('conn.php');
$id=$_GET['id'];
$uid=$_SESSION['userid'];

$sql="delete from msg where id=$id";

$sc = mysqli_query($conn,"select * from msg where id = $id");
$sc = mysqli_fetch_assoc($sc);
$qwe='../'.'upload/'.$sc['upload'];
unlink($qwe);

if (mysqli_query($conn,$sql)){
	$sql=mysqli_query($conn,"delete from notice where tid=$id");
	$sql=mysqli_query($conn,"delete from reply where tid=$id");
	$sql=mysqli_query($conn,"delete from save where tid=$id");
	echo "<script>top.location='javascript:history.back();'</script>";
}

?>