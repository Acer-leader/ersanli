<?php
namespace Common\Controller;
use Think\Controller;
class SmsverificationController extends Controller
{
    private $account;
    private $pswd;
    public $telephone;
    public $msg;
    private $mkuserid;
    private $mkpassword;
    private $mkaccount;
    public function _initialize()
    {
        header("Content-type:text/html;charset=utf-8");
        $this->User_verify_db = M('user_verify');   //验证码防伪标
        $this->account = 'ptq888';
        $this->pswd    = '9v1A3vl5';
        $this->mkuserid   = '112';
        $this->mkaccount  = 'ptq123';
        $this->mkpassword = 'KaAH1d8x';
    }
    public function index()
    {
        $msg = '您好,您的门店申请已通过,登陆账号是:15868882554,登陆地址是:http://ptq.unohacha.com/Store/';
        $telephone = I('get.telephone/s','','trim') ? I('get.telephone/s','','trim') : '15868882554';
        p($telephone);
        dump($this->sendMessage($telephone,100,$msg,1));
        exit('end');
    }
    /*
    * 注册 修改密码 提现
    * 发送短信
    * $type 绑定  1切换身份,2申请商家
    */
    public function sendMessage($telephone,$type,$msg="预约信息",$sendtype=0)
    {   
        if (empty($telephone) || empty($type))
        {
            return array("status"=>0,"info"=>"缺少发送验证码方式");
        }elseif(!preg_match("/^1[34578]\d{9}$/", $telephone)) {
            $this->ajaxReturn(array("status" => 0, "info" =>'手机号格式错误'));
        }
        if(!in_array($sendtype,array('0','1')))
        {
            return array("status"=>0,"info"=>"发送短信方式错误");
        }
        if(!in_array($type,array('1','2','100')))
        {
            return array("status"=>0,"info"=>"发送短信类型错误");
        }
        $this->telephone = $telephone;
        $this->msg       = $msg;
        $data = array();
        if($sendtype)
        {
            $data['status']    = 1;
            $retJson = $this->sendMkDo();
        }else{
            $code= $this->randInt();
            switch($type)
            {   
                case 1:
                    $this->msg = "您正在进行身份切换验证,验证码".$code.",请尽快验证！";
                break;
                case 2:
                    $this->msg = "您正在进行店铺申请验证,验证码".$code.",请尽快验证！";
                break;
                default:
                break;
            }
            $data['code']      = $code;
            $data['status']    = 0;
            $retJson = $this->sendDo();
        }
        if($retJson['result']==0)
        {
            $data['telephone'] = $this->telephone;
            $data['create_at'] = NOW_TIME;
            $data['type']      = $type;
            $data['msg']       = $this->msg;
            $data['sendtype']  = $sendtype;
            $this->User_verify_db->add($data);
            return array("status"=>1,"info"=>"短信发送成功,请注意查收!");
        }else{
            $array = array(date('Y-m-d H:i:s',NOW_TIME) => array($telephone=>$retJson));
            //file_put_contents(ACTION_NAME.'.txt',print_r(array($array,date("Y-m-d H:i:s",NOW_TIME)),true).PHP_EOL,FILE_APPEND);
            return array("status"=>0,"info"=>"短信发送失败，请重试！");
        }
    }
    public function checkMessage($phone, $identify, $type=false)
    {   //这里判断  短信验证码
        if(!preg_match("/^1[34578]\d{9}$/", $phone))
            $this->ajaxReturn(array("status" =>'0', "info" =>'手机号格式错误'));
        $data = array('telephone'=>$phone,'status'=>0,'sendtype'=>0);
        if($type)
            $data['type'] = $type;
        $res=$this->User_verify_db->where($data)->order('create_at desc')->limit(1)->find();
        $time=$res['create_at'];
        if (NOW_TIME < ($time + C('over_time')))
        {
            $code=$res['code'];
            if ($code==$identify){ // 验证码正确,修改验证码状态
                $this->User_verify_db->where(array('id'=>$res['id']))->save(array("status"=>1));
                return array("status"=>'1',"info"=>"ok");
            }else {     // 验证码错误
                return array("status"=>'2',"info"=>"验证码错误");
            }
        }else{      //验证码过期
            $this->User_verify_db->where(array('id'=>$res['id']))->save(array("status"=>5));
            return array("status"=>'3',"info"=>"验证码过期");
        }
    }
    public function sendMkDo()
    {   //营销短信  立即发送,无扩展子号
        $body ="action=send&userid={$this->mkuserid}&account={$this->mkaccount}&password={$this->mkpassword}&mobile={$this->telephone}&content={$this->msg}&sendTime=&extno=";
        $url     = 'http://101.201.37.87:8898/sms.aspx';
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt ($ch, CURLOPT_POST, 1 );
        curl_setopt ($ch, CURLOPT_HEADER, 0 );
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $body );
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        $result = json_decode($this->xml_to_json($return));
        if(($result->message == 'pk') || ($result->returnstatus == 'Success'))
        {
            return array('result' =>0,'errorno' =>serialize(array($result->returnstatus,$result->message,$result->remainpoint,$result->taskID,$result->successCounts)));
        }else{
            return array('result' =>1,'errorno' =>$this->xml_to_json($return));
        }
    }
    public function sendDo()
    {   //发送验证码短信
        $geturlc = "http://116.62.64.214/msg/HttpBatchSendSM?account=".$this->account."&pswd=".$this->pswd."&mobile=".$this->telephone."&msg=".$this->msg."&needstatus=true&product=&resptype=json";
        return json_decode(file_get_contents($this->trimall($geturlc)),true);
    }
    public function trimall($str)
    {   //删除空格
        $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
        return str_replace($qian,$hou,$str);    
    }
    public function randInt($int = 6, $caps = false)
    {  //随机数
        $strings = '0123456789';
        $return = '';
        for($i = 0; $i < $int; $i++)
        {
            srand();
            $rnd = mt_rand(0, 9);
            $return = $return . $strings[$rnd];
        }
        return $caps ? strtoupper($return) : $return;
    }
    public function xml_to_json($source) {
        if(is_file($source)){   //传的是文件，还是xml的string的判断
            $xml_array=simplexml_load_file($source);
        }else{
            $xml_array=simplexml_load_string($source);
        }
        $json = json_encode($xml_array); //php5，以及以上，如果是更早版本，请查看JSON.php
        return $json;
    }
}
?>