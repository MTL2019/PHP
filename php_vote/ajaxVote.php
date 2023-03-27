<?php
session_start();

$a = array();
if(!isset($_SESSION['loggedUsername']) || !$_SESSION['loggedUsername']){
    $a['error'] = 1;
    $a['errMsg'] = '请登录后再访问本页面';
    echo json_encode($a);//输出json对象
    exit;
}

include_once 'conn.php';
$id = $_GET['id'] ?? '';
//判断ID参数是否正确
if (!is_numeric($id) || $id == ''){
    $a['error'] = 1;
    $a['errMsg'] = '车辆ID参数错误';
    echo json_encode($a);//输出json对象
    exit;
}

//判断验证码是否正确
$code = $_GET['code'];//用户提交的验证码
if (strtolower($_SESSION['captcha']) == strtolower($code) and !empty($code)){
    $_SESSION['captcha'] = '';//验证码正确，验证码只能使用一次
}else{
    $_SESSION['captcha'] = '';
    $a['error'] = 1;
    $a['errMsg'] = '验证码错误';
    echo json_encode($a);//输出json对象
    exit;
}


//投票条件判断： 每人每天只能给一辆车最多投5票
//第1个条件：
//$sql = "select * from votedetail where userID = ". $_SESSION['loggedUserID']. " and carID=$id and voteTime = '". date("Y-m-d") . "'";
//$result = mysqli_query($conn,$sql);
//$num = mysqli_num_rows($result);
//if($num == 5){
//    //说明当前用户已投过5票
//    echo "<script>alert('当前用户给当前车辆已投过5票了');history.back()</script>";
//    exit;
//}
//第2种办法: 使用聚合函数
//第1个条件：每人每天只能给一辆车最多投5票
$sql = "select count(1) as num from votedetail where userID = ". $_SESSION['loggedUserID']. " and carID=$id and FROM_UNIXTIME(voteTime,'%Y-%m-%d') = '". date("Y-m-d") . "'";
$result = mysqli_query($conn,$sql);
$info = mysqli_fetch_array($result);
if($info['num'] == 5){
    //说明当前用户已投过5票
    $a['error'] = 1;
    $a['errMsg'] = '当前用户给当前车辆已投过5票了';
    echo json_encode($a);//输出json对象
    exit;
}
//第2个条件： 每人每天只能给3辆车投票
$sql = "select count(carID) as num from votedetail where userID = ". $_SESSION['loggedUserID']. "  and FROM_UNIXTIME(voteTime,'%Y-%m-%d')  = '". date("Y-m-d") . "' and carID <> $id group by carID";
$result = mysqli_query($conn,$sql);
$num = mysqli_num_rows($result);
if($num >= 3){
    //排除当前投票车辆，说明是在给第4辆车投票了
    $a['error'] = 1;
    $a['errMsg'] = '每人每天只能给3辆车投票';
    echo json_encode($a);//输出json对象
    exit;
}
//第3个条件： 2次投票之间要求间隔60s以上
$sql = "select voteTime from votedetail where userID = ". $_SESSION['loggedUserID']. " order by id desc limit 0,1";
$result = mysqli_query($conn,$sql);
//$num = mysqli_num_rows($result);
if(mysqli_num_rows($result)){
    //说明用户曾投过票
    $info = mysqli_fetch_array($result);
    if (time() - $info['voteTime'] <= 60){
        //说明时间间隔小于60s，不能投票
        $a['error'] = 1;
        $a['errMsg'] = '2次投票间隔必须大于60s';
        echo json_encode($a);//输出json对象
        exit;
    }
}
//第4个限制条件： 1个IP每天只能投15票
$sql = "select 1 from votedetail where FROM_UNIXTIME(voteTime,'%Y-%m-%d')  = '". date("Y-m-d") . "' and ip = '". getip() . "'";
$result = mysqli_query($conn,$sql);
//$num = mysqli_num_rows($result);
if(mysqli_num_rows($result) >= 10 ){
    //说明当前IP曾投过15票
    $a['error'] = 1;
    $a['errMsg'] = '1个IP每天只能投15票';
    echo json_encode($a);//输出json对象
    exit;
}

//第1步：更新票数carNum
$sql1 = "update carinfo set carNum = carNum  + 1 where id = $id";
//第2步：更新vote detail表
$sql2 = "insert into votedetail (userID,carID, voteTime, ip) values ('" . $_SESSION['loggedUserID'] . "','$id','" . time() ."','" . getip() ."')";

//引入事务机制
mysqli_autocommit($conn,0);//取消自动提交
$result1 = mysqli_query($conn,$sql1);
$result2 = mysqli_query($conn,$sql2);
if ($result1 and $result2){
    mysqli_commit($conn);//提交操作
    $a['error'] = 0;
    echo json_encode($a);//输出json对象

}else{
    mysqli_rollback($conn);//回滚操作
    $a['error'] = 1;
    $a['errMsg'] = '投票失败';
    echo json_encode($a);//输出json对象
}

function getip() {
    static $realip;
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } else {
            $realip = getenv('REMOTE_ADDR');
        }
    }
    return $realip;
}
