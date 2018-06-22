<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model
{   //后台用户操作类
    public function user_list()
    {
        return $this->field('id,username,cate,is_open')->where('id!=1')->select();
    }
    public function login()
    {
        if(isset($_POST['username']))
        {
            $data['username'] = $_POST['username'];
            $data['password'] = md5($_POST['password']);
            $rs = $this->where($data)->select();
            if($rs)
            {
                if($rs[0]['is_open']==1)
                {
                    $_SESSION['admin'] = $rs[0]['username'];
                    $_SESSION['admin_id'] = $rs[0]['id'];
                    $data_log=array(
                        'last_login' => time(),
                    );
                    M('user')->where(array('id'=>$rs[0]['id']))->save($data_log);
                    return 1; // 登陆成功
                }else{
                    return 2 ; // 禁用
                }
            }else{
                return 0; // 用户名密码错误
            }
        }
    }
    public function login_outside()
    {
        if(isset($_GET['username']))
        {
            $ly_key="5k3hk@8f3_kl";
            $data['username'] = $_GET['username'];
            $getsig = $_GET['sig'];
            $sig = md5($data['username'].$ly_key);
            if($getsig==$sig)
            {
                $rs = $this->where($data)->select();
                if($rs)
                {
                    $_SESSION['admin'] = $rs[0]['username'];
                    $_SESSION['admin_id'] = $rs[0]['id'];
                    return true;
                }
            }else{
                return false;
            }
        }
    }
    public function addAdmin($username,$password,$cate,$country)
    {   // 添加
        $res=explode('/', $country);
        $data=array(
            "username" => $username,
            "password" => md5($password),
            "cate"     => $cate,
            "province" => $res[0],
            "city"     => $res[1],
            "district" => $res[2],
            "add_time" => time(),
            "is_open" => 0,
        );
        $rs = $this->where("username = '".$username."'")->count();
        if($rs)
        {
            return 0; //已存在记录
        }else{
            $is_ok = $this->data($data)->add();	
            if($is_ok)
            {
                return 1;
            }else{
                return 2;
            }
        }
    }
    public function editAdmin($id,$username,$password,$cate,$country)
    {   //编辑
        // 判断密码是否为空，为空则不修改密码，反之修改密码
        if($password != "")
        {
            $postdata=array(
                "id"=>$id,
                "username"  => $username,
                "password"  => md5($password),
                "cate"      => $cate,
                "edit_time" => time(),
            );
            
        }else{
            $postdata=array(
                "id"=>$id,
                "username"  => $username,
                "cate"      => $cate,
                "edit_time" => time(),
            );
        }
        if($country!="//")
        {
            $res=explode('/', $country);
            $postdata['province'] = $res[0];
            $postdata['city']     = $res[1];
            $postdata['district'] = $res[2];
        }
        $data = $this->where("id=".$id)->select();      // 判断用户名是否为此id的用户名，
        if($data[0]['username'] == $username)
        {
            $rs = 0;
        }else{
            $rs = $this->where("username = '".$username."'")->count();
        }
        if($rs)
        {
            return 0; //记录不存在
        }else{
            $this->save($postdata);
            return 1;
        }
    }
    public function able($id,$able)
    {   // 禁用
        $postdata['id'] = $id;
        if($able == "enable")
        {
            $postdata['is_open'] = 0;
        }else{
            $postdata['is_open'] = 1;
        }
        $this->save($postdata);
        return 1;
    }
    public function del($id)
    {   // 删除
        $result = $this->where("id=$id")->delete();
        if($result)
        {
            return 1; // 成功
        }else{
            return 0; // 失败
        }
    }
    public function getone($name)
    {
        $userid = $_SESSION['admin_id'];
        $rs = $this->where('id='.$userid)->getField($name);
        return $rs;
    }
}
 ?>