<?php 
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
unset( $_SESSION['username']);
unset( $_SESSION['userid']);
echo "<script>top.location='../index.php'</script>";

?>