<?php
$lifeTime = 999 * 3600;
session_set_cookie_params($lifeTime); 
session_start();

$file = "php/conn.php";
if(!file_exists($file)){
  echo "<script>top.location='install/index.html'</script>";
}   
require_once('conn.php');

$setup = mysqli_query($conn,"select * from setup");
$setup = mysqli_fetch_assoc($setup);

$id = $_SESSION['userid'];
$my = mysqli_query($conn,"select * from user where id = $id");
$my = mysqli_fetch_assoc($my);

$admin=$my['isadmin'];
$time = $my['qd'];
$peise=$my['peise'];
$nowtime=date("Ymd");


function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'周',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=de vice-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <?php 
    if ($_SESSION['peise']){
        echo $_SESSION['peise'];
    }
    ?>
    <link rel="shortcut icon" href="ico.ico"/>
    <iframe id="iframe" name="fraSubmit"></iframe>
    <meta name="description" content="免费分享互联网资源。">
    <meta name="keywords" content="微社区, 微论坛, 微博客">
</head>
<body>  
<!--pc导航-->


<nav id="tou" class="navbar navbar-default">
    <div id="toumian" class="container">
        <a id="logo" class="navbar-brand" href="index.php"><?php echo $setup['title'];?></a>
        <ul class="nav navbar-nav navbar-left">
            <li><a data-active="index" class="link" href="index.php">首页</a></li>
            <li><a data-active="node" class="link" href="node.php">话题</a></li>
            <li><a data-active="search" class="link" href="search.php">搜索</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            if(isset($_SESSION['userid'])){
            ?>
            <li><a href="add.php" ><i id="pcsjb" class="fa fa-camera" aria-hidden="true"></i></a>
            <li><a href="notice.php" ><i id="pcsjb" class="fa fa-bell" aria-hidden="true"></i></a>
            <?php 
            if ($my['usermsg']!="0") {
            ?>
              <div class="pcdian"><?php echo$my['usermsg'];?></div>
            <?php
            }
            ?>
            </li>
            <li>
            <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img id="xhead" src="img/<?php echo $my['tou'];?>"></a>
            <ul id="sjul" class="dropdown-menu">
                <li><a id="ctlian" href="user.php?id=<?php echo $my['id']; ?>">个人主页</a></li>
                <li><a id="ctlian" href="bill.php">我的金币</a></li>
                <li><a id="ctlian" href="setup.php">个人设置</a></li>
                <?php if($admin=="1"){ ?>
                <li><a id="ctlian" href="admin.php">网站后台</a></li>
                <?php } ?> 
                <li><a id="ctlian" target="fraSubmit" href="php/logout.php" onclick="return confirm('确定退出吗？')">退出登录</a></li>
            </ul>
            </li>
            <?php
            }else{
            ?>
            <li><a href="login.php">登录</a></li> 
            <?php
            }
            ?>
        </ul>
    </div>   
</nav>
<!--pc导航-->

<!--sj导航-->
<nav id="sjdh" class="navbar navbar-default navbar-fixed-top">
    <div style="margin-top:10px;" class="container">
        <a id="logo" href="index.php"><?php echo $setup['title'];?></a>
        <?php
        if(isset($_SESSION['userid'])){
        ?>
        <a id="sjcd" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
           <img id="xhead" class="img-circle" src="img/<?php echo$my['tou'] ?>">
        </a>
        <a id="sjcd" href="notice.php"><i id="sjb" class="fa fa-bell" aria-hidden="true"></i></a>
        <a id="sjcd" href="add.php"><i id="sjb" class="fa fa-camera" aria-hidden="true"></i></a>
        <?php 
        if ($my['usermsg']!="0") {
        ?>
            <div class="dian"><?php echo$my['usermsg'];?></div>
        <?php
        }
        ?>
        <ul id="sjul" class="dropdown-menu dropdown-menu-right">
            <li><a id="ctlian" href="user.php?id=<?php echo $my['id']; ?>">个人主页</a></li>
            <li><a id="ctlian" href="node.php">社区话题</a></li>
            <li><a id="ctlian" href="bill.php">我的金币</a></li>
            <li><a id="ctlian" href="setup.php">个人设置</a></li>
            <?php if($admin=="1"){ ?>
            <li><a id="ctlian" href="admin.php">网站后台</a></li>
            <?php } ?> 
            <li><a id="ctlian" target="fraSubmit" href="php/logout.php" onclick="return confirm('确定退出吗？')">退出登录</a></li>
        </ul>
        <?php 
        }else{
        ?>
        <a id="sjcd" href="login.php">
            <img id="xhead" class="img-circle" src="img/tou.jpg">
        </a>
        <?php 
        }
        ?>
    </div>
</nav>

<!--sj导航-->

<p id="back-to-top" ><a href="javascript:location.reload();"><i style="background:#cfcfcf; padding: 10px; border-radius: 10px; opacity: 0.5;" class="fa fa-repeat fa-2x" aria-hidden="true"></i></a></p>

<!--sj导航-->
  
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.lazyload.js"></script>
<script src="js/jquery.cityselect.js"></script>
  
<script>
  $(function() {
     $("img.lazy").lazyload({
         effect : "fadeIn"
     });

  });
</script> 
  
<script type="text/javascript">
    function test() {
        $.ajax({
            url: 'php/peise.php',
            success: function(){
                 window.location.reload()
            }

        })
    }
</script>


</body>
</html>