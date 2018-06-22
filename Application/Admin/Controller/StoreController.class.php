<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class StoreController extends CommonController
{   //商家操作模块
    private $storeid;
    public function _initialize()
    {
        parent::_initialize();
        $this->storeid = 1;
        $this->assign('storeid',$this->storeid);
        
    }
    public function index()
    {   //平台商家管理
        $info = D("")->Info();
        $this -> assign('info',$info);
        $this->display();
    }
    public function detail()
    {   //详情
        if(IS_POST)
        {
            $this->ajaxReturn(D('')->addEditDelStatus());
        }else{
            $storeid = I('get.storeid/d',0,'intval');
            if(!$storeid){
                $storeid = $this->storeid;
            }
            $this->assign('storeshow',D('Store')->storeFind($storeid));
            $this->display();
        }
    }
    public function storeAddEditDelStatus()
    {   // 冻结/解冻
        if(IS_AJAX)
        {
            $id = I('post.id/d',0,'trim');
            $res = $this->Store_db->field("id,status,telephone")->where("id=$id")->find();
            if($res)
            {
                $res['status'] = $res['status'] ? 0 :1;
                $res2 = $this->Store_db->save($res);
                if($res2)
                {
                    $arr = array("正常","冻结");
                    $return = array("status" => 1,"info" => '操作成功','txt'=>$arr[$res['status']]);
                    $this->addStoreOperationLog(session('admin_id'),"删除还原商家{$res[telephone]},状态为:{$arr[$res[status]]}");
                }else{
                    $return = array("status" => 0,"info" => '操作失败');
                }
            }else{
                $return = array("status" => 2,"info" => '没有数据');
            }
            $this->ajaxReturn($return);
        }exit;
    }
    #标签#
    public function tag()
    {
        $where = array('storeid'=>$this->storeid,'isdel'=>'0');
        $lists = D("GoodsTag")->lists($where);
        $this->assign('lists',$lists);
        $this->display();
    }
    public function tagAddEditDelStatus()
    {   //添加修改删除状态
        if(IS_POST){
            $this->ajaxReturn(D("GoodsTag")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }
}