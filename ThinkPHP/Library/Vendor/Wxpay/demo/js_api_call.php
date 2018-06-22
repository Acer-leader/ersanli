<?php
include "../../include/config.php";
include "../../include/commen_func.php";
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
*/
include_once("../WxPayPubHelper/WxPayPubHelper.php");

$orderid=intval($_GET['orderid']);

//echo "$orderid";
if(!empty($orderid)){
    $arr=$db->getnews_con("tb_orderlist","where id=".$orderid);    //根据订单号查找订单详情

    $out_trade_no=$arr['order_no'];
    $total_fee=$arr['allprice']*100;
}else{

    $state=$_GET['state'];
//    echo $state;
    $str = stripslashes($state);
    $arr=json_decode($str,1);
//var_dump($arr);
    $out_trade_no=$arr['out_trade_no'];
    $total_fee=$arr['total_fee'];
}


	//使用jsapi接口
	$jsApi = new JsApi_pub();
    $orderid=intval($_GET['orderid']);
	//=========步骤1：网页授权获取用户openid============
	//通过code获得openid
	if (!isset($_GET['code']))
	{
//        echo $orderid;die;
		//触发微信返回code码
		$url= $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
        $state = json_encode(array(
//            "body" => $body,
            "out_trade_no" => $out_trade_no,
            "total_fee" => "$total_fee",
        ));
        $url = str_replace("STATE", $state, $url);
//        $url=$url1.'?orderid='.$orderid;
		Header("Location: $url'");
	}else
	{
		//获取code码，以获取openid
	    $code = $_GET['code'];
		$jsApi->setCode($code);
		$openid = $jsApi->getOpenId();
//        echo $openid;die;
	}
//echo $openid;die;
	//=========步骤2：使用统一支付接口，获取prepay_id============
	//使用统一支付接口
	$unifiedOrder = new UnifiedOrder_pub();

	//设置统一支付接口参数
	//设置必填参数
	//appid已填,商户无需重复填写
	//mch_id已填,商户无需重复填写
	//noncestr已填,商户无需重复填写
	//spbill_create_ip已填,商户无需重复填写
	//sign已填,商户无需重复填写



	$unifiedOrder->setParameter("openid","$openid");//商品描述
	$unifiedOrder->setParameter("body","储恋商城购物");//商品描述
	//自定义订单号，此处仅作举例
//	$timeStamp = time();
//	$out_trade_no = WxPayConf_pub::APPID."$timeStamp";


//    $orderid=$_GET['orderid'];


	$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
	$unifiedOrder->setParameter("total_fee","$total_fee");//总金额
	$unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址
	$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
	//非必填参数，商户可根据实际情况选填
	//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
	//$unifiedOrder->setParameter("device_info","XXXX");//设备号
	//$unifiedOrder->setParameter("attach","XXXX");//附加数据
	//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
	//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
	//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
	//$unifiedOrder->setParameter("openid","XXXX");//用户标识
	//$unifiedOrder->setParameter("product_id","XXXX");//商品ID

	$prepay_id = $unifiedOrder->getPrepayId();
	//=========步骤3：使用jsapi调起支付============
	$jsApi->setPrepayId($prepay_id);

	$jsApiParameters = $jsApi->getParameters();
	//echo $jsApiParameters;
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>

	<script type="text/javascript">

		//调用微信JS api 支付
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters; ?>,
				function(res){
					WeixinJSBridge.log(res.err_msg);
					alert(res.err_msg);
//					alert(res.err_code+res.err_desc+res.err_msg);
                    window.location.href="http://my.unohacha.com/chuliansc/";
                    if(res.err_msg=="get_brand_wcpay_request:ok"){
                        //alert(res.err_code+res.err_desc+res.err_msg);
                        alert(支付成功);
                        window.location.href="http://my.unohacha.com/chuliansc/";
                    }else{
                        //返回跳转到订单详情页面
                        alert(支付失败);
                        window.location.href="http://my.unohacha.com/chuliansc/";

                    }
				}
			);
		}
        window.onload=callpay();
		function callpay()
		{
//            alert(1);
			if (typeof WeixinJSBridge == "undefined"){
			    if( document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
//                alert(2);
			    jsApiCall();
			}
		}
	</script>
</head>
<body>
	</br></br></br></br>
	<div align="center">
<!--		<button style="width:210px; height:30px; background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >贡献一下</button>-->
	</div>
</body>
</html>