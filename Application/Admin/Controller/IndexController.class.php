<?php
namespace Admin\Controller;
header("Content-type:text/html;charset=utf-8");
use Common\Controller\CommonController;
class IndexController extends CommonController{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }
    public function index()
    {
        $this->display();
    }
    public function web_config()
    {   //官网配置
        if(IS_POST){
            $data=I("post.");
            $data['update_time']=time();
            $find = M("web_config")->where("id=1")->find();
            if($find)
            {
                $res = M("web_config")->where("id=1")->save($data);
            }else{
                $data['update_time'] = NOW_TIME;
                $res = M("web_config")->add($data);
            }
            if($res !== false){
                $this->ajaxReturn(array("status"=>1, "info"=>"保存成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"保存失败！"));
            }exit;
        }
        $cache = M("web_config")->where(array("id"=>1))->find();
        $this->assign("cache",$cache);
        $this->display();
    }
    public function updatepwd()
    {   //修改密码
        $action=D('User');
        $pass=I('post.password');
        if($pass){
            $md5_pass=md5(md5($pass).$pass);
            $re=$action->where("username='".$_SESSION['admin']."'")->setField('password',$md5_pass);
            if($re){
                $this->success('修改成功',U('/Admin/Index/index'));die;
            }else{
                $this->error('修改失败');die;
            }
        }
        $this->assign('munetype',9);
        $this->display('updatepwd');
    }
}

