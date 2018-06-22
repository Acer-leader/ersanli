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

<div class="container">
  <div class="inner clearfix"> <div class="content-left fl">
  <dl class="left-menu shop_3 sub_tags">
    <?php if(is_array($node_left_list)): foreach($node_left_list as $key=>$v): ?><dt> <i class="icon-menu tags"></i> <span id="shop_3" data-id="3"><?php echo ($v['classname']); ?></span> </dt>
      <?php if(is_array($v['nodes'])): foreach($v['nodes'] as $key=>$vv): ?><dd class="subshop_0 <?php if(($left_urlname) == $vv[controller_action]): ?>active<?php endif; ?> "> <a href="<?php echo U('/Admin/'.$vv[controller].'/'.$vv[action]);?>"><?php echo ($vv['classname']); ?></a> </dd><?php endforeach; endif; endforeach; endif; ?>
  </dl>
</div>

    <div class="content-right fl">
      <h1 class="content-right-title">现金卷列表</h1>
      <div class="alert alert-info disable-del"> 目前拥有 <span style="font-size:16px;"><?php echo (count($lists)); ?></span>个现金卷。 <a href="javascript:;" class="alert-delete" title="隐藏"><i class="gicon-remove"></i></a> </div>
      <div class="tablesWrap">
        <div class="tables-searchbox">
          <div class="fl">
          <a href="javascript:;" class="btn btn-success fl BtnAddClass">添加现金卷</a>
          </div>
        </div>
        <!-- end tables-searchbox -->
        <table class="wxtables" style="text-align:center;">
          <colgroup>
          <col width="6%">
          <col width="12%">
          <col width="10%">
          <col width="8%">
          <col width="6%">
          <col width="6%">
          <col width="14%">
          <col width="14%">
          <col width="20%">
          </colgroup>
          <thead>
            <tr>
              <td>ID</td>
              <td>标题<br/>数量</td>
              <td>金额</br>满XX元使用</td>
              <td>已发<br/>已使用</td>
              <td>排序</td>
              <td>状态</td>
              <td>使用时间段</td>
              <td>创建时间</td>
              <td>操作</td>
            </tr>
          </thead>
          <tbody>
            <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["title"]); ?><br/><?php echo ($vo["createnum"]); ?></td>
                <td><?php echo ($vo["money"]); ?><br/><?php echo ($vo["condit"]); ?></td>
                <td><?php echo ($vo["send_num"]); ?><br/><?php echo ($vo["use_num"]); ?></td>
                <td><?php echo ($vo["sorts"]); ?></td>
                <td class="status">
                  <?php switch($vo["status"]): case "0": ?><p style='color:green;'>发放</p><?php break;?>
                    <?php case "1": ?><p style='color:red;'>禁止</p><?php break; endswitch;?>
                </td>
                <td><?php echo ($vo["use_starttime"]); ?><br/><?php echo ($vo["use_endtime"]); ?></td>
                <td><?php echo ($vo["create_at"]); ?></td>
                <td>
                    <a href="JavaScript:void(0);" class='btn J-editInfo btn-success' data-info='<?php echo ($vo["info"]); ?>'>编辑</a>
                    <a href="JavaScript:void(0);" class='btn j-delClass btn-warning' data-id="<?php echo ($vo["id"]); ?>">删除</a>
                    <?php switch($vo["status"]): case "0": ?><a href="JavaScript:void(0);" class="btn btn-warning changeStatus" data-status="<?php echo ($list["status"]); ?>" data-id="<?php echo ($vo["id"]); ?>">禁止</a><?php break;?>
                      <?php case "1": ?><a href="JavaScript:void(0);" class="btn btn-success changeStatus" data-status="<?php echo ($list["status"]); ?>" data-id="<?php echo ($vo["id"]); ?>">发放</a><?php break; endswitch;?>
                </td>
              </tr><?php endforeach; endif; ?>
          </tbody>
        </table>
        <!-- end wxtables -->
        <div class="tables-btmctrl clearfix">
          <div class="fl">
            <div class="pages" style="width:100%;margin-left:0px;"> <?php echo ($page); ?> </div>
            <!-- end paginate -->
          </div>
        </div>
        <!-- end tables-btmctrl -->
      </div>
      <!-- end tablesWrap -->
    </div>
    <!-- end content-right -->
  </div>
</div>

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
<div id="albums-overlay" class="disshow"></div>
<div class="jbox addfenlei disshow" style="height:auto;">
  <div class="jbox-title">
    <div class="jbox-title-txt">添加现金卷</div>
    <a href="javascript:;" class="jbox-close cancle"></a></div>
  <div class="jbox-container" style="height: auto;">
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>标题：</label>
      <div class="form-controls">
        <label>
          <input type="text" class="input" name="title" value="10元现金卷" placeholder="现金卷标题">
          <span class="red">*必填</span> </label>
        <span class="fi-help-text"></span> </div>
    </div>
    <!--div class="formitems" style=" height:60px;">
      <label class="fi-name"><span class="colorRed"></span>上传LOGO：</label>
      <div class="form-controls images">
        <div class="showimg"></div>
        <div class="imagesadd">+</div>
        <input type="file" accept="image/jpg,image/jpeg,image/png" class="input sort" name="serial" id="addimage" >
        <div class="progress">
          <div class="bar"></div>
        </div>
        <span class="fi-help-text" style="left:85px; position:absolute; top:40px; width:150px; height:20px;">建议大小（宽809高310）</span> </div>
    </div-->
    <div class="formitems">
        <label class="fi-name">开始使用时间：</label>
        <div class="form-controls">
            <input type="text" class="input" readonly onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-#{%d+1}',minDate:'%y-%M-#{%d}'})"
             name="use_starttime" id="use_starttime" >
           <span class="red">*必填</span>
        </div>
    </div>
    <div class="formitems">
        <label class="fi-name">结束使用时间：</label>
        <div class="form-controls">
            <input type="text" class="input" readonly onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-#{%d+1}',minDate:'%y-%M-#{%d}'})"
                   name="use_endtime" id="use_endtime" >
                   <span class="red">*必填</span>
        </div>
    </div>
    <div class="formitems">
        <label class="fi-name">金额：</label>
        <div class="form-controls">
            <input type="text" class="input" value="10" name="money" placeholder="请输入优惠金额"/>
            <span class="red">*必填</span>
        </div>
    </div>
    <div class="formitems">
        <label class="fi-name">满额：</label>
        <div class="form-controls">
            <input type="text" class="input" value="100" name="condit" placeholder="  满多少可以用,不限,填写0"/>
        </div>
    </div>
    <div class="formitems">
        <label class="fi-name">发放数量：</label>
        <div class="form-controls">
            <input type="text" class="input" value="1" name="createnum" />
            <span class="red">*必填</span>
        </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>排序：</label>
      <div class="form-controls">
        <label>
          <input type="text" name="sorts" value="0" class="input" onKeyUp="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
          <span class="red">*必填</span> </label>
        <span class="fi-help-text"></span></div>
    </div>
  </div>
  <div class="jbox-buttons">
  <a href="javascript:void(0);" class="jbox-buttons-ok btn btn-primary" id="examine">确定</a>
  <a href="javascript:void(0);" class="jbox-buttons-ok btn cancle">取消</a></div>
</div>
<script type="text/javascript" src="/Public/Admin/Js/jquery-form.js"></script>
<script type="text/javascript">
$(".cancle").click(function(){
    $(this).parent().parent('.jbox').hide();
    $('#albums-overlay').hide();
    window.location.reload();
})
$(function () {
    var progress = $(".img");
    var bar = $('.bar') ;
    var percent = $('.percent');
    var progress = $('.progress');
    $("#addimage").wrap("<form id='myupload' action='<?php echo U('/Admin/Index/addImage');?>' method='post' enctype='multipart/form-data'></form>");
    $("#addimage").change(function(){ //选择文件
        $("#myupload").ajaxSubmit({
            dataType:  'json', //数据格式为json
            beforeSend: function() { //开始上传
                progress.show(); //显示进度条
                var percentVal = '0%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%'; //获得进度
                bar.width(percentVal); //上传进度条宽度变宽
                percent.html(percentVal); //显示上传进度百分比
            },
            success: function(data) { //成功
                var img = '<img src="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'" width="80" height="56" style="margin-top:-28px;"><input type="hidden" name="pic" id="addpic" value="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'"></input>';
                $('.showimg').html(img);
                $("#addimage").val('');
                progress.hide();
            },
            error:function(xhr){ //上传失败
                console.log(xhr.status)
            }
        });
    });
});
</script>
<!--添加分类-->
<script type="text/javascript">
var id=0;
$(".BtnAddClass").click(function(){
    $('.addfenlei').show();
    $('#albums-overlay').show();
})
<!--添加部分-->
<!--修改部分-->
$(".J-editInfo").click(function(){
    var info = JSON.parse($.trim($(this).attr("data-info")));
    if(info.id < 1){
        dialog.showTips('错误的编辑','warn');return false;
    }
    id = info.id;
    $(".jbox-title-txt").html('修改现金卷');
    $(".addfenlei input[name=title]").val(info.title);
    $(".addfenlei input[name=money]").val(info.money);
    $(".addfenlei input[name=condit]").val(info.condit);
    $(".addfenlei input[name=createnum]").val(info.createnum);
    $(".addfenlei input[name=use_starttime]").val(info.use_starttime);
    $(".addfenlei input[name=use_endtime]").val(info.use_endtime);
    $(".addfenlei input[name=sorts]").val(info.sorts)
    $('.addfenlei').show();
    $('#albums-overlay').show();
})
<!--修改部分-->
$("#examine").click(function(){
    //var pic           = $.trim($("#addpic").val());
    var title           = $.trim($(".addfenlei input[name=title]").val());
    var money           = parseInt($.trim($(".addfenlei input[name=money]").val()));
    var condit          = parseInt($.trim($(".addfenlei input[name=condit]").val()));
    var createnum       = parseInt($.trim($(".addfenlei input[name=createnum]").val()));
    var use_starttime   = $.trim($(".addfenlei input[name=use_starttime]").val());
    var use_endtime     = $.trim($(".addfenlei input[name=use_endtime]").val());
    var sorts           = parseInt($(".addfenlei input[name=sorts]").val());
    
    if(title.length<1){
        dialog.showTips('请填写现金卷标题','warn');return false;
    }else if(title.length>30){
        dialog.showTips('请填写30字以内的标题','warn');return false;
    }
    if(money < 0){
        dialog.showTips('请填写大于0的金额','warn');return false;
    }
    if(createnum < 0){
        dialog.showTips('请填写大于0的数量','warn');return false;
    }
    if(!(use_starttime && use_endtime)){
        dialog.showTips('请选择使用时间段','warn');return false;
    }
    var storeid  = "<?php echo ($storeid); ?>";
    var data = {action:'addEdit',storeid:storeid,id:id,title:title,sorts:sorts,money:money,condit:condit,createnum:createnum,use_starttime:use_starttime,use_endtime:use_endtime};
    $.post("<?php echo U('Admin/Coupon/couponAddEditDelStatus');?>",data,function(g){
        if(g.status==1){
            dialog.showTips(g.info,'',1);return false;
        }else{
            dialog.showTips(g.info,'warn');return false;
        }
    },"json");
})
</script>
<!--添加分类end-->
<!--修改状态-->
<script>
$(".changeStatus").click(function()
{   //是否显示隐藏
    var id = $(this).attr("data-id");
    if(!id){
        dialog.showTips('错误的请求','warn');return false;
    }
    var _this = $(this);
    $.post("<?php echo U('Admin/Coupon/couponAddEditDelStatus');?>",{action:'changeStatus',id:id},function(data){
        if(data.status == 1){
            var p = _this.parents('tr').find(".status p");
            p.html(data.text);
            _this.attr('data-status',data.status);
            if(_this.hasClass("btn-success")){
                _this.removeClass("btn-success").addClass("btn-warning").html("禁止");
                p.css("color","green")
            }else{
                _this.removeClass("btn-warning").addClass("btn-success").html("发放");
                p.css("color","red");
            }
            //window.location.reload();   //刷新当前页面.
        }else{
            alert("修改失败");
        }
    },"json")
})
<!--修改状态-->
</script>
<!--删除分类 1-->
<script>
$(".j-delClass").click(function(){   //是否开始结束
    var id = $(this).attr("data-id");
    if(id > 0){
        if(confirm('确定要删除吗？')){
            $.ajax({
                url: "<?php echo U('Admin/Coupon/couponAddEditDelStatus');?>",
                type: "post",
                dataType: "json",
                data: {
                    action:'Del',
                    id: id,
                }
            }).done(function (res) {
                if (res.status == 1) {
                    dialog.showTips(res.info,"",1); return false;
                } else {
                    dialog.showTips(res.info,"warn"); return false;
                }
            })
        }
    }else{
        dialog.showTips('错误的请求','warn');return false;
    }
});
</script>
<!--删除分类 2-->