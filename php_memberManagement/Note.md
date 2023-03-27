## 环境配置步骤
1. 配置虚拟主机
在httpd-vhosts.conf中添加虚拟主机名和路径  D:\ProgramFiles\XAMPP\apache\conf\extra\httpd-vhosts.conf
2. 在对应路径中建立项目文件夹member
3. 在C:\windows\system32\drivers\etc\hosts中添加虚拟主机解析 （没有权限时，可先拖到桌面修改后再拖回覆盖）
4. 在phpstorm中setting中配置开发inplace，然后重启服务器直接点击浏览器即可打开
5. phpMyAdmin文件夹中config.inc.php是配置文件，$cfg['Servers'][$i]['auth_type'] = 'config' 
   1. config: 通过配置文件方式登录
   2. cookie: 通过网页登录界面输入账户密码登录
## 代码步骤
1. index.php 主页， 构建导航栏
2. 添加signup注册页，建立表单及其后台响应
3. 数据查询和插入
4. 前后台表单验证
## 用户登录
1. 表单验证
2. 确认用户名密码是否正确
3. session
4. 配置database；即在database中连上数据库
5. 简化导航栏，抽出nav.php
## 用户资料修改
## 后台管理
1. 增加数据库管理员标识列
2. 增加管理员识别session
3. 后台管理页管理员身份读取会员数据
4. 分页，增加page.php
5. 增加admin用户，灰化删除和设置管理员功能，即禁止修改admin用户
6. 修改其他用户资料
7. 2个小功能：hover某行时变色；点击某行时变黄色
8. 修改资料后跳转优化  source属性
## 其他优化
1. 注册时使用Ajax验证用户名是否有效
2. 登录时使用Ajax验证用户名是否有效
## 使用验证码
1. 安装php_gd.dll库
   1. 在php.ini中 extension = php_gd.dll
   2. 重启服务器
   3. code.php中画图函数才可以调用
2. 在login前端页面增加显示验证码
## git使用

