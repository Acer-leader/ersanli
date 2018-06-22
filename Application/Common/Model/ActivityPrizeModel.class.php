<?php
namespace Common\Model;
use Think\Model;
class ActivityPrizeModel extends Model
{   //奖品模块
    public function _initialize()
    {
        $this->Activity_prize_db = M('Activity_prize');
    }
    public function prizeLists($activity,$field='')
    {   //活动下所有的奖品
        return $this->Activity_prize_db->field($field)->where(array('activity'=>$activity))->order('sorts ASC,id ASC')->select();
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