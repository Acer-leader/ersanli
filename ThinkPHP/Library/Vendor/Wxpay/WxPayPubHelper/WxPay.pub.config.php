<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
//1237853402@1237853402

	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wx650d7f24a514ef32';
	//受理商ID，身份标识
	const MCHID = '1486278752';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'ef0pa338f16T64e8014f984f81Q9b469';
	//const KEY = '874164';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = '720d3821f4c01c0adf889ec5565e38db';
	
	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = 'http://ptq.unohacha.com/Wxin/Weixinpay/jsapi.html';
	
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = 'http://ptq.unohacha.com/ThinkPHP/Library/Vendor/Wxpay/WxPayPubHelper/cert/apiclient_cert.pem';
	const SSLKEY_PATH =  'http://ptq.unohacha.com/ThinkPHP/Library/Vendor/Wxpay/WxPayPubHelper/cert/apiclient_key.pem';
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = 'http://ptq.unohacha.com/Wxin/Weixinpay/wxpayNotify';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
	
}
	
?>