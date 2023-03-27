<?php
header("Content-Type:text/html;charset=utf-8"); //指定字符集,注意！ :前后没有空格
//后端获取前端的数据，使用全局数组$_POST 、 $_GET
$username = trim($_POST['username']);
$pw = trim($_POST['pw']);
$cpw = trim($_POST['cpw']);
$sex = $_POST['sex'];
$email = $_POST['email'];

if(isset($_POST['fav'])){
    $fav = implode(",",$_POST['fav']);//如果兴趣为空，会出错，再修改******************************
}else{
    $fav = '';
}

///////////////演示打印到屏幕
//echo "您输入的内容是：" . $username . "<br>";//.号是连接符
//echo "您输入的密码是：{$pw} <br>";//"可以直接放变量"
//echo "您输入的确认密码是：$cpw <br>";//"可以直接放变量"
//echo "您选择的性别是：";
//echo $sex == 1 ? '男' : '女' . "<br>";//"可以直接放变量"
//echo "您选择的爱好有：";
////print_r($fav);//调试时使用打印数组
//$fav = implode(",",$fav);//将数组元素转换成string,以,分隔
//echo $fav;

include_once "conn.php";//把公共代码引入，避免重复

//3. 进行必要的表单后台验证
if(!strlen($username) || !strlen($pw)){
    echo "<script>alert('用户名和密码都不能为空');history.back();</script>";//history.back();程序后退一步
    exit;//退出程序
}else{
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$username)){
        echo "<script>alert('用户名必填，且只能大小写、字符和数字，长度为3-10个字符');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }
}
if($pw <> $cpw){
    echo "<script>alert('密码和确认密码必须相同');history.back();</script>";//history.back();程序后退一步
    exit;//退出程序
}else{
    if(!preg_match('/^[a-zA-Z0-9_*]{6,10}$/',$pw)){
        echo "<script>alert('密码必填，且只能大小写、字符和数字、*号，长度为6-10个字符');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }
}
if(!empty($email)){
    if(!preg_match('/^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/',$email)){
        echo "<script>alert('邮箱格式错误');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }
}
//判断用户名是否已占用
$sql = "select * from info where username = '$username'";
$result = mysqli_query($conn,$sql); //返回查询记录集
$num = mysqli_num_rows($result);//行数
if($num){
    echo "<script>alert('此用户名已存在，请返回重新输入');history.back();</script>";//history.back();程序后退一步
    exit;//退出程序
}

// sql语句
$sql = "insert into info(username,pw,sex,email,fav,creatTime) values('$username','" . md5($pw) ."','$sex','$email','$fav','" . time() . "')";
$result = mysqli_query($conn,$sql);

if($result){
    echo "<script>alert('数据插入成功');location.href='index.php';</script>";
}else{
    echo "<script>alert('数据插入失败');history.back()</script>";
}



