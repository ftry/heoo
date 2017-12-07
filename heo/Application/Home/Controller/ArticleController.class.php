<?php 
//++++----张盈修缮--------
namespace Home\Controller;
use Home\Controller\BaseController;

/**
* 文章控制器
*/
class ArticleController extends BaseController
{
    /**
     * 展示文章
     * @return [type] [description]
     */
    /*public function index(){
        $this->redirect('category','',0);
    }*/

    //新增文章
    public function add(){
        if (IS_POST && isset($_POST['artsubmit'])) {
            $tids = M('tags')->getField('id as tid',true);
            $data['title'] = (trim(I('post.title')) == ''?$this->error('标题不能为空'):I('post.title'));
            $data['summary'] = (trim(I('post.summary')) == ''?$this->error('内容概要不能为空'):I('post.summary'));
            I('post.cover') == null?$data['image']="/Public/home/imgs/jian.png":$data['image']=I('post.cover');
            if (I('post.tagid') != '') {
               if (in_array(I('post.tagid'), $tags)) {
                    $data['tagid'] = intval(I('post.tag'));
               }else{
                $this->error('请不要随意修改Tag值!');
               }
            }else{
                $data['tagid'] = 1;
            }
            $data['publish'] = time();
            $data['uid'] = session('uid');
            trim(I('post.content')) == ''?$this->error('文章内容不能为空哦!'):$data['content'] = I('post.content');
            if(M('article')->add($data)){
                $data=null;
                $this->success('添加文章成功!',U('index/index'));
            }else{
                $data=null;
                $this->error('抱歉，添加失败，请重试!');
            }
        }else{
            $tags = M('tags')->getField('tagname',true);
            $this->assign('tags',$tags);
            $this->display();
        }
       
    }

    //修改文章
    public function edit(){
        if (IS_POST && isset($_POST['artsubmit'])) {
            $aid = I('post.aid','',intval);
            $ainfo = M('article')
                    ->field('title,tagid,summary,content,image')
                    ->where('id='.$aid)->select()[0];
            $tids = M('tags')->getField('id as tid',true);
            if (I('post.title') != $ainfo['title']) {
                $data['title'] = (trim(I('post.title')) == ''?$this->error('标题不能为空'):I('post.title'));
            }
            if (I('post.tagid') != '') {
                if (I('post.tagid') != $ainfo['tagid']) {
                    if (in_array(I('post.tagid'), $tids)) {
                        $data['tagid'] = I('post.tagid');
                    }else{
                        $this->error('请不要修改tag值!');
                    }
                }
            }
            if (I('post.cover') != $ainfo['image']) {
               $data['image'] = I('post.cover');
            }
            if (I('post.summary') != $ainfo['summary']) {
               $data['summary'] = (trim(I('post.summary')) == ''?$this->error('内容概要不能为空'):I('post.summary'));
            }
            if (I('post.content') != $ainfo['content']) {
              trim(I('post.content')) == ''?$this->error('文章内容不能为空哦!'):$data['content'] = I('post.content');
            }
            if (!empty($data)) {
                if (M('article')->where('id='.$aid)->save($data)) {
                    $data=null;
                    $this->success('修改文章成功!','details?artid='.$aid);
                }else{
                    $data=null;
                    $this->error('抱歉,修改失败了,请重试!');
                }
            }else{
                $this->error('文章信息未做任何更改,请检查后重试!');
            }
        }else{
            $aid = I('get.aid','',intval);
            $ainfo = M('article')
                    ->field('id as aid,title,tagid,summary,content,image')
                    ->where('id='.$aid)->select()[0];
            $this->assign('ainfo',$ainfo);
            $tags = M('tags')->field('id as tid,tagname')->select();
            $this->assign('tags',$tags);
            $this->display();
        }
    }

    //删除文章
    public function delete(){
        $aid = I('get.aid','',intval);
        $articleModel = M('article');
        $aids = $articleModel->getField('id',true);
        if (!in_array($aid, $aids)) {
            $this->error("请不要修改相关数据!");
        }
        if ($articleModel->where('id='.$aid)->delete()) {
            $this->success('删除文章成功');
        }else{
            $this->error('抱歉,删除失败,请稍后重试');
        }
    }

    //查看我的文章
    public function mine(){
         $count =  M('article')->where('uid='.session('uid'))->count();
         $pagNum = ceil($count/C('PAGE_SIZE'));
         if (null != I('get.p')) {
            if (intval(I('get.p')) <= 0) {
               $p = 1;
            }elseif (intval(I('get.p')) > $pagNum) {
               $p = $pagNum;
            }else{
                $p = intval(I('get.p'));
            }
         }else{
            $p = 1;
         }
        $myarts = M('article as a')->field('a.id as aid,title,publish,hits,likes,tagname')->join('left join think_tags as t on a.tagid = t.id')->where('uid='.session('uid'))->page($p.','.C('PAGE_SIZE'))->select();
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $this->assign('order',C('C_PAGE_SIZE')*($p-1));
        $this->assign('page',$show);
        $this->assign('myarts',$myarts);
        $this->display();
    }
    
    //文章分类展示
    public function category(){
        $p=isset($_GET['p'])?$_GET['p']:0;
        if (null != I('get.cat')) {
            $cat = I('get.cat');
            $cats = M('tags')->getfield('tagname',true);
            if (!in_array($cat, $cats)) {
                $this->error('分类参数错误!');
            }
            $lists = M('article')->field('think_article.id,u.id as uid,username,title,hits,tagname,publish,think_article.likes,image')->join('think_tags as t on t.id = think_article.tagid')->join('think_user as u on u.id = think_article.uid')->where(array('tagname'=>$cat))->page($p.','.C('C_PAGE_SIZE'))->select();
            $count =  M('article')->join('think_tags as t on t.id = think_article.tagid')->where(array('tagname'=>$cat))->count();
            $this->assign('category',I('get.cat'));
        }else{
            $lists = M('article')->field('think_article.id,username,title,hits,tagname,publish,think_article.likes,image')->join('think_tags as t on t.id = think_article.tagid')->join('think_user as u on u.id = think_article.uid')->page($p.','.C('C_PAGE_SIZE'))->select();
            $count = M('article')->count();
        }
        $page = new \Think\Page($count,C('C_PAGE_SIZE'));
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }

    //文章详情
    public function details(){
            //文章内容
            $articleModel = M('article');
            $id = intval(I('get.artid'));
            if ($id <= 0 || !in_array($id, $articleModel->getField('id',true))) {
                $this->error('传输参数错误!');
            }
            $articleModel->where('id='.$id)->setInc('hits');
            $data = $articleModel->where(array('think_article.id'=>$id))->field('u.id as uid,title,hits,publish,username,tagname,content')->join('think_user as u on think_article.uid = u.id')->join('think_tags as t on think_article.tagid = t.id')->select();
            $nextid = $articleModel->where('id >'.$id)->field('id')->limit(1)->select()[0];
            $previd = $articleModel->where('id <'.$id)->field('id')->order('id desc')->limit(1)->select()[0];
            $data[0]['publish'] = substr($data[0]['publish'],0,10);
            $data[0]['aid'] = $id;
            $this->assign('details',$data[0]);
            $this->assign('next',$nextid['id']);
            $this->assign('prev',$previd['id']);
            //留言内容
            $comments = M('comment as c')->field('username,c.time,imgpath,content,pid,c.id as cid,u.id as uid')->join('think_user as u on c.uid=u.id')->where('c.aid='.$id)->order('c.time desc')->select();
            $this->assign('comments',$comments);
            $this->assign('comments_json',json_encode($comments));
            // var_dump($comments);
            $this->display();
    }

    //文章点赞
    public function like(){
        if (IS_AJAX) {
            $data['uid'] = session('uid');
            $data['aid'] = intval(I('post.aid'));
            if (null != I('post.check')) {
                $info['cur'] = M('like')->where($data)->count() == '1'?'1':'0';
                $info['sum'] = M('article')->where(array('id'=>$data['aid']))->field('likes')->select()[0]['likes'];
                $this->ajaxReturn($info,'json');
            }else{
            $count = M('like')->where($data)->count();
            if ($count == '0') {
                if (M('like')->add($data)) {
                    if (M('article')->where(array('id'=>$data['aid']))->setInc('likes')) {
                        echo "0";
                    }
                }
            }else{
                if (M('like')->where($data)->delete()) {
                    if (M('article')->where(array('id'=>$data['aid']))->setDec('likes')) {
                           echo "1";
                }
              }
            }
          }
        }
    }

    //添加评论
    public function addComment(){
        if (IS_POST) {
            $content = trim(I('post.comment')) == ''?$this->error('评论不能为空字符串'):trim(I('post.comment'));
            $data = array( 
                'content' => $content, 
                'ip' => ip2long(get_client_ip()), 
                'time' => time(), 
                'pid' => I('post.pid','',intval), 
                'uid' => session('uid'), 
                'aid' => I('post.aid','',intval),
            ); 
            if (M('comment')->add($data)) {
               $this->success('留言添加成功');
            }
        }
    }

    //删除评论
    public function deleteComment(){
            $cid = intval(I('get.cid'));
            if (M('comment')->where('id='.$cid)->delete()) {
               $this->success('删除留言成功');
            }else{
                $this->error('删除失败');
            }
    }
}
