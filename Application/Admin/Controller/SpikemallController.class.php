<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class SpikemallController extends CommonController
{   //秒杀商城
    private $malltype;   //商城类型
    private $storeid;    //商家id  平台0
    public function _initialize()
    {
        parent::_initialize();
        $this->malltype = 2;
        $this->storeid  = 1;
        $this->assign('malltype',$this->malltype);
        $this->assign('storeid',$this->storeid);
    }
    public function index()
    {
        $this->display();
    }
    #分类#
    public function cate()
    {   //分类列表
        $catelists = D("GoodsCate")->cateLists($this->malltype,$this->storeid);
        $this->assign('catelists',$catelists);
        $this->display('Pointsmall/cate');
    }
    #商品 201709131553#
    public function Goods()
    {   //商品列表
        $map = array('storeid'=>(string)$this->storeid,'malltype'=>(string)$this->malltype,'isdel'=>'0');
        $title = I('get.title','','trim');
        if($title){
            $map['title'] = array('like',$title.'%');
            $this->assign('title',$title);
        }
        $issale = I('get.issale',1,'intval');
        $map['issale'] = (string)$issale;
        $this->assign('issale',$issale);
        list($count,$lists,$show) = D('Goods')->lists($map);
        $this->assign('count', $count);
        $this->assign('lists', $lists);
        if($count > 20){
            $this->assign('page', $show);// 赋值分页输出
        }
        $count1 = M('goods')->where(array('storeid'=>(string)$this->storeid,'malltype'=>(string)$this->malltype,'isdel'=>'0','issale'=>'1'))->count();
        $count2 = M('goods')->where(array('storeid'=>(string)$this->storeid,'malltype'=>(string)$this->malltype,'isdel'=>'0','issale'=>'0'))->count();
        $this->assign('count1', $count1);
        $this->assign('count2', $count2);
        $this->display();
    }
    public function goodsAddEdit()
    {   //添加商品
        if($_POST){
            $data = array();
            $data['malltype'] = trim(I('post.malltype'));
            if(!in_array($data['malltype'],array(1,2,3,4))){
                $this->error('错误的提交');
            }
            $data['storeid'] = trim(I('post.storeid'));
            if(!in_array($data['storeid'],array(1,2,3,4))){
                $this->error('错误的提交');
            }
            $data['cateid'] = trim(I('post.cateid'));
            if(!$data['cateid']){
                $this->error('请选择分类');
            }
            $data['timelimitid'] = trim(I('post.timelimitid'));
            if(!$data['cateid']){
                $this->error('请选择秒杀时间点');
            }
            $data['title'] = trim(I('post.title'));
            if(!$data['title']){
                $this->error('请填写商品名称');
            }
            $data['logo']      = trim(I('post.logo'));
            $data['detailpic'] = I('post.detailpic');
            $id = I('post.id',0,'intval');
            if(!$id){
                if(!$data['logo']){
                    $this->error('请上传商品LOGO');
                }
                if(!is_array($data['detailpic'])){
                    $this->error('请上传商品详情图');
                }
            }
            if(!$data['logo']){
                unset($data['logo']);
            }
            if($data['detailpic']){
                $data['detailpic'] = implode(",", $data['detailpic']);
            }else{
                unset($data['detailpic']);
            }
            $data['ischoice']       = I('post.ischoice',0,'intval');
            $data['ishot']          = I('post.ishot',0,'intval');
            $data['isnew']          = I('post.isnew',0,'intval');
            $data['issale']         = I('post.issale',0,'intval');
            $data['price']          = I('post.price',0,'intval');
            $data['vprice']         = I('post.vprice',0,'intval');
            $data['oprice']         = I('post.oprice',0,'intval');
            $data['virtualsales']   = I('post.virtualsales',0,'intval');
            $data['integralprice']  = I('post.integralprice',0,'intval');
            $data['giftpoints']     = I('post.giftpoints',0,'intval');
            $data['postage']        = I('post.postage',0,'intval');
            $data['stock']          = I('post.stock',0,'intval');
            $data['sorts']          = I('post.sorts',0,'intval');
            $data['description']    = I('post.description',0,'trim');
            $data['edit_at']        = date('Y-m-d H:i:s',NOW_TIME);
            if($id){
                $retitle = '修改';
                $res = M('Goods')->where(array('id'=>$id))->save($data);
            }else{
                $data['create_at'] = date('Y-m-d H:i:s',NOW_TIME);
                $retitle = '添加';
                $res = M('Goods')->add($data);
            }
            if($data['malltype']  == 1){
                $url = U('/Admin/Pointsmall/Goods');
            }if($data['malltype'] == 2){
                $url = U('/Admin/Spikemall/Goods');
            }if($data['malltype'] == 3){
                $url = U('/Admin/Groupmall/Goods');
            }if($data['malltype'] == 4){
                $url = U('/Admin/Ordinarymall/Goods');
            }
            if($res){
                $this->success($retitle.'商品成功',$url);
            }else{
                $this->error($retitle.'商品失败');
            }
            exit;
        }
        $id = I('get.id',0,'intval');
        if($id){
            $info = D('Goods')->goodsInfo(array('id'=>$id));
            if($info){
                $this->assign('info',$info);
            }
        }
        //获取分类
        $catelists      = D("GoodsCate")->cateLists($this->malltype,$this->storeid);
        $this->assign('catelists',$catelists);
        //获取时间点
        $timelimitlists = D("GoodsTimelimit")->lists($this->malltype,$this->storeid);
        $this->assign('timelimitlists',$timelimitlists);
        $this->assign('taglists',$taglists);
        $this->display();
    }
    #限时设置部分 201709131500#
    public function timeLimit()
    {   //限时设置
        $lists = D("GoodsTimelimit")->lists($this->malltype,$this->storeid);
        $this->assign('lists',$lists);
        $this->display();
    }
    public function timeLimitAddEditDelStatus()
    {   //时间点添加删除修改状态
        if(IS_POST){
            $this->ajaxReturn(D("GoodsTimelimit")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }
    #商品属性 201709132006 Cyonger#
    public function goodsAttribute()
    {
        $id = I('get.id',0,'intval');
        if($id){
            $info = D('Goods')->goodsInfo(array('id'=>$id));
            if(!$info){
                $this->error('商品不存在!');
            }
        }
        $this->assign('goodsinfo',$info);
        $this->assign('goodsid',$id);
        $lists = D("GoodsAttribute")->Lists(array('goodsid'=>$id));
        $this->assign('lists',$lists);
        $this->display('Pointsmall/goodsAttribute');
    }
}