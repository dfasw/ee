<?php 
require_once('php/head.php');
$id = $_GET['id'];
$uid = $_SESSION['userid'];

$perNumber=2; 
$url=$_GET['url']; 
$count=mysqli_query($conn,"select count(*) from msg where node=$id");
$rs=mysqli_fetch_array($count);
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber);
if (!isset($url)) {
$url=1;
} 
$startCount=($url-1)*$perNumber;
$tag=mysqli_query($conn,"select * from msg where node=$id order by byday desc limit $startCount,$perNumber");

$tagname = mysqli_query($conn,"select * from node where id = $id");
$tagname = mysqli_fetch_assoc($tagname);

$sql="select * from tag where uid='{$uid}' and tagid ='{$id}'";
$rst= mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($rst);

?>

<title><?php echo $tagname['name'];?>-话题-<?php echo $setup['jiesao'];?></title>

<div id="mian" class="container">
	<div id="col" class="col-md-9">
		<div class="panel panel">
			<div class="panel-body">
				<?php
                if ($admin=="1" ){
                ?>
              	<div id="page_up" class="page-header">
        			<h4 id="page_zi"><strong><a href="node_tag.php?id=<?php echo $tagname['id'];?>"><?php echo $tagname['name'];?></a></strong><small><a style="float: right;" href="#" data-toggle="modal" data-target=".bs-example-modal-sm">修改</a></small></h4>
        		</div>
              	<p><?php echo $tagname['jiesao'];?> </p>
					<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						<div class="modal-dialog modal-sm" role="document">
							<div id="fanye"  class="modal-content">
								<div class="modal-body">
                				<form style="max-width: 350px;" action="admin/admin_xiugai_node.php" method="post" target="fraSubmit">
                                    <div class=" form-group">
                                        <input type="hidden" name="id" value="<?php echo $tagname['id'];?>">
                                        <input id="sosuo" type="text" class="form-control" name="name" placeholder="话题名称" value="<?php echo $tagname['name'];?>" autocomplete="off">
                                    </div>
                                    <div class=" form-group">
                                        <input id="sosuo" type="text" class="form-control" name="jiesao" placeholder="话题介绍" value="<?php echo $tagname['jiesao'];?>" autocomplete="off">
                                    </div>
                                    <div class=" form-group">
                                        <input onclick="return confirm('确定吗？')"  class="btn btn-primary btn-block" type="submit" value="确认修改">
                                      	<a class="btn btn-danger btn-block" target="fraSubmit" onclick="return confirm('确定删除话题吗？')" href="admin/admin_delete_node.php?id=<?php echo $tagname['id'];?>" role="button">删除话题</a>
                                    </div>
                                </form>
								</div>
							</div>
						</div>
					</div>
              	<?php
                }else{
                ?>
				<div id="page_up" class="page-header">
        			<a href="node_tag.php?id=<?php echo $tagname['id'];?>"><h4 id="page_zi" class="text-primary"><strong><?php echo $tagname['name'];?></strong></h4></a>
        		</div>
              	<p><?php echo $tagname['jiesao'];?></p>
              	<?php
                }
                ?>
			</div>
		</div>
		<?php
		while($row = mysqli_fetch_array($tag))
		{
		$uid = $row['uid'];
		$mytz = mysqli_query($conn,"select * from user where id = $uid");
		$mytz = mysqli_fetch_assoc($mytz);
        $day = $row['day'];
		?>
		<div class="panel panel">
			<div id="bodyxia"  class="panel-body">
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
          		<li><a id="fanye" href="node_tag.php?id=<?php echo $id;?>&url=1"><i class="fa fa-step-backward" aria-hidden="true"></i></a><li>
				<li><a id="fanye" href="node_tag.php?id=<?php echo $id;?>&url=<?php echo $url - 1;?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a><li>
				<li><a id="fanye"><?php echo $url;?>/<?php echo $totalPage;?></a></li>
			<?php
			}
			?>
			<?php  
			if ($url<$totalPage){
			?>
				<li><a id="fanye" href="node_tag.php?id=<?php echo $id;?>&url=<?php echo $url + 1;?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a><li>
          		<li><a id="fanye" href="node_tag.php?id=<?php echo $id;?>&url=<?php echo $totalPage;?>"><i class="fa fa-step-forward" aria-hidden="true"></i></a><li>
			<?php
			}
			?>
		</ul>
	</div>
	<?php require_once('home.php');?>
</div>

<script>
$('a[data-active="node"]').addClass('active');
</script>