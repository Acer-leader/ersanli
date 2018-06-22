<?php
namespace Api\Controller;
class IndexController extends PublicController
{   //首页部分
    public function _initialize()
    {
        parent::_initialize();
        $this->storeid = 1;
    }
    public function index()
    {
        $result = array('status'=>'1','result'=>'欢迎您来到首页!');
        ajaxR($result);
    }
    #商城首页#
    public function indexBanner()
    {   //首页banner
        if(IS_POST){
            $map = array('status'=>0,'isdel'=>0,'storeid'=>$this->storeid);
            $map['advplaceid'] = '1';       //头部
            $topArr = M('Goods_advertising')->field('pic AS img,url')->where($map)->order('sorts ASC,id DESC')->limit(3)->select();
            $map['advplaceid'] = 2;         //爆款平团1
            $bkptO  = M('Goods_advertising')->field('pic AS img')->where($map)->order('sorts ASC,id DESC')->find();
            $map['advplaceid'] = 3;         //爆款平团2
            $bkptT  = M('Goods_advertising')->field('pic AS img')->where($map)->order('sorts ASC,id DESC')->find();
            if(!($topArr || $bkptO || $bkptT)){
                returnJson(0);
            }
            if($topArr){
                foreach($topArr AS $k=>$v){
                    $topArr[$k]['img']= C('API_IMAGE_URL').$v['img'];
                }
                $top = array('result'=>'1','info'=>$topArr);
            }else{
                $top = array('result'=>'0','info'=>'没有banner');
            }
            $info = array(
                'top'  =>$top,
                'bkpt' =>array(
                    array('img'=> $bkptO ? C('API_IMAGE_URL').$bkptO['img'] : '0'),
                    array('img'=> $bkptT ? C('API_IMAGE_URL').$bkptT['img'] : '0'),
                ),
            );
            returnJson(1,$info);
        }else{
           returnJson(0);
       }
    }
    public function indexHotGroupGoods()
    {   //爆款拼团商品
        if(IS_POST){
            $field = 'id AS goodsid,title,logo,price,oprice,slug,sales,virtualsales';
            $num   = 5;
            $map   = array('storeid'=>$this->storeid,'isdel'=>'0','issale'=>1,'ishot'=>1);
            $lists = M('Goods')->field($field)->where($map)->order('sorts ASC,id DESC')->limit(2)->select();
            if($lists){
                foreach($lists AS $k=>$v){
                    $lists[$k]['logo']     = $v['logo'] ? C('API_IMAGE_URL').$v['logo'] : 0;
                    $lists[$k]['price']    = $v['price'] ? : 0;
                    $lists[$k]['oprice']   = $v['oprice'] ? : 0;
                    $lists[$k]['slug']     = $v['slug'] ? : $v['title'];
                    $lists[$k]['sales']    = $v['sales'] > $v['virtualsales'] ? $v['sales'] : $v['virtualsales'];
                    unset($lists[$k]['virtualsales']);
                }
                returnJson(1,$lists);
            }else{
                returnJson(0,'没有商品了');
            }
        }
        returnJson(0);
    }
    public function indexHotGoods()
    {   //热卖好货
        if(IS_POST){
            $page  = I('post.p',0,'intval');
            $field = 'id AS goodsid,title,logo,price,integralprice,subtitle,sales,virtualsales';
            $num   = 5;
            $map   = array('storeid'=>$this->storeid,'isdel'=>'0','issale'=>1,'ishot'=>1);
            $lists = M('Goods')->field($field)->where($map)->order('sorts ASC,id DESC')->limit($page * $num,5)->select();
            if($lists){
                foreach($lists AS $k=>$v){
                    $lists[$k]['logo']          = $v['logo'] ? C('API_IMAGE_URL').$v['logo'] : 0;
                    $lists[$k]['price']         = $v['price'] ? : 0;
                    $lists[$k]['integralprice'] = $v['integralprice'] ? : 0;
                    $lists[$k]['subtitle']      = $v['subtitle'] ? : $v['title'];
                    $lists[$k]['sales']         = $v['sales'] > $v['virtualsales'] ? $v['sales'] : $v['virtualsales'];
                    unset($lists[$k]['virtualsales']);
                }
                returnJson(1,array('lists'=>$lists,'p'=>$page+1));
            }else{
                returnJson(0,'没有商品了');
            }
        }
        returnJson(0);
    }
    #商城分类#
    public function classify()
    {   // 1积分商城,2秒杀商城,3平团商城,4普通商城
        if(IS_POST){
            $malltype = I('post.malltype',0,'intval');
            $lists    = $this->mallCateCache($malltype);
            returnJson(1,array('cateidstr'=>$lists[0],'cateidarr'=>$lists[1]));
        }
        returnJson(0);
    }
    #系统缓存#
    public function cateCache()
    {   //缓存分类信息
        $catearr = S($this->storeid.'_cate');
        if(!$catearr){
            $map   = array('malltype'=>1,'status'=>0,'isdel'=>0);
            $field = 'id AS cateid,classname,status,pic';
            $lists = M('Goods_cate')->field($field)->where($map)->order('id ASC')->select();
            if($lists){
                $catearr = array();
                foreach($lists AS $k=>$v){
                    $v['pic']   = $v['pic'] ? C('API_IMAGE_URL').$v['pic'] : '0';
                    $catearr[$v['cateid']] = $v;
                }
                unset($lists);
                S($this->storeid.'_cate',$catearr,3600);
            }else{
                returnJson(0,'商城没有设置分类');
            }
        }
        return $catearr;
    }
    protected function mallTypeCheck($malltype)
    {
        if(!in_array($malltype,array(1,2,3,4))){
            returnJson(0,'错误的商城请求');
        }
    }
    public function mallCateCache($malltype)
    {   //缓存商城分类
        $mallcatestrarr = '';//S($this->storeid.'_mall_cate_'.$malltype);
        if(!$mallcatestrarr){
            $this->mallTypeCheck($malltype);
            $map   = array('malltype'=>array('like','%'.$malltype.'%'),'storeid'=>$this->storeid,'issale'=>1,'isdel'=>'0');
            $lists = M('Goods')->group('cateid')->where($map)->order('cateid ASC')->getField('cateid',true);
            if($lists){
                $mallcatearr = array();
                $mallcatestr = '';
                $cateAll     = $this->cateCache();
                foreach($lists AS $v){
                    if($v){
                        $cateinfo = $cateAll[$v];
                        if(!$cateinfo['status']){
                            unset($cateinfo['status']);
                            $mallcatearr[] = $cateinfo;
                            $mallcatestr  .=$v.',';
                        }
                    }
                }
                if($mallcatearr){
                    $mallcatestrarr = array(rtrim($mallcatestr,','),$mallcatearr);
                    S($this->storeid.'_mall_cate_'.$malltype,$mallcatestrarr,3600);
                }else{
                    returnJson(0,'没有商品分类');
                }
            }else{
                returnJson(0,'没有商品分类');
            }
        }
        return $mallcatestrarr;
    }
}

