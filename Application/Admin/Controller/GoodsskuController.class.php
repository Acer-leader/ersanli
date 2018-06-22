<?php
namespace Admin\Controller;
header("Content-type:text/html;charset=utf-8");
use Common\Controller\CommonController;
class GoodsskuController extends CommonController{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }
    public function index()
    {
        $title = I('post.title');
        if ($title) {
            $where['classname'] = array('like', "%$title%");
        }
        //获取列表
        $list = D('SkuAttr')->listSku($where,10);
        $this->assign('list',$list['list']);
        $this->display();
    }

    //添加
    public function add()
    {
        //获取上级sku数据
        $list = D('SkuAttr')->getPid();
        $this->assign('list',$list);
        $data = I();
        if ($data['classname']) {
            $res = D('SkuAttr')->addSku($data);
            if ($res == 1) {
                $this->redirect('Admin/Goodssku/index');
            }
        }else{
            $id = I()['id'];
            $info = D('SkuAttr')->getOneSku($id);
            $this->assign('info',$info);
            $this->display();
        }
    }

    //删除/置顶
    public function del()
    {
        $data = I();
        $res = D('SkuAttr')->saveStatus($data);
        $this->ajaxReturn($res);die;
    }


    //批量删除
    public function edit()
    {
        $id = explode('-', I('post.ids'));
        array_pop($id);
        foreach ($id as $k => $v) {
            $res = M('sku_attr')->where("id=$v")->setField('isdel','1');
        }
        echo 1;
    }
    
}

