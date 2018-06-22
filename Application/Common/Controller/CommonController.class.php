<?php
namespace Common\Controller;
use Think\Controller;
class CommonController extends Controller
{
    protected function _initialize()
    {
        $uid = session('admin_id');
        if(!$uid)   //判断用户是否已经登录
            $this->redirect('/Admin/User/login');
        $this->assign("munetype", CONTROLLER_NAME);
        $this->assign('urlname', strtolower(ACTION_NAME));
        session('access',$this->getAccess($uid));   //获取当前用户所有的权限
        $this->checkAuth($uid);     //检查权限
        $this->showNodeList();      //显示导航
        $this->setSeo();
        $this->assign('IMG_URL',C('IMG_URL'));
    }
    public function setSeo($title="",$keywords="",$description="")
    {   // 得到商城SEO配置
        $shop_seo = S("chaowei_shop_seo");
        if(empty($shop_seo))
        {
            $shop_seo = M('web_config')->find(1);
            S("dnl_seo", $shop_seo, array('expire'=>24*60*60));
        } elseif ($shop_seo != M('web_config')->find(1)){
            $shop_seo = M('web_config')->find(1);
            S("dnl_seo", $shop_seo, array('expire'=>24*60*60));
        }
        $shop_seo['title'] = $title?$title:$shop_seo['seo_title'];
        $shop_seo['keywords'] = $keywords?$keywords:$shop_seo['seo_keywords'];
        $shop_seo['description'] = $description?$description:$shop_seo['seo_description'];
        $this->assign("shop_seo_config", $shop_seo);
    }

    //添加总后台操作日志记录
    public function addStoreOperationLog($adminid,$content,$controller=CONTROLLER_NAME,$action=ACTION_NAME){
        $map = array();
        $map['now_ip'] = real_ip();
        $map['admin_id'] = $adminid;
        $map['add_time'] = time();
        $map['content'] = $content;
        $map['controller'] = $controller; //控制器名称
        $map['action'] = $action;  //方法名称
        M('admin_log')->add($map);
    }

    public function addImage()
    {   //上传图片
        $data = $this->uploadImg();
        $this->ajaxReturn($data);
    }
    private function uploadImg()
    {   //上传图片
        $upload = new \Think\UploadFile;
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','svg');// 设置附件上传类型
        $savepath='./Uploads/Picture/'.date('Ymd').'/';
        if (!file_exists($savepath))
            mkdir($savepath);
        $upload->savePath =  $savepath;// 设置附件上传目录
        if(!$upload->upload())
        {   //上传错误提示错误信息
            $this->error($upload->getErrorMsg());
        }else{  //上传成功 获取上传文件信息
            $info = $upload->getUploadFileInfo();
        }
        return $info;
    }
    protected function delFile($srcfile)
    {   //删除文件
        $srcfile=str_replace(__ROOT__.'/', '', str_replace('//', '/', $srcfile));
        if (file_exists($srcfile))
            unlink($srcfile);
        print_r($srcfile);
        exit;
    }
    private function getAccess($uid)
    {   //获取当前用户的权限节点
        $cate   = D("user")->where(array('id'=>$uid))->getField('cate');    //所属用户组
        if($cate==0)
        {   //超级管理员
            $module = D('admin_node')->getField('id',true);       //超级管理员
            sort($module);
            return implode(',',$module);
        }
        return D('admin_cate')->where(array('id'=>$cate))->getField('module');   //所属用户组权限
    }
    protected function checkAuth($uid)
    {   //检查管理员操作权限，由当前控制器和方法 输出左侧的urlname
        $db = D("admin_node");
        $controller_name = strtolower(CONTROLLER_NAME);
        $action_name     = strtolower(ACTION_NAME);
        $map = array();
        $map["level"] = 4;
        $map["controller"] = $controller_name;
        $map["action"]     = $action_name;
        $map["id"]         = array("in", session('access'));
        $res = $db->where($map)->order("level desc")->find();
        if(!$res)
        {
            if(IS_AJAX)
            {
                $this->ajaxReturn(array('status'=>0,"info"=>"您没有此操作权限"));
            }else{
                exit("no access!");
            }
        }// 输出左侧选中的urlname
        $action = $db->where(array('id'=>$res['pid']))->getField('action');
        $action = $controller_name.'_'.$action;
        //$action = session('controller_action');  //dump($action);
        $this->assign('left_urlname', $action);
    }
    protected function showNodeList()
    {  //获取头部导航/左侧导航栏/
        $controller_name = strtolower(CONTROLLER_NAME);
        $action_name     = strtolower(ACTION_NAME);   //dump($controller_name);dump($action_name);
        $db = D("admin_node");
        //dump(session('access'));
        $head = $db->where(array("level"=>1,"id"=>array("in", session('access'))))->order("sorts ASC")->select();     //获取顶部导航栏
        $this->assign("node_head_list", $head);     // 输出顶部
        $q = $db->where(array("controller"=>$controller_name, "action"=>$action_name))->order("level DESC")->find();    //获取当前访问的模块/方法
        $qselect = $controller_name.'_'.$action_name;
        $map = array();
        $map['id'] = array("in",session('access'));
        switch($q['level'])
        {
            case "1":
                $map["pid"] = $q['id'];
            break;
            case "3":
                $map["pid"] = $q['pid2'];
            break;
            case "4":
                $map["pid"] = $q['pid3'];
            break;
            default:
                exit("no access");
        }
        $left = $db->where($map)->order("sorts ASC")->select();   //所有左侧导航
        foreach($left as $k=>$v)
        {
            $left[$k]['nodes'] = $db->where(array("pid"=>$v['id']))->order("sorts ASC")->select();       //获取所有子节点
            foreach($left[$k]['nodes'] as $key=>$val)
            {   //组合模块/方法
                $left[$k]['nodes'][$key]['controller_action'] = $val['controller'].'_'.$val['action'];
                if(($val['controller'].'_'.$val['action']) == $qselect){//当前访问模块存在于左侧中
                    session('controller_action',$qselect);
                    $this->assign('left_urlname', $qselect);
                }
            }
        }
        $this->assign("node_left_list", $left);     //输出左侧导航
        //$sort = $db->where(array('id'=>$map['pid']))->getField('sorts');    //获取当前选中头部
        $controllering = $db->where(array('id'=>$map['pid']))->getField('controller'); //dump($controllering);   //获取当前选中头部
        //$this->assign("head_munetype", $sort);      //输出当前选中头部note
        $this->assign("head_munetype", $controllering);      //输出当前选中头部note
    }
    /**
     * 发送系统通知的方法
     * @param int     $userid    接受消息者的id
     * @param string  $msg       需要推送的消息
     * @param array   $data      需要修改的参数
     */
    protected function sendSystemMessage($userid,$title, $msg, $data=array())
    {
        $data["title"]=$title;
        $data["msg"]       = $msg;
        $data['user_id']   = $userid;
        $data['create_at'] = time();
        $res = M("systemMessage")->add($data);
        if($res)
            return true;
        return false;
    }
    
    protected function returnAjax($id=1)
    {   //简单返回状态
        if($id!==false)
          $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
        $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败'));
    }
    public function emojiToImg($text){
        $biaoqing = array();
        $bqimg = array();
        for ($i = 1; $i <= 75; $i++) {
            $biaoqing[] = '/\[em_'.$i.'\]/';
            $bqimg[] = '<img src="/Public/Home/images/arclist/'.$i.'.gif">';
        }
        return preg_replace($biaoqing,$bqimg,$text);
    }
}