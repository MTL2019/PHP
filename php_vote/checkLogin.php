<?php
//首先判断是不是登录了
session_start();
//isset函数判断值是否存在
if(!isset($_SESSION['loggedUsername']) || !$_SESSION['loggedUsername']){

    echo "<script>alert('请登录后再访问本页面');location.href='login.php';</script>";
    exit;
}
?>
