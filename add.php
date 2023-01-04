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


$timestamp = $my['day'];
$second = time() - $timestamp; 
$minute = $second / 60;
$yan=round($minute);

if ($yan<5) {
    echo "<script>alert('您已经注册{$yan}分钟, 5分钟观察期内禁止发贴！',top.location='index.php')</script>";
    exit;
}

$uid = $_SESSION['userid'];
$tag=mysqli_query($conn,"select * from tag where uid=$uid");
?>

<title>发布主题-<?php echo $setup['jiesao'];?></title>

<div id="mian" class="container">
<div id="col"  class="col-md-9">
  <div class="panel panel">
    <div class="panel-body">
      <div id="page_up" class="page-header">
        <h4 id="page_zi"><strong>发布主题</strong></h4>
      </div>
      <form method="post" action="php/add.php" enctype="multipart/form-data" name="myform" target="fraSubmit">
                <div style="max-width: 120px;" class="form-group">
                    <select id="sosuo" name="node" class="form-control"> 
          <?php
                    $node = mysqli_query($conn,"select * from node");
          while($row = mysqli_fetch_array($node))
          {
          ?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
          <?php 
          } 
          ?>
                    </select>
        </div>
        <div class="form-group">
          <textarea id="sosuo" class="form-control" rows="5" name="content" style="resize:none"></textarea>
        </div>
                <?php 
                if ($my['jinbi']>1){
                ?>
                <div style="max-width: 400px;">
                <div class="form-group">
                  <a class="btn btn-warning btn-xs" role="button" data-toggle="collapse" data-parent="#accordion" href="#addmsg">设置回复可见</a>
                </div>
                <div id="addmsg" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="form-group">
                    <input id="sosuo" class="form-control" type="text" name="lian" placeholder="设置回复可见内容,留空则不设置">
                  </div>
                  <div class="form-group">
                    <input id="sosuo" class="form-control" type="text" name="jiage"  oninput = "value=value.replace(/[^\d]/g,'')" placeholder="回复所需金币，留空则为免费资源">
                  </div>
                </div>
                </div>
                <?php 
                }
                ?>
        <div class="form-group">
          <a href="javascript:;">
                    <input type="file" id="previewImg" name="img" style="display: none;" onchange="previewImage(this);submitform()" multiple="">
                  </a>
                  <div id="preview"><img id="imghead" onclick="$(&quot;#previewImg&quot;).click()" src="img/ico/photo.png" width="50" height="50" ></div>
              </div>
              
        <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane" aria-hidden="true"></i> 发布主题</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require_once('home.php');?>
</div>

<script>
  //图片上传预览    IE是用了滤镜。
    function previewImage(file)
    {
      var MAXWIDTH  = 50; 
      var MAXHEIGHT = 50;
      var div = document.getElementById('preview');
      if (file.files && file.files[0])
      {
          div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
          var img = document.getElementById('imghead');
          img.onload = function(){
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            img.width  =  rect.width;
            img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
            img.style.marginTop = rect.top+'px';
          }
          var reader = new FileReader();
          reader.onload = function(evt){img.src = evt.target.result;}
          reader.readAsDataURL(file.files[0]);
      }
      else //兼容IE
      {
        var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
        file.select();
        var src = document.selection.createRange().text;
        div.innerHTML = '<img id=imghead>';
        var img = document.getElementById('imghead');
        img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
        div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
      }
    }
    function clacImgZoomParam( maxWidth, maxHeight, width, height ){
        var param = {top:0, left:0, width:width, height:height};
        if( width>maxWidth || height>maxHeight ){
            rateWidth = width / maxWidth;
            rateHeight = height / maxHeight;
            
            if( rateWidth > rateHeight ){
                param.width =  maxWidth;
                param.height = Math.round(height / rateWidth);
            }else{
                param.width = Math.round(width / rateHeight);
                param.height = maxHeight;
            }
        }
        param.left = Math.round((maxWidth - param.width) / 2);
        param.top = Math.round((maxHeight - param.height) / 2);
        return param;
    }
</script>

<script>
$('a[data-active="add"]').addClass('active');
</script>
