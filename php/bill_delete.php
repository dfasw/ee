<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
$uid = $_SESSION['userid'];

$sql="delete from bill where uid=$uid";
if (mysqli_query($conn,$sql)){
	echo "<script>top.location='../bill.php'</script>";
}
?>