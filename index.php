<?php 
require_once('php/head.php');

$perNumber=20; 
$url=$_GET['url']; 
$count=mysqli_query($conn,"select count(*) from msg");
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber);
if (!isset($url)) {
$url=1;
} 
$startCount=($url-1)*$perNumber;
$msg=mysqli_query($conn,"select * from msg order by byday desc limit $startCount,$perNumber");

?>

<title><?php echo $setup['title'];?>-<?php echo $setup['jiesao'];?></title>
<meta name="description" content="HEY微社区，新交流！免费分享互联网资源">
<meta name="keywords" content="HEY微社区, 微社区, 微论坛, 微博客">

<div id="mian" class="container">
	<div id="col" class="col-md-9">
		<div id="result"></div>
		<?php
		if(isset($_SESSION['userid'])){
		if($time!=$nowtime){
        ?>
            <div class="panel panel">
                <div class="panel-body">
                    <a target="fraSubmit" href="php/qian.php"><p class="text-primary"><i class="fa fa-gift" aria-hidden="true"></i> 点我领取金币</p></a>
                </div>
            </div>
		<?php
		}
      	}
		?>
		<?php
		while($row = mysqli_fetch_array($msg))
		{
		$id = $row['uid'];
		$mytz = mysqli_query($conn,"select * from user where id = $id");
		$mytz = mysqli_fetch_assoc($mytz);
        $day = $row['day'];
		?>
		<div class="panel panel">
			<div id="bodyxia" class="panel-body">
				<div class="media">
					<div class="media-left">
						<div id="container">
							<a href="user.php?id=<?php echo $mytz['id'];?>">
								<img id="head" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $mytz['tou'];?>" width="150" height="150">
							</a>
						</div>
					</div>
					<div class="media-body">
						<a href="user.php?id=<?php echo $mytz['id'];?>"><p class="text-primary"><strong><?php echo $mytz['username'];?></strong></p></a>
						<p><span id="jiesao" class="text-muted"><?php echo format_date("$day");?></span></p>
					</div>
						<div id="shil">	
							<a href="msg.php?id=<?php echo $row['id'];?>"><p><?php echo htmlspecialchars($row['content']);?></p></a>		
						</div>
                  		<div id="container">	
						<?php 
						if ($row['upload']!=""){
						?>
							<a href="msg.php?id=<?php echo $row['id'];?>"><img class="lazy img-responsive" src="img/ico/timg.gif" data-original="upload/<?php echo $row['upload'];?>" width="200" height="50%"></a>
						<?php
						}
						?>
                  		</div>
                  
						<?php 
						$lian=$row['lian'];
						if ($lian!=""){
						?>
							<p><span class="label label-success">回复获取资源</span></p>
						<?php
						}
						?>
				</div>
			</div>
          	<table id="bg" class="table">
				<tr>
					<td><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $row['save'];?></td>
					<td><i class="fa fa-comment" aria-hidden="true"></i> <?php echo $row['pid'];?></td>
				</tr>
			</table>
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
	<?php require_once('home.php');?>
</div>


<script>
$('a[data-active="index"]').addClass('active');
</script>