<?php
include_once 'checkAdmin.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我最爱的汽车投票</title>
    <script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
    <script src="layer/layer.js"></script>
    <style>
        .img{
            width:100%;max-width: 250px;
        }
        h1,h2{
            text-align: center;
        }
        h2{
            font-size: 20px;
        }
        h2 a{text-decoration: none;color: #4476A7;}
        h2 a:hover{text-decoration: underline;color: brown;}
        .current{color: blueviolet;}
    </style>
</head>
<body>
<h1>车辆管理</h1>
<h2>
    <a href="index.php">返回首页</a>
    <a href="admin.php" class="current">车辆管理</a>
    <a href="showData.php">数据查看</a>
    <a href="logout.php">注销</a>
</h2>
<?php
include_once 'conn.php';
$id = $_GET['id'] ?? 0;
$sql = "select * from carinfo where id = $id";
$result = mysqli_query($conn,$sql);
if (!mysqli_num_rows($result)){
    echo "<script>alert('未查到当前车辆'); history.back();</script>";
    exit;
}
$info = mysqli_fetch_array($result);//获取查询数据备用
?>
<h2>车辆资料修改</h2>
<form onsubmit="return check()" enctype="multipart/form-data" method="post" action="postModifyCar.php">
    <table width="70%" align="center" style="border-collapse: collapse;" border="1" bordercolor="gray" cellpadding="10" cellspacing="0" >
        <tr>
            <td align="right">车辆名称</td>
            <td align="left"><input name="carName" id="carName" value="<?php echo $info['carName']; ?>"></td>
        </tr>
        <tr>
            <td align="right">车辆描述</td>
            <td align="left"><textarea name="carDesc" id="carDesc" ><?php echo $info['carDesc']; ?></textarea></td>
        </tr>
        <tr>
            <td align="right">车辆图片</td>
            <td align="left"><input type="file" id="carPic" name="carPic">
                <img class="img" src="img/<?php echo $info['carPic']; ?>">
            </td>
        </tr>
        <tr>
            <td align="right">
                <input type="submit" value="修改">
                <input type="hidden" name="id" value="<?php echo $info['id'];?>">
            </td>
            <td align="left"><input type="reset" value="重置"></td>
        </tr>
    </table>
</form>
<script>

    function check(){
        //注意使用jquery前，要包含jquery.js
        let carName = $("#carName").val().trim();
        let carDesc = $("#carDesc").val().trim();

        if(carName == '' || carDesc == ''){
            alert('车辆名称、车辆描述都必须要填写');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
