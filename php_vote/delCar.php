<?php
include_once 'checkAdmin.php';
$id = $_GET['id'] ?? 0;
include_once 'conn.php';

$sql = "delete from carinfo where id=$id";
$result = mysqli_query($conn,$sql);
if ($result){
    echo "<script>alert('删除成功');location.href='admin.php';</script>";

}else{
    echo "<script>alert('删除失败');history.back();</script>";
}
