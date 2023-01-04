<?php 
$lifeTime = 999 * 3600;
session_set_cookie_params($lifeTime); 
session_start();

if ($_SESSION['peise']=="") {
	$_SESSION['peise']="<link rel='stylesheet' href='css/peise.css'>";
	echo "<script>top.location='../index.php'</script>";
	exit;
}else{
	unset( $_SESSION['peise']);
	echo "<script>top.location='../index.php'</script>";
	exit;
}

?>