<?php 
require_once('php/head.php');

if ($my['isadmin']=="2") {
  	echo "<script>alert('对不起，您的账号存在异常！',top.location='index.php')</script>";
    exit;
}

$id = $_GET['id'];
$msg= mysqli_query($conn,"select * from msg where id=$id");
$msg = mysqli_fetch_assoc($msg);

$uid = $msg['uid'];
$mys = mysqli_query($conn,"select * from user where id = $uid");
$mys = mysqli_fetch_assoc($mys);

$nodeid=$msg['node'];
$node = mysqli_query($conn,"select * from node where id = $nodeid");
$node = mysqli_fetch_assoc($node);

$zid=$mys['id'];
$mid=$my['id'];
$day = $msg['day'];


if ($msg['content']==""){
  echo "<script>location='404.php'</script>";
}

$biaoti=mb_substr(strip_tags($msg['content']),0,40,utf8);
?>

<title><?php echo $biaoti;?>-<?php echo $setup['jiesao'];?></title>

<link rel="stylesheet" href="css/viewer.min.css">
<div id="mian" class="container">
	<div id="col" class="col-md-9">
		<div class="panel panel">
			<div class="panel-body">
				<div class="media">
                  <div class="page-header">
						<div class="media-left">
							<a href="user.php?id=<?php echo $mys['id'];?>"><img id="head" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $mys['tou'];?>" width="150" height="150"></a>
						</div>
						<div class="media-body">
                          	<a href="user.php?id=<?php echo $mys['id'];?>"><p class="text-primary"><strong><?php echo $mys['username'];?></strong></p></a>
                          	<p id="yichu"  class="text-muted"><a class="text-muted" href="node_tag.php?id=<?php echo $node['id'];?>"><?php echo $node['name'];?></a> | <?php echo date( "Y-m-d H:i", $day);?> </p>
						</div>
                    </div>
					<h4><?php echo htmlspecialchars($msg['content']);?></h4>
					<?php 
					if ($msg['upload']!=""){
					?>
					<ul id="jqhtml">
						<li>
							<img class="lazy"  data-original="upload/<?php echo $msg['upload'];?>" src="upload/<?php echo $msg['upload'];?>">
						</li>
					</ul>
					<?php
					}
					?>

					<?php 
					if ($msg['lian']!=""){
						if ($zid==$mid) {
							$lian=$msg['lian'];
							echo "<div class='alert alert-warning'><p id='link'>$lian</p></div>";
						}else{
							$sql="select * from reply where tid='{$id}' and uid ='{$mid}'";
							$rst= mysqli_query($conn,$sql);
							$row=mysqli_fetch_assoc($rst);
							if ($row) {
								$lian=$msg['lian'];
								echo "<div class='alert alert-warning'><p id='link'>$lian</p></div>";
							}else{
								$jiage=$msg['jiage'];
								echo "<div class='alert alert-warning'><i class='fa fa-exclamation-triangle'></i> 主题含有隐藏资源，回复所需 $jiage 金币</div>";
							}
						}
					}
					?>

                  	<hr>
                  
                    <h2>
                    <?php
                    $like = mysqli_query($conn,"select * from save where tid = $id");
                    while($row = mysqli_fetch_array($like))
                    {
                    $uid = $row['uid'];
					$shou = mysqli_query($conn,"select * from user where id = $uid");
					$shou = mysqli_fetch_assoc($shou);
                    ?>
						<a title="<?php echo $shou['username'];?>" href="user.php?id=<?php echo $shou['id'];?>"><img id="xhead" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $shou['tou'];?>"></a>	
                    <?php
                    }
                    ?>
                    </h2>

					<?php 
	    			if(isset($_SESSION['userid'])){
	    			?>
					<ul class="pager">
					<?php 
					if ($zid==$mid){
					?>
						<li><a id="sosuo" target="fraSubmit" onclick="return confirm('确定删除帖子吗？')" href="php/msg_delete.php?id=<?php echo $msg['id'];?>"> 删除</a><li>
					<?php
					}else{
					?>

					<?php 
					$uid = $_SESSION['userid'];//收藏
					$sql="select * from save where tid='{$id}' and uid ='{$uid}'";
					$rst= mysqli_query($conn,$sql);
					$row=mysqli_fetch_assoc($rst);
					if (!$row){
					?>
						<li><a id="save" href="javascript:void(0)" >喜欢</a></li>
					<?php 
					}else{
					?>
						<li><a id="save" href="javascript:void(0)" >已喜欢</a></li>
					<?php 
					}//收藏
					?>
						<li><a id="sosuo" href="#din" >回复</a></li>


					<?php 
					if ($admin=="1" and $mid=="1"){
					?>
						<li><a id="sosuo" target="fraSubmit" onclick="return confirm('确定删除帖子吗？')" href="admin/admin_delete.php?id=<?php echo $msg['id'];?>"> 删除</a><li>
					<?php
					}
					?>
					<?php
					}
					?>
					</ul>
                  
					<?php 
                    }
	    			?>
				</div>
			</div>
		</div>

		<div class="panel panel">
			<div class="panel-body">
			<h4>最新回复（<?php echo $msg['pid'];?>）</h4>
			<?php  
			if ($msg['pid']=="0"){
			?>
				<div id="kon"></div>
			<?php
			}
			?>
			<?php
			$reply= mysqli_query($conn,"select * from reply where tid=$id order by day asc");
			while($row = mysqli_fetch_array($reply))
			{
			$uid = $row['uid'];
			$uid = mysqli_query($conn,"select * from user where id = $uid");
			$uid = mysqli_fetch_assoc($uid);
            $days = $row['day'];
			?>
				<div id="" class="page-header">
					<div class="media-left">
						<a href="user.php?id=<?php echo $uid['id'];?>"><img id="head" class="lazy" src="img/ico/timg.gif" data-original="img/<?php echo $uid['tou'];?>" width="150" height="150"></a>
					</div>
					<div  class="media-body">
                      	<a href="user.php?id=<?php echo $uid['id'];?>"><p class="text-primary"><strong><?php echo $uid['username'];?></strong></p></a>
						<?php 
						$zid= $row['zid'];
						$znr= $row['znr'];
						if ($znr!=""){
						$zid = mysqli_query($conn,"select * from user where id = $zid");
						$zid = mysqli_fetch_assoc($zid);	
						$znr = mysqli_query($conn,"select * from reply where id = $znr");
						$znr = mysqli_fetch_assoc($znr);	
						?>
						<p id="link"><?php echo htmlspecialchars($row['reply']);?></p>
						<div class="well well-sm">
							<p><a class="text-primary" href="user.php?id=<?php echo $zid['id'];?>"><img id="xhead" src="img/<?php echo $zid['tou'];?>">  <strong><?php echo $zid['username'];?></strong></a>:<?php echo htmlspecialchars($znr['reply'])?></p>
						</div>
							
						<?php	
						}else{
						?>
							<p id="link"><?php echo htmlspecialchars($row['reply']);?></p>
						<?php 			
						}
						?>
						<div class="pull-left">
							<span class="text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo format_date("$days");?></span> 
						</div>

                        <?php
                      	if(isset($_SESSION['userid'])){
                        $nameid=$uid['id'];
                        $myid=$my['id'];
                        if ($nameid!=$myid){
                        ?>
                        	<div class="pull-right">
                            	<a class="text-muted" href="#din" onclick="document.getElementById('aa').value='<?php echo $uid['id'];?>';document.getElementById('bb').value='<?php echo $row['id'];?>';document.getElementById('din').placeholder='<?php echo '回复 '.$uid['username'];?>'"><i class="fa fa-comment-o" aria-hidden="true"></i> 回复</a>
                            </div>
                        <?php
                        }
                        }
                        ?>

				        <?php 
						if ($admin=="1"){
						?>
							<a target="fraSubmit" onclick="return confirm('确定删除评论吗？')" href="admin/admin_delete_hui.php?id=<?php echo $row['id'];?>&tid=<?php echo $msg['id'];?>"> &nbsp; <span class="text-muted">删除</span></h5>
						<?php
						}
						?>
						
					</div>
				</div>
			<?php
			}
			?>
			<?php 
	    	if(isset($_SESSION['userid'])){
	    	?>
            <a id="di"></a>
			<form  method="post" action="php/reply.php" name="myform" target="fraSubmit">
		        <div class="form-group">
		        	<input type="hidden" name="id" value="<?php echo $id;?>">
		        	<input type="hidden" id="aa" name="zid" value="<?php echo $mys['id'];?>">
		        	<input type="hidden" id="bb" name="znr" value="">
		        </div>
		        <div  class="form-group">
		        	<textarea id="din" class="form-control" name="reply" style="resize:none" placeholder=""></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> 回复</button>
				</div>
			</form>
			<?php 
	    	}
	    	?>
			</div>
		</div>
	</div>
	<?php require_once('home.php');?>
</div>

<script src="js/viewer.min.js"></script> 
<script>
var viewer = new Viewer(document.getElementById('jqhtml'), {
	url: 'data-original'
});
</script>

<script>
	$("#save").click(function(){
    $.ajax({
        url: "php/save.php?id=<?php echo $id?>",
        type: "POST",
        success: function (data) {
        $("#save").text(data);
    	}
    });
});
</script>


<script>
$('a[data-active="<?php echo $msg['node'];?>"]').addClass('active');
</script>