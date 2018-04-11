# Soul Explore

# 项目说明
验证类使用了 [jwt](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/) 
需要先安装插件,并且在wp-config.php中添加 
```
define('JWT_AUTH_SECRET_KEY', '您的密钥,请重写');
```

-   推荐使用php7.2 速度比php5.6快上4倍不止
-   如果感觉缓慢,请在wp-config.php设置define('DB_HOST', '127.0.0.1');

# 安装


# 项目结构

采用restApi

-   apis   api请求
-   functions.php   主入口

#  前端编译gitHub
[soul-explore-front](https://github.com/Relsoul/soul-explore-front)