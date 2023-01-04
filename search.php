<?php
require_once('php/head.php');
if (!$_SESSION['userid']) {
    echo "<script>location='login.php'</script>";
    exit;
}


?>

<title>搜索主题-<?php echo $setup['jiesao'];?></title>

<div id="mian" class="container">
	<div id="col" class="col-md-9">
	<form action="search.php">
	<?php 
	$sosuo = $_GET['sosuo'];
	if ($sosuo==""){
	$sui=mysqli_query($conn,"select * from msg order by rand() limit 3");
	?>
	<div class="panel panel">
		<div class="panel-body">
			<div class="input-group">
				<input id="sosuo" type="text" class="form-control" name="sosuo" placeholder="搜索帖子关键词" >
				<span class="input-group-btn">
        			<button id="sosuo" class="btn btn-default" type="submit">搜索</button>
      			</span>
			</div>
		</div>
	</div>
	
	<?php
	}else{

	$perNumber=20; 
	$url=$_GET['url']; 
	$count=mysqli_query($conn,"select count(*) from msg where content like '%$sosuo%'");
	$rs=mysqli_fetch_array($count);
	$totalNumber=$rs[0];
	$totalPage=ceil($totalNumber/$perNumber);
	if (!isset($url)) {
	$url=1;
	} 
	$startCount=($url-1)*$perNumber;
	$soso=mysqli_query($conn,"select * from msg where content like '%$sosuo%' limit $startCount,$perNumber");
	?>
		<div class="panel panel">
			<div class="panel-body">	
				<div class="input-group">
				<input  id="sosuo" type="text" class="form-control" name="sosuo" value="<?php echo $sosuo;?>">
					<span class="input-group-btn">
	        			<button id="sosuo" class="btn btn-default" type="submit">搜索</button>
	      			</span>
      			</div>
				<h4>找到 <?php echo $totalNumber;?> 条内容</h4>
			</div>
		</div>

		<?php
		while($row = mysqli_fetch_array($soso))
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
						<p><span id="jiesao" class="text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo format_date("$day");?></span></p>
					</div>
						<div id="shil">		
							<a href="msg.php?id=<?php echo $row['id'];?>"><p><?php echo htmlspecialchars($row['content']);?></p></a>	
						</div>
						<div id="container">					
						<?php 
						$upload=$row['upload'];
						if ($upload!=""){
						?>
                          	<a href="msg.php?id=<?php echo $row['id'];?>"><img class="lazy img-responsive" src="img/ico/timg.gif" data-original="upload/<?php echo $row['upload'];?>" width="200"></a>
						<?php
						}
						?>
						</div>
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
          		<li><a id="fanye" href="search.php?sosuo=<?php echo $sosuo;?>&url=1"><i class="fa fa-step-backward" aria-hidden="true"></i></a><li>
				<li><a id="fanye" href="search.php?sosuo=<?php echo $sosuo;?>&url=<?php echo $url - 1;?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a><li>
				<li><a id="fanye"><?php echo $url;?>/<?php echo $totalPage;?></a></li>
			<?php
			}
			?>
			<?php  
			if ($url<$totalPage){
			?>
				<li><a id="fanye" href="search.php?sosuo=<?php echo $sosuo;?>&url=<?php echo $url + 1;?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a><li>
          		<li><a id="fanye" href="search.php?sosuo=<?php echo $sosuo;?>&url=<?php echo $totalPage;?>"><i class="fa fa-step-forward" aria-hidden="true"></i></a><li>
			<?php
			}
			?>
		</ul>

	<?php
	}
	?>
	</form>
	</div>
	<?php require_once('home.php');?>
</div>

<script>
$('a[data-active="search"]').addClass('active');
</script>