<?php
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');

$tid = $_GET['id'];
$uid = $_SESSION['userid'];

$sql="select * from save where tid='{$tid}' and uid ='{$uid}'";
$rst= mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($rst);

if (!$row){
	$sql= "insert into save (tid,uid) values ('{$tid}','{$uid}')";
	if (mysqli_query($conn,$sql)){
      	$sql= mysqli_query ($conn,"update msg set save = save+1 where id = $tid");
		echo "已喜欢";
	}
}else{
	$sql="delete from save where tid=$tid and uid=$uid";
	if (mysqli_query($conn,$sql)){
      	$sql= mysqli_query ($conn,"update msg set save = save-1 where id = $tid");
		echo "喜欢";
	}

}


