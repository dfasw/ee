<?php 
require_once('php/head.php');
?>

<div id="mian" class="container">
    <div style="max-width: 350px; margin:0 auto;" class="panel panel">
        <div class="panel-body">
            <h4>
                <a data-active="login" class="link" href="login.php">登录</a>
                <a data-active="register" class="link" href="register.php">注册</a>
            </h4>
            <form style="max-width: 350px;" action="php/register.php" method="post" target="fraSubmit">
                <div class="form-group">
                    <input id="fanye" type="text" class="form-control" autocomplete="off" name="username" placeholder="用户名">
                </div>
               	<div class="form-group">
                    	<input id="fanye" type="password" class="form-control" autocomplete="off" name="password" placeholder="密码">
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input id="fanye" type="text" class="form-control" name="verify" placeholder="验证码" autocomplete="off">
                        <span class="input-group-btn">
                            <img src="php/captcha.php"  onclick="this.src='php/captcha.php?'+new Date().getTime();" width="120" height="30">
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <input id="bt" class="btn btn-primary btn-block" type="submit" value="立即注册" >
                </div>
            </form>
        </div>
    </div>
    </div>
  
<script>
$('a[data-active="register"]').addClass('active');
</script>