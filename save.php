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


$id = $_GET['id'];
$uid = $_GET['id'];

$user = mysqli_query($conn,"select * from user where id = $id");
$user = mysqli_fetch_assoc($user);

$usid=$user['id'];
$woid=$my['id'];
$fenid=$user['isadmin'];

$perNumber=20; 
$url=$_GET['url']; 
$count=mysqli_query($conn,"select count(*) from save where uid = $uid");
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber);
if (!isset($url)) {
$url=1;
} 
$startCount=($url-1)*$perNumber;
$save=mysqli_query($conn,"select * from save where uid = $uid order by id desc limit $startCount,$perNumber");
?>

<title><?php echo $user['username'];?>个人主页-<?php echo $setup['jiesao'];?></title>

<div id="mian"class="container">
	<div id="col" class="col-md-9">
		<div style="text-align:center;" id="uptou" class="panel panel">
			<div class="panel-body">
				<div id="container">
                  <a href="save.php?id=<?php echo $user['id'];?>">
                    <img id="dahead" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $user['tou'];?>" >
                  </a>
              </div>			
				<h3><?php echo $user['username'];?></h3>
				<p class="text-muted"><?php echo $user['jiesao'];?></p>
              	<p class="text-muted">
                <i class="fa fa-calendar" aria-hidden="true"></i> 
                <?php
                echo date( "Y-m-d", $user['day'])
                ?>
                </p>
              
                <?php
				if(isset($_SESSION['userid'])){
                if($usid!=$woid){
		        ?>
				<ul class="pager">
                  	<li><a href="#" id="sosuo" data-toggle="modal" data-target=".bs-example-modal-sm">发消息</a></li>
					<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-sm" role="document">
							<div id="fanye"  class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">发送给<?php echo $user['username'];?></h4>
								</div>
								<div class="modal-body">
									<form  action="php/letter.php" method="post" target="fraSubmit">
										<div class="form-group">
											<input type="hidden" name="id" value="<?php echo $user['id'];?>">
											<textarea id="sosuo" class="form-control" rows="5" name="reply" style="resize:none" ></textarea>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block">发送消息</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</ul>
				<?php
		      	}
                }
				?>
			</div>
          	<a data-active="user" class="link" href="user.php?id=<?php echo $id ?>">主题</a>
            <a data-active="user_reply" class="link" href="user_reply.php?id=<?php echo $id ?>">帖子</a>
            <a data-active="save" class="link" href="save.php?id=<?php echo $id ?>">喜欢</a>
		</div>
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
		while($row = mysqli_fetch_array($save))
		{
		$tid = $row['tid'];
		$msg = mysqli_query($conn,"select * from msg where id = $tid");
		$msg = mysqli_fetch_assoc($msg);

		$uid = $msg['uid'];
		$user = mysqli_query($conn,"select * from user where id = $uid");
		$user = mysqli_fetch_assoc($user);
		$day = $user['day'];
		?>
		<div class="panel panel">
			<div id="bodyxia" class="panel-body">
				<div class="media">
					<div class="media-left">
						<a href="user.php?id=<?php echo $user['id'];?>">
							<img id="head" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $user['tou'];?>" width="150" height="150">
						</a>
					</div>
					<div class="media-body">
						<a href="user.php?id=<?php echo $user['id'];?>"><p class="text-primary"><strong><?php echo $user['username'];?></strong></p></a>
						<p><span id="yichu" class="text-muted"><?php echo format_date("$day");?></span></p>
					</div>
					<div id="shil">	
                      	<a href="msg.php?id=<?php echo $msg['id'];?>"><p><?php echo htmlspecialchars($msg['content']);?></p></a>
					</div>
						<?php 
						if ($msg['upload']!=""){
						?>
							<a href="msg.php?id=<?php echo $msg['id'];?>"><img class="lazy img-responsive" src="img/ico/timg.gif" data-original="upload/<?php echo $msg['upload'];?>" width="200" ></a>
						<?php
						}
						?>
				</div>
			</div>
			<table id="bg" class="table">
				<tr>
					<td title="喜欢"><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $msg['save'];?></td>
                  	<td title="评论"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo $msg['pid'];?></td>
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
$('a[data-active="save"]').addClass('active');
</script>