<?php
session_start();
if (!$_SESSION['userid']) {
    echo "<script>location='../login.php'</script>";
    exit;
}
require_once('conn.php');

$tid=$_POST['id'];
$uid=$_SESSION['userid'];
$reply=$_POST['reply'];
$zid=$_POST['zid'];
$znr=$_POST['znr'];
$day = time();
$byday = time();
$suiji=rand(1,10);


if ($reply==""){
	echo "<script>alert('不能为空')</script>";
	exit;
}

$msg = mysqli_query($conn,"select * from msg where id = $tid");
$msg = mysqli_fetch_assoc($msg);
$jiage=$msg['jiage'];

if($jiage!="0"){
	$my = mysqli_query($conn,"select * from user where id = $uid");
	$my = mysqli_fetch_assoc($my);
	$jinbi=$my['jinbi'];
	if($jinbi<$jiage){
		echo "<script>alert('金币不足,无法回复',top.location='../msg.php?id=$tid')</script>";
		exit;
	}

}

if ($uid==$zid){ 
	$sql = "insert into reply (tid,uid,reply,day) values ('{$tid}','{$uid}','{$reply}','{$day}')";
	if (mysqli_query($conn,$sql)){
		$sql= mysqli_query ($conn,"update msg set pid = pid+1,byday = $byday where id = $tid");
		echo "<script>alert('回复成功！',top.location='../msg.php?id=$tid')</script>";
	}	
}else{		
	if ($znr=="") {
	$sql = "insert into reply (tid,uid,reply,day) values ('{$tid}','{$uid}','{$reply}','{$day}')";

	if (mysqli_query($conn,$sql)){
		$sql= mysqli_query ($conn,"update msg set pid = pid+1,byday = $byday where id = $tid");
		$sql= mysqli_query ($conn,"update user set usermsg = usermsg+1 where id = $zid");
		$sql= mysqli_query ($conn,"insert into notice (tid,uid,zid,reply,day) values ('{$tid}','{$uid}','{$zid}','{$reply}','{$day}')");
		$sql= mysqli_query ($conn,"update user set jinbi = jinbi+$suiji where id = $zid");//回复奖励金币
      	$sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('回复奖励：+$suiji','{$zid}','{$day}')");//金币明细
		if($jiage!="0"){
			$sql= mysqli_query ($conn,"update user set jinbi = jinbi+$jiage where id = $zid");
			$sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('资源收益：+$jiage','{$zid}','{$day}')");

			$sql= mysqli_query ($conn,"update user set jinbi = jinbi-$jiage where id = $uid");
			$sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('资源回复：-$jiage','{$uid}','{$day}')");//资源回复：
		}
		echo "<script>alert('回复成功！', top.location='../msg.php?id=$tid')</script>";
		}
	}else{
		$sql = "insert into reply (tid,uid,zid,znr,reply,day) values ('{$tid}','{$uid}','{$zid}','{$znr}','{$reply}','{$day}')";
		if (mysqli_query($conn,$sql)){
			$sql= mysqli_query ($conn,"update msg set pid = pid+1,byday = $byday where id = $tid");
			$sql= mysqli_query ($conn,"update user set usermsg = usermsg+1 where id = $zid");
			$sql= mysqli_query ($conn,"insert into notice (tid,uid,zid,znr,reply,day) values ('{$tid}','{$uid}','{$zid}','{$znr}','{$reply}','{$day}')");
			if($jiage!="0"){
				$sql= mysqli_query ($conn,"update user set jinbi = jinbi+$jiage where id = $zid");
				$sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('资源收益：+$jiage','{$zid}','{$day}')");

				$sql= mysqli_query ($conn,"update user set jinbi = jinbi-$jiage where id = $uid");
				$sql= mysqli_query ($conn,"insert into bill (content,uid,day) values ('资源回复：-$jiage','{$uid}','{$day}')");//资源回复：
			}
			echo "<script>alert('回复成功！',top.location='../msg.php?id=$tid')</script>";
		}
	}	
}
