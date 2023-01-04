<?php 
require_once('php/head.php');
if ($my['isadmin']=="2") {
  	echo "<script>alert('对不起，您的账号存在异常！',top.location='index.php')</script>";
    exit;
}

$perNumber=20; 
$url=$_GET['url']; 
$count=mysqli_query($conn,"select count(*) from node");
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber);
if (!isset($url)) {
$url=1;
} 
$startCount=($url-1)*$perNumber;
$node=mysqli_query($conn,"select * from node order by id desc limit $startCount,$perNumber");
?>

<title>社区话题-<?php echo $setup['jiesao'];?></title>

<div id="mian" class="container">
<?php
while($row = mysqli_fetch_array($node))
{
$id=$row['id'];
$msg=mysqli_query($conn,"select count(1) from msg where node=$id");
$rs=mysqli_fetch_array($msg);
$msg=$rs[0];
?>
<div id="colp" onclick="window.open('node_tag.php?id=<?php echo $row['id'];?>','_self')" class="col-md-3 col-xs-6" title="<?php echo $row['name'];?>">
	<div style="margin-bottom: 0px;" class="panel panel">
		<div class="panel-body">
            <h4 id="jiesao" class="text-primary"><strong><?php echo $row['name'];?></strong> <span class="badge"><?php echo $msg;?></span></h4>
          	<p id="jiesao" class="text-muted" title="<?php echo $row['jiesao'];?>" ><?php echo $row['jiesao'];?></p>
		</div>
	</div>
</div>
<?php 
} 
?>
<div class="col-md-12 col-xs-12">
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

<script>
$('a[data-active="node"]').addClass('active');
</script>