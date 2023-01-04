<?php 
session_start();
$id = $_SESSION['userid'];
require_once('../php/conn.php');

$my = mysqli_query($conn,"select * from user where id = $id");
$my = mysqli_fetch_assoc($my);
if ($my['isadmin']!="1") {
    echo "<script>location='index.php'</script>";
    exit;
}

$name=$_POST['name'];
$jiesao=$_POST['jiesao'];

if ($name=="" or $jiesao=="") {
	echo "<script>alert('不能为空',top.location='../node.php')</script>";
	exit;
}else{
	$sql = "insert into node (name,jiesao) values ('{$name}','{$jiesao}')";
	if (mysqli_query($conn,$sql)){
		echo "<script>alert('添加成功！',top.location='../node.php')</script>";
	}
}



$stop=array('滚','去死','妈逼','你妈的','他妈的','他娘的','贱人','婊子','骚逼','骚b','阴道','鸡巴','叼毛','吊毛','骚B','狗比','逼毛','口爆','内射','插逼','强奸','做爱','强奸','犯罪','性爱','颜色','奶子','奶爆','射精','奶爆','欠操','操死你','口爆','卖淫','枪支出售','军火出售','毛片','A片','AV','刮刮乐','代办','黄网','发卡','辅助','外挂','六合彩','卡盟','网赚','啪啪','约炮','彩票','博彩','中国分裂','国家分裂','台独','藏独','政治局','常委','共和国','毛泽东','胡锦涛','江泽明','习近平','李克强','主席','总统','主席','臭逼','蠢逼','杀人','砍人','砍死','枪杀','妓女');

?>