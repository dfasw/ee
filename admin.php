<?php 
require_once('php/head.php');

if ($admin!="1") {
    echo "<script>location='index.php'</script>";
    exit;
}

?>

<title>网站后台-<?php echo $setup['jiesao'];?></title>
<div id="mian" class="container">
	<div id="col"  class="col-md-9">
		<div class="panel panel">
			<div class="panel-body">
				<div id="page_up" class="page-header">
        			<h4 id="page_zi"><strong>网站后台</strong></h4>
        		</div>
				<form style="max-width: 350px;" method="post" action="admin/admin_setup.php" target="fraSubmit">
					<div class="form-group">
						<input id="sosuo" type="text" class="form-control" name="title" value="<?php echo $setup['title'];?>" autocomplete="off" placeholder="社区名称">
					</div>
					<div class="form-group">
						<input id="sosuo" type="text" class="form-control" name="jiesao" value="<?php echo $setup['jiesao'];?>" autocomplete="off" placeholder="社区介绍">
					</div>
					<div class="form-group">
						<button onclick="return confirm('确定吗？')"  type="submit" class="btn btn-primary btn-sm">确认修改</button>
					</div>
				</form>

				<form style="max-width: 350px;" action="admin/admin_add_node.php" method="post" target="fraSubmit">
                    <div class=" form-group">
                        <input id="sosuo" type="text" class="form-control" name="name" autocomplete="off" placeholder="版块名称">
                    </div>
                    <div class=" form-group">
                        <input id="sosuo" type="text" class="form-control" name="jiesao" autocomplete="off" placeholder="版块介绍">
                    </div>
                    <div class=" form-group">
                    	<button onclick="return confirm('确定吗？')"  type="submit" class="btn btn-primary btn-sm">确认添加</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
	<?php require_once('home.php');?>
</div>

<script>
$('a[data-active="admin"]').addClass('active');
</script>