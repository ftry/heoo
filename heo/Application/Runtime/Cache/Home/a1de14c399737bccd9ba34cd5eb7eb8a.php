<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新闻发布</title>
</head>
<body>
    <div>
        <form action="/heo/index.php/Home/Admin/add" method="post">
            <span class="input-group-addon" id="basic-addon1"  required="" maxlength="15">文章标题</span>
            <input type="text" class="form-control" id="title" placeholder="Title" aria-describedby="basic-addon1" name="title"><br/>

            <span class="input-group-addon" id="basic-addon1"  required="" maxlength="100">文章概要</span>
            <input type="text" class="form-control" style="resize: none;" maxlength="255"  placeholder="Summary" name="summary" id="summary"><br/>

            <span class="input-group-addon" id="basic-addon1" >封面图片</span>
            <input type="text" class="form-control" placeholder="Cover Image" aria-describedby="basic-addon1" name="cover" maxlength="200"><br/>

            <textarea id="editor" class="content" class="form-control" placeholder="Content" autofocus name="content" required=""></textarea><br/>

            <button type="submit" >提交发布</button><br/>

        </form>
    </div>
</body>
</html>