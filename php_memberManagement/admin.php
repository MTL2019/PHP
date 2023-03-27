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
    <title>Document</title>

    <title>会员管理系统</title>
    <style>
        .main {
            width: 80%;
            margin: 0 auto;
            text-align: center
        }

        h2 {
            text-align: center;
            font-size: 20px;
        }

        h2 a {
            margin-right: 15px;
            color: navy;
            text-decoration: none
        }

        h2 a:last-child {
            margin-right: 0px;
        }

        h2 a:hover {
            color: crimson;
            text-decoration: underline
        }
        tr:hover {
            background-color: azure;
        }
        .trClick1{background-color: yellow;}
        .trClick2{background-color: white;}
    </style>
</head>
<body>
<div class="main">
    <?php include_once 'nav.php';
    include_once 'conn.php';
    include_once 'page.php';

    //查询总的记录条数
    $sql = "select count(id) as total from info ";//使用聚合函数
    $result = mysqli_query($conn, $sql);
    $info = mysqli_fetch_array($result);
    $total = $info['total'];
    $perPage = 5;//设置每页显示多少条记录
    $page = $_GET['page'] ?? 1;//读取当前页码，如果没有值则设置为第1页
    paging($total, $perPage);//调用分页函数，位于page.php中

    $sql = "select * from info order by id desc limit $firstCount, $perPage";//$dispalyPG是带默认值，防止不给perPage值的情况
    $result = mysqli_query($conn, $sql);
    ?>

    <table border="1" cellspacing="0" cellpadding="10" style="border-collapse: collapse" align="center" width="70%">
        <tr>
            <td>序号</td>
            <td>用户名</td>
            <td>性别</td>
            <td>邮箱</td>
            <td>爱好</td>
            <td>是否管理员</td>
            <td>操作</td>
        </tr>
        <?php
        $i = ($page - 1) * $perPage + 1;
        while ($info = mysqli_fetch_array($result)){
        ?>
        <tr onclick="if(this.className == 'trClick2'){this.className = 'trClick1'}else{this.className = 'trClick2'}" class="trClick2">
            <td><?php echo $i; ?></td>
            <td><?php echo $info['username']; ?></td>
            <td><?php echo $info['sex'] ? '男' : '女'; ?></td>
            <td><?php echo $info['email']; ?></td>
            <td><?php echo $info['fav']; ?></td>
            <td><?php echo $info['admin'] ? '是' : '否'; ?></td>
            <td><a href="modify.php?id=4&username=<?php echo $info['username']; ?>&source=admin&page=<?php echo $page; ?>">修改资料</a>
                <?php if ($info['username'] <> 'admin'){ ?><a
                        href="javascript:del(<?php echo $info['id']; ?>,'<?php echo $info['username']; ?>');">删除会员</a>
                <?php
                }
                else {
                    echo '<span style="color: gray">删除会员</span> ';
                }
                if ($info['admin']) {
                    if ($info['username'] <> 'admin') {
                        ?><a href="setAdmin.php?action=0&id=<?php echo $info['id']; ?>">取消管理员</a>
                        <?php
                    } else {
                        echo '<span style="color: gray">取消管理员</span>';
                    }
                } else {
                    if ($info['username'] <> 'admin') {
                        ?><a href="setAdmin.php?action=0&id=<?php echo $info['id']; ?>">设置管理员</a>
                        <?php
                    } else {
                        echo '<span style="color: gray">设置管理员</span>';
                    }
                }
                ?>
            </td>
        </tr>
    <?php
    $i++;
    }
    ?>
    </table>
    <?php
    echo $pageNav;
    ?>
</div>
<script>
    function del(id,name){
        if (confirm('您确定要删除会员' + name + '?')){
            location.href='del.php?id=' + id + '&username=' + name;
        }
    }
</script>
</body>
</html>