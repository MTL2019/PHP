<?php
session_start();//开始session，位于页面输出之前

$username = trim($_POST['username']);
$pw = trim($_POST['pw']);

//获取提交的验证码
$code = $_POST['code'];
//判断验证码是否正确；一般输入的验证码部分大小写，所以对比时要统一转换为大写或小写，然后对比
if (strtolower($_SESSION['captcha']) == strtolower($code)){
    $_SESSION['captcha'] = '';//验证码正确，验证码只能使用一次

}else{
    $_SESSION['captcha'] = '';
    echo "<script>alert('验证码错误');location.href='login.php?id=3';</script>";//history.back();程序后退一步
    exit;//退出程序
}

//数据验证
if(!strlen($username) || !strlen($pw)){
    echo "<script>alert('用户名和密码都不能为空');history.back();</script>";//history.back();程序后退一步
    exit;//退出程序
}else{
    if(!preg_match('/^[a-zA-Z0-9]{3,10}$/',$username)){
        echo "<script>alert('用户名必填，且只能大小写、字符和数字，长度为3-10个字符');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }
    if(!preg_match('/^[a-zA-Z0-9_*]{6,10}$/',$pw)) {
        echo "<script>alert('密码必填，且只能大小写、字符和数字、*号，长度为6-10个字符');history.back();</script>";//history.back();程序后退一步
        exit;//退出程序
    }
}

include_once "conn.php";
$sql = "select * from userinfo where username = '$username' && pw = '" . md5($pw) . "'";//用MD5加密，便于后面与数据库比对
$result = mysqli_query($conn,$sql);
$num = mysqli_num_rows($result);
if($num){
    $_SESSION['loggedUsername'] = $username;
    //增加管理员的判断
    $info = mysqli_fetch_array($result);
    $_SESSION['loggedUserID'] = $info['id'];//保存ID，vote中使用
    if($info['admin']){
        $_SESSION['isAdmin'] = 1;// 1 表示 是管理员
    }else{
        $_SESSION['isAdmin'] = 0;// 0 表示 是管理员
    }
    echo "<script>alert('登录成功');window.parent.location.reload()</script>";//刷新页面

}else{
    unset($_SESSION['loggedUsername']);//销毁该session name; insert()查询
    unset($_SESSION['isAdmin']);//销毁该session name; insert()查询
    //session_destroy();//销毁所有session
    echo "<script>alert('登录失败');window.parent.closeLayer()</script>";
}
