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
?>

<title>个人设置-<?php echo $setup['jiesao'];?></title>

<div id="mian" class="container">
	<div id="col" class="col-md-9">
		<div class="panel panel">
			<div class="panel-body">
				<div id="page_up" class="page-header">
        			<h4 id="page_zi"><strong>个人设置</strong></h4>
        		</div>

					<form name="form01" method="post" enctype= "multipart/form-data" target="fraSubmit">
						<div class="form-group">
							<img id="head" class="img-rounded" src="img/<?php echo $my['tou'];?>">
						</div>
						<div class="form-group">
							<a href="javascript:;" class="a-upload">
								<input type= "file" name="img" onchange="submitform()">更换头像
							</a>
							<a class="a-upload" href="#" onclick="test()">切换主题</a>
						</div>
					</form>

					<form style="max-width: 350px;" method="post" action="php/name_xiugai.php" target="fraSubmit">
						<div class=" form-group">
							<label class="text-muted">用户名修改：（500金币一次）</label>
							<input id="sosuo" type="text" class="form-control" name="username" value="<?php echo $my['username'];?>" autocomplete="off">
	                    </div>
	                    <div class="form-group">
                          	<button  type="submit" class="btn btn-primary btn-sm" onclick="return confirm('用户名修改一次扣除500金币，确定修改吗？')">确认修改</button>
                     	</div>
					</form>


	                <form style="max-width: 350px;" method="post" action="php/setup.php" target="fraSubmit">
	                    <div class="form-group">
	                    	<label class="text-muted">个人介绍：</label>
	                        <textarea id="sosuo" class="form-control" name="jiesao" style="resize:none" onkeyup="this.value=this.value.replace(/[</>]/g, '');"><?php echo $my['jiesao'];?></textarea>
	                    </div>
	                    <div class="form-group">
                          	<button type="submit" class="btn btn-primary btn-sm">确认修改</button>
                     	</div>
	                </form>
                	<h4><label for="exampleInputEmail1">修改密码</label></h4>
	                <form style="max-width: 350px;" id="myform" method="post" action="php/pass.php" target="fraSubmit">
	                    <div class=" form-group">
	                        <input id="sosuo" type="password" class="form-control" autocomplete="off" name="password" placeholder="新密码">
	                    </div>
	                    <div class=" form-group">
	                        <input id="sosuo" type="password" class="form-control" autocomplete="off" name="rpassword" placeholder="确认密码">
	                    </div>
	                    <div class="form-group">
	                        <button type="submit" class="btn btn-primary btn-sm">确认修改</button>
	                    </div>
	                </form>

			</div>
		</div>
	</div>
	<?php require_once('home.php');?>


<script>
$('a[data-active="setup"]').addClass('active');
</script>

<script>   
    function submitform(){   
        document.form01.action="php/tou.php";   
        document.form01.submit();   
    }  
</script> 
