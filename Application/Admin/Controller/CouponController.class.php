<?php

namespace Admin\Controller;
use Common\Controller\CommonController;
class CouponController extends CommonController
{   //优惠劵模块
    private $storeid;
    public function _initialize()
    {
        parent::_initialize();
        $this->storeid = 1;
        $this->assign('storeid',$this->storeid);
    }
    public function index()
    {   //获取优惠券列表
        $map = array('storeid'=>'1','isdel'=>'0');
        list($count,$lists,$show) = D('Coupon')->lists($map);
        $this->assign('count', $count);
        $this->assign('lists', $lists);
        if($count > 20){
            $this->assign('page', $show);// 赋值分页输出
        }
        $this->display();
    }
    public function couponAddEditDelStatus()
    {
        if(IS_POST){
            $this->ajaxReturn(D("Coupon")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }

    /*
     * 添加编辑一个优惠券类型
     */
    public function coupon_info()
    {
        if (IS_POST) {
            $data = I('post.');
            if(!($data['send_start_time'] && $data['send_end_time']))
                $this->error('请输入发放起止时间');
            $data['send_start_time']  = strtotime($data['send_start_time']);
            $data['send_end_time']    = strtotime($data['send_end_time']);
            //$data['use_start_time'] = strtotime($data['use_start_time']);
            if($data['send_start_time'] > $data['send_end_time'])
                $this->error('发放日期必须小于结束发放日期');
            if(!$data['name']){
                $this->error('名称必填');
            }else{
                $data['name'] = trim($data['name']);
            }
            $data['money'] = trim($data['money']) ? trim($data['money']) : 0;
            if(!$data['money']){
                $this->error('金额/折扣必填');
            }else{
                $data['money'] = trim($data['money']);
            }
            if($data['is_type'] !=1){
                if($data['money'] < 0 || $data['money'] > 100){
                    $this->error('金额/折扣介于1~100之间');
                }
            }else{
                if($data['money'] < 0){
                    $this->error('金额/折扣必须大于0');
                }
            }
            $data['condit'] = trim($data['condit']) ? trim($data['condit']) : 0;
            $data['createnum'] = trim($data['createnum']) ? trim($data['createnum']) : 1;
            //if($data['use_end_time']){
                //$data['use_end_time'] = strtotime(trim($data['use_end_time']));
            //}
            //dump($data);exit;
            if (empty($data['id'])) {
                $data['add_time'] = NOW_TIME;
                $row = M('coupon')->add($data);
            } else {
                $row = M('coupon')->where(array('id' => $data['id']))->save($data);
            }
            if (!$row)
                $this->error('操作失败');
            $this->success('操作成功', U('Admin/Coupon/index'));
            exit;
        }
        $cate = M("cate")->where(array("pid"=>0,"isdel"=>0))->order("sort Asc")->field("id,classname")->select(); // dump($cate);   //查询商品分类
        $this->assign("cate",  $cate);
        $cid = I('get.id');
        if ($cid) {
            $coupon = M('coupon')->where(array('id' => $cid))->find();
            $this->assign('coupon', $coupon);
        } /*else {
            $def['send_start_time'] = strtotime("+1 day");
            $def['send_end_time'] = strtotime("+1 month");
            $def['use_start_time'] = strtotime("+1 day");
            $def['use_end_time'] = strtotime("+2 month");
            $this->assign('coupon', $def);
        }
        $goods = M('goods');
        $goods_list = $goods->field('id,goods_des,goods_name,price')->where(array('is_sale' => 1, 'isdel' => 0))->select();

        $this->assign('goods_list', $goods_list);*/
        $this->display();
    }

    /*
    * 优惠券线下发放按验证码领取
    */
    public function make_coupon()
    {
        //获取优惠券ID
        $cid = I('get.id');
        $type = I('get.type');
        //查询是否存在优惠券
        $data = M('coupon')->where(array('id' => $cid))->find();
        $remain = $data['createnum'] - $data['send_num'];//剩余派发量
        if ($remain <= 0) $this->error($data['name'] . '已经发放完了');
        if (!$data) $this->error("优惠券类型不存在");
        if ($type != 4) $this->error("该优惠券类型不支持发放");
        if (IS_POST) {
            $num = I('post.num');
            if ($num > $remain) $this->error($data['name'] . '发放量不够了');
            if (!$num > 0) $this->error("发放数量不能小于0");
            $add['cid'] = $cid;
            $add['type'] = $type;
            $add['send_time'] = time();
            for ($i = 0; $i < $num; $i++) {
                do {
                    $code = get_rand_str(8, 0, 1);//获取随机8位字符串
                    $check_exist = M('coupon_list')->where(array('code' => $code))->find();
                } while ($check_exist);
                $add['code'] = $code;
                M('coupon_list')->add($add);
            }
            M('coupon')->where("id=$cid")->setInc('send_num', $num);
            adminLog("发放" . $num . '张' . $data['name']);
            $this->success("发放成功", U('Admin/Coupon/index'));
            exit;
        }
        $this->assign('coupon', $data);
        $this->display();
    }

    public function ajax_get_user()
    {
        $data = I('param.');
        // dump($data);
        if ($data['cate_id']) {
            dump($data);
            exit;
        }
        //搜索条件
        $condition = array();
        $nickname = I('nickname');
        if (!empty($nickname)) {
            $condition['realname|person_name|telephone'] = array('like', "%$nickname%");
        }
        $model = M('member');
        $count = $model->where($condition)->count();

        $Page = getpage($count, 10);
        $show = $Page->show();
        $lists = M('member')->field('id,telephone,realname,person_name,email,status')->where($condition)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('lists', $lists);
        $this->assign('count', $count);
        $this->assign('page', $show);// 赋值分页输出
        $condition['nickname'] = $nickname ? $nickname : '';
        $this->assign('condition', $condition);
        //优惠券列表
        $time = time();
        $coupon_list = M('coupon')->where("use_start_time < $time and use_end_time > $time and createnum > send_num")->field('id,name')->select();//活动时间之内的
        $this->assign('coupon_list', $coupon_list);


        /*  dump($condition);*/
        $this->display('coupon/send_coupon');
    }
    /*
     * 删除单张优惠券类型
     */
    public function del_coupon()
    {
        //获取优惠券ID
        $cid = I('get.id');
        //查询是否存在优惠券
        $row = M('coupon')->where(array('id' => $cid))->delete();
        if ($row) {
            //删除此类型下的优惠券
            M('coupon_list')->where(array('cid' => $cid))->delete();
            $this->success("删除成功");
        } else {
            $this->error("删除失败");
        }
    }


    /*
     * 优惠券分配详情查看
     */
    public function coupon_list()
    {
        //获取优惠券ID
        $cid = I('param.id');
        //查询是否存在优惠券
        $check_coupon = M('coupon')->field('id,type')->where(array('id' => $cid))->find();
        if (!$check_coupon['id'] > 0)
            $this->error('不存在该类型优惠券');

        //查询该优惠券的列表的数量
        $sql = "SELECT count(1) as c FROM __PREFIX__coupon_list  l " .
            "LEFT JOIN __PREFIX__coupon c ON c.id = l.cid " . //联合优惠券表查询名称
            "LEFT JOIN __PREFIX__order_info o ON o.id = l.order_id " .     //联合订单表查询订单编号
            "LEFT JOIN __PREFIX__member u ON u.id = l.userid WHERE l.cid = " . $cid;    //联合用户表去查询用户名

        $count = M()->query($sql);
        $count = $count[0]['c'];
        $Page = getpage($count, 20);
        $show = $Page->show();

        //查询该优惠券的列表
        $sql = "SELECT l.*,c.name,c.is_status,c.is_type,o.order_no,u.person_name,u.mobile FROM __PREFIX__coupon_list  l " .
            "LEFT JOIN __PREFIX__coupon c ON c.id = l.cid " . //联合优惠券表查询名称
            "LEFT JOIN __PREFIX__order_info o ON o.id = l.order_id " .     //联合订单表查询订单编号
            "LEFT JOIN __PREFIX__member u ON u.id = l.userid WHERE l.cid = " . $cid .    //联合用户表去查询用户名
            " limit {$Page->firstRow} , {$Page->listRows}";
        $coupon_list = M()->query($sql);
        /* echo M()->getLastSql();*/
        $this->assign('coupon_type', C('COUPON_TYPE'));
        $this->assign('type', $check_coupon['type']);
        $this->assign('lists', list_sort_by($coupon_list,'id','desc'));
        /* dump($coupon_list);*/
        if($count > 20)
            $this->assign('page', $show);
        $this->display();
    }

    /*
     * 删除一张优惠券的分配情况
     */
    public function coupon_list_del()
    {
        //获取优惠券ID
        $cid = I('param.id');
        if (!$cid)
            $this->error("缺少参数值");
        //查询是否存在优惠券
        $row = M('coupon_list')->where(array('id' => $cid))->delete();
        if (!$row)
            $this->error('删除失败');
        $this->success('删除成功');
    }

    /*
     * 启用或结束某个优惠劵的使用
     */
    public function changeStatus()
    {
        //获取优惠券ID
        $cid = I('param.id');
        $data = array();
        if (!$cid)
            $this->error("缺少参数值");
        //查询是否存在优惠券
        $row = M('coupon')->where(array('id' => $cid))->find();
        if (!$row) {
            $this->ajaxReturn(array('status' => 2, 'info' => '优惠劵失效'));
        }
        $title = array('0' => '启用', '1' => '停止');
        $is_status = $row['is_status'];
        if ($is_status == 0) {
            $data['is_status'] = 1;
        } else {
            $data['is_status'] = 0;
        }
        $res = M('coupon')->where(array('id' => $cid))->save($data);
        if (!$res) {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败', 'title' => $title[$row['is_status']]));
        } else {
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功', 'title' => $title[$row['is_status']]));
        }
    }

    public function explanationcoupon()
    {   //优惠劵使用说明
        if(IS_POST)
        {
            $id = I('post.id/d',0);
            $content = I('post.content','','trim');
            if(!$content)
            {
                $this->ajaxReturn(array('status' =>0, 'info' => '请填写优惠劵说明'));exit;
            }
            if($id)
            {
                $id = M('coupon_explana')->where(array('id'=>$id))->save(array('content'=>$content,'create_at'=>date("Y-m-d H:i:s",NOW_TIME)));
            }else{
                $id = M('coupon_explana')->add(array('id'=>1,'content'=>$content,'create_at'=>date("Y-m-d H:i:s",NOW_TIME)));
            }
            if($id)
            {
                $this->ajaxReturn(array('status' =>1, 'info' => '操作成功'));exit;
            }
            $this->ajaxReturn(array('status' =>0, 'info' => '操作失败'));exit;
        }
        $info = M('coupon_explana')->where(array('id'=>1))->find();
        $this->assign('info',$info);
        $this->display();
    }
    public function import()
    {
        $filename = $_FILES['file']['tmp_name'];
        if (empty ($filename)) {
            echo '请选择要导入的CSV文件！';
            exit;
        }
        // dump($filename);exit;
        $handle = fopen($filename, 'r');
        $result = $this->_inputCsv($handle); //解析csv
        $len_result = count($result);
        if ($len_result == 0) {
            echo '没有任何数据！';
            exit;
        }

        $list = array('id', 'cid', 'type', 'uid', 'order_id', 'use_time', 'code', 'send_time');

        $data = array();
        foreach ($result as $k => $v) {
            $i = 1;
            foreach ($v as $kk => $vv) {
                if ($kk != 0) {
                    if ($vv == '') {
                        $vv = null;
                    }
                    $data[$k][$list[$i]] = $vv;
                    $i++;
                }
            }
        }
        //dump($data);exit;
        fclose($handle); //关闭指针
        $model = M('coupon_list');
        foreach ($data as $da => $dd) {
            $query = $model->add($dd);
        }

        if ($query) {
            $this->success('导入成功');
        } else {

            $this->error('导入失败');
        }
    }


    /*private function _inputCsv($handle) {
        $out = array();
        $n = 0;
        while ($data = fgetcsv($handle, 10000)) {
            $num = count($data);
            for ($i = 0; $i < $num; $i++) {
                $out[$n][$i] = $data[$i];
            }
            $n++;

        }
        return $out;
    }*/


    /*  public function export(){
          header("content-Type: text/html; charset=utf-8");
          //phpinfo();exit;
          $model=M('coupon_list');
          $result=$model->select();
          $str = "表id,优惠劵id,发放类型,用户id,订单id,使用时间,优惠劵兑换码,发放时间\n";
          $str = iconv("UTF-8", "GB2312//IGNORE", $str);
          foreach ($result as $kk => $row) {
              foreach ($row as $key => $val) {
                  $val = empty($val) ? "null" : $val;
                  $str .= $val . ",";
              }
              $str = substr($str, 0, -1); //去掉最后一个逗号
              $str = $str . "\n";
          }
          try {
              //$str = mb_convert_encoding($str,'GBK','UTF-8');
              $str = iconv("UTF-8", "GB2312//IGNORE", $str);
          } catch (\Exception $e) {

          }
          $filename = date('Ymd') . 'coupon.csv';

          $this->export_csv($filename, $str);
      }

      public function export_csv($filename,$data) {
          header("Content-type:text/csv");
          header("Content-Disposition:attachment;filename=".$filename);
          header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
          header('Expires:0');
          header('Pragma:public');
          echo $data;exit;
      }*/

    public function Excelexport()
    {
        //搜索条件
        $model = M('coupon_list');
        $result = $model->select();
        $strTable = '<table width="500" border="1">';
        $strTable .= '<tr>';
        $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">表id</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="100">优惠劵id</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">发放类型</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">用户编号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">订单编号</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">使用时间</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">优惠劵兑换码</td>';
        $strTable .= '<td style="text-align:center;font-size:12px;" width="*">发放时间</td>';
        $strTable .= '</tr>';
        if (is_array($result)) {
            foreach ($result as $k => $val) {
                $strTable .= '<tr>';
                $strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;' . $val['id'] . '</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['cid'] . ' </td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['type'] . '</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">' . "{$val['uid']}" . ' </td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['order_id'] . '</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['use_time'] . '</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['code'] . '</td>';
                $strTable .= '<td style="text-align:left;font-size:12px;">' . $val['send_time'] . '</td>';
                $strTable .= '</tr>';
            }
        }
        $strTable .= '</table>';
        unset($result);
        $this->downloadExcel($strTable, 'couponlist');
        exit();
    }

    public function downloadExcel($strTable, $filename)
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=" . date('Ymd') . "-" . $filename . ".xls");
        header('Expires:0');
        header('Pragma:public');
        echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . $strTable . '</html>';
    }

    public function export()
    {
        $model = M('coupon_list');
        $result = $model->select();

        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=goods_class.csv");
        if (is_array($result)) {
            $tmp2 = "表id,优惠劵id,发放类型,用户id,订单id,使用金额,使用时间,优惠劵兑换码,发放时间,使用状态";
            echo $tmp2 . "\r\n";
            foreach ($result as $k => $v) {
                $tmp = array();
                //序号
                $tmp = $v;
                //$tmp_line = iconv('UTF-8','GB2312//IGNORE',join(',',$tmp));
                $tmp_line = str_replace("\r\n", '', join(',', $tmp));
                echo $tmp_line . "\r\n";
            }
        }
        exit;
    }

    /**
     * 邀请返利配置
     */
    public function ReturnConfig()
    {
        $bigconfig = M('return_config');
        $config = $bigconfig->order('id desc')->find();
        if (IS_POST) {
            $data = I('param.');
            if (empty($config['id'])) {
                $data['add_time'] = time();
                $row = $bigconfig->add($data);
            } else {
                $row = $bigconfig->where(array('id' => $config['id']))->save($data);
            }
            if (!$row) {
                $this->error('邀请返现配置失败');
            }
            $this->success('邀请返现配置成功', U('Admin/coupon/ReturnConfig'));
            exit;
        }
        $this->assign('config', $config);
        $this->display();
    }
    public function explain(){
        $m = M('coupon_explain');
        if(IS_POST)
        {
            $id = I('post.id/d',0);
            $content = I('post.explain');
            if(!$content)
            {
                $this->ajaxReturn(array('status' =>0, 'info' => '请填写优惠劵说明'));exit;
            }
            if($id)
            {
                $id = $m->where(array('id'=>$id))->save(array('explain'=>$content,'add_time'=>date("Y-m-d H:i:s",NOW_TIME)));
            } else {
                $id = $m->add(array('id'=>1,'explain'=>$content,'add_time'=>date("Y-m-d H:i:s",NOW_TIME)));
            }
            if($id)
            {
                $this->ajaxReturn(array('status' =>1, 'info' => '操作成功'));exit;
            }
            $this->ajaxReturn(array('status' =>0, 'info' => '操作失败'));exit;
        }
        $config = $m->where(array('id'=>1))->find();
        $this->assign('res',$config);
        $this->display();
    }
}