### Laravel-forum是一个Laravel 5.8建立的文章发布和问答系统，后台基于 [laravel-admin](https://laravel-admin.org/)。

- [功能介绍](#feature-link)
- [安装](#install-link)
- [克隆源码到本地](#first-link)
- [安装扩展包](#second-link)
- [修改配置文件](#three-link)
- [配置key与软链接](#four-link)
- [数据迁移](#five-link)
- [填充后台数据](#six-link)
- [License](#license-link)

<a name="feature-link">

   ### 功能介绍
   
   - 注册，登录，找回密码，支持github和qq登录
   - 文章多级评论
   - 文章点赞
   - 文章抒写支持markdown语法
   - 分享插件
   - Vue实现问答
   - 话题订阅、锁定
   - 动态搜索
   
<a name="install-link">

## 安装
<a name="first-link">

### 1. 克隆源码到本地

`git clone https://github.com/dxmq/laravel-forum.git`

<a name="second-link">

### 2. 安装扩展包

- 安装`laravel`扩展包 `composer install`
- 安装`Vue.js`扩展包 `npm install`
- 编译js `npm run dev`

> 后续两步也可不执行，因为已经事先已编译好了

<a name="three-link">

### 3. 修改配置文件

`cd laravel-forum`

`cp .env.example .env`

编辑`.env`文件 `vim .env`

`APP_NAME=xxx`
`APP_ENV=production`
`APP_DEBUG=false`
`APP_URL=http://xxx`

配置好数据库信息、邮件发送、github与qq的key/secret/callback_url

配置好`redis`

最后`php artisan config:clear`

<a name="four-link">

### 4. 配置key与软链接

`php artisan key:generate`

`php artisan storage:link`

<a name="five-link">

### 5. 数据迁移

`php artisan migrate`

<a name="six-link">

### 6. 填充后台数据

`php artisan db:seed --class=AdminTablesSeeder`

进入后台：`http://xxx/admin`

用户名：admin
密码: `admin`

<a name="license-link">

## License
The project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
