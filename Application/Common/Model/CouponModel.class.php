<?php
namespace Common\Model;
use Think\Model;
class CouponModel extends Model
{   //优惠劵操作
    public function lists($map)
    {   //优惠劵列表
        $count = $this->where($map)->count();
        $Page  = getpage($count, 20);
        $show  = $Page->show();
        $lists = $this->where($map)->order('create_at desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        if($lists){
            foreach($lists AS $k=>$v){
                unset($v['create_at']);unset($v['send_num']);unset($v['use_num']);unset($v['storeid']);unset($v['isdel']);
                $lists[$k]['info']          = json_encode($v);
                $lists[$k]['use_starttime'] = date("Y-m-d H:i:s",$v['use_starttime']);
                $lists[$k]['use_endtime']   = date("Y-m-d H:i:s",$v['use_endtime']);
            }
        }
        return array($count,$lists,$show);
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
                $storeid        = trim(I('post.storeid'));
                $id             = trim(I('post.id'));
                $title          = trim(I('post.title'));
                $money          = trim(I('post.money'));
                $condit         = trim(I('post.condit'));
                $createnum      = trim(I('post.createnum'));
                $use_starttime  = trim(I('post.use_starttime'));
                $use_endtime    = trim(I('post.use_endtime'));
                $sorts          = trim(I('post.sorts'));
                if(!$storeid){
                    return array('status'=>0,'info'=>'操作错误');
                }
                if(!$title){
                    return array('status'=>0,'info'=>'标题必填');
                }
                if(!($use_starttime && $use_endtime)){
                    return array('status'=>0,'info'=>'请选择使用时间段!');
                }
                if($use_starttime > $use_endtime){
                    return array('status'=>0,'info'=>'开始时间必须小于结束时间!');
                }
                $data = array(
                        'title'=>$title,'sorts'=>$sorts,'storeid'=>$storeid,
                        'money'=>$money,'condit'=>$condit,'createnum'=>$createnum,
                        'use_starttime'=>strtotime($use_starttime),'use_endtime'=>strtotime($use_endtime),
                );
                if($id > 0)
                {
                    $retitle = '修改';
                    $id = $this->where(array('id'=>$id))->save($data);
                }else{
                    $retitle = '添加';
                    $data['create_at'] = date("Y-m-d H:i:s",NOW_TIME);
                    $data['status']    = 1;
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
                        $arr = array("发放","禁止");
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