<?php
require_once('php/head.php');
if ($my['isadmin']=="2") {
  	echo "<script>alert('对不起，您的账号存在异常！',top.location='index.php')</script>";
    exit;
}
$id = $_GET['id'];
$user = mysqli_query($conn,"select * from user where id = $id");
$user = mysqli_fetch_assoc($user);

$usid=$user['id'];
$woid=$my['id'];
$fenid=$user['isadmin'];

$perNumber=20; 
$url=$_GET['url']; 
$count=mysqli_query($conn,"select count(*) from reply where uid = $id"); 
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); 
if (!isset($url)) {
$url=1;
}
$startCount=($url-1)*$perNumber;
$myreply=mysqli_query($conn,"select * from reply where uid = $id order by id desc limit $startCount,$perNumber");
$day = $user['qd'];

$mytie=mysqli_query($conn,"select count(1) from msg where uid=$id");
$rs=mysqli_fetch_array($mytie);
$mytie=$rs[0];

if ($user['username']==""){
  echo "<script>location='404.php'</script>";
}

?>

<title><?php echo $user['username'];?>个人主页-<?php echo $setup['jiesao'];?></title>

<div id="mian" class="container">
	<div id="col" class="col-md-9">
		<div style="text-align:center;" class="panel panel">
			<div class="panel-body">
				<div id="container">
                  <a href="user_reply.php?id=<?php echo $user['id'];?>">
                    <img id="dahead" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $user['tou'];?>" width="150" height="150">
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
		if ($admin=="1" and $woid=="1"){
		?>
		<div class="panel panel">
			<div class="panel-body">
              	<p><?php echo '金币：'.$user['jinbi'];?></p>
	          	<div class="pull-left">
          		<?php 
                if ($user['isadmin']=="2"){
                ?>
                    <p class="label label-danger">账号已封</p>
                <?php 
                }else{
                ?>
              		<p class="label label-success">账号正常</p>
              	<?php 
                }
                ?>
	            </div>
	          	<div class="pull-right">
				<?php 
	          	if ($fenid!="1"){
				if ($fenid=="0"){
				?>
					<a class="a-upload" href="admin/admin_user.php?id=<?php echo $user['id'];?>" onclick="return confirm('确定封号吗？')" target="fraSubmit">封号</a>
				<?php
				}else{
				?>
	      			<a class="a-upload" href="admin/admin_user.php?id=<?php echo $user['id'];?>" onclick="return confirm('确定解封吗？')" target="fraSubmit">解封</a>
				<?php
				}
	            }
				?>
	            </div>
      		</div>
     	</div>
		<?php
		}
		?> 
		
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
		while($row = mysqli_fetch_array($myreply))
		{
        $day = $row['day'];
        $tid = $row['tid'];
        $msg= mysqli_query($conn,"select * from msg where id=$tid");
		$msg = mysqli_fetch_assoc($msg);
		?>
		<div onclick="window.open('msg.php?id=<?php echo $row['tid'];?>','_self')" id="panel" class="panel panel">
			<div id="bodyxia" class="panel-body">
				<div class="media">
					<div class="media-left">
						<div id="container">
							<a href="user.php?id=<?php echo $user['id'];?>">
								<img id="head" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $user['tou'];?>" width="150" height="150">
							</a>
						</div>
					</div>
					<div class="media-body">
						<a href="user.php?id=<?php echo $user['id'];?>"><p class="text-primary"><strong><?php echo $user['username'];?></strong></p></a>
						<p><span id="jiesao" class="text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo format_date("$day");?></span></p>
					</div>
                  	<div id="shil">		
						<p style="margin-top:10px;"><?php echo htmlspecialchars($row['reply']);?></p>
					</div>
                  	<div class="well well-sm"><p><?php echo htmlspecialchars($msg['content']); ?></p></div>
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
          		<li><a id="fanye" href="user_reply.php?id=<?php echo $usid;?>&url=1"><i class="fa fa-step-backward" aria-hidden="true"></i></a><li>
				<li><a id="fanye" href="user_reply.php?id=<?php echo $usid;?>&url=<?php echo $url - 1;?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a><li>
				<li><a id="fanye"><?php echo $url;?>/<?php echo $totalPage;?></a></li>
			<?php
			}
			?>
			<?php  
			if ($url<$totalPage){
			?>
				<li><a id="fanye" href="user_reply.php?id=<?php echo $usid;?>&url=<?php echo $url + 1;?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a><li>
          		<li><a id="fanye" href="user_reply.php?id=<?php echo $usid;?>&url=<?php echo $totalPage;?>"><i class="fa fa-step-forward" aria-hidden="true"></i></a><li>
			<?php
			}
			?>
		</ul>
	</div>
	<?php require_once('home.php');?>
</div>

<script>
$('a[data-active="user_reply"]').addClass('active');
</script>