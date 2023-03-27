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
    </style>
</head>
<body>
    <div class="main">
    <?php include_once 'nav.php'?>
    </div>
</body>
</html>