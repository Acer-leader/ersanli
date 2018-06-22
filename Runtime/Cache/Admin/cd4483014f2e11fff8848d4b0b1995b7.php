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

<!-- end header -->
<style>
.wxtables td .btn {
    padding: 0px 6px;
}

#J_wx_fans {
    vertical-align: -2px;
    margin-top: 5px;
}

.select.mini.new {
    width: 140px;
}

input.mini.Wdate {
    width: 100px;
}
</style>
<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script>
<div class="container">
    <div class="inner clearfix">
        <div class="content-left fl">
  <dl class="left-menu shop_3 sub_tags">
    <?php if(is_array($node_left_list)): foreach($node_left_list as $key=>$v): ?><dt> <i class="icon-menu tags"></i> <span id="shop_3" data-id="3"><?php echo ($v['classname']); ?></span> </dt>
      <?php if(is_array($v['nodes'])): foreach($v['nodes'] as $key=>$vv): ?><dd class="subshop_0 <?php if(($left_urlname) == $vv[controller_action]): ?>active<?php endif; ?> "> <a href="<?php echo U('/Admin/'.$vv[controller].'/'.$vv[action]);?>"><?php echo ($vv['classname']); ?></a> </dd><?php endforeach; endif; endforeach; endif; ?>
  </dl>
</div>

        <!-- end content-left -->
        <div class="content-right fl">
            <h1 class="content-right-title">用户列表</h1>
            <div class="alert alert-info disable-del">
                目前拥有 <span style="font-size:16px;"><?php echo ($count); ?></span>名用户。
                <a href="javascript:;" class="alert-delete" title="隐藏"><i class="gicon-remove"></i></a>
            </div>
            <!--<a href="/User/user_export" class="btn btn-warning">会员导出</a>-->
            <a href="/Admin/Member/memberImport" class="btn btn-success">用户导入</a>
            <div class="tablesWrap">
                    <div class="tables-searchbox">
                        <div class="fl">
                            <form action="<?php echo U('admin/member/index');?>">
                                <input type="text" class="input small" name="title" id="title" value="<?php echo ($title); ?>" placeholder="真实姓名/手机号">
                                <select class="select small" name="branchid">
                                    <option value="">--请选择部门--</option>
                                    <?php if(is_array($branchlists)): $i = 0; $__LIST__ = $branchlists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($branchid == $vo['id']): ?>selected<?php endif; ?>><?php echo ($vo["classtitle"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <select class="select small" name="gid">
                                    <option value="">--请选择职位--</option>
                                    <?php if(is_array($joblists)): $i = 0; $__LIST__ = $joblists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($gid == $vo['id']): ?>selected<?php endif; ?>><?php echo ($vo["classtitle"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <button class="btn btn-primary" id="search_m" style="vertical-align:-2px;">
                                    <i class="gicon-search white"></i>查询
                                </button>
                            </form>
                        </div>
                        <div class="fl" style="margin-left:10px;"><a href="javascript:;" class="btn btn-success fl BtnAddClass">添加用户</a></div>
                    </div>
                <!-- end tables-searchbox -->
                <table class="wxtables" style="text-align:center;">
                    <colgroup>
                        <col width="10%">
                        <col width="10%">
                        <col width="16%">
                        <col width="16%">
                        <col width="16%">
                        <col width="8%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                    <tr>
                        <td>真实姓名</td>
                        <td>手机</td>
                        <td>部门</td>
                        <td>职位</td>
                        <td>开户时间</td>
                        <td>状态</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
                        <td><?php echo ($vo["realname"]); ?></td>
                        <td><?php echo ($vo["telephone"]); ?></td>
                        <td><?php echo ($vo["branchtitle"]); ?></td>
                        <td><?php echo ($vo["jobtitle"]); ?></td>
                        <td><?php echo ($vo["add_time"]); ?></td>
                        <td class="status">
                            <?php switch($vo["status"]): case "0": ?><p>正常</p><?php break;?>
                                <?php case "1": ?><p style='color:red;'>冻结</p><?php break; endswitch;?>
                        </td>
                        <td>
                            <p>
                                <a href="<?php echo U('/Admin/Member/detail/id');?>/<?php echo ($vo["id"]); ?>" class="btn btn-success">详情|编辑</a>
                                <?php switch($vo["status"]): case "0": ?><a href="JavaScript:void(0);" class="btn btn-warning changeStatus" title="冻结" data-id="<?php echo ($vo["id"]); ?>">冻结</a><?php break;?>
                                    <?php case "1": ?><a href="JavaScript:void(0);" class="btn btn-danger changeStatus" title="解冻" data-id="<?php echo ($vo["id"]); ?>">解冻</a><?php break; endswitch;?>
                            </p>
                        </td>
                    </tr><?php endforeach; endif; ?>
                    </tbody>
                </table>
                <!-- end wxtables -->
                <div class="tables-btmctrl clearfix">
                    <div class="fl">
                        <div class="pages" style="width:100%;margin-left:0px;">
                            <?php echo ($page); ?>
                        </div>
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
<div id="albums-overlay" class="disshow"></div>
<div class="jbox addfenlei disshow" style="width:500px">
  <div class="jbox-title">
    <div class="jbox-title-txt">添加用户</div>
    <a href="javascript:;" class="jbox-close cancle"></a></div>
  <div class="jbox-container" style="height: 263px;">
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>部门：</label>
      <div class="form-controls">
        <select name="branchid">
            <option value="">——请选择——</option>
            <?php if(is_array($branchlists)): $i = 0; $__LIST__ = $branchlists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classtitle"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <span class="fi-help-text examinemsg"></span> </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>职位：</label>
      <div class="form-controls">
        <select name="gid">
            <option value="">——请选择——</option>
            <?php if(is_array($joblists)): $i = 0; $__LIST__ = $joblists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classtitle"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <span class="fi-help-text examinemsg"></span> </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>真实姓名：</label>
      <div class="form-controls">
        <label>
            <input type="text" name="realname" value="" placeholder=""><span class="red">*必填</span>
        </label>
        <span class="fi-help-text"></span>
      </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>昵称：</label>
      <div class="form-controls">
        <label>
            <input type="text" name="person_name" value="" placeholder=""><span class="red">*必填</span>
        </label>
        <span class="fi-help-text"></span>
      </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>手机号：</label>
      <div class="form-controls">
        <label>
            <input type="tel" name="telephone" value="" onKeyUp="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"><span class="red">*必填</span>
        </label>
        <span class="fi-help-text">前台登录账号</span></div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>密码：</label>
      <div class="form-controls">
        <label>
            <input type="password" name="password" placeholder=" (若不填写默认手机号)"><span>*可填</span>
        </label>
        <span class="fi-help-text">前台登录账号,默认手机号密码,6~16位</span></div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>性别：</label>
      <div class="form-controls">
        <label>
            <input type="radio" name="sex" value="1" checked><span>男</span>
            <input type="radio" name="sex" value="2"><span>女</span>
        </label>
        <span class="fi-help-text"></span> </div>
    </div>
  </div>
  <div class="jbox-buttons"><a href="javascript:void(0);" class="jbox-buttons-ok btn btn-primary" id="examine">确定</a><a
            href="javascript:void (0);" class="jbox-buttons-ok btn cancle">取消</a></div>
</div>
<!-- end container -->
<script>
$(function(){
    $(".cancle").click(function(){  //取消层
        $(this).parent().parent('.jbox').hide();
        $('#albums-overlay').hide();
    })
    $(".BtnAddClass").click(function(){   //弹出消层
        $('.addfenlei').show();
        $('#albums-overlay').show();
    })
    $("#examine").click(function (){
        var branchid =$(".addfenlei select[name=branchid]").val();
        var gid      =$(".addfenlei select[name=gid]").val();
        var realname =$.trim($(".addfenlei input[name=realname]").val());
        var person_name =$.trim($(".addfenlei input[name=person_name]").val());
        var telephone=$.trim($(".addfenlei input[name=telephone]").val())
        var password =$.trim($(".addfenlei input[name=password]").val());
        var sex      =$(".addfenlei input[name=sex]:checked").val();
        if(!branchid)
        {
            dialog.showTips('请选择部门','warn');return false;
        }
        if(!gid)
        {
            dialog.showTips('请选择职位','warn');return false;
        }
        if(realname.length<1)
        {
            dialog.showTips('真实姓名必填','warn');return false;
        }else if(realname.length>30){
            dialog.showTips('真实姓名必须30字内','warn');return false;
        }
        if(person_name.length<1)
        {
            dialog.showTips('昵称必填','warn');return false;
        }else if(person_name.length>30){
            dialog.showTips('昵称必填必须30字内','warn');return false;
        }
        if(telephone.length<1)
        {
            dialog.showTips('手机号必填','warn');return false;
        }else if(!(/^1[34578]\d{9}$/.test(telephone))){
            dialog.showTips('手机号格式错误','warn');return false;
        }
        if(password.length<1){
            password = telephone;
        }
        if(!password.match(/^[a-zA-Z0-9]{6,16}$/)){
            dialog.showTips('密码格式错误','warn');return false;
        }
        if(!sex){
            dialog.showTips('请选择性别','warn');return false;
        }
        var data = {branchid:branchid,gid:gid,realname:realname,person_name:person_name,telephone:telephone,password:password,sex:sex}
        //console.log(data);  //return false;
        $.post("<?php echo U('Admin/Member/addMember');?>",data,function(g){
            if(g.status==1)
            {
                window.location.reload()
            }else{
                dialog.showTips(g.info,'warn');return false;
            }
        },"json");
    })
    $(".changeStatus").click(function(){        //是否冻结
        var id = $(this).attr("data-id");
        var _this = $(this);
        $.post("<?php echo U('admin/member/changeStatus');?>",{id:id},function(data){
            if(data.status == 1){
                var p = _this.parent().parent().parent().find(".status p");
                p.html(data.info);
                if(_this.hasClass("btn-warning")){
                    _this.removeClass("btn-warning").addClass("btn-danger").html("解冻")
                    p.css("color","red")
                }else{
                    _this.removeClass("btn-danger").addClass("btn-warning").html("冻结")
                    p.css("color","black")
                }
            }else{
                alert("修改失败");
            }
        },"json")
    })
})
</script>

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