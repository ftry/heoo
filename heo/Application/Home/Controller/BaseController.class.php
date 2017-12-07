<?php 
namespace Home\Controller;
use Think\Controller;
/**
* 基础控制器
*/
class BaseController extends Controller
{
    function __construct()
    {
        parent::__construct();
        //读取cookie
        if (!session('?logined')) {
            if (cookie('uid')) {
                if ($this->isActiveUser(cookie('sessionid'),cookie('uid'))) {
                    session('sessionid',cookie('sessionid'));
                    session('logined',cookie('username'));
                    session('uid',cookie('uid'));
                    session('imgpath',cookie('imgpath'));
                }else{
                    cookie('username',null);
                    cookie('sessionid',null);
                    cookie('uid',null);
                    cookie('imgpath',null);
                    $this->redirect('user/login',0);
            }
        }else{
            $this->redirect('user/login',0);
        }
    }
       if (!session('?logined')) {
            $this->error('尚未登陆，无法操作',U('user/login'));
        }
       if (!$this->isActiveUser(session('sessionid'),session('uid'))) {
          $this->error('你的账号已在其他地方登陆,即将注销当前账号!',U('user/logout'));
       }
        $this->assign('tags',$this->getTags());
        $this->assign('count',M('article')->count());
    }

    //获取标签数据
    protected function getTags(){
        return M('tags as t')->field('tagname,count(tagid) as num')->join('left join think_article as a on a.tagid = t.id')->group('t.id')->select();
    }

    //判断当前状态是否有效
    protected function isActiveUser($sessionid,$uid){
        $sessionFlag = M('session')->where(array('uid'=>$uid))->field('sessionid')->select()[0]['sessionid'];
        if ($sessionid == $sessionFlag) {
            return true;
        }else{
            return false;
        }
    }
}