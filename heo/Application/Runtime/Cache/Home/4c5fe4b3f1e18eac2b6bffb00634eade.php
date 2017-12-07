<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
    <meta charset="utf-8">
    <tittle></tittle>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link  href="/heo/Public/css/home_page.css" rel="stylesheet" type="text/css" />
    <link  href="/heo/Public/css/mui.min.css" rel="stylesheet" type="text/css" />   

</head>

<body>

    <div class="user">
        <!--a链接用来连接到用户界面-->
        <!--<?php echo ($_SESSION['name']); ?>-->
        <a href="user_centre.html"> <button type="button" class="shit"><font color="#ffffff"><?php echo ($_SESSION['name']); ?></font></button></a>
    </div>


    <div class="campus">
        <div class="mui-card">
            <div class="mui-card-header">校园动态</div>
            <div class="mui-card-content"><a href="read.html"><img src="/heo/Public/img/campus_dynamic.png"></a></div>
            <div class="mui-card-footer">校园动态</div>
        </div>
    </div>
    <div class="community">
        <div class="mui-card">
            <div class="mui-card-header">社区</div>
            <div class="mui-card-content"><a href="video.html"><img src="/heo/Public/img/community.png"></a></div>
            <div class="mui-card-content"><a href="work.html"><img src="/heo/Public/img/community.png"></a></div>
            <div class="mui-card-footer">社区</div>
        </div>
    </div>

</body>

</html>