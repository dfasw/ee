<?php
require_once('php/head.php');
if (!$_SESSION['userid']) {
    echo "<script>location='login.php'</script>";
    exit;
}

$id = $my['id'];
$perNumber=20; //每页显示的记录数
$url=$_GET['url']; //获得当前的页面值
$count=mysqli_query($conn,"select count(*) from notice where zid = $id"); //获得记录总数
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($url)) {
$url=1;
} //如果没有值,则赋值1
$startCount=($url-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$notice=mysqli_query($conn,"select * from notice where zid = $id order by id desc limit $startCount,$perNumber");
$sql= mysqli_query ($conn,"update user set usermsg = '0' where id = $id");
?>


<title>消息通知-<?php echo $setup['jiesao'];?></title>
<div id="mian" class="container">
<div id="col" class="col-md-9">	
	<div class="panel panel">
		<div class="panel-body">
        <div id="page_up" class="page-header">
        	<h4 id="page_zi"><strong>消息通知</strong><small><a style="float: right;" href="php/notice_delete.php" onclick="return confirm('确定清空吗？')" target="fraSubmit"><i class="fa fa-trash" aria-hidden="true"></i> 清空</a></small></h4>
        </div>
        <?php  
		if ($totalNumber=="0"){
		?>
			<div id="kon"></div>
		<?php
		}
		?>
		<?php 
		while($row = mysqli_fetch_array($notice))
		{
		$uid = $row['uid'];
		$uid = mysqli_query($conn,"select * from user where id = $uid");
		$uid = mysqli_fetch_assoc($uid);
        $days = $row['day'];
		?>
			<div class="page-header">
				<div class="media-left">
                  	<div id="container">
                      <a href="user.php?id=<?php echo $uid['id'];?>">
                        <img id="head" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $uid['tou'];?>" width="150" height="150">
                      </a>
                  </div>
				</div>
				<div class="media-body">
                  	<a href="user.php?id=<?php echo $uid['id'];?>"><p class="text-primary"><strong><?php echo $uid['username'];?></strong></p></a>
					<?php
					$zid = $row['zid'];
					$znr = $row['znr'];
					if ($znr!=""){
					$zid = mysqli_query($conn,"select * from user where id = $zid");
					$zid = mysqli_fetch_assoc($zid);	
					$znr = mysqli_query($conn,"select * from reply where id = $znr");
					$znr = mysqli_fetch_assoc($znr);	
					?>
					<a href="msg.php?id=<?php echo $row['tid'];?>"><p><?php echo htmlspecialchars($row['reply']);?></p></a>
                  	<div class="well well-sm">
						<p><span class="label label-primary">帖子</span> <?php echo $my['username'];?>：<?php echo htmlspecialchars($znr['reply'])?> </p>
					</div>
					<?php	
					}else{
					$tizi = $row['tid'];
					$msg = mysqli_query($conn,"select * from msg where id = $tizi");
					$msg = mysqli_fetch_assoc($msg);
					?>

					<?php 
					$tid = $row['tid'];
					if ($tid==""){
					?>
					<p><span class="label label-success">私信</span> <?php echo htmlspecialchars($row['reply'])?></p>
					
					<?php 
					}else{
					?>

					<a href="msg.php?id=<?php echo $row['tid'];?>"><p><?php echo htmlspecialchars($row['reply']);?></p></a>
					<div class="well well-sm">
                      	<p><span class="label label-warning">主题</span> <?php echo $my['username'];?>：<?php echo htmlspecialchars($msg['content']);?></p>
					</div>

					<?php 
					}
					?>
              
					<?php
					}
					?>
					<div class="pull-left">
						<span class="text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo format_date("$days");?></span>
					</div>
                    <div class="pull-right">
                    	<a target="fraSubmit" onclick="return confirm('确定删除吗')" href="php/notice_delete.php?id=<?php echo $row['id'];?>"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
                    </div>
				</div>
			</div>
			<?php
			}
			?>
		  <ul class="pager">
		    <?php 
		    if ($url != 1){
		    ?>
		    <li><a id="fanye" href="?url=1"><i class="fa fa-step-backward" aria-hidden="true"></i></a><li>
		    <li><a id="fanye" href="?url=<?php echo $url - 1;?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a><li>
		    <li><a id="fanye"><?php echo $url;?>/<?php echo $totalPage;?></a></li>
		    <?php
		    }
		    ?>

		    <?php  
		    if ($url<$totalPage){
		    ?>
		    <li><a id="fanye" href="?url=<?php echo $url + 1;?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a><li>
		    <li><a id="fanye" href="?url=<?php echo $totalPage;?>"><i class="fa fa-step-forward" aria-hidden="true"></i></a><li>
		    <?php
		    }
		    ?>
		  </ul>
       	</div>
	</div> 
</div>
<?php require_once('home.php');?>

<script>
$('a[data-active="notice"]').addClass('active');
</script>