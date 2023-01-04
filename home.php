<div id="col_zuo" class="col-md-3">

<div class="panel panel">
	<div id="bodyxia" class="panel-body">
      	<div class="pull-left"><p>新人报道</p></div>
		<div class="pull-right"><a href="alluser.php"><p>更多 <i class="fa fa-angle-right" aria-hidden="true"></i></p></a></div>
	</div>
	<div class="panel-body">
		<?php 
		$user=mysqli_query($conn,"select * from user order by id desc limit 6");
		while($row = mysqli_fetch_array($user))
		{
		?>
		<div class="media">
			<div class="media-left">
				<div id="container">
					<a href="user.php?id=<?php echo $row['id'];?>">
						<img id="head" class="lazy" src="img/<?php echo $row['tou'];?>" title="<?php echo $row['username'];?>">
					</a>
				</div>
			</div>
			<div class="media-body">
              	<a href="user.php?id=<?php echo $row['id'];?>" title="<?php echo $row['username'];?>"><p class="text-primary"><strong><?php echo $row['username'];?></strong></p></a>
				<span class="text-muted" id="yichu" title="<?php echo $row['jiesao'];?>"><?php echo $row['jiesao'];?></span>
            </div>
        </div>
		<?php 
		}
		?>
	</div>
</div>

  
<div class="panel panel">
	<div class="panel-body">

      	<?php include'php/tonji.php'; ?>
      	<p class="text-muted">主题：<span class="text-primary"><?php echo $msgtj ?></span></p>
      	<p class="text-muted">帖子：<span class="text-primary"><?php echo $replytj ?></span></p>
      	<p class="text-muted">会员：<span class="text-primary"><?php echo $usertj ?></span></p>
    </div>
</div>

<div class="panel panel">
	<div class="panel-body">
		<p>© <?php echo date("Y")?> <?php echo $setup['title'];?> v1.2 </p>
		<p class="text-muted">Powered by <a href="http://hey8.cn">Heybbs</a> <a href="seal.php">小黑屋</a></p>
  </div>
</div>

</div>