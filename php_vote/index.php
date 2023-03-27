<?php
session_start();//开启session
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>我最爱的汽车投票</title>

<!--    layui的lay组件-->
    <script src="layer/layer.js"></script>
    <style>
        .login{text-align: right;margin-bottom: 20px;}
        .img{position: relative;}
        .row img{width:100%;}
        .img .row{position: absolute;bottom: 0;left: 15px;background-color: rgba(0,0,0,0.5);width: 100%;color: white;}
        p{margin: 10px 0 !important;}
        .code td{padding:10px !important;}
        /*.code{display: none}*/
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">我最爱的汽车投票</h1>
    <p class="login">
        <?php
        if (isset($_SESSION['loggedUsername']) && $_SESSION['loggedUsername'] != ''){
            //说明已经登录
            ?>
            当前登录者：<?php echo $_SESSION['loggedUsername'];?>
            <a href="logout.php">注销</a>
            <a href="javascript:open('signup.php','用户注册')">注册</a>
            <a href="javascript:open('modify.php','修改资料')">修改资料</a>
            <?php if ($_SESSION['isAdmin']){
            ?>
                <a href="admin.php">后台管理</a>
            <?php
                }
            ?>
        <?php
        }else{
        ?>
            <a href="javascript:open('login.php','用户登录')">登录</a>
            <a href="javascript:open('signup.php','用户注册')">注册</a>
        <?php
            }
        ?>

    </p>
    <div class="row">
        <?php
        include_once 'conn.php';
        $sql = "select * from carinfo order by id desc";
        $result = mysqli_query($conn,$sql);
        $i = 1;//计数器，用户计数，以清理浮动
        while($info = mysqli_fetch_array($result)){
            ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="img">
                <?php
                if (isset($_SESSION['loggedUsername']) && $_SESSION['loggedUsername'] != ''){
                //说明已经登录
                ?>
                    <a href="javascript:showCode(<?php echo $info['id'];?>)">
                    <img src="img/<?php echo $info['carPic'];?>"></a>
                <?php
                }else{
                ?>
                    <img src="img/<?php echo $info['carPic'];?>"></a>
                <?php
                }
                ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6">
                        <p class="text-center"><?php echo $info['carName'];?></p>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-6">
                        <p class="text-center">当前票数：
                            <span id="num<?php echo $info['id'];?>"><?php echo $info['carNum'];?></span>
                        </p>
                    </div>
                </div>
            </div>
            <p><?php echo $info['carDesc'];?></p>
        </div>
        <?php
            if ($i % 2 == 0){
                echo '<div class="clearfix visible-sm-block"></div>';
            }
//            if ($i % 3 == 0){
//                echo '<div class="clearfix visible-md-block"></div>';
//            }
//            if ($i % 4 == 0){
//                echo '<div class="clearfix visible-lg-block"></div>';
//            }
            $i++;
        }
        ?>
    </div>
</div>

<script>
    function showCode(id){

        let str = '';
        str += '<div class="code">';
        //str += '    <form action="vote.php" method="GET">'
        str += '        <table style="border-collapse: collapse" border="1" bordercolor="gray" cellspacing="0">';
        str += '            <tr>';
        str += '                <td align="center">验证码</td>';
        str += '                <td align="left">';
        str += '                    <input name="code" id="code">';
        str += '                        <img src="code.php" id="codeIMG">';
        str += '                            <input type="hidden" name="id" id="carID">';
        str += '               </td>';
        str += '            </tr>';
        str += '            <tr>';
        //str += '                <td align="right"><input type="submit" value="提交"></td>';
        // 改为button，再添加事件
        str += '                <td align="right"><input type="button" id="postVote" value="提交"></td>';
        str += '                <td align="left"><input type="reset" value="重置"></td>';
        str += '            </tr>';
        str += '        </table>';
        //str += '    </form>';
        str += '</div>';

        //利用layui的弹框将str中的table展示出来
        layer.open({
            type: 1,
            title: '请输入验证码',
            closeBtn: 2,//右上角关闭按钮
            shadeClose: false,
            content: str,//利用layui的弹框将str中的table展示出来
            success:function (layero,index) {
                $("#postVote").click(function () {
                    $.ajax({
                        url:'ajaxVote.php',
                        data:{id:id,code:$("#code").val().trim()},
                        dataType:'json',
                        type:'GET',
                        success:function (d) {
                            if (d.error == 1){
                                //说明出错
                                layer.alert(d.errMsg,{icon:1},function (index) {
                                    layer.closeAll();
                                });//layui的弹框提示
                            }else {
                                let num = parseInt($("#num" + id).text());//读取当前投票数
                                $("#num" + id).text(num+1);//将投票数写入
                                layer.alert('投票成功',{icon:1},function (index) {
                                    layer.closeAll();
                                });
                            }
                        },
                        error:function () {
                            layer.alert(d.errMsg,{icon:3},function (index) {
                                layer.closeAll();
                            });
                        }
                    })
                })
                //验证码点击刷新的响应函数
                $("#codeIMG").click(function () {
                    $(this).attr('src','code.php?id='+new Date());//点击验证码刷新，得到新的验证码
                })
                //$("#carID").val(id);//通过隐藏域把id传到后台;异步时不需要这
            }
        });
    }

    function open(url,title){
        layer.open({
            type: 2,
            title: title,
            area: ['700px', '450px'],
            fixed: false,//不固定
            maxmin:true,
            content: url
        });
    }

    //关掉所有弹窗
    function closeLayer(){
        layer.closeAll();
    }

</script>
</body>
</html>