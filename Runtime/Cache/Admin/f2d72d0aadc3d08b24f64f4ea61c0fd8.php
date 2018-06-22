<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="shortcut icon" href="/Public/Public/images/logo.ico"/>
<title><?php echo ($shop_seo_config["title"]); ?>-后台管理系统</title>

<link rel="stylesheet" href="/Public/Admin/Css/component-min.css">
<link rel="stylesheet" href="/Public/Admin/Css/jbox-min.css">
<link rel="stylesheet" href="/Public/Admin/Css/home.2015.05.22-09.32.css">
<link rel="stylesheet" href="/Public/Admin/Css/list_homepage.css">
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/datepicker/WdatePicker.js"></script>

<style>
#teding {
    width: 100%;
    height: 495px;
}
.gaoliang {
    background-color: #e30000;
    color: #fff;
}
.fl .zzss {
    /*position: absolute;*/
    font-size: 15px;
    right: 0;
    top: -5px;
    background: #c61e2d;
    color: #fff;
    width: 25px;
    height: 25px;
    line-height: 25px;
    text-align: center;
    display: inline-block;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    -khtml-border-radius: 50%;
}
.addfenlei{
    z-index: 998;
}
</style>
<style>
.disabled {pointer-events:none;background: #666;color: #cec9c9;}
.page{margin-top:10px;width:800px;}
.page a,.page span {display:inline-block;padding:5px 10px;margin:0 1px;border:1px solid #f0f0f0;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;width: 40px;text-align: center;}
.page a,.page li {display:inline-block;list-style: none;text-decoration:none;color:#CEAF64;}
.page a.first,.page a.prev,.page a.next,.page a.end{width:70px;margin:0;}
.page a:hover{border-color:#CEAF64;}
.page span.current{background:#f5f5f5;color:#CEAF64;font-weight:700;border-color:#e8e8e8;width: 30px;text-align: center;}
/*********弹出框**********/
.wap_tanc{width:100%;height:100%;position:fixed; top:0; left:0;z-index:1000000;display:none;}
.wap_tanc_bg{width:100%;height:100%;position:absolute; top:0; left:0;z-index:-1;background:#000;opacity:0.4;filter:alpha(opacity=40);-moz-opacity:0.4;-khtml-opacity:0.4;-webkit-opacity:0.4;}
.wap_tanc_con{width:300px;min-height:110px;background:#fff;border-radius:5px;position:absolute; left:50%; top:50%;margin-top:-55px;margin-left:-150px;display:none;}
.wap_tanc_con h5{margin:0;min-height:60px;line-height:60px;text-align:center;font-size:15px;font-weight:600 !important;letter-spacing:1px;border-bottom:1px solid #f1f1f1;padding: 0 10px;}
.wap_tanc_btn a{text-decoration:none;display:inline-block;width:49%;float:left;line-height:50px;text-align:center;letter-spacing:1px;font-size:14px;color:#666;}
.wap_tanc_con1{width:500px;height:250px;margin-top:-125px;margin-left:-250px;padding:50px;}
.wap_tanc_con1 h5{border-bottom:none;text-align:left;line-height:40px;font-weight:normal !important;}
.wap_tanc_con1 h5 img{display:inline-block;vertical-align:top;margin-right:10px;}
.wap_tanc_con1 h5 p{display:inline-block;vertical-align:top;font-size:30px;}
.wap_tanc_con1 h5 p span{color:#ea5404;margin:0 3px;}
.wap_tanc_con1 a{font-size:14px;display:inline-block;padding-left:95px;margin-top:20px;color:#ea5404;letter-spacing:1px;}
.wap_tanc_con1>p{font-size:24px;color:#999;position:absolute; top:10px; right:20px;cursor:pointer;}
/*********弹出框**********/
</style>
<script>
window.alert = function (msg){
    dialog.showTips(msg,"warn");
}
var dialog = {
    showTips:function(msg,type,url,target){    //type为firm时，url传回调参数
        var msg = msg ? msg : "提示内容",target = target ? target : '_self',htmlCon="";
        htmlCon+='<div class="wap_tanc" style="display: block;">'+
                    '<div class="wap_tanc_bg"></div>'+
                    '<div class="wap_tanc_con" style="display: block;">'+
                        '<h5>'+msg+'</h5>'+
                        '<div class="wap_tanc_btn clearfix">';
        if(type=='warn'){       //警告
            htmlCon+='<a href="javascript:void(0);" style="width:100%;color: #000 !important;" class="ble" >确定</a>';
        }else if(type=="firm"){     //函数调用
            htmlCon+='<a href="javascript:void(0);" class="ble" style="border-right:1px solid #f1f1f1;">取消</a>'+
                '<a href="javascript:void(0);" class="closedown" >确定</a>';
        }else{
            if(url!=""){
                if(url=="1"){       //刷新
                    htmlCon+='<a href="javascript:void(0);" style="width:100%;" class="reload">确定</a>';
                }else if(url=="2"){     //返回上一页
                    htmlCon+='<a href="javascript:void(0);" onclick="javascript:history.back(-1);" style="width:100%;">确定</a>';
                }else{      //url跳转
                    htmlCon+='<a href="'+url+'" style="width:100%;" target="'+target+'">确定</a>';
                }
            }else{
                htmlCon+='<a href="javascript:void(0)" style="border-right:1px solid #f1f1f1;" class="ble">取消</a>'+
                    '<a href="javascript:void(0);" class="ble">确定</a>';
            }
        }
        htmlCon+=       '</div>'+
                    '</div>'+
                 '</div>';
        $('body').append(htmlCon);      //追加内容
        $('.ble').click(function () {       //关闭弹窗
            $('.wap_tanc').stop(true).fadeOut(300);
            $('.wap_tanc_con').stop(true).fadeOut(300);
        })
        $('.closedown').click(function(){  //关闭弹窗(带action)
            $('.ble').trigger("click");
            if(typeof url == "function" && type=='firm'){
                url();
            }
        });
        $(".reload").click(function(){      //刷新
            window.location.reload();
        });
        return false;
    }
}
</script>
</head>
<body class="cp-bodybox">
<div class="header">
  <div class="inner clearfix">
    <div class="fl"> <a href="<?php echo U('Admin/Index/web_config');?>" class="header-logo"> <img src="/Public/Public/images/logo.png" height="45"> </a> </div>
    <div class="header-nav fl">
      <ul class="header-nav-list clearfix">
        <!--li class="fl <?php if(($head_munetype) == $v[sorts]): ?>active<?php endif; ?>"><a href="<?php echo U('/Admin/'.$v[controller].'/'.$v[action]);?>"><?php echo ($v['classname']); ?></a></li-->
        <?php if(is_array($node_head_list)): foreach($node_head_list as $key=>$v): ?><li class="fl <?php if(($head_munetype) == $v[controller]): ?>active<?php endif; ?>"><a href="<?php echo U('/Admin/'.$v[controller].'/'.$v[action]);?>"><?php echo ($v['classname']); ?></a></li><?php endforeach; endif; ?>
      </ul>
    </div>
    <div class="fr">
      <ul class="header-ctrl clearfix">
        <li class="header-ctrl-item fl"> <a href="javascript:;" class="header-ctrl-item-parent"> <i class="gicon-user white"></i> <i class="gicon-user"></i> 账户 </a>
          <ul class="header-ctrl-item-children">
            <li><a href="<?php echo U('/Admin/Index/updatepwd');?>">修改密码</a></li>
            <li><a href="<?php echo U('/Admin/User/logout/sid/1');?>">退出</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- end list --> 
    <span class="account_inbox_switch fr">
        <a href="javascript:void(0)" class="header_mail"></a>
    </span>
    <span class="header-welcome fr"> 
        <a href="javasecript:void(0);" class="tips" data-trigger="hover" data-placement="top" data-content="&lt;strong&gt;版本：&lt;/strong&gt;&lt;font style=&quot;color:red&quot;&gt;免费版&lt;/font&gt;"> <?php echo (session('admin')); ?>，欢迎回来</a>
   </span> 
    <!-- end header-welcome --> 
  </div>
</div>
<!-- end header -->

<style>
.imgnav {
    max-height: 30px;
    overflow: hidden;
    cursor: pointer;
}
.imgwrapper {
    display: block;
    width: 78px;
    height: 78px;
    overflow: hidden;
}
.imgwrapper img {
    display: block;
    width: 100%;
    padding: 0;
    margin: 0;
    border: 0;
}
.spanpd10 {
    margin: 10px;
}
.wxtables.wxtables-sku.newtable {
    width: 40%;
    margin: 0;
}
.img-list li {
    width: 60px;
    height: 60px;
}
.cst_h3 span {
    font-weight: normal;
}
#imgdiv img {
    max-width: 190px;
    max-height: 190px;
    display: none;
    margin: 5px;
}
.btnimage {
    width: 80px;
    height: 30px;
    background: white;
    border: 1px solid #d9d9d9;
    cursor: pointer;
    position: relative;
    text-align: center;
    line-height: 31px;
}
.file {
    position: absolute;
    top: 0px;
    left: 0;
    width: 80px;
    height: 30px;
    background: white;
    border: 1px solid #d9d9d9;
    cursor: pointer;
    opacity: 0
}
#imgdiv2 img {
    max-width: 88px;
    max-height: 88px;
    display: none;
    margin: 5px;
}
#xuanze2 {
    width: 60px;
    height: 30px;
    background: white;
    border: 1px solid #d9d9d9;
}
#xuanze2:hover {
    background: #E6E6E6;
}
.huase {
    display: none;
    width: 86px;
    height: 30px;
    margin: 5px;
    text-indent: 5px;
}
</style>
<div class="container">
  <div class="inner clearfix"> <div class="content-left fl">
  <dl class="left-menu shop_3 sub_tags">
    <?php if(is_array($node_left_list)): foreach($node_left_list as $key=>$v): ?><dt> <i class="icon-menu tags"></i> <span id="shop_3" data-id="3"><?php echo ($v['classname']); ?></span> </dt>
      <?php if(is_array($v['nodes'])): foreach($v['nodes'] as $key=>$vv): ?><dd class="subshop_0 <?php if(($left_urlname) == $vv[controller_action]): ?>active<?php endif; ?> "> <a href="<?php echo U('/Admin/'.$vv[controller].'/'.$vv[action]);?>"><?php echo ($vv['classname']); ?></a> </dd><?php endforeach; endif; endforeach; endif; ?>
  </dl>
</div>
 
    <!-- end content-left -->
    
    <div class="content-right fl">
      <h1 class="content-right-title">发布产品</h1>
        <form aciton="<?php echo U('/Admin/Groupmall/goodsAddEdit');?>" enctype="multipart/form-data" method="post" id="add_step2" onsubmit="return toVaild()">
        <input type="hidden" value="<?php echo ($malltype); ?>" name="malltype">
        <input type="hidden" value="<?php echo ($storeid); ?>" name="storeid">
        <input type="hidden" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):0); ?>" name="id">
        <!-- end 基本信息 -->
        <div class="panel-single panel-single-light mgt20">
        <h3 class="cst_h3 mgb20">商品信息</h3>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed">*</span>产品分类：</label>
          <div class="form-controls">
            <a href="javascript:void(0)" class="btn btn-primary" id="j-selectcateid"> <i class="gicon-edit white"></i> 选择产品分类 </a>
            <input type="text" value="<?php echo ($info["catetitle"]); ?>" id="catetitle" class="input" style="border: 1px solid #fff;background-color:#fff;" readonly>
            <input type="hidden" value="<?php echo ($info["cateid"]); ?>" name="cateid">
            <span class="fi-help-text error"></span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed">*</span>产品名称：</label>
          <div class="form-controls">
            <input type="text" class="input xxlarge" name="title" value="<?php echo ($info["title"]); ?>" placeholder="产品名字">
            <span class="fi-help-text"></span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed">*</span>产品简介：</label>
          <div class="form-controls">
            <input type="text" class="input xxlarge" name="description" value="<?php echo ($info["description"]); ?>" placeholder="简短介绍 20字内">
            <span class="fi-help-text"></span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed">*</span>商品logo图片：</label>
          <div class="form-controls pdt5 j-imglistPanel">
            <div class="xuanze_showimge fl mgr10"><?php if(!empty($info["logo"])): ?><img src="<?php echo ($info["logo"]); ?>" height="80"><?php endif; ?></div>
            <div class="btnimage fl">选择图片
              <input type="file"  accept="image/jpg,image/jpeg,image/png" name="serial" id="xuanze" class="file" >
            </div>
            <div class="xuanze_progress fl mgr15" style="display:none"><img src="/Public/Admin/Images/loadings.gif" width="30" /><span class="xuanze_percent">80%</span></div>
            <span style="color:red;" class="fi-help-text fl lh30 mgl10">建议大小（宽610px高610px）</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>是否精选：</label>
          <div class="form-controls">
            <div class="radio-group">
            <?php if(($info["ischoice"]) > "0"): ?><label><input type="radio" name="ischoice" value="1" checked>是</label>
                <label><input type="radio" name="ischoice" value="0">否</label>
            <?php else: ?>
                <label><input type="radio" name="ischoice" value="1">是</label>
                <label><input type="radio" name="ischoice" value="0" checked>否</label><?php endif; ?>
            </div>
          </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>是否热卖：</label>
          <div class="form-controls">
            <div class="radio-group">
            <?php if(($info["ishot"]) > "0"): ?><label><input type="radio" name="ishot" value="1" checked>是</label>
                <label><input type="radio" name="ishot" value="0">否</label>
            <?php else: ?>
                <label><input type="radio" name="ishot" value="1">是</label>
                <label><input type="radio" name="ishot" value="0" checked>否</label><?php endif; ?>
            </div>
          </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>是否新品：</label>
          <div class="form-controls">
            <div class="radio-group">
            <?php if(($info["isnew"]) > "0"): ?><label><input type="radio" name="isnew" value="1" checked>是</label>
                <label><input type="radio" name="isnew" value="0">否</label>
            <?php else: ?>
                <label><input type="radio" name="isnew" value="1">是</label>
                <label><input type="radio" name="isnew" value="0" checked>否</label><?php endif; ?>
            </div>
          </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>是否上架：</label>
          <div class="form-controls">
            <div class="radio-group">
            <?php if(($info["issale"]) > "0"): ?><label><input type="radio" name="issale" value="1" checked>是</label>
                <label><input type="radio" name="issale" value="0" >否</label>
            <?php else: ?>
                <label><input type="radio" name="issale" value="1" checked>是</label>
                <label><input type="radio" name="issale" value="0" >否</label><?php endif; ?>
            </div>
          </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>库存：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="stock" value="<?php echo ((isset($info["stock"]) && ($info["stock"] !== ""))?($info["stock"]):0); ?>">
            <span class="fi-help-text">注：输入整数字</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>虚拟销量：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="virtualsales" value="<?php echo ((isset($info["virtualsales"]) && ($info["virtualsales"] !== ""))?($info["virtualsales"]):0); ?>">
            <span class="fi-help-text">注:输入整数字</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>参团人数：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="grouperson" value="<?php echo ((isset($info["grouperson"]) && ($info["grouperson"] !== ""))?($info["grouperson"]):1); ?>">
            <span class="fi-help-text">注:输入整数字</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>团结束时间：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="grouphour" value="<?php echo ((isset($info["grouphour"]) && ($info["grouphour"] !== ""))?($info["grouphour"]):0); ?>">
            <span class="fi-help-text">注:几小时后关闭团,0不限时间,输入整数字</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>价格：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="price" value="<?php echo ((isset($info["price"]) && ($info["price"] !== ""))?($info["price"]):0.00); ?>">
            <span class="fi-help-text">注:输入数字(两位小数)</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>会员价：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="vprice" value="<?php echo ((isset($info["vprice"]) && ($info["vprice"] !== ""))?($info["vprice"]):0.00); ?>">
            <span class="fi-help-text">注:输入数字(两位小数)</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>原价：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="oprice" value="<?php echo ((isset($info["oprice"]) && ($info["oprice"] !== ""))?($info["oprice"]):0.00); ?>">
            <span class="fi-help-text">注:输入数字(两位小数)</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>积分价：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="integralprice" value="<?php echo ((isset($info["integralprice"]) && ($info["integralprice"] !== ""))?($info["integralprice"]):0.00); ?>">
            <span class="fi-help-text">注:输入整数字</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>赠送积分：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="giftpoints" value="<?php echo ((isset($info["giftpoints"]) && ($info["giftpoints"] !== ""))?($info["giftpoints"]):0); ?>">
            <span class="fi-help-text">注:输入整数字</span> </div>
        </div>
        <div class="formitems">
          <label class="fi-name"><span class="colorRed"></span>邮费：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="postage" value="<?php echo ((isset($info["postage"]) && ($info["postage"] !== ""))?($info["postage"]):0); ?>">
            <span class="fi-help-text">注:输入整数字</span> </div>
        </div>
        <div class="formitems"> 
          <label class="fi-name"><span class="colorRed"></span>排序：</label>
          <div class="form-controls">
            <input type="text" class="input mini" name="sorts" value="<?php echo ((isset($info["sorts"]) && ($info["sorts"] !== ""))?($info["sorts"]):0); ?>">
          </div>
        </div>
        <div class="formitems">
          <label class="fi-name">商品参数图片(多选)：</label>
          <div class="form-controls pdt5 j-imglistPanel">
            <div class="btnimage fl">选择图片
              <input type="file"  accept="image/jpg,image/jpeg,image/png" name="serial" id="duoxuan" class="file" >
            </div>
            <div class="duoxuan_progress fl mgr15" style="display:none"><img src="/Public/Admin/Images/loadings.gif" width="30" /><span class="duoxuan_percent">80%</span></div>
            <span class="fi-help-text fl lh30 mgl10"></span>
            <div style="clear:both"></div>
            <ul class="duoxuan_showimge mgr10" id="more_pic" style="position:relative">
                <?php if(is_array($info["detailpic"])): foreach($info["detailpic"] as $k=>$vo): ?><img src="<?php echo ($vo); ?>" height="80"  class="mgr10 mgt10 " onclick="delImg(this)">
                    <input type="hidden" name="detailpic[]" id="pic1" value="<?php echo ($vo); ?>"></input><?php endforeach; endif; ?>
            </ul>
          </div>
        </div>
        <!-- end 详情及其它 -->
        <div class="panel-single panel-single-light mgt20 txtCenter">
          <a href="javascript:;" onclick="javascript:history.back(-1);" class="btn btn-success">返回</a>
          <input type="submit" class="btn btn-primary" value="保存">
        </div>
      </form>
    </div>
    <!-- end content-right --> 
  </div>
</div>
<!-- end container --> 


<!--gonggao-->
<div class="footer"><?php echo ($shop_seo_config["copyright"]); ?> , Inc. All rights reserved.</div>
<!-- end footer -->
<div class="fixedBar" style="left: 1321px; height: 285px; top: 76px; margin-top: 0px;">
    <!--<ul>
        <li class="shopManager0 cur"><a href="javascript:;" data-target="#shop_0">店铺管理</a></li><li class="shopManager1"><a href="javascript:;" data-target="#shop_1">自定义专题</a></li><li class="shopManager2"><a href="javascript:;" data-target="#shop_2">商品管理</a></li><li class="shopManager3"><a href="javascript:;" data-target="#shop_3">分组管理</a></li><li class="shopManager4"><a href="javascript:;" data-target="#shop_4">批量导入</a></li><li class="shopManager5"><a href="javascript:;" data-target="#shop_5">订单管理</a></li><li class="shopManager6"><a href="javascript:;" data-target="#shop_6">售后服务</a></li><li class="shopManager8"><a href="javascript:;" data-target="#shop_8">会员管理</a></li><li class="shopManager7"><a href="javascript:;" data-target="#shop_7">分销商</a></li><li class="shopManager9"><a href="javascript:;" data-target="#shop_9">分销财务</a></li>        </ul>-->
</div>
<a href="#" id="j-gotop" class="gotop" title="回到顶部" style="left: 1322.5px;"></a>
<!-- end gotop -->




<!--end front template  -->

<script src="/Public/Admin/Js/lib-min.js"></script>
<script src="/Public/Admin/Js/jquery.jbox-min.js"></script>
<script src="/Public/Admin/Js/jquery.zclip-min.js"></script>
<!-- 线上环境 -->
<script src="/Public/Admin/Js/component-min.js"></script>
<script src="/Public/Admin/Js/scroll.js"></script>
<script src="/Public/Admin/Js/echarts.min.js"></script>
<!--[if lt IE 10]>
<script src=".//Public/Admin/Js/jquery.placeholder-min.js"></script>
<script>
    $(function(){
        //修复IE下的placeholder
        $('.input,.textarea').placeholder();
    });
</script>
<![endif]-->


<script>
    $(function(){
        $(".j-copy").zclip({
            path: '/Public/plugins/zclip/ZeroClipboard.swf',
            copy: function(){
                return $(this).data('copy');
            },
            afterCopy:function(){
                HYD.hint("success","内容已成功复制到您的剪贴板中");
            }
        });
        $(".btn-notice").click(function(){
            // $.post('/System/readAllNotice',{},function(){
            //     window.location.reload();
            // })
            $.ajax({
                url: '/System/readAllNotice',
                type: 'POST',
                success:function(data){
                    if(data.status == 1){
                        window.location.reload();
                    }else{
                        HYD.hint("danger",data.msg);
                    }

                }
            })
        });


        ;(function(){
            // 首页竖线到底
            var height1=$(".content-right").height();
            var height2=$(".content-left").height();
            if(parseInt(height1) < parseInt(height2)){
                $(".content-right").css({'min-height': height2});
            };

        })();

    });
</script>
<!-- end session hint -->
<script>
    $(function () {
        setTimeout(gggoup(),5000);
        $('.gound_close').click(function(){
            $('#gonggao').animate({bottom:"-270px"},1000);
        });
    });
    function gggoup(){
        $('#gonggao').animate({bottom:"3px"},1000);
    };
</script>


</body></html>
<!--遮罩层-->
<div id="albums-overlay" style="display: none;"></div>
<!--内容层-->
<!--分类-->
<div class="jbox fenlei select-cate disshow" style="height:auto;">
  <div class="jbox-title">
    <div class="jbox-title-txt">请选择产品分类</div>
    <a href="javascript:void(0);" class="jbox-close cancle"></a></div>
  <div class="jbox-container" style="height:auto;">
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>选择分类：</label>
      <div class="form-controls">
        <select name="selectcateid" class="select">
          <?php if(is_array($catelists)): foreach($catelists as $key=>$vo): ?><option  value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></option><?php endforeach; endif; ?>
        </select>
        <span class="fi-help-text"></span> </div>
    </div>
  </div>
  <div class="jbox-buttons">
    <a href="javascript:void(0);" class="jbox-buttons-ok btn btn-primary" id="selectcateid">确定</a>
    <a href="javascript:void(0);" class="jbox-buttons-ok btn cancle">取消</a>
  </div>
</div>
<!--选择分类--> 
<script type="text/javascript">
var _this;
$(".cancle").click(function(){
    colseSelect($(this));
})
//产品分类S
$("#j-selectcateid").click(function(){
    var cateid = "<?php echo ($info["cateid"]); ?>";
    if(cateid){
        $('select[name=selectcateid]').val(cateid);
    }
    $('#albums-overlay').show();
    $('.select-cate').show();
});
$("#selectcateid").click(function(){
    var id   =$("select[name=selectcateid] option:selected").val();
    var title=$("select[name=selectcateid] option:selected" ).text();
    $('input[name=cateid]').val(id);
    $('#catetitle').val(title);
    colseSelect($(this));
});
//产品分类E
function colseSelect(_this){      //关闭弹框
    _this.parent().parent('.jbox').hide();
    $('#albums-overlay').hide();
}
</script> 
<!--选择分类-end->
<!--提交表单前验证--> 
<script type="text/javascript">
 $(".start").click(function(){
    var check = $(".start").attr("checked");
    if(check==true){
        $("input[name=integral_limit]").removeAttr("disabled");
    }else{
        $("input[name=integral_limit]").attr("disabled","true");
    }
 })

function toVaild(){
    /*var classname=$('#class_id').val();
    var goods_name=$('#goods_name').val();
    var goods_des=$('#goods_des').val();
    var goods_ser=$('#goods_ser').val();
    var model = $('#model').val();
    var goods_title=$('#goods_title').val();
    var resource=$('#resource').val();
    var price=$('#price').val();
    var num=$('#j-totalStock').val();
    var upimg=$('#up_img1').val();
    var detail=$('#editor').text();
    var nums=$('#nums').val();*/
}
</script> 
<!--提交表单前验证end--> 
<!--上传图片--> 
<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script> 
<script type="text/javascript" src="/Public/Admin/Js/jquery-form.js"></script> 
<script>
/*$("input[name=oprice]").change(function(){
    var oprice = $(this).val();//市场价
    var integral  =oprice*("<?php echo ($rate); ?>");
    integral  = Math.floor(integral*100)/100;
    $("input[name=integral]").val(integral);
    var s_integral = Math.floor(integral*("<?php echo ($tage); ?>")*100)/100;
    $("input[name=s_integral]").val(s_integral);
})*/
</script> 
<script type="text/javascript">
function delImg(obj){
    if(!confirm("删除这张图片？")){
        return false;
    }
    var id = $(obj).attr("data-id")
    if(id){
        alert(1);
        return false;
    }
    $(obj).next("input").remove();
    $(obj).remove();
}
$(function () {
    var percent = $('.xuanze_percent');
    var progress = $('.xuanze_percent');
    $("#xuanze").wrap("<form id='myupload1' action='<?php echo U('/Admin/Index/addImage');?>' method='post' enctype='multipart/form-data'></form>");
    $("#xuanze").change(function(){ //选择文件
        $("#myupload1").ajaxSubmit({
            dataType:  'json', //数据格式为json
            beforeSend: function() { //开始上传
                progress.show(); //显示进度条
                var percentVal = '0%';
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%'; //获得进度
                percent.html(percentVal); //显示上传进度百分比
            },
            success: function(data) { //成功
                var img = '<img src="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'" height="80" ><input type="hidden" name="logo" id="pic" value="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'"></input>';
                $('.xuanze_showimge').html(img);
                progress.hide();
            },
            error:function(xhr){ //上传失败
                //console.log(xhr.status)
            }
        });
    });
    var percent = $('.duoxuan_percent');
    var progress = $('.duoxuan_percent');
    $("#duoxuan").wrap("<form id='myupload' action='<?php echo U('/Admin/Index/addImage');?>' method='post' enctype='multipart/form-data'></form>");
    $("#duoxuan").change(function(){ //选择文件
        $("#myupload").ajaxSubmit({
            dataType:  'json', //数据格式为json
            beforeSend: function() { //开始上传
                progress.show(); //显示进度条
                var percentVal = '0%';
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%'; //获得进度
                percent.html(percentVal); //显示上传进度百分比
            },
            success: function(data) { //成功
                var img = '<img src="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'" height="80"  class="mgr10 mgt10 " onclick="delImg(this)"><input type="hidden" name="detailpic[]" id="pic1" value="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'"></input>';
                console.log(img);
                $('.duoxuan_showimge').append(img);
                progress.hide();
            },
            error:function(xhr){ //上传失败
                //console.log(xhr.status)
            }
        });
    });
});
function add_re(r){
    $('#restriction'+r).show();
}
function del_re(r){
    $('#restriction'+r).hide();
}
</script> 
<!--上传图片-end->