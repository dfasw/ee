<?php
header("content-type:text/html;charset=utf-8"); 

$db_leixin=$_POST['db_leixin'];
$db_name=$_POST['db_name'];
$db_user=$_POST['db_user'];
$db_pass=$_POST['db_pass'];
$admin_user=$_POST['admin_user'];
$admin_pass=md5($_POST['admin_pass']);
$day = time();


if ($db_leixin=="" or $db_name=="" or $db_user=="" or $db_pass=="" or $admin_user=="" or $admin_pass=="") {
	echo "<script>alert('所有表单不能为空！',top.location='index.html')</script>";
	exit;
}

$conn=mysqli_connect("$db_leixin","$db_user","$db_pass","$db_name"); 
if (!$conn){
	echo "<script>alert('数据库账号或密码错误！',top.location='index.html')</script>";
	exit;
}else{
	$add_conn = fopen( '../php/conn.php','w'); 
	fputs($add_conn, '
	<?php

	header("content-type:text/html;charset=utf-8"); 

	$conn=mysqli_connect("'.$db_leixin.'","'.$db_user.'","'.$db_pass.'","'.$db_name.'"); 
	error_reporting(0);

	if (mysqli_connect_errno($conn)){ 
	    echo "连接数据库失败: " . mysqli_connect_error(); 
	} 

	?>
	');
	fclose($add_conn);

	$msg="CREATE TABLE IF NOT EXISTS `msg` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uid` varchar(255) DEFAULT NULL,
	  `name` varchar(255) DEFAULT NULL,
	  `content` text CHARACTER SET utf8mb4,
	  `upload` varchar(255) DEFAULT NULL,
	  `day` varchar(255) DEFAULT NULL,
	  `byday` varchar(255) DEFAULT NULL,
	  `pid` varchar(255) DEFAULT '0',
	  `save` int(11) NOT NULL DEFAULT '0',
	  `lian` varchar(255) NOT NULL,
	  `node` varchar(20) NOT NULL,
	  `jiage` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;";

	$node="CREATE TABLE `node` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(10) NOT NULL,
	  `jiesao` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;";

	$notice="CREATE TABLE `notice` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `tid` varchar(255) DEFAULT NULL,
	  `uid` varchar(255) DEFAULT NULL,
	  `zid` varchar(255) DEFAULT NULL,
	  `znr` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
	  `reply` text CHARACTER SET utf8mb4,
	  `day` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=884 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

	$reply="CREATE TABLE `reply` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `tid` varchar(255) DEFAULT NULL,
	  `uid` varchar(255) DEFAULT NULL,
	  `zid` varchar(255) DEFAULT NULL,
	  `znr` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
	  `reply` text CHARACTER SET utf8mb4,
	  `day` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

	$user="CREATE TABLE `user` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `username` varchar(32) DEFAULT NULL,
	  `password` varchar(32) DEFAULT NULL,
	  `tou` varchar(32) DEFAULT 'tou.jpg',
	  `usermsg` varchar(32) DEFAULT '0',
	  `isadmin` varchar(32) DEFAULT '0',
	  `jinbi` int(11) NOT NULL DEFAULT '10',
	  `day` int(11) NOT NULL DEFAULT '0',
	  `qd` int(11) NOT NULL DEFAULT '0',
	  `jiesao` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'ta很懒，什么都没有留下',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

	$setup="CREATE TABLE `setup` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `title` varchar(32) DEFAULT NULL,
	  `jiesao` varchar(32) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

	$bill="CREATE TABLE `bill` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `content` varchar(255) DEFAULT NULL,
	  `uid` varchar(255) DEFAULT NULL,
	  `day` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

	$save="CREATE TABLE `save` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `tid` varchar(255) DEFAULT NULL,
	  `uid` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";

	if (mysqli_query($conn,$msg).mysqli_query($conn,$node).mysqli_query($conn,$notice).mysqli_query($conn,$reply).mysqli_query($conn,$user).mysqli_query($conn,$setup).mysqli_query($conn,$bill).mysqli_query($conn,$save)){

		$sql= mysqli_query ($conn,"insert into user (username,password,isadmin,day) values ('{$admin_user}','{$admin_pass}','1','{$day}')");
		$sql= mysqli_query ($conn,"insert into setup (title,jiesao) values ('HEYBBS','垂直社交')");
		echo "<script>alert('恭喜你，安装成功！',top.location='../index.php')</script>";

	}


}