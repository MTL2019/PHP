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
            width:100%;max-width: 150px;
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
include_once 'page.php';//分页
$sql = "select count(id) as total from carinfo";//使用聚合函数count统计记录总数
$result = mysqli_query($conn, $sql);
$info = mysqli_fetch_array($result);
$total = $info['total'];  //得到记录总数
$perPage = 4; //设置每一页显示多少条数据
$page = $_GET['page'] ?? 1; //读取当前页码
paging($total, $perPage);//引用分页函数
$sql = "select * from carinfo order by id desc limit $firstCount,$perPage";
$result = mysqli_query($conn, $sql);

?>
<table border="0" width="100%" align="center">
    <tr>
        <td>
            <table align="center" width="100%" border="1" bordercolor="black" cellspacing="0" cellpadding="10" style="border-collapse: collapse">
                <tr>
                    <td align="center" width="8%">序号</td>
                    <td align="center" width="20%">车辆名称</td>
                    <td align="center" width="39%">车辆描述</td>
                    <td align="center" width="10%">车辆图片</td>
                    <td align="center" width="8%">当前票数</td>
                    <td align="center" width="15%">操作</td>
                </tr>
                <?php
                    $i = ($page - 1) * $perPage + 1;//当前页码
                    while($info = mysqli_fetch_array($result)){
                ?>
                        <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td align="center"><?php echo $info['carName']; ?></td>
                            <td align="center"><?php echo $info['carDesc']; ?></td>
                            <td align="center"><img class="img" src="img/<?php echo $info['carPic']; ?>"></td>
                            <td align="center"><?php echo $info['carNum']; ?></td>
                            <td align="center">
                                <a href="modifyCar.php?id=<?php echo $info['id'];?>">修改</a>
                                <a href="javascript:del('<?php echo $info['carName'];?>',<?php echo $info['id'];?>)">删除</a>
                            </td>
                        </tr>
                <?php
                        $i++;
                    }
                ?>

            </table>
        </td>
    </tr>

    <tr>
        <td align="right">
            <?php
                echo $pageNav;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <h2>添加车辆</h2>
            <form onsubmit="return check()" enctype="multipart/form-data" method="post" action="postAddCar.php">
                <table width="70%" align="center" style="border-collapse: collapse;" border="1" bordercolor="gray" cellpadding="10" cellspacing="0" >
                    <tr>
                        <td align="right">车辆名称</td>
                        <td align="left"><input name="carName" id="carName"></td>
                    </tr>
                    <tr>
                        <td align="right">车辆描述</td>
                        <td align="left"><textarea name="carDesc" id="carDesc"></textarea></td>
                    </tr>
                    <tr>
                        <td align="right">车辆图片</td>
                        <td align="left"><input type="file" id="carPic" name="carPic"></td>
                    </tr>
                    <tr>
                        <td align="right"><input type="submit" value="添加"></td>
                        <td align="left"><input type="reset" value="重置"></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
<script>
    function del(name,id){
        layer.confirm('您确认要删除车辆 ' + name + ' ?', {icon: 3, title:'提示'}, function(index){
            location.href = 'delCar.php?id='+id;
            layer.close(index);
        });
    }
    function check(){
        //注意使用jquery前，要包含jquery.js
        let carName = $("#carName").val().trim();
        let carDesc = $("#carDesc").val().trim();
        let carPic = $("#carPic").val().trim();

        if(carName == '' || carDesc == '' || carPic == ''){
            alert('车辆名称、车辆描述、车辆图片都必须要填写');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
