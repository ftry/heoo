<?php if (!defined('THINK_PATH')) exit();?><html>
    <head>
        <meta charset="utf-8">
        <tittle></tittle>
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <link  href="/heo/Public/css/user_centre.css" rel="stylesheet" type="text/css" />
        <link  href="/heo/Public/css/mui.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <!--这里修改背景图片-->
    <body style="background:url(/heo/Public/img/background2.png) no-repeat 0 0">

        <div class="headshot">
            <!--用户头像，需要在数据库中调用-->
            <img src="/heo/Public/img/headshot.png" />
        </div>

        <!--用户个人信息模块，后台用append方法插入个人信息-->
       <!-- <form action="/heo/index.php/Home/Index/show" method="post">-->
        
        <div  class="content">
            <p>这里输入用户个人信息</p>
            昵称：<?php echo ($_SESSION['name']); ?><br/>
            电话：<?php echo ($_SESSION['tel']); ?><br/>
        </div>
      
       <!--</form>-->

        <!--接单与发布记录，点击图片，进入界面-->
        <div class="record">
            <a href=""><img src="/heo/Public/img/record.png"></a>
        </div>

        <!--积分板块-->
        <div  class="score">
            <button type="button" class="mui-btn mui-btn-danger">积分</button><br/>
            <div class="btn2"><button type="button" class="mui-btn mui-btn-success"><a href=""><div class="scoreHis">记录积分</div></a></button></div>
            <br/>
            <div class="btn2"><button type="button" class="mui-btn mui-btn-success"><a href=""><div class="scoreHis">积分获取方式</div></a></button></div>
        </div>  

        <!--底部，我的发布和接单-->
        <div class="bottom">
            <div class="publish">
                <a href="deal.html"><button type="button" class="mui-btn mui-btn-royal">我要发布</button></a>
            </div>
            <div class="get">
                <button type="button" class="mui-btn mui-btn-danger">接单</button>
            </div>
            <div class="get">
                <a href="ret.html"><button type="button" class="mui-btn mui-btn-danger">查询</button></a>
            </div>
        </div>

    </body>
</html>