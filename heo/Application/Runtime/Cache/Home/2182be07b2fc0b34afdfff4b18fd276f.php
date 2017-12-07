<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>校园新闻</title>
</head>
<body>
 

     
    
    
   <!-- <form action="/heo/index.php/Home/Index/words" method="post">
    <li>新闻列表</li><br/>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["title"]); ?><br/>
        <?php echo ($vo["content"]); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?>
    </form>一个失败的部分-->


    <li>新闻</li><br/>
    <table>
        <tr>
            <!--<td></td>-->
            <td><?php echo ($data["title"]); ?></td>
        </tr>
        <tr>
            <!--<td></td>-->
            <td><?php echo ($data["content"]); ?></td>
        </tr>
    </table>
    
    <!--<li class="active">详细</li>-->
    <!--   <input type="hidden" name="uid" id="uid" value="<?php echo ($details["uid"]); ?>"> 
      <input type="hidden" name="data" id="data" value="<?php echo ($words["title"]); ?>">
    <?php echo ($words["title"]); ?><br/>
    <?php echo ($words["content"]); ?><br/>--一个是失败的部分>
</body>
</html>