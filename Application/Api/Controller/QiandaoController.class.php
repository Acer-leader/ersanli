<?php
/**
* 这是app接口的控制器
* 需要用户登录后才能进行的操作
*/
namespace Api\Controller;
class QiandaoController extends CulpController
{   //签到模块
    public function _initialize()
    {   
        parent::_initialize();
        date_default_timezone_set("Asia/Shanghai");
        $this->Member_db  = M('member');
        $this->Qiandao_db = M('qiandao');
    }
    public function index(){
        $year  = date("Y",NOW_TIME);
        $month = date("n",NOW_TIME);
        $where = array('id'=>$this->userId);
        $lxqd  = $this->Member_db->where($where)->getField('qiandao');
        $where = array('userid'=>$this->userId,'year'=>$year,'month'=>$month);
        $lists = $this->Qiandao_db->field('year,month,day')->where($where)->order('day ASC,id ASC')->select();
        $where['day'] = date("j",NOW_TIME);
        $yiqian= $this->Qiandao_db->where($where)->order('day ASC,id ASC')->count();
        if($lists){
            returnJson(1,array('qiandao'=>$lists,'lxqd'=>$lxqd ? $lxqd : '0','yiqian'=>$yiqian ? '1' : '0'));
        }
        returnJson(0,array('qiandao'=>"没有签到",'lxqd'=>$lxqd ? $lxqd : '0','yiqian'=>'0'));
    }
    public function addQiandao()
    {   //签到开始
        //今天
        $year  = date("Y",NOW_TIME);
        $month = date("n",NOW_TIME);
        $day   = date("j",NOW_TIME);
        $where = array('userid'=>$this->userId,'year'=>$year,'month'=>$month,'day'=>$day);
        $count = $this->Qiandao_db->where($where)->order('id DESC')->count();
        if($count){
            returnJson(0,'今天你签到过了');
        }
        $data = $where;$lqyhj = '0';
        $data['createtime'] = NOW_TIME;
        M()->startTrans();
        $id = $this->Qiandao_db->add($data);
        if(!id)
        {   //签到失败
            M()->rollback();
            returnJson(0,'签到失败,请稍后重试');
        }
        //昨天
        $year  = date("Y",strtotime("-1 day"));
        $month = date("n",strtotime("-1 day"));
        $day   = date("j",strtotime("-1 day"));
        $where = array('userid'=>$this->userId,'year'=>$year,'month'=>$month,'day'=>$day);
        $count = $this->Qiandao_db->where($where)->order('id DESC')->count();
        if((int)$count < 1)
        {   //连续签到断开  昨天有签到
            $qiandao = $this->Member_db->where(array('id'=>$this->userId))->getField('qiandao');
            if($qiandao != 1)
            {
                $id1 = $this->Member_db->where(array('id'=>$this->userId))->setField('qiandao',1);
                if(!$id1)
                {
                    M()->rollback();
                    returnJson(0,'签到失败,请稍后重试');
                }
            }
            M()->commit();
            returnJson(1,array('qiandao'=>"签到成功",'lxqd'=>'1','lqyhj'=>'1','lqyhj'=>$lqyhj));
        }
        $id1 = $this->Member_db->where(array('id'=>$this->userId))->setInc('qiandao',1);
        if(!$id1)
        {   //更新签到天数
            M()->rollback();
            returnJson(0,'签到失败,请稍后重试');
        }
        /* $lxqd  = $this->Member_db->where(array('id'=>$this->userId))->getField('qiandao');
        if(($lxqd % 3) == 0)
        {   //连续三天签到领取优惠劵
            $couponresult = D('Coupon')->sendCoupon($this->userId);
            if((int)$couponresult['result'] == 1)
            {   //领取优惠劵成功
                //M()->rollback();
                //ajaxR(array("result"  => "0","info"=>"签到失败,请稍后重试"));exit;
                $lqyhj = '1';
            }
        } */
        M()->commit();
        returnJson(1,array('qiandao'=>"签到成功",'lxqd'=>$lxqd,'lqyhj'=>$lqyhj));
    }
}