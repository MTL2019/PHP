<!---->
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
        .red {color: red}
        .green{color: green}
        #loading{width: 23px;display: none}


    </style>
</head>
<body>
    <div class="main">
<!--        --><?php //include_once 'nav.php'?>

        <form action="postReg.php" method="post" onsubmit="return check()">
            <table align="center" border="1" style="border-collapse: collapse" cellpadding="10" cellspacing="0">
                <tr >
                    <td align="right">用户名</td>
                    <td align="left"><input name="username" onblur="checkUsername()"><span class="red">*</span><span id="usernameMsg"></span><img src="img/loading.gif" id="loading"></td>
                </tr>
                <tr>
                    <td align="right">密码</td>
                    <td align="left"><input name="pw" type="password"><span class="red">*</span></td>
                </tr><tr>
                    <td align="right">确认密码</td>
                    <td align="left"><input name="cpw" type="password"><span class="red">*</span></td>
                </tr>

                <tr >
                    <td align="right">邮箱</td>
                    <td align="left"><input name="email"></td>
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
        let username = document.getElementsByName('username')[0].value.trim();
        //用户验证
        let usernameReg = /^[a-zA-Z0-9]{3,10}$/;
        if(!usernameReg.test(username)){
            alert('用户名必填，且只能大小写、字符和数字，长度为3-10个字符！');
            $('#usernameMsg').text('');//清除用户名后，提示字符串要清空
            return false;
        }

        //Ajax
        $.ajax({
            url:"checkUsername.php",
            type:'post',
            dataType:'json',
            data:{username:username},
            beforeSend:function () {
                $("#usernameMsg").text('');
                $("#loading").show();
            },
            success:function (data){
                $("#loading").hide();
                if (data.code == 0){
                    $('#usernameMsg').text(data.msg).removeClass('green').addClass('red');//红色提示不可用
                }
                else if(data.code == 2){
                    $('#usernameMsg').text(data.msg).removeClass('red').addClass('green');//绿色提示可用
                }
            },
            error:function () {
                $("#loading").hide();
                alert('网络错误');
            }
        })
    }
    //表单前台验证，提交数据给后台前调用
    function check(){
        let username = document.getElementsByName('username')[0].value.trim();
        let pw = document.getElementsByName('pw')[0].value.trim();
        let cpw = document.getElementsByName('cpw')[0].value.trim();
        let email = document.getElementsByName('email')[0].value.trim();

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
        }else {
            if(pw != cpw){
                alert('密码和确认密码必须一致！');
                return false;
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