## Create database
1. create database vote
2. create tables carinfo/userinfo/votedetail
3. create constrains

## create index
1. use bootstrap


## Create Mysql connection
1. create conn.php

## import lay.layui
1. 下载lay组件压缩包
2. script中引入lay.js
3. 在javascript函数中添加lay open的函数
4. 在登录、注册按钮中添加调用响应

## 借鉴member中的登录、注册、修改功能
1. 拷贝登录、注册、修改页面，并修改相关代码，适配
2. 设置只有登录用户才可以投票
   1. 在index页面添加检查登录代码
   2. 登录后，利用事务机制处理投票时的数据库更新
## 设置投票限制
1. 每人每天只能给同一辆车投5票
2. 每人每天只能给3辆车投票
3. 2次投票间隔大于1分钟
4. 同一个IP每天最多只能投15票
## 使用layui显示验证码
1. index中添加响应函数showCode
2. 利用layui打开验证码对话框
3. 后台添加验证码判断代码
## 使用异步的方式刷新票数
