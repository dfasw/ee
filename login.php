<?php 
require_once('php/head.php');
?>

<div id="mian" class="container">
        <div style="max-width: 350px; margin:0 auto; " class="panel panel">
            <div class="panel-body">
                <form action="php/login.php" method="post" name="myform" target="fraSubmit">
                    <h4>
                      	<a data-active="login" class="link" href="login.php">登录</a>
                        <a data-active="register" class="link" href="register.php">注册</a>
                    </h4>
                  	<div class="form-group">
                      <input id="fanye" type="text" class="form-control" name="username" placeholder="用户名">
                    </div>
                  	<div class="form-group">
                      <input id="fanye" type="password" class="form-control" name="password" placeholder="密码">
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
                        <input  class="btn btn-primary btn-block" type="submit" value="立即登录" >
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
$('a[data-active="login"]').addClass('active');
</script>