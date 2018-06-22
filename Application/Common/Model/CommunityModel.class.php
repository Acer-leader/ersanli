<?php
namespace Common\Model;
use Think\Model;
class CommunityModel extends Model
{   
    //获取列表 $where条件 $limit每页显示多少
    public function communityLists($where='',$limit='')
    {   
        if ($limit) {
            $limit = 10;
        }
        //显示分页
        $tatal = $this->where($where)->count();        
        $pages = getpage($tatal, $limit);
        $res['page']  = $pages->show();
        //获取新闻列表
        $res['list'] = $this->where($where)->Order("id desc")->limit($pages->firstRow. ',' .$pages->listRows)->select();
        return $res;
    }

    //修改删除/置顶
    public function saveStatus($data='')
    {
        $re = $this->where("id=".$data['id'])->find();
        if ($data['action'] == 'del') {
            $is = $re['isdel']==1?0:1;
            $res = $this->where('id='.$data['id'])->setField('isdel',$is);
        }else if($data['action'] == 'top'){
            $is = $re['istop'] ==1?0:1;
            $res = $this->where('id='.$data['id'])->setField('istop',$is);   
        }
        $info['is'] = $is;
        if ($res) {
            $info['status'] = 1;
            return $info;
        }else{
            $info['status'] = 0;
            return $info;
        }
    }

    //编辑添加 $data 信息
    public function addCommunity($data='')
    {
        $data['isofficial'] = 0;
        if ($data['id'] == '') {
            unset($data['id']);
            $data['pic'] = implode('|',$data['detailpic']);
            unset($data['detailpic']);
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
            $data['pic'] = implode('|',$data['detailpic']);
            unset($data['detailpic']);
            $res = $this->where("id=$id")->save($data);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }
    }

    //获取单条信息  $id
    public function getOneCommunity($id = '')
    {
        if ($id) {
            $res = $this->where("id=$id")->find();
            $res['pic'] = explode('|',$res['pic']);
            return $res;
        }
    }

 }

?>