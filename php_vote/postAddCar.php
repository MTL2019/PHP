<?php
$carName = $_POST['carName'];
$carDesc = $_POST['carDesc'];
//print_r($_FILES['carPic']['error']);
$fileName = '';
//第1步： 判断图片上传是否有错
if ($_FILES['carPic']['error']){
    echo "<script>alert('图片上传错误');history.back();</script>";
    exit;
}

//第2 步： 判断文件格式以及大小是否正确
if (!empty($_FILES['carPic']['name'])){
    //说明有上传图片
    if ($_FILES['carPic']['size'] > 2048*1024){
        echo "<script>alert('图片文件大小不能超过2MB');history.back();</script>";
        exit;
    }
    //接下来判断文件格式
    $allowPicType = array("image/gif","image/pjpeg","image/jpeg","image/jpg","image/png");
    if (!in_array($_FILES['carPic']['type'],$allowPicType)){
        echo "<script>alert('图片类型错误，只能是jpg,png,gif图片');history.back();</script>";
        exit;
    }
    //接下来判断文件扩展名
    $allowPicExt = array("gif","jpeg","jpg","png");
    $nameArray = explode(".",$_FILES['carPic']['name']);//将文件名以点好分隔，取扩展名部分
    $nameExt = end($nameArray);
    if (!in_array(strtolower($nameExt),$allowPicExt)){
        echo "<script>alert('图片文件扩展名错误，只能是jpg,jpeg,png,gif图片');history.back();</script>";
        exit;
    }
    //保存上传的文件
    $fileName = uniqid() . "." .$nameExt;
    $result = move_uploaded_file($_FILES['carPic']['tmp_name'],"img/".$fileName);
    if (!$result){
        //说明保存文件出错
        echo "<script>alert('保存文件出错');history.back();</script>";
        exit;
    }
}

//第3步： 写入数据库
include_once 'conn.php';
$sql = "insert into carinfo(carName, carDesc, carPic,carNum) VALUES ('$carName','$carDesc','$fileName','0')";
$result = mysqli_query($conn,$sql);
if ($result){
    echo "<script>alert('车辆添加成功');location.href='admin.php';</script>";

}else{
    echo "<script>alert('车辆添加失败');history.back();</script>";
}
