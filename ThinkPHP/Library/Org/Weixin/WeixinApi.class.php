<?php
/**
 * @explain    OAuth授权,获取用户信息,获取微信分享配置
 * @version    2.0
 * @category   ORG
 * @package    ORG
 * @subpackage Net
 * @author     Cyong <iwanjiao@qq.com>
 * @prompt     dataJson/access_token/ and dataJson/jsapi_ticket/  为文件写入目录,位于根目录下/wwwroot/
 */
class WeixinApi
{
    
    private $requestCodeURL         = 'https://open.weixin.qq.com/connect/oauth2/authorize';            //获取code URL
    private $requestOauthUrl        = 'https://api.weixin.qq.com/sns/oauth2';                           //请求授权
    private $requestUserinfoUrl     = 'https://api.weixin.qq.com/sns/userinfo';                         //授权获取用户信息
    private $requestRsfreshTokenUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';             //刷新授权token
    private $requestBasisTokenUrl   = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential';   //刷新基础token 包括UnionID机制
    private $requestUserUrl         = 'https://api.weixin.qq.com/cgi-bin/user/info';                     //获取用户信息
    private $requestTicketUrl       = 'http://api.weixin.qq.com/cgi-bin/ticket/getticket';               //jsapi_ticket
    
    public function __construct()
    {
        header("Content-Type:text/html; charset=utf-8");
        $this->appId = 'wx650d7f24a514ef32';
        $this->appSecret = '720d3821f4c01c0adf889ec5565e38db';
        $this->jsonUserInfoAccessToken = "./dataJson/access_token/".$this->appId."_userinfo_access_token.json";
        $this->jsonBasicsAccessToken   = "./dataJson/access_token/".$this->appId."_basics_access_token.json";
        $this->jsonJsapiTicket         = "./dataJson/jsapi_ticket/".$this->appId."_jsapi_ticket.json";
    }
    public function getOpenid()
    {   //获取微信openid
        if (!isset($_GET['code']))
        {
            $query = array(
                'appid'         => $this->appId,
                'redirect_uri'  => self::getUrl(),
                'response_type' => 'code',
                'scope'         => 'snsapi_userinfo',
                'state'         => 'oauth',
            );
            header('Location:'."{$this->requestCodeURL}?".http_build_query($query)."#wechat_redirect");exit();
        }
        if (isset($_GET['code'])&&isset($_GET['state'])&&isset($_GET['state'])=='oauth')
        {
            $query = array(
                'appid'     => $this->appId,
                'secret'    => $this->appSecret,
                'code'      => $_GET['code'],
                'grant_type'=> 'authorization_code',
            );
            $res=$this->httpsRequest("{$this->requestOauthUrl}/access_token?".http_build_query($query));
            if($res['access_token'])
            {
                $data->expire_time   = time() + 7000;
                $data->access_token  = $res['access_token'];
                $data->refresh_token = $res['refresh_token'];
                file_put_contents($this->jsonUserInfoAccessToken,json_encode($data));
            }
            if($res['openid'])
            {
                return $res['openid']; exit();
            }else{
                throw new \Exception('授权失败');
            }
        }
    }
    public function getWexinInfoOAuthTwo($openId)
    {   //获取微信用户信息OAuth2.0(网页授权)
        #https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
        $query = array(
            'access_token'=>$this->getUserinfoAccessToken(),
            'openid'      =>$openId,
            'lang'        =>'zh_CN',
        );
        $wxUserInfo=$this->httpsRequest("{$this->requestUserinfoUrl}?".http_build_query($query));
        $wxUserInfo['nickname']=$this->filterNickname($wxUserInfo['nickname']);
        return $wxUserInfo;
    }
    public function getWexinInfoUnionId($openId)
    {   //获取用户基本信息（包括UnionID机制）
        $query = array(
            'access_token'=>$this->getBasicsAccessToken(),
            'openid'      =>$openId,
            'lang'        =>'zh_CN',
        );
        $wxUserInfo=$this->httpsRequest("{$this->requestUserUrl}?".http_build_query($query));
        $wxUserInfo['nickname']=$this->filterNickname($wxUserInfo['nickname']);
        return $wxUserInfo;
    }
    public function getWexinShare()
    {   //获取微信分享配置
        $jsapiTicket = $this->getJsApiTicket();
        $url = self::getUrl();  // 注意 URL 一定要动态获取，不能 hardcode.
        $timestamp = time(); 
        $nonceStr = $this->createNonceStr();
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";  // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $signature = sha1($string); 
        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
    private function getJsApiTicket()
    {   //获取getJsApiTicket   //jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents($this->jsonJsapiTicket));
        if ($data->expire_time < time())
        {
            $query = array(
                'access_token' => $this->getBasicsAccessToken(),
                'type'         => 'jsapi',
            );
            $res=$this->httpsRequest("{$this->requestTicketUrl}?".http_build_query($query));
            if($res['ticket'])
            {
                $data->expire_time   = time() + 7000;
                $data->jsapi_ticket  = $res['ticket'];
                $data->jsapi_errmsg  = $res['errmsg'];
                $data->jsapi_errcode = $res['errcode'];
                file_put_contents($this->jsonJsapiTicket,json_encode($data));
            }else{
                throw new \Exception('请求错误');
            }
        }
        return $data->jsapi_ticket;
    }
    private function getUserinfoAccessToken()
    {   //获取用户信息的access_token
        $data = json_decode(file_get_contents($this->jsonUserInfoAccessToken));
        if($data->expire_time < time())
        {
            #https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
            $query = array(
                'appid'         => $this->appId,
                'grant_type'    => 'refresh_token',
                'refresh_token' => $data->refresh_token,
            );
            $res=$this->httpsRequest("{$this->requestRsfreshTokenUrl}?".http_build_query($query));
            if($res['access_token'])
            {
                $data->expire_time   = time() + 7000;
                $data->access_token  = $res['access_token'];
                $data->refresh_token = $res['refresh_token'];
                file_put_contents($this->jsonUserInfoAccessToken,json_encode($data));
            }else{
                throw new \Exception('请求错误');
            }
        }
        return $data->access_token;
    }
    public function getAcc()
    {
        return $this->getBasicsAccessToken();
    }
    private function getBasicsAccessToken()
    {   //获取AccessToken  基础支持access_token
        #https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
        $data = json_decode(file_get_contents($this->jsonBasicsAccessToken));
        if($data->expire_time < time())
        {
            $query = array(
                'appid' => $this->appId,
                'secret'=> $this->appSecret,
            );
            $res=$this->httpsRequest("{$this->requestBasisTokenUrl}&".http_build_query($query));
            if($res['access_token'])
            {
                $data->expire_time = time() + 7000;
                $data->access_token = $res['access_token'];
                file_put_contents($this->jsonBasicsAccessToken,json_encode($data));
            }else{
                throw new \Exception('请求错误');
            }
        }
        return $data->access_token;
    }
    private function filterNickname($str)
    {   //Cyong  //过滤微信里特殊字符
        if($str)
        {
            $name = $str;
            $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name);
            $name = preg_replace('/xE0[x80-x9F][x80-xBF]бо.бо|xED[xA0-xBF][x80-xBF]/S','?', $name);
            $return = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#ie","",json_encode($name)));
        }else{
            $return = '微信用户';
        }
        return $return;
    }
    private function createNonceStr($length = 16)
    {   //16位随机数
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    protected function httpsRequest($url, $data = NULL)
    {
        $curl = curl_init();
        $header = 'Accept-Charset: utf-8';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $output  = curl_exec($curl);
        $errorno = curl_errno($curl);
        curl_close($curl);
        if ($errorno)
        {
            //return array('curl' => false, 'errorno' => $errorno);
            throw new \Exception('请求发生错误：' . $errorno);
        }else{
            $res = json_decode($output, 1);
            if($res['errcode'])
            {
                //return array('errcode' => $res['errcode'], 'errmsg' => $res['errmsg']);
                throw new \Exception('请求发生错误：' . $res['errmsg']);
            }else{
                return $res;
            }
        }
    }
    public function getUrl()
    {   //获取当前完整URl
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self     = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info    = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url   = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }
    public function curPageURL()
    {   //获取当前无参数URl
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on")
        {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        $this_page = $_SERVER["REQUEST_URI"];
        
        if (strpos($this_page, "?") !== false)   // 只取 ? 前面的内容
            $this_page = reset(explode("?", $this_page));
        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $this_page;
        }else{
            $pageURL .= $_SERVER["SERVER_NAME"] . $this_page;
        }
        return $pageURL;
    }
    public function curHost()
    {   //获取当前域名
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on")
        {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
        }else{
            $pageURL .= $_SERVER["SERVER_NAME"];
        }
        return $pageURL;
    }
}