<?php 
require_once('php/head.php');

$perNumber=24; 
$url=$_GET['url']; 
$count=mysqli_query($conn,"select count(*) from user where isadmin=2");
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber);
if (!isset($url)) {
$url=1;
} 
$startCount=($url-1)*$perNumber;
$user=mysqli_query($conn,"select * from user where isadmin=2 order by jinbi desc limit $startCount,$perNumber");
?>

<title>小黑屋-Heybbs社区</title>


<div id="mian"  class="container">
<?php  
if ($totalNumber=="0"){
?>
<div class="panel panel">
	<div class="panel-body">
		<div id="kon"></div>
	</div>
</div>
<?php
}
?>
	
<?php
while($row = mysqli_fetch_array($user))
{
?>
	<div style="text-align: center; padding: 5px; margin-bottom: 0px; cursor:pointer;" onclick="window.open('user.php?id=<?php echo $row['id'];?>','_self')" class="col-md-3 col-xs-6">
		<div style="margin-bottom: 0px;" class="panel panel">
        	<div class="panel-body">
        		<div id="container">
					<h4><img id="dahead" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $row['tou'];?>" width="150" height="150"></h4>
					<p id="jiesao" class="text-primary"><strong><?php echo $row['username'];?></strong></p>
					<p id="jiesao" class="text-muted"><?php echo $row['jiesao'];?></p>
                  	<p class="text-muted">
                    <i class="fa fa-calendar" aria-hidden="true"></i> 
                    <?php
                    echo date( "Y-m-d", $row['day'])
                    ?>
                    </p>
                  	<span class="label label-danger">已封号</span>
				</div>
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
