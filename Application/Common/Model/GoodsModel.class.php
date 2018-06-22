<?php
namespace Common\Model;
use Think\Model;
class GoodsModel extends Model
{   //商品模块
    public function lists($map)
    {   //商品列表
        $count = $this->where($map)->count();
        $Page  = getpage($count, 10);
        $show  = $Page->show();
        $lists = $this->where($map)->order('sorts ASC,id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        return array($count,$lists,$show);
    }
    //获取商品信息
    public function goodsInfo($map)
    {  
        $info = $this->where($map)->find();
        if($info){
            $info['catetitle']      = M('Goods_cate')->where(array('id'=>$info['cateid']))->getField('classname');
            $info['timelimittitle'] = M('Goods_timelimit')->where(array('id'=>$info['timelimitid']))->getField('timelimit');
            $info['detailpic']      = explode(',',$info['detailpic']);
        }
        return $info;
    }

     //添加修改  $info   信息
    public function addGoods($info = '')
    {   
        $data['malltype'] = $info['malltype'];
        if(!$data['malltype'][0]){
            return array('status'=>0 , 'info'=>'请选择商城');
        }
        $data['malltype'] = implode('|',$data['malltype']);
        $data['storeid'] = $info['storeid'];
        if(!isset($data['storeid'])){
            return array('status'=>0 , 'info'=>'错误的提交');
        }
        $data['cateid'] = $info['cateid'];
        if(!$data['cateid']){
            return array('status'=>0 , 'info'=>'请选择分类');
        }
        $data['title'] = $info['title'];
        if(!$data['title']){
            return array('status'=>0 , 'info'=>'请填写商品名称');
        }
        $data['slug'] = $info['slug'];
        if(!$data['slug']){
            return array('status'=>0 , 'info'=>'请填写商品短标题');
        }
        $data['subtitle'] = $info['subtitle'];
        if(!$data['subtitle']){
            return array('status'=>0 , 'info'=>'请填写商品副标题');
        }
        $data['logo']      = $info['logo'];
        $data['detailpic'] = $info['detailpic'];
        $id = $info['id'];
        if(!$id){
            if(!$data['logo']){
                return array('status'=>0 , 'info'=>'请上传商品LOGO');
            }
            if(!is_array($data['detailpic'])){
                return array('status'=>0 , 'info'=>'请上传商品详情图');
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
        $data['ischoice']       = $info['ischoice'];
        $data['ishot']          = $info['ishot'];
        $data['isnew']          = $info['isnew'];
        $data['issale']         = $info['issale'];
        $data['price']          = $info['price'];
        $data['vprice']         = $info['vprice'];
        $data['oprice']         = $info['oprice'];
        $data['virtualsales']   = $info['virtualsales'];
        $data['integralprice']  = $info['integralprice'];
        $data['giftpoints']     = $info['giftpoints'];
        $data['timelimitid']     = $info['timelimitid'];
        $data['grouperson']        = $info['grouperson'];
        $data['grouphour']        = $info['grouphour'];
        $data['postage']        = $info['postage'];
        $data['stock']          = $info['stock'];
        $data['sorts']          = $info['sorts'];
        $data['costprice']      = $info['costprice'];
        $data['supplier']       = $info['supplier'];
        $data['description']    = $info['description'];
        $data['edit_at']        = date('Y-m-d H:i:s',NOW_TIME);
        if($id){
            $retitle = '修改';
            $res = M('Goods')->where(array('id'=>$id))->save($data);
        }else{
            $data['create_at'] = date('Y-m-d H:i:s',NOW_TIME);
            $retitle = '添加';
            $res = M('Goods')->add($data);
        }
        $url = U('/Admin/Goods/index');
        if($res){
            $str = $retitle.'商品成功';
            return array('status'=>1 , 'info'=>$str, 'url'=>$url);
        }else{
            $str = $retitle.'商品失败';
            return array('status'=>0 , 'info'=>$str);
        }

    }


    public function addEditDelStatus()
    {   // 添加
        if(!IS_POST){
            return array('status'=>0,'info'=>'访问错误');
        }
        $action = trim(I('post.action'));
        if(!in_array($action,array('addEdit','Del','changeStatus','changeIssale','changeIsend'))){
            return array('status'=>0,'info'=>'访问错误');
        }
        switch($action)
        {   //添加修改
            case 'addEdit':
                if($id > 0){
                    $retitle = '修改';
                }else{
                    $retitle = '添加';
                }
                return $this->returnArr($id,$retitle);
            break;
            case 'Del':
                $id = I('post.id');
                if (strstr($id,"-")) {
                    $ids = explode('-',$id);
                    array_pop($ids);
                    foreach ($ids as $k => $v) {
                        $this->where(array('id'=>$v))->setField('isdel',1);
                    }
                }else{
                    $id = $this->where(array('id'=>$id))->setField('isdel',1);
                }
                return $this->returnArr($id);
            break;
            case "changeStatus":
                $id  = trim(I('post.id'));
                $res = $this->where("id=$id")->field("id,status")->find();
                if($res){
                    $res['status'] = ($res['status']==1) ? 0 :1;
                    $res2 = $this->save($res);
                    if($res2){
                        $arr = array("发放","禁止");
                        return array("status" => 1,"info" => '操作成功','text'=>$arr[$res['status']]);
                    }else{
                        return array("status" => 0,"info" => '操作失败');
                    }
                }else{
                    return array("status" => 2,"info" => '没有分类');
                }
            break;
            case 'changeIssale':
                $id  = trim(I('post.id'));
                $res = $this->where("id=$id")->field("id,issale")->find();
                if($res){
                    $res['issale'] = ($res['issale']==1) ? 0 :1;
                    $res2 = $this->save($res);
                    if($res2){
                        $arr = array("下架","上架");
                        return array("status" => 1,"info" => '操作成功','text'=>$arr[$res['issale']]);
                    }else{
                        return array("status" => 0,"info" => '操作失败');
                    }
                }else{
                    return array("status" => 2,"info" => '没有商品');
                }
            break;
            case 'changeIsend':
                $id  = trim(I('post.id'));
                $res = $this->where("id=$id")->field("id,isend")->find();
                if($res){
                    $res['isend'] = ($res['isend']==1) ? 0 :1;
                    $res2 = $this->save($res);
                    if($res2){
                        $arr = array("已售罄","出售中");
                        return array("status" => 1,"info" => '操作成功','text'=>$arr[$res['isend']]);
                    }else{
                        return array("status" => 0,"info" => '操作失败');
                    }
                }else{
                    return array("status" => 2,"info" => '没有商品');
                }
            break;
        }
        return array('status'=>0,'info'=>'你真调皮');
    }
    public function returnArr($id,$title='操作')
    {
        if($id === false){
            return array('status'=>0,'info'=>$title.'失败!');
        }
        return array('status'=>1,'info'=>$title.'成功!');
    }
}
 ?>