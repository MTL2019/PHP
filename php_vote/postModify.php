<?php
header("Content-Type:text/html;charset=utf-8"); //指定字符集,注意！ :前后没有空格
//后端获取前端的数据，使用全局数组$_POST 、 $_GET
$username = trim($_POST['username']);
$pw = trim($_POST['pw']);
$cpw = trim($_POST['cpw']);
$email = $_POST['email'];

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

//3. 进行必要的表单后台验证
if(!strlen($username) ){
    echo "<script>alert('用户名不能为空');history.back();</script>";//history.back();程序后退一步
    exit;//退出程序
}else{
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$username)){
        echo "<script>alert('用户名必填，且只能大小写、字符和数字，长度为3-10个字符');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }
}

if(!empty($pw)){
    if($pw <> $cpw){
        echo "<script>alert('密码和确认密码必须相同');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }else{
        if(!preg_match('/^[a-zA-Z0-9_*]{6,10}$/',$pw)){
            echo "<script>alert('密码必填，且只能大小写、字符和数字、*号，长度为6-10个字符');history.back();</script>";//history.back();程序后退一步
            exit;//退出程序
        }
    }
}

if(!empty($email)){
    if(!preg_match('/^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/',$email)){
        echo "<script>alert('邮箱格式错误');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }
}

include_once "conn.php";//把公共代码引入，避免重复

if($pw){
    //说明有填写密码，则需要更新密码
    $sql = "update userinfo set pw= '" . md5($pw) . "', email = '$email' where username = '$username'";
    $url = 'logout.php';//销毁session后跳转到index.php
}else{
    //说明没有填写密码，则不需要更新密码
    $sql = "update userinfo set email = '$email'  where username = '$username'";

}
$result = mysqli_query($conn,$sql);

if($result){
    echo "<script>alert('更新个人资料成功');window.parent.closeLayer();</script>";
}else{
    echo "<script>alert('更新个人资料失败');history.back();</script>";
}
