<?php
namespace Api\Controller;
header('Content-Type:text/html; charset=utf-8');
use Think\Controller;
class PublicController extends Controller
{   //公共文件  ajaxR自定义返回函数
    private $storeid;
    public function _initialize()
    {   //初事化模块
        $this->storeid = 1;
    }
    public function index(){
        exit("您真调皮哦");
    }
    public function __call($method, $param)
    {
        returnJson(0,$method."非法的访问！".$param);
    }
}

