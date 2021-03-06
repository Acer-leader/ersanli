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

<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script>
<style>
.imgnav{
    max-height: 30px;
    overflow: hidden;
    cursor: pointer;
}
.imgwrapper{
    display: block;
    width: 78px;
    height: 78px;
    overflow: hidden;
}
.imgwrapper img{
    display: block;
    width: 100%;
    padding: 0;
    margin: 0;
    border:0;
}
.spanpd10{
    margin:10px;
}
.wxtables.wxtables-sku.newtable{
    width: 40%;
    margin: 0;
}
.img-list li{
    width: 60px;
    height:60px;
}
.cst_h3 span{font-weight: normal;}
#imgdiv img{ max-width:190px; max-height:190px; display:none; margin:5px;}
.btnimage{width:80px; height:30px; background:white; border:1px solid #d9d9d9;cursor:pointer; position:relative; text-align:center; line-height:31px;}
.file{ position:absolute; top:0px; left:0; width:80px; height:30px; background:white; border:1px solid #d9d9d9;cursor:pointer; opacity:0}
#imgdiv2 img{ max-width:88px; max-height:88px; display:none; margin:5px;}
#xuanze2{ width:60px; height:30px; background:white; border:1px solid #d9d9d9; }
#xuanze2:hover{ background:#E6E6E6; }
.huase{display:none; width:86px; height:30px; margin:5px; text-indent:5px;}
.formitems .fi-name{width:300px !important;}
</style>
<div class="container">
    <div class="inner clearfix">
        <div class="content-left fl">
  <dl class="left-menu shop_3 sub_tags">
    <?php if(is_array($node_left_list)): foreach($node_left_list as $key=>$v): ?><dt> <i class="icon-menu tags"></i> <span id="shop_3" data-id="3"><?php echo ($v['classname']); ?></span> </dt>
      <?php if(is_array($v['nodes'])): foreach($v['nodes'] as $key=>$vv): ?><dd class="subshop_0 <?php if(($left_urlname) == $vv[controller_action]): ?>active<?php endif; ?> "> <a href="<?php echo U('/Admin/'.$vv[controller].'/'.$vv[action]);?>"><?php echo ($vv['classname']); ?></a> </dd><?php endforeach; endif; endforeach; endif; ?>
  </dl>
</div>

        <div class="content-right fl">
            <h1 class="content-right-title">配置详情</h1>
            <form action="" enctype="multipart/form-data" method="post" id="web_config_form" >
                <div class="panel-single panel-single-light mgt20">
                    <h3 class="cst_h3 mgb20">基本信息</h3>
                    <div class="formitems">
                        <label class="fi-name">网站LOGO：</label>
                        <div class="form-controls pdt5 j-imglistPanel">
                            <div class="pic1_showimage fl mgr10">
                                <img src="<?php echo ($cache['logo']); ?>" width="60px">
                            </div>
                            <div class="btnimage fl">选择图片
                                <input type="file"  accept="image/jpg,image/jpeg,image/png" name="logo" id="pic1" class="file" >
                            </div>
                            <div class="pic1_progress fl mgr15" style="display:none">
                                <img src="/Public/Admin/Images/loadings.gif" width="30" />
                                <span class="pic1_percent">80%</span>
                            </div>
                            <span class="fi-help-text fl lh30 mgl10">建议大小（宽120高30）</span>
                        </div>
                    </div>
                    <div class="formitems">
                        <label class="fi-name"><span class="colorRed">*</span>客服电话：</label>
                        <div class="form-controls">
                            <input type="text" class="input large" value="<?php echo ($cache["servise_phone"]); ?>"  name="servise_phone" placeholder="">
                            <!-- <span style="color: #aaafff">请按格式填写</span> -->
                        </div>
                    </div>
                    <div class="formitems">
                        <label class="fi-name"><span class="colorRed">*</span>网站标题：</label>
                        <div class="form-controls">
                            <input type="text" class="input xxlarge title" name="seo_title" value="<?php echo ($cache["seo_title"]); ?>"/>
                        </div>
                    </div>
                    <div class="formitems">
                        <label class="fi-name"><span class="colorRed">*</span>SEO关键字：</label>
                        <div class="form-controls">
                            <input type="text" class="input xxlarge keywords" name="seo_keywords" value="<?php echo ($cache["seo_keywords"]); ?>"/>
                        </div>
                    </div>
                    <div class="formitems">
                        <label class="fi-name"><span class="colorRed">*</span>SEO描述：</label>
                        <div class="form-controls">
                            <input type="text" class="input xxlarge description" name="seo_description" value="<?php echo ($cache["seo_description"]); ?>"/>
                        </div>
                    </div>
                    <div class="formitems">
                        <label class="fi-name"><span class="colorRed">*</span>版权设置：</label>
                        <div class="form-controls">
                            <textarea style="height:100px;width:400px;" class="input copyright" name="copyright" ><?php echo ($cache["copyright"]); ?></textarea>
                        </div>
                    </div>
                    <div class="formitems">
                        <label class="fi-name"><span class="colorRed">*</span>上次更新时间：</label>
                        <div class="form-controls"><?php echo (date("Y-m-d H:i:s",$cache["update_time"])); ?></div>
                    </div>
                    <div class="panel-single panel-single-light mgt20 txtCenter">
                        <button class="btn btn-primary" id="btn-submit">保存</button>
                    </div>
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
<script type="text/javascript" src="/Public/Admin/Js/jquery-form.js"></script>
<!--上传图片 1-->
<script type="text/javascript">
    //上传图片
    $(function () {
        var percent = $('.pic1_percent');
        var progress = $('.pic1_progress');
        $("#pic1").wrap("<form id='pic11' action='<?php echo U('/Admin/Index/addImage');?>' method='post' enctype='multipart/form-data'></form>");
        $("#pic1").change(function(){ //选择文件
            $("#pic11").ajaxSubmit({
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
                    var img = '<img src="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'"  width="100px" class="mgr10 mgt10 " onclick="delImg(this)"><input type="hidden" name="logo" id="pic1" value="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'">';
                     progress.hide();
                    $('.pic1_showimage').html(img);     //编辑时
                },
                error:function(xhr){ //上传失败
                    //console.log(xhr.status)
                }
            });
        });
    });


    $(function () {
        var percent = $('.pic2_percent');
        var progress = $('.pic2_progress');
        $("#pic2").wrap("<form id='pic22' action='<?php echo U('/Admin/Index/addImage');?>' method='post' enctype='multipart/form-data'></form>");
        $("#pic2").change(function(){ //选择文件
            $("#pic22").ajaxSubmit({
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
                    var img = '<img src="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'" height="80"  class="mgr10 mgt10 " onclick="delImg(this)"><input type="hidden" name="index_banner_pic" id="pic2" value="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'"></input>';

                    //$('.pic2_showimage').append(img);   //添加时
                    $('.pic2_showimage').html(img);     //编辑时
                    progress.hide();
                },
                error:function(xhr){ //上传失败
                    //console.log(xhr.status)
                }
            });
        });
    });

</script>
<!--上传图片 2-->

<!--编辑保存 1-->
<script>
$("#btn-submit").click(function(){
	var data = $("#web_config_form").serialize();
	//console.log(data);//return false;
	$.post("<?php echo U('/Admin/Index/web_config');?>", data, function(res){
		if(res['status']){
			dialog.showTips(res.info, "firm", function (){
				window.location.reload();
			});
		}else{
			dialog.showTips(data.info, "warn");
		}
	})
	return false;
})
</script>
<!--编辑保存 2-->