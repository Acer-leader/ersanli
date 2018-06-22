<?php
namespace Common\Model;
use Think\Model;
class GoodsStoreModel extends Model
{   //商城设置
    public function storeAddEditStatus()
    {
        //添加 修改
        $storelogo = input['storelogo'];
        $storename = input['storename'];
        $name      = input['name'];
        $telephone = input['telephone'];
        $adress    = input['adress'];
        $password  = input['password'];
        $data = array('storelog'=> $storelogo,'storename'=>$storename,'name'=>$name,'telephone'=>$telephone,'adress'=>$adress,'password'=>$password);
        if($data !== null){
            $retitle = '修改';
            $data = $this->where(array('data'=>$data))->save($data);
        }else{
            $retitle = '添加';
            $data['create_at'] = date("Y-m-d H:i:s",NOW_TIME);
            $data= $this->add($data);
        }
        return $this->  returnArr($data,$retitle);
    }

}
?>