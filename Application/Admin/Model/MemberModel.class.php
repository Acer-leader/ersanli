<?php
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model
{
    public function _initialize()
    {
        $this->Job_db    = M('job');
        $this->Member_db = M('member');
    }
    public function jobArr()
    {
        $Job = array();
        $Job['lists']  = $this->Job_db->order('id ASC')->select();
        foreach($Job['lists'] as $k=>$v)
        {
            $v['info'] = json_encode($v);
            if($v['type'] == 1)
            {   //部门
                $Job['branchArr'][] = $v;
            }else{//职位
                $Job['jobArr'][] = $v;
            }
            $Job['listsIdArr'][$v['id']] = $v['classtitle'];
        }
        $Job['jobArr']    = $this->arraySorts($Job['jobArr'],'SORT_ASC','sorts');       //按 sorts  升序
        $Job['branchArr'] = $this->arraySorts($Job['branchArr'],'SORT_ASC','sorts');       //按 sorts  升序
        return $Job;
    }
    public function GetInfomation($uid){
        $where = array('id' => $uid,);
        return $this->where($where)->find(); //查询， 用find()只能查出一条数据，select()多条
    }
    public function upMemberIsZhen($id,$status)
    {   //修改会员的认证状态
        return $this->where("id=%d",$id)->setField('is_zhen',$status);
    }
    public function arraySorts($arr,$direction='SORT_DESC',$field='id')
    {   //二维数组按指定字段,指定顺序排序
        if(!is_array($arr))
        {
            return $arr;
        }
        $sort = array(
            'direction' => $direction, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
            'field'     => $field,       //排序字段
        );
        $arrSort = array();
        foreach($arr as $uniqid => $row)
        {
            foreach($row as $key=>$value){
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if($sort['direction'])
        {
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arr);
        }
        return $arr;
    }
 }

?>