<?php if (!defined('THINK_PATH')) exit();?><html>
    <head>
        <meta charset="utf-8">
        <tittle></tittle>
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <link  href="/heo/Public/css/login.css" rel="stylesheet" type="text/css" />
    </head>

    <body style="background:url(/heo/Public/img/background_login.png) no-repeat 0 0">

        <div class="headshot">
            <!--用户头像，需要在数据库中调用-->
            <img src="/heo/Public/img/headshot.png" />
        </div>
        
        <div class="info">
            <form action="/heo/index.php/Home/Index/login" method="post">
                <input type="text" placeholder="用户名">
                <input type="password" placeholder="密码">
                <input type="submit" value="登陆" />
               <!-- <button type="submit" >登录</button>-->
                <input type="submit" value="注册一个"/>
            
            </form>
        </div>

    </bdoy>

</html>