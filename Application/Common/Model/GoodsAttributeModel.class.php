<?php
namespace Common\Model;
use Think\Model;
class GoodsAttributeModel extends Model
{   //商品属性模块
    public function lists($map)
    {   //列表
        $lists = $this->where($map)->order('id DESC')->select();
        if($lists){
            foreach($lists AS $k=>$v){
                unset($v['create_at']);unset($v['goodsid']);
                $lists[$k]['info']          = json_encode($v);
            }
        }
        return $lists;
    }
    public function addEditDel()
    {   // 添加修改删除
        if(!IS_POST){
            return array('status'=>0,'info'=>'访问错误');
        }
        $action = trim(I('post.action'));
        if(!in_array($action,array('addEdit','Del'))){
            return array('status'=>0,'info'=>'访问错误');
        }
        switch($action)
        {   //添加修改
            case 'addEdit':
                $goodsid  = intval(I('post.goodsid'));
                $id       = intval(I('post.id'));
                $title    = trim(I('post.title'));
                $value    = trim(I('post.value'));
                if(!$goodsid){
                    return array('status'=>0,'info'=>'操作错误');
                }
                if(!($title && $value)){
                    return array('status'=>0,'info'=>'请填写属性或属性值');
                }
                $data = array('goodsid'=>$goodsid,'title'=>$title,'value'=>$value);
                if($id > 0){
                    $retitle = '修改';
                    $id = $this->where(array('id'=>$id))->save($data);
                }else{
                    $retitle = '添加';
                    $data['create_at'] = date("Y-m-d H:i:s",NOW_TIME);
                    $id = $this->add($data);
                }
                return $this->returnArr($id,$retitle);
            break;
            case 'Del':
                $id = I('post.id/d',0);
                $id = $this->where(array('id'=>$id))->delete();
                return $this->returnArr($id);
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