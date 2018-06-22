<?php
namespace Common\Model;
use Think\Model;
class SkuAttrModel extends Model
{   
    //获取列表 $where条件 $limit每页显示多少
    public function listSku($where='',$limit='')
    {   
        if ($limit) {
            $limit = 10;
        }
        //显示分页
        $tatal = $this->where($where)->count();        
        $pages = getpage($tatal, $limit);
        $res['page']  = $pages->show();
        //获取新闻列表
        $res = $this->where($where)->Order("sort desc")->limit($pages->firstRow. ',' .$pages->listRows)->select();
        $arr = array();
        $arrs = array();
        if ($where['classname']) {
            $arrs = $res;
        }else{
            foreach ($res as $k => $v) {
                if ($v['pid'] == 0) {
                    $arr[] = $v;
                }
            }
            foreach ($arr as $k => $v) {
                $arrs[] = $v;
                foreach ($res as $ks => $vs) {
                    if ($vs['pid'] == $v['id']) {
                        $arrs[] = $vs;
                    }
                }
            }
        }
        
        $res['list'] = $arrs;
        return $res;
    }

    //修改/添加 $data  信息
    public function addSku($data='')
    {
        if ($data['sort'] == '') {
            unset($data['sort']);
        }
        if ($data['id'] == '') {
            unset($data['id']);
            $data['time'] = date('Y-m-d H:i:s',time());
            $res = $this->add($data);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }else{
            $id = $data['id'];
            unset($data['id']);
            $res = $this->where("id=$id")->save($data);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }
    }

    //修改删除
    public function saveStatus($data='')
    {
        $re = $this->where("id=".$data['id'])->find();
        // if ($data['action'] == 'del') {
            $is = $re['isdel']==1?0:1;
            $res = $this->where('id='.$data['id'])->setField('isdel',$is);
        // }else if($data['action'] == 'top'){
        //     $is = $re['istop'] ==1?0:1;
        //     $res = $this->where('id='.$data['id'])->setField('istop',$is);   
        // }
        $info['is'] = $is;
        if ($res) {
            $info['status'] = 1;
            return $info;
        }else{
            $info['status'] = 0;
            return $info;
        }
    }

    //获取单条sku  $id  skuid 
    public function getOneSku($id='')
    {
        if ($id) {
            $res = $this->where("id=$id")->find();
            return $res;
        }
    }

    //获取pid 为0的sku  $goodsid 商品id
    public function getPid($goodsid = '')
    {
        $map['isdel'] = 0;
        $map['pid'] = 0;
        $res = $this->where($map)->field('id,classname')->select();
        return $res;
    }
    //获取商品sku列表  $id  商品id
    public function getSkuList($id='')
    {
        $table_str = "<tr></tr>";
        $goods_skus = M("sku_list")->where(array("goods_id"=>$id, "status"=>1))->select();
        $table_str .= "<tr><td>SKU</td><td>图片</td><td>库存</td><td>价格</td></tr>";
        foreach($goods_skus as $k=>$v){
            $table_str .= "<tr>";
            $skus_arr = array_filter(explode("-", $v['attr_list']));
            // $table_str .= "<td class='sku-attr-data' data-id='{$vv}'>";
            $table_str .= "<td>";
            foreach($skus_arr as $kk=>$vv){
                $table_str .="<span class='sku-attr-data' data-id='{$vv}'>";
                $table_str .= $this->where(array('id'=>$vv))->getField("classname");
                $table_str .="</span>";
                $table_str .=" ";
            }
            $table_str=substr($table_str,0,-1);
            $table_str .= "</td>";
            $table_str .= "<td >
                        
                        <div class='btnimage fl' id='fileimg{$v['id']}'>选择图片
                            <input type='file'  accept='image/jpg,image/jpeg,image/png' img='fileimg{$v['id']}' name='imagefile' class='file' >
                        </div>
                        <img class='fileimg{$v['id']}' src='{$v['image']}' name='image' height='30'>
                        
                    </td>

                    <td><input name='store' value='{$v['store']}'></td>
                    <td><input name='price' value='{$v['price']}'></td>
                    ";
            $table_str .= "</tr>";
        }
        return $table_str;
    }

 }

?>