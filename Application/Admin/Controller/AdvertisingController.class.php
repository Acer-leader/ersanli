<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class AdvertisingController extends CommonController
{   //广告模块
    private $malltype;   //商城类型
    private $storeid;    //商家id  平台0
    public function _initialize()
    {
        parent::_initialize();
        $this->storeid  = 1;
        $this->assign('storeid',$this->storeid);
    }
    #广告 201709141131 Cyonger#
    public function index()
    {   //列表
        $lists = D("GoodsAdvertising")->Lists();
        $this -> assign('list',$lists);
        $this->display();
    }
    #位置 201709141101 Cyonger#
    public function indexAddEditDelStatus()
    { //添加 修改 删除
        if(IS_POST){
            $this -> ajaxReturn(D("GoodsAdvertising")->addEditDelStatus());
        }
        $this -> ajaxReturn(array('status'=>0,'info'=>''));
    }
    public function place()
    {   //列表
        $lists = D("GoodsAdvplace")->Lists();
        $this->assign('lists',$lists);
        $this->display();
    }
    public function placeAddEditDelStatus()
    {   //添加修改删除状态
        if(IS_POST){
            $this->ajaxReturn(D("GoodsAdvplace")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }
    #分类#
    
}