<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/heo/index.php/Home/Index/deal" method="post">
        时间：<INPUT type = "text" name = "time"> <br/>
        科目：<INPUT type = "text" name = "class"> <br/>
        地点：<INPUT type = "text" name = "room"> <br/>
        要求：<INPUT type = "text" name = "demand"> <br/>
                    
        <INPUT type = "submit" value = "发布">  


    </form>
    
</body>
</html>