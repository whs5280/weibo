## Laravel 微博

如果你觉得还可以的话，请Star , Fork给作者鼓励一下

## 说明

本系统是基于《Laravel教程-Web开发实战入门》,在此基础上进行扩展开发 

有需要的话： https://learnku.com/courses/laravel-essential-training/5.8?rf=34236

## 功能模块：
- 注册登录
- 邮箱激活
- 邮箱找回密码
- 用户管理
- 微博管理
- 粉丝关系

## 后续添加的功能模块：
- 管理员
- 图片的上传


## 环境需求

* Composer
* PHP >= 7.1.3
* OpenSSL PHP 扩展
* PDO PHP 扩展
* Mysql 5.7+

## 安装步骤

* git clone或者下载解压到本地
* composer install
* npm install
* 修改.env文件，关于邮件发送请参考官网文档配置（修改.env以及email.php）
* 启动mysql，创建数据库，执行 php artisan migrate:refresh
* 前台用户名为whs@qq.com,密码为123456

