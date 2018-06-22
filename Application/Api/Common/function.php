<?php
#Api  公共方法#
function returnJson($result=0,$info='')
{   //错误的请求
    switch($result){
        case -1:
            $info = $info ? : '请先登录!';
        break;
        default:
            $info = $info ? : '没有数据';
        break;
    }
    $return = array('result'=>$result,'info'=>$info);
    ajaxR($return);
}
function returnStatus($id,$retitle)
{   //判断返回
    $retitle = $retitle ? : '操作';
    if($id === true){
        returnJson(1,$retitle.'成功!');
    }
    returnJson(0,$retitle.'失败!');
}