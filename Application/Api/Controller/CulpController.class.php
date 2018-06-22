<?php
namespace Api\Controller;
class CulpController extends PublicController
{
    public function _initialize()
    {   //判断用户登录
        if(!IS_POST){
            $this->ajaxReturn($this->returnError());
        }
        $this->token=trim(I('post.token'));
        $userinfo   = $this->getUserInfoByToken($this->token);
        if(!$userinfo){
            returnJson('-1','请先登录');
        }
        $this->userid   = $userinfo['id'];
        $this->userinfo = $userinfo;
    }
    protected function getUserInfoByToken($token)
    {
        $tokeninfo = M("memberToken")->where(array("token"=>$token))->find();
        if(empty($tokeninfo)){
            returnJson('-1','请先登录');
        }
        if($tokeninfo['isonline']==0){
            returnJson('-1','请先登录');
        }
        $map = array(
            "id"        => $tokeninfo['userid'],
            "telephone" => $tokeninfo['telephone'],
        );
        $userinfo = M("member")->where($map)->find();
        if(!$userinfo){
            returnJson('-1','请先登录');
        }
        if($userinfo['isdel']){     //账号删除
            returnJson(0,'账号删除');
        }
        if($userinfo['status']){    //账号冻结
            returnJson(0,'账号冻结');
        }
        return $userinfo;
    }
}
?>