<?php
namespace Common\Model;
use Think\Model;
class GoodsAdvplaceModel extends Model
{   //广告
    public function Lists($malltype=1,$storeid=0)
    {
        $where = array('malltype'=>(string)$malltype,'storeid'=>$storeid,'isdel'=>0);
        $lists = $this->where($where)->order('sorts ASC,id DESC')->select();
        if($lists){
            foreach($lists AS $k=>$v){
                unset($v['create_at']);unset($v['status']);unset($v['isdel']);
                $lists[$k]['info'] = json_encode($v);
            }
        }
        return $lists;
    }
    public function addEditDelStatus()
    {   // 添加 修改 删除
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
                $id        = trim(I('post.id'));
                $title     = trim(I('post.title'));
                $sorts     = trim(I('post.sorts'));
                if(!$title){
                    return array('status'=>0,'info'=>'请填写广告位置');
                }
                $storeid = $storeid? : 0;
                $data = array('title'=>$title,'sorts'=>$sorts);
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
                        $arr = array("关闭","启用");
                        return array("status" => 1,"info" => '操作成功','text'=>$arr[$res['status']]);
                    }else{
                        return array("status" => 0,"info" => '操作失败');
                    }
                }else{
                    return array("status" => 2,"info" => '没有广告位置');
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