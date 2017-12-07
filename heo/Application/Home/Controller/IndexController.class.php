<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
   /* public function index()
    {
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }*/
   
   // public function index(){

   //}

   //REGISTER
   public function register_boy(){
    if(IS_POST){
        $User = D('User');

        if(!$data = $User -> create()){
            header("Content-type: text/html ; charset = utf-8");
             
            exit($User -> getError());
        }

      
        if($id = $User -> add($Data)){

          
            
            $this -> success('注册成功', './login');
        }else{
            $this -> error('注册失败');
        }
    
    }else{
        $this -> display();
    }
    
   }

   public function register_girl(){
    if(IS_POST){
        $User = D('User');

        if(!$data = $User -> create()){
            header("Content-type: text/html ; charset = utf-8");
             
            exit($User -> getError());
        }

      
        if($id = $User -> add($Data)){

          
            
            $this -> success('注册成功' , './login');
        }else{
            $this -> error('注册失败');
        }
    
    }else{
        $this -> display();
    }
    
   }


   //login--------------------------------------------------------------------
  public function login(){
    
            if(!empty($_POST)){
               /* $verify = new \Think\Verify();
                if(!$verify -> check($_POST['captcha'])){
                    $verify = I('paran . verify' , '');
                    if(!check_verify($verify)){
                        $this -> error("亲，验证码错误" , $this -> site_url , 1);
    
                    } 
                }else{*/
                    $user = new \Home\Model\UserModel();//此处调用的model里的方法要单独以xxxModel的方式。非常重要我的青娘！！！！！！！！！！！！！！！！
                    $user = D('user');
                    $rst = $user -> checkNamePwd($_POST['name'] , $_POST["pw"]);
    
                    if($rst === false){
                        echo '用户名或密码错误';
                    }else{
                        session("name" , $rst['name']);
                        session("id" , $rst['id']);
                        session("tel" , $rst['tel']);
                        $this -> redirect('Index/home_page',0);
                        //$this -> redirect('Index/shuo',0)
                    
                } 
            }else {$this -> display();}
            //$this -> display();
    }//---------------------------------------------------------------
    //退出------------------------------
    public function userLogout()
    {
        session(null);
        //session_destroy();
        //unset($_SESSION);
        $this->redirect(U('Home/Index/index'));
    }
   //--------------------------------------
    //show
    public function show(){ 
        session_start();
        //uname == $_SESSION['name']; 
        //upwd==_SESSION['pw'];
        $id = SESSION('id');
           $user=M('user');
           $select=$user->query("select * from think_user where name='$name' and tel");
        
           $this->assign('info',$select);
           $this->display();      
           
        }



    //user
    public function user_center(){

    }

    //校园动态：新闻发布/
    public function news()
    {
       
            /*if (IS_POST && isset($_POST['artsubmit'])) {
                //$tids = M('tags')->getField('id as tid',true);
                $data['title'] = (trim(I('post.title')) == ''?$this->error('标题不能为空'):I('post.title'));
                $data['summary'] = (trim(I('post.summary')) == ''?$this->error('内容概要不能为空'):I('post.summary'));
                $data['cover'] = (trim(I('post.cover')) == ''?$this->error('内容概要不能为空'):I('post.cover'));
                
                //I('post.cover') == null?$data['image']="/Public/home/imgs/jian.png":$data['image']=I('post.cover');
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
                if(M('tags')->add($data)){
                    $data=null;
                    $this->success('添加文章成功!',U('index/index'));
                }else{
                    $data=null;
                    $this->error('抱歉，添加失败，请重试!');
                }
            }*/
            
    }
    
    
    //新闻查看
    public function read()
    {
        $Tags = M('Tags');

      
        //$title = $Tags->getField('title',10);
        //$Model -> field('title')->select();
       /*$data = $Tags->find($title);
        if($data) {
        $this->assign('data',$data);// 模板变量赋值
        }else{
        $this->error('数据错误');
        }*///-------------------

        //$this->data = $Data->select();

        $list = $Tags -> limit(100) -> select();
        
        $this -> assign('list' , $list);
        
        


        /*$data = $tags -> find('$id');

        if($data){
            $this -> data =$data;
        }else{
            $this -> error('数据错误')；
        }
        $this -> display('category');
        $list = $tags -> limit(5) -> select();
            
        $this -> assign('list' , $list);*/
        
        $this -> display();
    }

    public function words()
    {
        # code...

        $Tags = M('Tags');
        $id = I('get.id');//一个非常重要的部分：用于读取由模板view传来的参数------------------++++++++++------------
       
        //$title = intval(I('get.title'));
        //$Tags->where('title='.$title)->find('content');
        //!in_array($id, $Tags->getField('id',true));
        //$list = $Tags->where(array('think_tags.id'=>$id))->field('title,content')->select();
        
        
        //---------------------------------------------
        //$list = $Tags -> limit(100) -> select();
        //+                                             +
        //$this -> assign('list' , $list);
        //-----------------------------------------------


        $data = $Tags -> find($id);
        if($data) {
            $this->assign('data',$data);// 模板变量赋值
            }else{
            $this->error('数据错误');
            }



        $this -> display();

    }


    //视频播放
    public function video()
    {
        # code...
        $Video = M('Video');

        $list = $Video -> limit(100) -> select();
        
        $this -> assign('list' , $list);

        $this -> display();


        
    }


    /*public function user_centre()
    {
        # code...
        $user = M('user')->where(array('id' => session(MERCHANT)))->find();
        $this->user = $user;
        $this->user_id = $user['id'];
    }*/
   
    //交易----------------
    //发布
    public function deal()
    {
        if(IS_POST){
        //if (IS_POST && isset($_POST['artsubmit'])){
        //$task = M('task');

        $data['uid'] = session('id');
        $data['time'] = I('post.time');
        $data['class'] = I('post.class');
        $data['room'] = I('post.room');
        $data['demand'] = I('post.demand');

        if(M('task') -> add($data)){
            $data = null;
            $this -> success('发布成功!','./work');
        }else{
            $data = null;

            $this -> error('抱歉，发布失败！');

        }
        }else{
            
            $this -> display();

        }
 
        

        
      


    }

    //任务列表

    public function work()
    {
        $task = M('task');

        $list = $task -> limit(100) -> select();
        
        $this -> assign('list' , $list);

        $this -> display();
    }


    //接受任务
    public function take()
    {
        $tid = M('tid');
        //$uid = I('get.uid')
        //if(IS_POST){

            
            
    
            $data['jid'] = session('id');//记录接任务的人
            $data['uid'] = I('get.id');//记录发布任务的人
            //$data['class'] = I('post.class');
            //$data['room'] = I('post.room');
            //$data['demand'] = I('post.demand');
    
            if(M('tid') -> add($data)){
                $data = null;
                $this -> success('接单成功!');
            }else{
                $data = null;
    
                $this -> error('抱歉，接单失败！');
    
            }//-------------写入操作

            $task = M('task');
            $id = I('get.id2');
            //echo $id;
            $task->where('id='.$id)->delete();//用点来连接变量
            //$task -> delete('$id');

            //$this -> display();
            /*}
            else{
                
                $this -> display();
    
            }*/

    }



    //任务处理
    public function ret()
    {
        $tid = M('tid');
        //$con['jid'] = session('id');
        //$tid -> where($con)->select();
        $list = $tid->getField('uid',true);


       //foreach($this ->tid as $val){
           foreach($list as $val){//循环list数组

           
           //如果有相同的id则输出 已接受
           if($val == session('id')){
            //$a = strtoupper($val['jid']);
            echo  "已接受";
            //echo $a;
            //continue;//跳出循环
            break;//找到跳出第一循环
            
           }
           //echo "未接受";
           //else{
            //echo "未接受";
            //break;
            //echo $list;
            //echo session('id');
          //}
        } 
        //echo "未接受";

           /*foreach($list as $val){
            if($val != session('id')){
                echo "未接受";
                break;//结束循环S
    
               }
           }*/
    }

    //任务处理反馈
    public function inform()
    {
        $fk = M('fk');
        
       
    }











    //发邮件
   
     public function send(){
        if(sendMail('vsiryxm@qq.com','你好!邮件标题','这是一篇测试邮件正文！')){
                  echo '发送成功！';
            } else{
                   echo '发送失败！';
                  }
        }
         

}