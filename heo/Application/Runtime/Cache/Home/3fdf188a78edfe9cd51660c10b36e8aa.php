<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>笑死你</title>
</head>
<body>
 <form action="/heo/index.php/Home/Index/video" method="post">
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><video width="320" height="240" controls="controls">

         <source src="/heo/Public/video/<?php echo ($vo["name"]); ?>.mp4" type="video/mp4"/>
         

       

     </video><br/><?php endforeach; endif; else: echo "" ;endif; ?>
 </form>
    
</body>
</html>