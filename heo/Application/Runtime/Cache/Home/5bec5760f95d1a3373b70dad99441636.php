<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>任务大堂</title>
</head>
<body>
        <form action="/heo/index.php/Home/Index/take" method="post">
            <li>任务列表</li><br/>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--<?php echo ($vo["title"]); ?><INPUT type = "submit" value = "查看"><br/>-->
                <a href="/heo/index.php/Home/Index/take?id=<?php echo ($vo["uid"]); ?>&id2=<?php echo ($vo["id"]); ?>"><?php echo ($vo["time"]); ?>-<?php echo ($vo["class"]); ?>-<?php echo ($vo["room"]); ?>-<?php echo ($vo["demand"]); ?></a><br/><?php endforeach; endif; else: echo "" ;endif; ?>
        </form>
</body>
</html>