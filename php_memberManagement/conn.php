<?php
//////////////////////公共代码，数据库连接部分
//1. 连接数据到服务器
$conn = mysqli_connect("localhost","root","root","member");
if(!$conn){
    //连接失败
    die("连接数据库失败");
}
//else{
//    //连接成功
//    echo "连接数据库成功";
//}
//2. 设置字符集
mysqli_query($conn,"set names utf8");
