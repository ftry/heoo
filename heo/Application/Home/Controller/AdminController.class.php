<?php 
//++++----张盈修缮--------
namespace Home\Controller;

use Think\Controller;


/**
* 文章控制器
*/
class AdminController extends Controller
{
   

    //新增文章
    /*public function add(){
        if (IS_POST && isset($_POST['artsubmit'])) {
            //$tids = M('tags')->getField('id as tid',true);
            $data['title'] = (trim(I('post.title')) == ''?$this->error('标题不能为空'):I('post.title'));
            $data['summary'] = (trim(I('post.summary')) == ''?$this->error('内容概要不能为空'):I('post.summary'));
            $data['cover'] = (trim(I('post.cover')) == ''?$this->error('内容概要不能为空'):I('post.cover'));
            
            //I('post.cover') == null?$data['image']="/Public/home/imgs/jian.png":$data['image']=I('post.cover');
          /*  if (I('post.tagid') != '') {
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
            trim(I('post.content')) == ''?$this->error('文章内容不能为空哦!'):$data['content'] = I('post.content');*/
           /* if(M('tags')->add($data)){
                $data=null;
                $this->success('添加文章成功!',U('index/index'));
            }else{
                $data=null;
                $this->error('抱歉，添加失败，请重试!');
            }
        }/*else{
            $tags = M('tags')->getField('tagname',true);
            $this->assign('tags',$tags);
            $this->display();
        }
       
    }*/
    //分类展示
    /*public function news(){
        $p=isset($_GET['p'])?$_GET['p']:0;
        if (null != I('get.cat')) {
            $cat = I('get.cat');
            $cats = M('tags')->getfield('title',true);
            if (!in_array($cat, $cats)) {
                $this->error('分类参数错误!');
            }
            $lists = M('tags')->field('think_tags.id,title,image')->join('think_tags as t on t.id = think_article.tagid')->join('think_user as u on u.id = think_article.uid')->where(array('tagname'=>$cat))->page($p.','.C('C_PAGE_SIZE'))->select();
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
    }*/


    public function category(){
    
        $tags = M('tags');

      
        $title = $tags->where('id=1')->getField('title');

        /*$data = $tags -> find('$id');

        if($data){
            $this -> data =$data;
        }else{
            $this -> error('数据错误')；
        }
        $this -> display('category');
        $list = $tags -> limit(5) -> select();
        
        $this -> assign('list' , $list);
        
        $this -> display();*/
    }

    public function add()
    {
        if(IS_POST){
            $Tags = D('Tags');
    
            if(!$data = $Tags -> create()){
                header("Content-type: text/html ; charset = utf-8");
                 
                exit($Tags -> getError());
            }
    
          
            if($id = $Tags -> add($Data)){
    
              
                
                $this -> success('发表成功');
               
            }else{
                $this -> error('噢，失败');
            }
        
        }else{
           
            $this -> display();
        }  
    }
}