<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');
$id=$_GET['id'];
$zid = $_SESSION['userid'];

if ($id!=""){
    $sql="delete from notice where id=$id";
    if (mysqli_query($conn,$sql)){
        echo "<script>top.location='../notice.php'</script>";
    }
}else{
    $sql="delete from notice where zid=$zid";
    if (mysqli_query($conn,$sql)){
        echo "<script>top.location='../notice.php'</script>";
    }
}

?>