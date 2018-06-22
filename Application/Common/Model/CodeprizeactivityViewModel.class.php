<?php
namespace Common\Model;
use Think\Model\ViewModel;
class CodeprizeactivityViewModel extends ViewModel
{   //奖品中奖视图   _type定义对下一个表有效，要注意视图模型的定义顺序
    public $viewFields = array(
        'Activity_code' => array(   //抽奖码表
            'id','code','create_at','status',
            'ip','use_at','name','mobile','region','address','consignee','phoneno','address_at','prizeinfo',
            'isprize','prizeid','winning_at','isreceive','receive_at',
            '_type'=>'LEFT'),       //关联方式 对下一个表有效，要注意视图模型的定义顺序
        'Activity_prize'=>array(   //奖品表
            'activityid','title'=>'prtitle','logopic'=>'prlogopic',
            '_on'=>'Activity_code.prizeid = Activity_prize.id'),
        'Activity'=>array(      //活动表
            'title'=>'actitle','poster'=>'poster',
            '_on'=>'Activity_code.activityid = Activity.id'),
    );
    public function getLists($where,$field='')
    {   //查询中奖用户
        return $this->field($field)->where($where)->limit($limit)->select();
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