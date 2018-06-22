<?php
namespace Common\Model;
use Think\Model;
class GoodsTagModel extends Model
{   //商品评价标签
    public function lists($map)
    {   //优惠劵列表
        $lists = $this->where($map)->order('type ASC,sorts ASC,id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        if($lists){
            foreach($lists AS $k=>$v){
                unset($v['create_at']);unset($v['storeid']);unset($v['isdel']);unset($v['status']);
                $lists[$k]['info']          = json_encode($v);
            }
        }
        return $lists;
    }
    public function addEditDelStatus()
    {   // 添加
        if(!IS_POST){
            return array('status'=>0,'info'=>'访问错误');
        }
        $action = trim(I('post.action'));
        if(!in_array($action,array('addEdit','Del','changeStatus'))){
            return array('status'=>0,'info'=>'访问错误');
        }
        switch($action)
        {   //添加修改
            case 'addEdit':
                $storeid   = trim(I('post.storeid'));
                $id        = trim(I('post.id'));
                $classname = trim(I('post.classname'));
                $type      = trim(I('post.type'));
                $sorts     = trim(I('post.sorts'));
                if(!$classname){
                    return array('status'=>0,'info'=>'标题必填');
                }
                if(!$storeid){
                    return array('status'=>0,'info'=>'操作错误');
                }
                $data = array('classname'=>$classname,'sorts'=>$sorts,'storeid'=>$storeid,'type'=>$type);
                if($id > 0)
                {
                    $retitle = '修改';
                    $id = $this->where(array('id'=>$id))->save($data);
                }else{
                    $retitle = '添加';
                    $data['create_at'] = date("Y-m-d H:i:s",NOW_TIME);
                    $data['status']    = 0;
                    $id = $this->add($data);
                }
                return $this->returnArr($id,$retitle);
            break;
            case 'Del':
                $id = I('post.id/d',0);
                $id = $this->where(array('id'=>$id))->setField('isdel',1);
                return $this->returnArr($id);
            break;
            case "changeStatus":
                $id  = trim(I('post.id'));
                $res = $this->where("id=$id")->field("id,status")->find();
                if($res){
                    $res['status'] = ($res['status']==1) ? 0 :1;
                    $res2 = $this->save($res);
                    if($res2){
                        $arr = array("启用","关闭");
                        return array("status" => 1,"info" => '操作成功','text'=>$arr[$res['status']]);
                    }else{
                        return array("status" => 0,"info" => '操作失败');
                    }
                }else{
                    return array("status" => 2,"info" => '没有分类');
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