<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller
{   //后台用户登录部分
    public function login()
    {   //登录
        $this->setSeo();
        $this->display();
    }
    public function setSeo($title="",$keywords="",$description="")
    {   // 得到商城SEO配置
        $shop_seo = S("web_seo");
        if(empty($shop_seo))
        {
            $shop_seo = M('web_config')->find(1);
            S("web_seo", $shop_seo, array('expire'=>24*60*60));
        } elseif ($shop_seo != M('web_config')->find(1)){
            $shop_seo = M('web_config')->find(1);
            S("web_seo", $shop_seo, array('expire'=>24*60*60));
        }
        $shop_seo['title'] = $title?$title:$shop_seo['seo_title'];
        $shop_seo['keywords'] = $keywords?$keywords:$shop_seo['seo_keywords'];
        $shop_seo['description'] = $description?$description:$shop_seo['seo_description'];
        $this->assign("shop_seo_config", $shop_seo);
    }
    public function verify_c()
    {   //验证码生成
        ob_clean();
        $Verify = new \Think\Verify();
        $Verify->fontSize = 18;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 130;
        $Verify->imageH = 50;
        $Verify->entry();
    }
    public function checkloginajax()
    {   //后台检测登录
        // 检查验证码
        $verify = I('param.vcode','');
        if(!check_verify($verify))
        {
            $data['info']   =   '亲，验证码输错了哦！'; // 提示信息内容
            $data['status'] =   0;  // 状态 如果是success是1 error 是0
            $data['url']    =   ''; // 成功或者错误的跳转地址
            $this->ajaxReturn($data);
        }
        $rs = D("User")->login();
        if($rs == 1)
        {
            $data['info']   =   '登录成功咯~'; // 提示信息内容
            $data['status'] =   1;  // 状态 如果是success是1 error 是0
            $data['url']    =   ''; // 成功或者错误的跳转地址
        }elseif($rs == 0){
            $data['info']   =   '帐号或者密码错误~'; // 提示信息内容
            $data['status'] =   0;  // 状态 如果是success是1 error 是0
            $data['url']    =   ''; // 成功或者错误的跳转地址
        }else{
            $data['info']   =   '帐号已禁用~'; // 提示信息内容
            $data['status'] =   0;  // 状态 如果是success是1 error 是0
            $data['url']    =   ''; // 成功或者错误的跳转地址
        }
        $this->ajaxReturn($data);
    }
    public function  logout()
    {   //后台退出的登录
        $username=I("get.sid");
        if(!empty($username)){
            session('admin',null); // 删除登录信息
            session('admin_id',null); // 删除name
            session_destroy();
            $this->redirect("/Admin/Index/login"); //直接跳转，不带计时后跳转
        }
    }
    public function updatepwd()
    {   //修改密码
        $action=D('User');
        $pass=I('post.password');
        if($pass)
        {
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