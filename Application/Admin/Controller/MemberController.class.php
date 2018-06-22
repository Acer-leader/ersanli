<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class MemberController extends CommonController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->Member_db = M('member');
    }
    public function index()
    {
        
        $where    = array();
        $title    = trim(I('title'));
        
        if($title)
        {
            //$where["realname|person_name|telephone"] = array('like',"%{$title}%");
            //$this->assign('title',$title);
        }
        $where["isdel"] = 0;
        $count = $this->Member_db->where($where)->count();
        $Page = getpage($count,30);
        $show  = $Page->show();
        $lists = $this->Member_db->where($where)->order('status ASC,id DESC')->limit($Page->firstRow, $Page->listRows)->select();
        
        $this->assign('count',$count);
        if($count>30){
            $this->assign('page',$show);
        }
        $this->assign('lists',$lists);
        $this->display();
    }
    public function addMember()
    {
        if(IS_AJAX)
        {
            $branchid =trim(I('post.branchid'));
            $gid      =trim(I('post.gid'));
            $realname =trim(I('post.realname'));
            $person_name =trim(I('post.person_name'));
            $telephone=trim(I('post.telephone'));
            $password =trim(I('post.password'));
            $sex      =trim(I('post.sex'));
            if(!$telephone){
                $this->ajaxReturn(array('status'=>0, 'info'=>'手机号必填！'));
            }elseif(!preg_match("/^1[35789][0-9]{9}$/", $telephone)){
                $this->ajaxReturn(array('status'=>0, 'info'=>'手机号格式错误！'));
            }elseif($this->Member_db->where(array('telephone'=>$telephone))->count()){
                $this->ajaxReturn(array('status'=>0, 'info'=>'手机号已存在！'));
            }elseif($branchid<1){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请选择部门！'));
            }elseif($gid<1){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请选择职位！'));
            }elseif(!$realname){
                $this->ajaxReturn(array('status'=>0, 'info'=>'真实姓名必填！'));
            }elseif(!$person_name){
                $this->ajaxReturn(array('status'=>0, 'info'=>'昵称必填！'));
            }elseif(($sex!=1)&&($sex!=2)){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请选择性别！'));
            }elseif(!$password){
                $password = $telephone;
            }
            if(!preg_match("/.{6,16}/", $password))
            {
                $this->ajaxReturn(array("status"=>0, "info"=>"密码格式错误！"));
            }
            $data = array(
                    'branchid'=>$branchid,
                    'gid'=>$gid,
                    'realname'=>$realname,
                    'person_name'=>$person_name,
                    'telephone'=>$telephone,
                    'password'=>MD5(MD5($password)),
                    'sex'=>$sex,
                    'person_img'=>'/Public/Home/images/u1.png',
                    'status'=>0,
                    'add_time'=>date("Y-m-d H:i:s",NOW_TIME),
            );
            $id = $this->Member_db->add($data);
            $this->returnAjax($id);
        }exit;
    }
    public function detail()
    {   // 编辑个人资料
        if(IS_POST)
        {
            $data = array();
            $data = I('post.');
            if(!trim($data['id']))
            {
                $this->ajaxReturn(array('status'=>0, 'info'=>'修改失败'));
            }
            if(!trim($data['branchid']))
            {
                $this->ajaxReturn(array('status'=>0, 'info'=>'部门必须选择'));
            }
            if(!trim($data['gid']))
            {
                $this->ajaxReturn(array('status'=>0, 'info'=>'职位必须选择'));
            }
            if(!trim($data['realname']))
            {
                $this->ajaxReturn(array('status'=>0, 'info'=>'真实姓名必填！'));
            }else{
                $data['realname'] = trim($data['realname']);
            }
            if(trim($data['person_name']))
            {
                $data['person_name'] = trim($data['person_name']);
            }else{
                unset($data['person_name']);
            }
            if(trim($data['password']))
            {
                $data['password'] = trim($data['password']);
                if(!preg_match("/.{6,16}/",$data['password']))
                {
                    $this->ajaxReturn(array("status"=>0, "info"=>"密码格式错误！"));
                }else{
                    $data['password'] = MD5(MD5($data['password']));
                }
            }else{
                unset($data['password']);
            }
            if(($data['sex']!=1)&&($data['sex']!=2))
            {
                $this->ajaxReturn(array('status'=>0, 'info'=>'请选择性别！'));
            }
            if(trim($data['birth']))
            {
                $data['birth'] = trim($data['birth']);
            }else{
                unset($data['birth']);
            }
            if(trim($data['qq']))
            {
                $data['qq'] = trim($data['qq']);
            }else{
                unset($data['qq']);
            }
            if(trim($data['email']))
            {
                $data['email'] = trim($data['email']);
                if(!preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/",$data['email'])){
                    $this->ajaxReturn(array("status"=>0, "info"=>"邮箱格式错误"));
                }
            }else{
                unset($data['email']);
            }
            if(trim($data['website']))
            {
                $data['website'] = trim($data['website']);
            }else{
                unset($data['website']);
            }
            if(trim($data['signature']))
            {
                $data['signature'] = trim($data['signature']);
            }else{
                unset($data['signature']);
            }
            $res = $this->Member_db->save($data);
            $this->returnAjax($res);
        }else{
            $id = trim(I("get.id"));
            $info = M("member")->where(array('id'=>$id))->find();   //dump($info);
            if(!$info)
            {
                $this->error('查询错误');
            }
            $action = D('Admin/Member');
            $jobArr = $action->jobArr();  //dump($jobArr);
            $this->assign('branchlists',$jobArr['branchArr']);
            $this->assign('joblists',$jobArr['jobArr']);
            $this->assign("info",$info);
            $this->display();
        }
    }
    public function changeStatus()
    {   // 冻结/解冻
        if(IS_AJAX)
        {
            $id = I("id");
            $m = M("member");
            $res = $m->where("id=$id")->field("id,status")->find();
            if($res)
            {
                $res['status'] = $res['status']==1?0:1;
                $res2 = $m->save($res);
                if($res2)
                {
                    $arr = array("正常","冻结");
                    $return = array(
                        "status" => 1,
                        "info" => $arr[$res['status']]
                    );
                }else{
                    $return = array(
                        "status" => 0
                    );
                }
            }else{
                $return = array(
                    "status" => 2
                );
            }
           $this->ajaxReturn($return);
        }exit;
    }
    public function delmember()
    {
        $memberid=I('get.id');
        $m = M("member"); // 实例化User对象
        $rs=$m->where("id=$memberid")->delete(); // 删除id为5的用户数据
        if($rs)
        {
            $this->success('删除成功',U('/Admin/Member/index'));
        }else{
            $this->error('删除失败');
        }
    }
    public function memberImport()
    {
        if(IS_POST)
        {
            set_time_limit(0);
            header('Content-Type: text/html; charset=utf-8');
            if(!empty($_FILES['upfile']['size']))
            {
                $upload = new \Think\Upload();
                $upload->maxSize = 3145728;// 设置附件上传大小  3M
                $upload->exts = array('xlsx','xls');// 设置附件上传类型
                $upload->rootPath ='./Uploads/Excel/';
                // 上传文件
                $info = $upload->upload();
                if(!$info)
                {// 上传错误提示错误信息
                    $this->error('上传文件失败,请重新上传！');
                    //exit('出现异常,请放回重新上传文件 <br> <a href="'.U('/Admin/Member/memberImport') .'">返回</a>');
                }else{// 上传成功 获取上传文件信息  $file_name excal文件的保存路径
                    $file_name=$upload->rootPath.$info["upfile"]['savepath'].$info["upfile"]["savename"];//地址等于更目录加上创建的子目录加上文件名
                }
                echo "每次导入500条记录,请耐心等待网页尾部出现返回按钮,即导入全部处理完成<br/>";
                import("Org.Util.PHPExcel");
                //文件名为文件路径和文件名的拼接字符串
                if ($info['upfile']['ext'] =='xlsx')
                {
                    //$objReader = new PHPExcel_Reader_Excel2007();
                    $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//创建读取实例
                } else if ($info['upfile']['ext'] =='xls') {
                    //$objReader = new PHPExcel_Reader_Excel5();
                    $objReader = \PHPExcel_IOFactory::createReader('Excel5');//创建读取实例
                }
                $objPHPExcel    = $objReader->load($file_name,$encode='utf-8');//加载文件
                $sheet          = $objPHPExcel->getSheet(0);//取得sheet(0)表
                $highestRow     = $sheet->getHighestRow(); // 取得总行数  2117
                $highestColumn  = $sheet->getHighestColumn(); // 取得总列数 
                $lengths = 500;  //每次处理500条数据
                $existtxt  = $unexisttxt  = $successtxt  = $failuretxt  ='';   //重复  成功  失败
                $nums   = ceil($highestRow / $lengths);  //dump($nums);  //页数
                for($i=0;$i<$nums;$i++)
                {
                    $existhtml = $unexisthtml = $successhtml = $failurehtml ='';   //重复  成功  失败
                    $startRow = $i * $lengths; //dump($startRow); dump($startRow + $lengths); //开始读取的行数
                    if(($startRow + $lengths) > $highestRow)
                    {   //最后执行的次数
                        $lengths = $highestRow - ($i * $lengths); //dump($lengths); //最后一页执行的次数
                    }
                    for($j=1;$j<$lengths+1;$j++)
                    {   //读取限制的数据,并组装
                        $telephone  = trim($objPHPExcel->getActiveSheet()->getCell("A".($startRow + $j))->getValue());  //手机号
                        $name       = trim($objPHPExcel->getActiveSheet()->getCell("B".($startRow + $j))->getValue());  //用户名
                        $status     = trim($objPHPExcel->getActiveSheet()->getCell("C".($startRow + $j))->getValue());  //状态
                        $branchid   = trim($objPHPExcel->getActiveSheet()->getCell("D".($startRow + $j))->getValue());  //部门id
                        $person_img = "/Public/Home/images/u1.png";
                        if(!$telephone)
                        {   //手机号不存在的数据
                            $unexisthtml .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++手机号不存在<br>";
                            $unexisttxt  .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++手机号不存在\r";
                            continue;
                        }
                        $data = array();  
                        $data['telephone'] = $telephone;   //手机号
                        $count = $this->Member_db->where($data)->order('id DESC')->count();
                        if($count > 0)
                        {
                            $existhtml .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++已经存在<br>";
                            $existtxt  .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++已经存在\r";
                            continue;
                        }
                        $data['password']  = MD5(MD5(substr($telephone,-6)));        //手机号后6位密码
                        $data['realname']  = $name ? $name : $telephone;
                        $data['person_img']= "/Public/Home/images/u1.png";  //头像
                        $data['status']    = $status ? $status : 0;  //状态
                        $data['branchid']  = $branchid ? $branchid : 0;  //部门
                        $data['gid']       = 1;
                        $data['add_time']  = date("Y-m-d H:i:s",NOW_TIME);
                        $id = $this->Member_db->add($data);
                        if($id)
                        {
                            $successhtml .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++导入成功<br>";
                            $successtxt  .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++导入成功\r";
                        }else{
                            $failurehtml .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++导入失败<br>";
                            $failuretxt  .= "第".($startRow + $j)."行+++手机号: ".$telephone."+++姓名: ".$name."+++导入失败\r";
                        }
                    }
                    echo $unexisthtml."<br>".$existhtml."<br>".$successhtml."<br>".$failurehtml;
                    usleep(100);
                }
                $textcontent = "手机号不存在:\r".$unexisttxt."\n\r";
                $textcontent .="用户已经存在:\r".$existtxt."\n\r";
                $textcontent .="导入成功:\r".$successtxt."\n\r";
                $textcontent .="导入失败:\r".$failuretxt;
                $txtname = "memberImport - ".date("YmdHis",NOW_TIME).".txt";
                file_put_contents($txtname, print_r(iconv("UTF-8", "GB2312//IGNORE", $textcontent) ,true).PHP_EOL, FILE_APPEND);
                $url = curHost()."/".$txtname;
                exit("导入完成!!!&nbsp;&nbsp;&nbsp;&nbsp;<a href='".U('/Admin/Member/memberImport') ."'>返回</a>&nbsp;&nbsp;<a href='".$url."' target='_black'>下载日志</a>");
            }else{
                $this->error('请选择上传文件！');
            }
            exit;
        }
        $this->display();
    }
}