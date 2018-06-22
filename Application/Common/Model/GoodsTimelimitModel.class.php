<?php
namespace Common\Model;
use Think\Model;
class GoodsTimelimitModel extends Model
{   //秒杀时间设置限制  1积分,2秒杀,3拼团,4普通
    public function lists($malltype=1,$storeid=1)
    {
        $where = array('malltype'=>(string)$malltype,'storeid'=>$storeid,'isdel'=>0);
        $lists = $this->where($where)->order('sorts ASC,id DESC')->select();
        if($lists){
            foreach($lists AS $k=>$v){
                unset($v['create_at']);
                $lists[$k]['info'] = json_encode($v);
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
                $malltype  = trim(I('post.malltype'));
                $id        = trim(I('post.id'));
                $timelimit = trim(I('post.timelimit'));
                $sorts     = trim(I('post.sorts'));
                if(!$timelimit){
                    return array('status'=>0,'info'=>'标题必填456');
                }
                $storeid = $storeid? : 0;
                $data = array('timelimit'=>$timelimit,'sorts'=>$sorts,'storeid'=>$storeid,'malltype'=>$malltype);
                if($id > 0)
                {
                    $retitle = '修改';
                    $id      = $this->where(array('id'=>$id))->save($data);
                }else{
                    $retitle = '添加';
                    $data['create_at'] = date("Y-m-d H:i:s",NOW_TIME);
                    $data['status']    = 0;
                    $id      = $this->add($data);
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
                        $arr = array("显示","隐藏");
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