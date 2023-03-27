
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
        .none{width: 20px;display: none}


    </style>
</head>
<body>
    <div class="main">

<!--        --><?php //include_once 'nav.php'?>

        <form action="postLogin.php" method="post" onsubmit="return check()">
            <table align="center" border="1" style="border-collapse: collapse" cellpadding="10" cellspacing="0">
                <tr >
                    <td align="right">用户名</td>
                    <td align="left">
                        <input name="username"  id="username" onblur="checkUsername()">
                        <span class="red">*</span>
                        <img src="img/x0.jpg" id="x0" class="none">
                        <img src="img/x1.jpg" id="x1" class="none">
                    </td>
                </tr>
                <tr>
                    <td align="right">密码</td>
                    <td align="left"><input name="pw" type="password"><span class="red">*</span></td>
                </tr>
                <tr>
                    <td align="right">验证码</td>
                    <td align="left">
                        <input name="code" placeholder="请输入图片中的验证码">
                        <img src="code.php" style="cursor: pointer" onclick="this.src='code.php?'+new Date().getTime();" width="200" height="50">
                        <span class="red">*</span>
                    </td>
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
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script>
    function checkUsername(){
        let username = $('#username').val().trim();//使用jquery取，也可以使用javascript取
        if (username.length == 0){
            $('#x0').hide();
            $('#x1').hide();
            return;//如果没有输入则不验证
        }else{
            //用户验证
            let usernameReg = /^[a-zA-Z0-9]{3,10}$/;
            if(!usernameReg.test(username)){
                alert('用户名只能大小写、字符和数字，长度为3-10个字符！');
                return ;
            }
            $.ajax({
                url:'checkUsername.php',
                type:"post",
                dataType:'json',
                data:{username:username},
                success:function(d){
                    if (d.code == 0){
                        //说明用户名存在
                        $("#x0").hide();
                        $("#x1").show();

                    }else if (d.code == 2){
                        //说莫用户名不存在
                        $("#x0").show();
                        $("#x1").hide();

                    }
                },
                error:function (){
                    $("#x0").hide();
                    $("#x1").hide();
                }
            })
        }

    }
    //表单前台验证，提交数据给后台前调用
    function check(){
        let username = document.getElementsByName('username')[0].value.trim();
        let pw = document.getElementsByName('pw')[0].value.trim();

        /*
        * 正则表达式
        * ^ 匹配开始
        * $ 匹配结束
        * [] 可选内容 ，可罗列其他字符可选项* _;转义字符用\, 如- 用\-
        * {} 匹配重复次数*/

        //用户验证
        let usernameReg = /^[a-zA-Z0-9]{3,10}$/;
        if(!usernameReg.test(username)){
            alert('用户名必填，且只能大小写、字符和数字，长度为3-10个字符！');
            return false;
        }
        //密码验证
        let pwReg = /^[a-zA-Z0-9_*]{6,10}$/;
        if(!pwReg.test(pw)){
            alert('密码必填，且只能大小写、字符和数字、*号，长度为6-10个字符！');
            return false;
        }

        return true;
    }
</script>
</body>
</html>