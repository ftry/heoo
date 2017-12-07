<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>校园新闻</title>
</head>
<body>
 
   <table>
    <tr>
        <!--<td></td>-->
        <td><?php echo ($data["tite"]); ?></td>
    </tr>
    <tr>
        <!--<td></td>-->
        <td><?php echo ($data["conctnt"]); ?></td>
    </tr>
     
    
    </table>
    <form action="/heo/index.php/Home/Index/words" method="post">
    <li>新闻列表</li><br/>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--<?php echo ($vo["title"]); ?><INPUT type = "submit" value = "查看"><br/>-->
            <a href="/heo/index.php/Home/Index/words?id=<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?><br/></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </form>
</body>
</html>