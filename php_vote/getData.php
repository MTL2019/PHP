<?php
include_once 'conn.php';
$sql = "select carName, carNum from carinfo order by carNum desc";
$result = mysqli_query($conn,$sql);
$a['categories'] = array();
$a['data'] = array();
while ($info = mysqli_fetch_array($result)){
    array_push($a['categories'],$info['carName']);//往数组里放数据
    array_push($a['data'],$info['carNum']);
}

echo json_encode($a);//输出数组

