<?php
namespace Api\Controller;
class PointsmallController extends PublicController
{   //积分商城部分
    protected $storeid;
    protected $malltype;
    protected $malltypeid;
    public function _initialize()
    {
        parent::_initialize();
        $this->storeid    = 1;
        $this->malltype   = array('like','%1%');
        $this->malltypeid = 1;
    }
    public function index()
    {
        returnJson(1,'欢迎来到积分商城');
    }
    #商城首页#
    public function indexBanner()
    {   //首页banner
        if(IS_POST){
            $map   = array('status'=>0,'isdel'=>0,'storeid'=>$this->storeid,'advplaceid'=>2);
            $banner= M('Goods_advertising')->field('pic AS img')->where($map)->order('sorts ASC,id DESC')->find();
            if($banner){
                returnJson(1,$banner ? C('API_IMAGE_URL').$banner['img'] : '0');
            }
        }else{
           returnJson(0);
       }
    }
    public function index()
    {   //积分秒杀
        
    }
    public function indexNewtj()
    {   //上新推荐
        if(IS_POST){
            $field = 'id AS goodsid,title,logo,price,integralprice,giftpoints,sales,virtualsales';
            $map   = array('storeid'=>$this->storeid,'isdel'=>'0','issale'=>1,'isnew'=>1,'malltype'=>$this->malltype);
            $lists = M('Goods')->field($field)->where($map)->order('rand()')->limit(12)->select();
            if($lists){
                foreach($lists AS $k=>$v){
                    $lists[$k]['logo']     = $v['logo'] ? C('API_IMAGE_URL').$v['logo'] : 0;
                    $lists[$k]['price']    = $v['price'] ? : 0;
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
    public function timelimit()
    {
        $timelimit = S($this->storeid.'_timelimit_'.$this->malltypeid);
        if(!$timelimit){
            $map = array('storeid'=>$this->storeid,'status'=>0,'isdel'=>0);
            $lists = M('Goods_timelimit')->field('timelimit')->where($map)->order('sorts ASC')->select();  dump($lists);
            if($lists){
                
            }else{
                returnJson(0,'商城没有设置积分抢购时间');
            }
        }
        return $timelimit;
        
    }
}

