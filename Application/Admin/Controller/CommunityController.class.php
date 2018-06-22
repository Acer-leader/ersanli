<?php
namespace Admin\Controller;
header("Content-type:text/html;charset=utf-8");
use Common\Controller\CommonController;
class CommunityController extends CommonController{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }
    public function index()
    {
        $title = I('post.title');
        if ($title) {
            $where['title'] = array('like', "%$title%");
        }
        //获取列表
        $list = D('Community')->communityLists($where,10);
        $this->assign('list',$list['list']);
        $this->assign('page',$list['page']);
        $this->display();
    }

    //删除/置顶
    public function savestatus()
    {
        $data['id'] = I('post.id');
        $data['action'] = I('post.action');
        $res = D('Community')->saveStatus($data);
        $this->ajaxReturn($res);
    }

    //批量删除/置顶
    public function delall()
    {
        $id = explode('-', I('post.ids'));
        array_pop($id);
        foreach ($id as $k => $v) {
            $res = M('community')->where("id=$v")->setField('isdel','1');
        }
        echo 1;
    }

    //添加
    public function addcommunity()
    {
        $data = I('post.');
        if ($data) {
            $res = D('Community')->addCommunity($data);
            if ($res == 1) {
                $this->redirect('Admin/community/index');
            }
        }else{
            $id = I('get.id');
            $info = D('Community')->getOneCommunity($id);
            $this->assign('info',$info);
            $this->display();
        }
    }
    
}

