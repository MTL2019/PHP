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
    <style>

        h1,h2{
            text-align: center;
        }
        h2{
            font-size: 20px;
        }
        h2 a{text-decoration: none;color: #4476A7;}
        h2 a:hover{text-decoration: underline;color: brown;}
        .current{color: blueviolet;}
        #main{margin:40px auto;}
    </style>
    <script src="js/echarts.min.js"></script>
    <script src="https://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
    <h1>车辆管理</h1>
    <h2>
        <a href="index.php">返回首页</a>
        <a href="admin.php" >车辆管理</a>
        <a href="showData.php" class="current">数据查看</a>
        <a href="logout.php">注销</a>
    </h2>

    <!-- Prepare a DOM with a defined width and height for ECharts -->
    <div id="main" style="width: 1000px;height:500px;"></div>
    <script type="text/javascript">
        // Initialize the echarts instance based on the prepared dom
        var myChart = echarts.init(document.getElementById('main'));
        // 显示标题，图例和空的坐标轴
        myChart.setOption({
            title: {
                text: '车辆票数柱状图'
            },
            tooltip: {},
            legend: {
                data: ['票数']
            },
            xAxis: {
                data: []
            },
            yAxis: {},
            series: [
                {
                    name: '票数',
                    type: 'bar',
                    data: []
                }
            ]
        });

        $.ajax({
            url:'getData.php',
            dataType:'json',
            success:function (data){
                // 成功就 填入数据
                myChart.setOption({
                    xAxis: {
                        data: data.categories
                    },
                    series: [
                        {
                            // 根据名字对应到相应的系列
                            name: '票数',
                            data: data.data
                        }
                    ]
                });
            },
            error:function (){
                alert('获取数据出错');
            }
        })
    </script>
</body>
</html>