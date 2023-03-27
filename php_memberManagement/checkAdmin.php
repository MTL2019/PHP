<?php
//首先判断是不是管理员用户
session_start();
//isset函数判断值是否存在
if(!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']){
    //说明isAdmin不存在或存在，但值不为0，即非管理员
    echo "<script>alert('请以管理员身份登录后再访问本页面');location.href='login.php';</script>";
    exit;
}
?>
