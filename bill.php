<?php 
require_once('php/head.php');
if (!$_SESSION['userid']) {
    echo "<script>location='login.php'</script>";
    exit;
}

if ($my['isadmin']=="2") {
  	echo "<script>alert('对不起，您的账号存在异常！',top.location='index.php')</script>";
    exit;
}

$perNumber=30; 
$url=$_GET['url']; 
$count=mysqli_query($conn,"select count(*) from bill where uid=$id");
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber);
if (!isset($url)) {
$url=1;
} 
$startCount=($url-1)*$perNumber;
$bill=mysqli_query($conn,"select * from bill where uid=$id order by day desc limit $startCount,$perNumber");
?>

<title>我的金币-<?php echo $setup['jiesao'];?></title>


<div id="mian" class="container">
	<div id="col" class="col-md-9">
		<div class="panel panel">
			<div class="panel-body">
			<div id="page_up" class="page-header">
				<h4 id="page_zi"><strong>我的账单</strong><small><a style="float: right;" href="php/bill_delete.php" onclick="return confirm('确定清空吗？')" target="fraSubmit"><i class="fa fa-trash" aria-hidden="true"></i> 清空</a></small></h4>
			</div>
				<h4>当前金币 <?php echo $my['jinbi'];?> <div class="pull-right"><a href="alluser.php"><p>金币排行榜 <i class="fa fa-angle-right" aria-hidden="true"></i></p></a></div></h4>
				<ul class="list-group">
				<?php  
				if ($totalNumber=="0"){
				?>
					<div id="kon"></div>
				<?php
				}
				?>
				<?php
				while($row = mysqli_fetch_array($bill))
				{
				?>
					<li class="list-group-item">
						<span class="text-muted"><?php echo $row['content'];?></span> 
						<span class="text-muted" style="float: right;"><?php echo date( "Y-m-d H:i", $row['day']);?></span>
					</li>
				<?php
				}
				?>
				</ul>
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
</div>

<script>
$('a[data-active="bill"]').addClass('active');
</script>