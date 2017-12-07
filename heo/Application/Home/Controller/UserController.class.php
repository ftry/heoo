<?php
// +----------------------------------------------------------------------
// | Author: 付立 <674310383@qq.com> 
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
use Home\Model\Captche;
/**
* 用户控制器
*/
class UserController extends Controller
{
    
    public function index(){
        if (!session('?logined')) {
            $this->show();
        }else{
            $this->success('您已经登陆,请注销后再进行此项操作!',U('index/index'));
        }
        
    }

    public function register(){
            if (IS_POST) {
                $userModel = D('user');
                $data['username'] = trim(I('post.userName'));
                $data['email'] = trim(I('post.email'));
                $data['password'] = trim(I('post.password'));
                $data['confirmpwd'] =trim(I('post.confirmPwd'));
                $data['gender'] = trim(I('post.gender'));
                $data['birthday'] =trim( I('post.birthday'));
                $data['imgpath'] = "/Public/home/imgs/defaultx.png";
                // $data['ip'] = get_client_ip();
                if ($userModel->create($data)) {
                    if ($userModel->add()) {
                        $this->success('注册成功,请登录!','login');
                    }else{
                       $this->error($userModel->getError());
                    }
                }else{
                    $this->error($userModel->getError());
                }
            }else{
                 $this->redirect('index',0);
            }
           
    }

    public function login(){
        if (!session('?logined')) {
            if (IS_POST) {
                $data['email'] = trim(I('post.email'));
                $data['password'] = md5(trim(I('post.password')));
                $code = trim(I('post.vcode'));
                $ip = ip2long(get_client_ip());
                $userModel = D('user');
                if (Captche::checkCaptche($code)) {
                    if ($userModel->where($data)->select()) {
                      $loginInfo = $userModel->login($data,$ip);
                        if ($loginInfo) {
                          session('sessionid',$loginInfo['sessionid']);
                          session('logined',$loginInfo['username']);
                          session('uid', $loginInfo['id']);
                          session('imgpath',$loginInfo['imgpath']);
                          if (null != I('post.keep')) {
                              cookie('username',$loginInfo['username'],3600*24);
                              cookie('sessionid',$loginInfo['sessionid'],3600*24);
                              cookie('uid',$loginInfo['id'],3600*24);
                              cookie('imgpath',$loginInfo['imgpath'],3600*24);
                          }
                        $this->success('登录成功',U('index/index'));
                        }else{
                          $this->error('登陆失败,请稍后重试!');
                        }
                    }else{
                        $this->error('用户名或密码错误!');
                    }
                }else{
                    $this->error('验证码不正确');
                }
            }else{
                $this->assign('login','ok');
                $this->display('index');
            }
        }else{
            $this->error('您已登录,不必重复登陆.',U('index/index'));
        }
    }

    public function logout(){
        if (session('?logined')) {
            $db_session = M('session')->where(array('uid'=>session('uid')))->field('sessionid')->select()[0]['sessionid'];
            //判断是否是当前用户正常注销操作
            if ($db_session == session('sessionid')) {
                if (M('session')->where(array('sessionid'=>session('sessionid')))->delete()) {
                    if (M('user')->where(array('id'=>session('uid')))->save(array('status'=>0))) {
                        session(null);
                        cookie('username',null);
                        cookie('sessionid',null);
                        cookie('uid',null);
                        cookie('imgpath',null);
                        $this->success('注销成功','login');
                    }else{
                        $this->error('注销失败,请重试!');
                    }
                }else{
                    $this->error('注销失败,请重试!');
                }               
            }else{
                session(null);
                cookie('username',null);
                cookie('sessionid',null);
                cookie('uid',null);
                cookie('imgpath',null);
                $this->success('注销成功','login');
            }
        }else{
            $this->error('非法操作!');
        }
    }
    //处理注册页面ajax验证
    public function ajaxUserName(){
        if (IS_AJAX) {
            $userModel = M('user');
            if ($userModel->where(array('username'=>I('post.userName')))->select()) {
                echo "1";
            }else{
                echo "0";
            }
        }else{
            $this->error('你谁呀，不认识你!');
        }
    }

    //生成验证码
    public function captche(){
        return Captche::createCaptche();
    }

    public function userInfo(){
      if (session('logined')) {
        //用户基本信息
        $baseInfo = M('user as u')
                                ->where(array('u.id'=>session('uid')))
                                ->field('username,email,birthday,gender,login_count,last_login_ip,last_login_time,count(a.id) as acount,createtime')
                                ->join('think_article as a on u.id = a.uid')
                                ->select()[0];
        //留言信息
        $commentInfo = M('comment as c')
                                ->where(array('c.uid'=>session('uid'),'pid'=>'0'))
                                ->field('title,time,c.content')
                                ->join('think_article as a on c.aid = a.id')
                                ->select();
        //回复我的消息
        $replyToMe = M('comment as c')
                                ->where(array('c.uid'=>session('uid')))
                                ->field('username,cr.content,c.time')
                                ->join('think_comment as cr on cr.pid = c.id')
                                ->join('think_user as u on cr.uid = u.id')
                                ->select();
        //我回复的消息
        $replyFromMe = M('comment as c')
                                ->where('c.uid='.session('uid').' and not c.pid=0')
                                ->field('username,c.content,c.time')
                                ->join('think_comment as cf on cf.id = c.pid')
                                ->join('think_user as u on cf.uid = u.id')
                                ->select();

        $setInfo = M('user')->where('id='.session('uid'))->field('username,imgpath,birthday,email,gender')->select()[0];
        // var_dump($setInfo);
        // var_dump($commentInfo);
        // var_dump($replyToMe);
        // var_dump($replyFromMe);
        $this->assign('baseInfo',$baseInfo);
        $this->assign('commentInfo',$commentInfo);
        $this->assign('replyToMe',$replyToMe);
        $this->assign('replyFromMe',$replyFromMe);
        $this->assign('setInfo',$setInfo);
        $this->Display();
      }else{
         $this->redirect('login',0);
      }
    }

    public function setUserInfo(){
        $userModel = M('user');
        $userInfo = $userModel->where('id !='.session('uid'))->field('username,email,birthday')->select()[0];
        $data = array();
        if (I('post.username') != session('logined')) {
            $username = I("post.username");
            if (!in_array($username,$userInfo)) {
               $data['username'] = I('post.username');
            }else{
                $this->error('用户名已被占用,请更换后重试...');
            }
        }
        $otherInfo = $userModel->where('id='.session('uid'))->field('gender,birthday,email,imgpath')->select()[0];
        if (I('post.email') != $otherInfo['email']) {
            $email = I('post.email');
            if (!in_array($email, $userInfo)) {
               $data['email'] = I('post.email');
            }else{
                $this->error('邮箱已被注册,请更换后重试...');
            }
        }

        if (I('post.gender') != $otherInfo['gender']) {
            $data['gender'] = I('post.gender');
        }
        
        if (I('post.birthday','',strtotime) != $otherInfo['birthday']) {
            strtotime(I('post.birthday')) > time() || strtotime(I('post.birthday')) < strtotime('1970-00-00')?$this->error('生日超出可能日期!') : $data['birthday'] = strtotime(I('post.birthday'));
        }
        $uploadFlag = false;    //判断是否上传文件
        if ($_FILES['myfile']['name'] != '') {
            $uploadFlag = true;
            //首次上传文件
            if ((!file_exists('./Public/home/uploads/'.session('uid').'_img.png')) &&
                (!file_exists('./Public/home/uploads/'.session('uid').'_img.jpg')) &&
                (!file_exists('./Public/home/uploads/'.session('uid').'_img.jpeg')))
                {
                $uploadInfo = $this->uploadTx();
                if (!$uploadInfo) {
                    $this->error('上传头像失败!0');
                }
                $data['imgpath'] = '/Public/home/uploads/'.$uploadInfo;
                }else{
                    //相同用户头像不能重复存在
                    if (file_exists('./Public/home/uploads/'.session('uid').'_img.png')) {
                        if (unlink('./Public/home/uploads/'.session('uid').'_img.png')) {
                            $uploadInfo = $this->uploadTx();
                             if (!$uploadInfo) {
                                 $this->error('上传头像失败!1');
                             }
                             if ('/Public/home/uploads/'.$uploadInfo != $otherInfo['imgpath']) {
                                 $data['imgpath'] = '/Public/home/uploads/'.$uploadInfo;
                             }
                        }
                    }elseif (file_exists('./Public/home/uploads/'.session('uid').'_img.jpg')) {
                        if (unlink('./Public/home/uploads/'.session('uid').'_img.jpg')) {
                            $uploadInfo = $this->uploadTx();
                             if (!$uploadInfo) {
                                 $this->error('上传头像失败!2');
                             }
                             if ('/Public/home/uploads/'.$uploadInfo != $otherInfo['imgpath']) {
                                 $data['imgpath'] = '/Public/home/uploads/'.$uploadInfo;
                             }
                        }
                    }elseif (file_exists('./Public/home/uploads/'.session('uid').'_img.jpeg')) {
                        if (unlink('./Public/home/uploads/'.session('uid').'_img.jpeg')) {
                            $uploadInfo = $this->uploadTx();
                             if (!$uploadInfo) {
                                 $this->error('上传头像失败!3');
                             }
                             if ('/Public/home/uploads/'.$uploadInfo != $otherInfo['imgpath']) {
                                 $data['imgpath'] = '/Public/home/uploads/'.$uploadInfo;
                             }
                        }
                    }
                }
        }else{
            $upload = false;
        }

        //判断更新信息是否为空
        if (!empty($data)) {
            if($userModel->where('id='.session('uid'))->save($data)) {
                isset($data['username'])?session('logined',$data['username']):null;
                // isset($data['email'])?session('email',$data['email']):null;
                isset($data['imgpath'])?session('imgpath',$data['imgpath']):null;
                $this->success('修改信息成功');
            }else{
                $this->error($userModel->getError());
            }
        }elseif (!$uploadFlag) {
            $this->error('你的信息未修改');
        }else{
            $this->success('修改信息成功');
            }
        }

    //上传文件方法
    public function uploadTx(){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->autoSub = false;
            $upload->saveName   =   session('uid').'_img';
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
            $upload->rootPath =      './Public/home/uploads/';  
            $info   =   $upload->uploadOne($_FILES['myfile']); // 上传单个文件 
            if(!$info) {// 上传错误提示错误信息  
                 // $this->error($upload->getError());
                 // die;
                 return false;
            }else{// 上传成功 获取上传文件信息  
                 // echo $info['savepath'].$info['savename'];
                 return $info['savename'];
            }
    }
}
