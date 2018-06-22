<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class GoodsController extends CommonController {

    private $storeid;    //商家id  平台1
    public function _initialize()
    {
        parent::_initialize();
        $this->storeid  = 1;
        $this->assign('storeid',$this->storeid);
    }
    /**
     * 分类列表
     */
    public function cate(){
        //获取分类列表
        $catelists = D('GoodsCate')->getCateList(1,$this->storeid);
        $this->assign("catelists", $catelists);
        $this->assign("malltype", 1);
        $this->assign("storeid", $this->storeid);
        $this->display();
    }

    /**
     * 增加分类
     */
    public function addcate()
    {   //添加修改删除状态
        if(IS_POST){
            $this->ajaxReturn(D("GoodsCate")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }

    //分类隐藏/删除
    public function hidecate()
    {   
        if(IS_POST){
            $this->ajaxReturn(D("GoodsCate")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }

    //商品
    public function index(){
        $map = array('storeid'=>$this->storeid,'isdel'=>'0');
        $title = I('get.title','','trim');
        if($title){
            $map['title'] = array('like',$title.'%');
            $this->assign('title',$title);
        }
        list($count,$lists,$show) = D('Goods')->lists($map);
        $this->assign('count', $count);
        $this->assign('lists', $lists);
        if($count > 10){
            $this->assign('page', $show);// 赋值分页输出
        }
        $this->display();
    }

    //添加/编辑
    public function addgoods()
    {
        if($_POST){
            $data = I('post.');
            $res = D('Goods')->addGoods($data);
            if ($res['status'] == 0) {
                $this->error($res['info']);
            }else{
                $this->success($res['info'],$res['url']);
            }
            exit;
        }
        $id = I('get.id',0,'intval');
        if($id){
            $info = D('Goods')->goodsInfo(array('id'=>$id));
            if($info){
                $this->assign('info',$info);
            }
        }
        //获取分类
        $catelists = D("GoodsCate")->getCateList(1,$this->storeid);
        $this->assign('catelists',$catelists);
        //获取时间点
        $timelimitlists = D("GoodsTimelimit")->lists($this->malltype,$this->storeid);
        $this->assign('timelimitlists',$timelimitlists);
        //获取商城信息
        $malllist = D("GoodsCate")->getCateList(0,0);
        if ($info) {
            foreach ($malllist  as $k => $v) {
                if (strstr($info['malltype'],$v['id'])) {
                    $malllist[$k]['is'] = 1;
                }else{
                    $malllist[$k]['is'] = 0;
                }
            }
        }
        $this->assign('storeid',$this->storeid);
        $this->assign('malllist',$malllist);
        $this->display();
    }

    //商品删除
    public function delgoods()
    {
        if(IS_POST){
            $this->ajaxReturn(D("Goods")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }

    //商品属性
    public function attribute()
    {
        $id = I('get.id',0,'intval');
        if($id){
            $info = D('Goods')->goodsInfo(array('id'=>$id));
            if(!$info){
                $this->error('商品不存在!');
            }
        }
        $this->assign('goodsinfo',$info);
        $this->assign('goodsid',$id);
        $lists = D("GoodsAttribute")->Lists(array('goodsid'=>$id));
        $this->assign('lists',$lists);
        $this->display();
    }

    //属性添加修改删除
    public function attributeAddEditDel()
    {   //修改添加删除
        if(IS_POST){
            $this->ajaxReturn(D("GoodsAttribute")->addEditDel());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }

    //上架
    public function top()
    {
        $map = array('storeid'=>$this->storeid,'isdel'=>'0','issale'=>'1');
        $title = I('get.title','','trim');
        if($title){
            $map['title'] = array('like',$title.'%');
            $this->assign('title',$title);
        }
        list($count,$lists,$show) = D('Goods')->lists($map);
        $this->assign('count', $count);
        $this->assign('lists', $lists);
        if($count > 10){
            $this->assign('page', $show);// 赋值分页输出
        }
        $this->display();
    }

    //下架
    public function down()
    {
        $map = array('storeid'=>$this->storeid,'isdel'=>'0','issale'=>'0');
        $title = I('get.title','','trim');
        if($title){
            $map['title'] = array('like',$title.'%');
            $this->assign('title',$title);
        }
        list($count,$lists,$show) = D('Goods')->lists($map);
        $this->assign('count', $count);
        $this->assign('lists', $lists);
        if($count > 10){
            $this->assign('page', $show);// 赋值分页输出
        }
        $this->display();
    }

    //删除所选商品
    public function changeAllStatus()
    {
        $ids = I('post.ids');
        $arrid = explode('-',$ids);
        $arrid = array_pop($arrid);
        foreach ($arrid as $k => $v) {
            D("GoodsAttribute")->addEditDel();
        }
        $this->ajaxReturn(1);
    }

    //sku展示页
    public function goodsskulist($value='')
    {
        //获取列表
        $where['pid'] = 0;
        $where['storeid'] = $this->storeid;
        $skulist = D('SkuAttr')->listSku($where);
        $id = I('get.goodsid');
        $table_str = D('SkuAttr')->getSkuList($id);
        $this->assign('storeid',$this->storeid);
        $this->assign('table',$table_str);
        $this->assign('id',$id);
        $this->assign('skulist',$skulist['list']);
        $this->display();
    }

    /**
     * 生成对应的sku表格 得到sku的id,组合成表格
     */
    public function makeSkuTable(){
        $ids = I("ids");
        $goods_id = I("goods_id");
        // 获取到子sku参数
        $skuarr=array();
        $str = "<tr>";
        foreach($ids as $id){
            $where['pid'] = $id;
            $where['isdel'] = 0;
            $where['status'] = 0;
            $arr = D('SkuAttr')->listSku($where);
            unset($arr['list']);
            $skuarr[] = $arr;
            $str .= "<th>";
            $str .= M('sku_attr')->where(array('id'=>$id))->getField("classname");
            $str .= "</th>";
        }
        // $str .= "<th>库存</th><th>市场价</th><th>积分价</th><th>spu</th></tr>";
        $str .= "<th>图片</th><th>库存</th><th>价格</th></tr>";
        $arr = mixSku($skuarr);
        foreach($arr as $v){
            $str .= "<tr>";
            $sku_array = array();
            $s_data = array();
            foreach($v as $vv){
                $sku_array[] = $vv['id'];
                $s_data[$vv['id']] = $vv['classname'];
                $str .= "<td class='sku-attr-data' data-id='{$vv[id]}'>{$vv[classname]}</td>";
            }
            sort($sku_array);

            $sku_str = implode("-", $sku_array);

            $sku_str = "-".$sku_str."-";

            $data = M("sku_list")->where(array('attr_list'=>$sku_str,"goods_id"=>$goods_id,"status"=>1))->find();
            $fileimg='';
            $fileimg.='fileimg';
            if(empty($data['id'])){
                $fileimg.=rand(999,9999);
            }else{
                $fileimg.=$data['id'];
            }
            $datas .=$data;
            $str .= "<td >
                        
                        <div class='btnimage fl' id='{$fileimg}'>选择图片
                            <input type='file'  accept='image/jpg,image/jpeg,image/png' img='{$fileimg}' name='imagefile' class='file' >
                        </div>
                        <img class='{$fileimg}' src='{$data['image']}' name='image' height='30'>
                        
                    </td>

                    <td><input name='store' value='{$data['store']}'></td>
                    <td><input name='price' value='{$data['price']}'></td>
                    ";
            $str .= "</tr>";

        }

        exit(json_encode(array(
                "data" => $skuarr,
                "html" => $str
            )));
    }

    /**
     * 保存商品对应的sku
     */
    public function addGoodsSkuAttr(){
        if(IS_AJAX){
            $m        = M("skuList");
            $sku_m    = M("skuAttr");
            $sku_arr  = I("post.");
            $goods_id = $sku_arr['goods_id'];
            unset($sku_arr['goods_id']);
            // 查询旧sku，将暂时用不到的sku isdel=》1   

            // 添加新的sku
            $arrs=array();
            $goods_sku_info=array();
            foreach($sku_arr as $k=>$v){
                $ids_arr = array_filter(explode("-",$v['ids']));
                sort($ids_arr);
                foreach($ids_arr as $kk=>$vv){
                    $sku_a  = $sku_m->where(array('id'=>$vv))->find();
                    $pid  = $sku_a['pid'];
                    $psku = $sku_m->where(array('id'=>$pid, "pid"=>0, "isdel"=>0))->getField("classname");
                    if(array_key_exists($psku, $goods_sku_info)){
                        //$goods_sku_info[$psku][$sku_a['id']] = array('name'=>$sku_a['classname'],"img"=>$sku_a['img']);
                        $goods_sku_info[$psku][$sku_a['id']] = $sku_a['classname'];
                    }else{
                        //$goods_sku_info[$psku] = array($sku_a['id']=>array('name'=>$sku_a['classname'],"img"=>$sku_a['img']));
                        $goods_sku_info[$psku] = array($sku_a['id']=>$sku_a['classname']);
                    }
                }
                $arrs[$k] = "-".implode("-", $ids_arr)."-";
            }
            // 得到对应pid的classname，并组成下表
            $old_sku = $m->where(array("goods_id"=>$goods_id))->select();
            $arr_keys = array_flip($arrs);

            foreach($old_sku as $k=>$v){
                if(in_array($v['attr_list'], $arrs)){
                    // 这里未做完
                    $data = array(
                            "price" => $sku_arr[$arr_keys[$v['attr_list']]]['price'],     
                            "store"  => $sku_arr[$arr_keys[$v['attr_list']]]['store'],
                            "image" =>$sku_arr[$arr_keys[$v['attr_list']]]['image'],
                            "status" => 1,
                        );
                    $m->where(array('id'=>$v['id']))->save($data);
                    unset($sku_arr[$arr_keys[$v['attr_list']]]);
                }else{
                    $m->where(array('id'=>$v['id']))->delete();
                }
            }
     
            foreach($sku_arr as $k=>$v){
                $data = array(
                        "goods_id"  => $goods_id,
                        "attr_list" => $arrs[$k],
                        "price"    => $v['price'],
                        "image"     =>$v['image'],
                        "store"     => $v['store'],
                        "status"    => 1,
                    );
                 $m->add($data);
            }
               
           
            $goods_sku_info = serialize($goods_sku_info);            
            M("goods")->where(array('id'=>$goods_id))->setField(array("goods_sku_info"=>$goods_sku_info,"is_sku"=>1));
            $this->ajaxReturn(array("status"=>1 ,"info"=>"执行成功！"));
        }
    }



    //sku
    public function goodssku()
    {
        $title = I('post.title');
        if ($title) {
            $where['classname'] = array('like', "%$title%");
        }
        $where['storeid'] = $this->storeid;
        //获取列表
        $list = D('SkuAttr')->listSku($where,10);
        $this->assign('goodsid',$goodsid);
        $this->assign('list',$list['list']);
        $this->display();
    }

    //添加编辑sku
    public function addgoodssku()
    {
        //获取上级sku数据
        $list = D('SkuAttr')->getPid();
        $this->assign('list',$list);
        $data = I();
        if ($data['classname']) {
            $res = D('SkuAttr')->addSku($data);
            if ($res == 1) {
                $this->redirect('Admin/goods/goodssku');
            }
        }else{
            $id = I('get.id');
            $info = D('SkuAttr')->getOneSku($id);
            $this->assign('info',$info);
            $this->display();
        }
    }

    //删除/置顶
    public function skudel()
    {
        $data = I();
        $res = D('SkuAttr')->saveStatus($data);
        $this->ajaxReturn($res);die;
    }



    //批量删除
    public function skudelall()
    {
        $id = explode('-', I('post.ids'));
        array_pop($id);
        foreach ($id as $k => $v) {
            $res = M('sku_attr')->where("id=$v")->setField('isdel','1');
        }
        echo 1;
    }


    #限时设置部分 
    public function timeLimit()
    {   //限时设置
        $lists = D("GoodsTimelimit")->lists($this->malltype,$this->storeid);
        $this->assign('lists',$lists);
        $this->assign('storeid',$this->storeid);
        $this->display();
    }
    public function timeLimitAddEditDelStatus()
    {   //时间点添加删除修改状态
        if(IS_POST){
            $this->ajaxReturn(D("GoodsTimelimit")->addEditDelStatus());
        }
        $this->ajaxReturn(array('status'=>0,'info'=>'你真调皮!'));
    }
}