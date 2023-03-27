<?php
session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        .current {
            color: brown;
        }
        .red {color: red;}


    </style>
</head>
<body>
    <div class="main">
        <?php

        include_once 'conn.php';

            $sql = "select * from userinfo where username = '" . $_SESSION['loggedUsername'] . "'";

        //根据session中用户名查询用户信息，先显示用户信息，再保存提交修改信息

        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)){
            //找到了对应的用户信息
            $info = mysqli_fetch_array($result);//抓取到数字中

        }else{
            die("未找到有效用户");
        }
        ?>

        <form action="postModify.php" method="post" onsubmit="return check()">
            <table align="center" border="1" style="border-collapse: collapse" cellpadding="10" cellspacing="0">
                <tr>
                    <td align="right">用户名</td>
                    <td align="left"><input name="username" readonly value="<?php echo $info['userName'];?>"></td>
                </tr>
                <tr>
                    <td align="right">密码</td>
                    <td align="left"><input name="pw" type="password" placeholder="不修改密码请留空"></td>
                </tr>
                <tr>
                    <td align="right">确认密码</td>
                    <td align="left"><input name="cpw" type="password" placeholder="不修改密码请留空"></td>
                </tr>

                <tr >
                    <td align="right">邮箱</td>
                    <td align="left"><input name="email" value="<?php echo $info['email'];?>"></td>
                </tr>

                <tr>
                    <td align="right"><input type="submit" value="提交"></td>
                    <td align="left">
                        <input type="reset" value="重置">

                    </td>
                </tr>
            </table>
        </form>
    </div>
<script>
    //表单前台验证，提交数据给后台前调用
    function check(){
        let pw = document.getElementsByName('pw')[0].value.trim();
        let cpw = document.getElementsByName('cpw')[0].value.trim();
        let email = document.getElementsByName('email')[0].value.trim();

        /*
        * 正则表达式
        * ^ 匹配开始
        * $ 匹配结束
        * [] 可选内容 ，可罗列其他字符可选项* _;转义字符用\, 如- 用\-
        * {} 匹配重复次数*/

        //密码验证
        let pwReg = /^[a-zA-Z0-9_*]{6,10}$/;
        if(pw.length > 0 ){//如果密码长度大于0 ， 则需要验证
            if(!pwReg.test(pw)){
                alert('密码必填，且只能大小写、字符和数字、*号，长度为6-10个字符！');
                return false;
            }else {
                if(pw != cpw){
                    alert('密码和确认密码必须一致！');
                    return false;
                }
            }
        }

        //邮箱验证,邮箱可以为空
        let emailReg = /^[a-zA-Z0-9_\-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
        if(email.length > 0){
            if(!emailReg.test(email)){
                alert('邮箱格式错误！');
                return false;
            }
        }

        return true;
    }
</script>
</body>
</html>