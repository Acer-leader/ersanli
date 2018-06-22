<?php
namespace Api\Controller;
class AddressController extends CulpController
{   //地址操作模块
    public function _initialize()
    {
        parent::_initialize();
        //实例化数据库
        $this->Address_db = M("Address");
        $this->field      ='id AS addressid,consignee,telephone,province,city,district,address,isdefault';
    }
    public function index()
    {   //获取用户所有的地址  //查询默认地址
        $result = $this->selectAddress();
    }
    public function addAndEdit()
    {   //添加修改地址
        $data = array();
        $data['consignee'] = trim(I('consignee'));
        $data['telephone'] = trim(I('telephone'));
        $data['province']  = trim(I('province'));
        $data['city']      = trim(I('city'));
        $data['district']  = trim(I('district'));
        $data['address']   = trim(I('address'));
        $this->checkParam($data);
        $data['id']        = trim(I('addressid'));
        $data['isdefault'] = trim(I('isdefault')) ? 1 : 0;
        if (!preg_match("/^1[34578]\d{9}$/", $data['telephone'])){
            returnJson(0,'请填写正确的手机号');
        }
        if($data['id'])
        {   //修改
            $retitle   = '修改';
            $addressid = $data['id'];
            $id = $this->Address_db->save($data);
        }else{  //添加
            unset($data['id']);
            $retitle            = '添加';
            $data['userid']     = $this->userId;
            $data['createtime'] = NOW_TIME;
            $id = $this->Address_db->add($data);
            $addressid = $id;
        }
        if($addressid){
            if($data['isdefault']){
                $where       = array('userid'=>$this->userId);
                $where['id'] = array('neq',$addressid);
                $this->Address_db->where($where)->setField('isdefault',0);
            }
        }
        if($id !== false){   //修改成功
            returnJson(1,$retitle.'成功');
        }else{
            returnJson(0,$retitle.'失败');
        }
    }
    public function del()
    {   //删除地址
        $where       = array('userid'=>$this->userId);
        $where['id'] = trim(I('addressid'));
        $this->checkParam($where);
        $count = $this->Address_db->where($where)->count();
        if(!$count){
            returnJson(0,'地址不存在');
        }
        $id = $this->Address_db->where($where)->delete();
        returnStatus($id);
    }
    public function isDefaultSet()
    {   //设置默认地址
        $where       = array('userid'=>$this->userId);
        $where['id'] = trim(I('addressid'));
        $this->checkParam($where);
        $find = $this->Address_db->where($where)->find();
        if(!$find){
            returnJson(0,'地址不存在');
        }
        if($find['isdefault'] == 1){
            returnJson(1,'设置成功');
        }
        $id = $this->Address_db->where($where)->setField('isdefault',1);
        if($id){
            $where['id'] = array('neq',$where['id']);
            $this->Address_db->where($where)->setField('isdefault',0);
        }
        returnStatus($id);
    }
    public function selectAddress()
    {   //查询地址
        $lists = $this->Address_db->field($this->field)->where(array('userid'=>$this->userId))->order('isdefault desc,id desc')->select();
        if($lists){
            returnJson(1,$lists);
        }
        returnJson(0);       //没有数据
    }

}
?>