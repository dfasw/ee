<?php 
include'conn.php';

$msgtj=mysqli_query($conn,"select count(1) from msg");
$rs=mysqli_fetch_array($msgtj);
$msgtj=$rs[0];

$reply=mysqli_query($conn,"select count(1) from reply");
$rs=mysqli_fetch_array($reply);
$replytj=$rs[0];

$usertj=mysqli_query($conn,"select count(1) from user");
$rs=mysqli_fetch_array($usertj);
$usertj=$rs[0];

?>