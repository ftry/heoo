<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset="utf-8">
    <tittle></tittle>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link  href="/heo/Public/css/register.css" rel="stylesheet" type="text/css" />

</head>
<!--body有背景设置，要改变背景就改变url里的链接和img里的图片-->
<body  style="background:url(/heo/Public/img/background_boy.png) no-repeat 0 0">
    <div class="boy_girl">
        <ul>
            <!--第一个img里面是男孩图片，第二个是女孩图片，第二个图片有链接，点击进入女孩的界面-->
            <li><img src="/heo/Public/img/boy_on.png" width="100px"></li>
            <li><a href="register_girl.html"><img src="/heo/Public/img/girl.png" width="100px"></a></li>    
        <ul>
    </div>

    <!--表单信息-->
    <div class="info">
        <!--action和method留给后台-->
        <form action="/heo/index.php/Home/Index/register_boy" method="post">
            <label>
                <span>用户名</span><input name="name" type="text" placeholder="请输入用户名" />
            </label>
            <label>
                <span>密码</span><input name="pw" type="password" placeholder="请输入密码" />
            </label>
            <label>
                <span>电话</span><input name="tel" type="text" placeholder="请输入电话" />
            </label>
            
            <input type="submit" class="button_boy">
        </form>
    </div>
</body>

</html>