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

<link rel="stylesheet" href="/Public/Admin/Css/city-picker.css">
<style>
.btn-success {
    margin-top: 12px;
}
.city-picker-span {
    width: 200px !important;
}
.city-select-content {
    width: auto !important;
}
</style>
<div class="container">
<div class="inner clearfix"> <div class="content-left fl">
  <dl class="left-menu shop_3 sub_tags">
    <?php if(is_array($node_left_list)): foreach($node_left_list as $key=>$v): ?><dt> <i class="icon-menu tags"></i> <span id="shop_3" data-id="3"><?php echo ($v['classname']); ?></span> </dt>
      <?php if(is_array($v['nodes'])): foreach($v['nodes'] as $key=>$vv): ?><dd class="subshop_0 <?php if(($left_urlname) == $vv[controller_action]): ?>active<?php endif; ?> "> <a href="<?php echo U('/Admin/'.$vv[controller].'/'.$vv[action]);?>"><?php echo ($vv['classname']); ?></a> </dd><?php endforeach; endif; endforeach; endif; ?>
  </dl>
</div>

  <div class="content-right fl">
    <h1 class="content-right-title">管理及权限-管理员</h1>
    <form action="" method="post">
      <div class="clearfix"> <a href="javascript:;" class="btn btn-success fl BtnAddClass">添加管理员</a> </div>
    </form>
    <table class="wxtables mgt15">
      <colgroup>
      <col width="5%">
      <col width="10%">
      <col width="10%">
      <col width="15%">
      <col width="15%">
      <col width="10%">
      <col width="15%">
      <col width="20%">
      </colgroup>
      <thead>
        <tr align="center">
          <td>序号</td>
          <td>登陆账号</td>
          <td>所属群组</td>
          <td>最后登录时间</td>
          <td>地区</td>
          <td>状态</td>
          <td>添加时间</td>
          <td class="center">操作</td>
        </tr>
      </thead>
      <tbody>
        <?php if(is_array($cache)): foreach($cache as $k=>$vo): ?><tr align="center">
            <td><?php echo ($k+1); ?></td>
            <td><?php echo ($vo["username"]); ?></td>
            <td><?php echo ($vo["per_name"]); ?></td>
            <td><?php if(!empty($vo['last_login'])): echo (date("Y-m-d H:i:s",$vo["last_login"])); ?>
                <?php else: ?>
                暂无登录<?php endif; ?></td>
            <td><?php echo ($vo["province"]); ?>-<?php echo ($vo["city"]); ?>-<?php echo ($vo["district"]); ?></td>
            <td style="color:red"><?php if(($vo["is_open"]) == "0"): ?><span class="red">已禁用</span><?php endif; ?>
              <?php if(($vo["is_open"]) == "1"): ?><span class="green">启用中</span><?php endif; ?></td>
            <td><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
            <td>
              <a href="javascript:;" class="btn btn-primary j-editClass" title="编辑" data-id="<?php echo ($vo["id"]); ?>" data-title="<?php echo ($vo["username"]); ?>" data-cate="<?php echo ($vo["cate"]); ?>" data-province="<?php echo ($vo["province"]); ?>" data-city="<?php echo ($vo["city"]); ?>" data-district="<?php echo ($vo["district"]); ?>">编辑</a> 
              <?php if(($vo['id']) > "1"): ?><a href="jsvascript:;" class="btn btn-warning j-delClass" title="删除" data-id="<?php echo ($vo["id"]); ?>">删除</a>
              <?php if(($vo["is_open"]) == "1"): ?><a href="javascript:;" class="btn btn-warning j-able" data-able="enable" title="禁用" data-id="<?php echo ($vo["id"]); ?>">禁用</a><?php endif; ?>
              <?php if(($vo["is_open"]) != "1"): ?><a href="javascript:;" class="btn btn-warning j-able" data-able="able" title="启用" data-id="<?php echo ($vo["id"]); ?>">启用</a><?php endif; endif; ?></td>
          </tr><?php endforeach; endif; ?>
      </tbody>
    </table>
    <!-- end wxtables -->
    <div class="tables-btmctrl clearfix">
      <div class="fl"> 
        <!--                    <a href="javascript:;" class="btn btn-primary btn_table_selectAll">全选</a>
                    <a href="javascript:;" class="btn btn-primary btn_table_Cancle">取消</a>--> 
        <!--<a href="javascript;" class="btn btn-primary btn_table_delAll">批量删除</a></div>-->
        <div class="fr"> 
          <!--<div class="paginate">-->
          
          <div class="pages"> <?php echo ($page); ?> 
            <!--</div>--> 
          </div>
          <!-- end paginate --> 
        </div>
      </div>
      <!-- end tables-btmctrl --> 
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
<div id="albums-overlay" class="disshow"></div>
<div class="jbox addfenlei disshow" style="height:auto; overflow: visible;">
  <div class="jbox-title">
    <div class="jbox-title-txt">添加账号</div>
    <a href="javascript:;" class="jbox-close cancle"></a></div>
  <div class="jbox-container" style="height: 140px;overflow: visible;">
    <div class="formitems">
      <label class="fi-name"><span class="colorRed">*</span>登陆账号：</label>
      <div class="form-controls">
        <input type="text" class="input username" name="username" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" >
        <span class="fi-help-text"></span> </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed">*</span>登陆密码：</label>
      <div class="form-controls">
        <input type="password" class="input password" name="password" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" >
        <span class="fi-help-text"></span> </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed">*</span>所属地区：</label>
      <div class="form-controls" style="position: relative;width:200px;">
        <input id="city-picker1" class="form-control city-picker-input" readonly="" type="text" value="<?php echo ($cache['province']); echo ($cache['city']); echo ($cache['district']); ?>" name="country" data-toggle="city-picker">
        <!-- <input type="text" class="input required" value="<?php echo ($cache["country"]); ?>" title="籍贯" name="country" > --> 
      </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed">*</span>管理员权限：</label>
      <div class="form-controls">
        <select class="select cate" name="cate">
          <?php if(is_array($cate_list)): foreach($cate_list as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["per_name"]); ?></option><?php endforeach; endif; ?>
        </select>
        <span class="fi-help-text"></span> </div>
    </div>
  </div>
  <div class="jbox-buttons">
  <a href="javascript:void(0);" class="jbox-buttons-ok btn btn-primary" id="addcategory">确定</a>
  <a href="javascript:void (0);" class="jbox-buttons-ok btn cancle">取消</a></div>
</div>
<div class="jbox editfenlei disshow" style="height:auto; overflow: visible;">
  <div class="jbox-title">
    <div class="jbox-title-txt">修改账号</div>
    <a href="javascript:;" class="jbox-close cancle"></a></div>
  <div class="jbox-container" style="height: 140px;overflow: visible;">
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>登陆账号：</label>
      <div class="form-controls">
        <input type="hidden" class="input sort" name="serial" id="adminid" >
        <input type="text" class="input username" name="username" id="editclassname" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" >
        <span class="fi-help-text"></span> </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed"></span>登陆密码：</label>
      <div class="form-controls">
        <input type="password" class="input password" name="password" id="editpassword" placeholder="不修改不用填写密码" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" >
        <span class="fi-help-text"></span> </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed">*</span>所属地区：</label>
      <div class="form-controls" style="position: relative;width:200px;">
        <input id="city-picker" class="form-control city-picker-input" readonly="" type="text" value="<?php echo ($cache['country'][0]); ?>/<?php echo ($cache['country'][1]); ?>/<?php echo ($cache['country'][2]); ?>" name="country" data-toggle="city-picker">
        <!-- <input type="text" class="input required" value="<?php echo ($cache["country"]); ?>" title="籍贯" name="country" > --> 
      </div>
    </div>
    <div class="formitems">
      <label class="fi-name"><span class="colorRed">*</span>管理员权限：</label>
      <div class="form-controls">
        <select class="select cate" name="cate" id="editcate">
          <?php if(is_array($cate_list)): foreach($cate_list as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["per_name"]); ?></option><?php endforeach; endif; ?>
        </select>
        <span class="fi-help-text"></span> </div>
    </div>
  </div>
  <div class="jbox-buttons">
  <a href="javascript:void(0);" class="jbox-buttons-ok btn btn-primary" id="editcategory">确定</a>
  <a href="javascript:;" class="jbox-buttons-ok btn cancle">取消</a></div>
</div>
<script type="text/javascript" src="/Public/Admin/Js/city-picker.data.js"></script> 
<script type="text/javascript" src="/Public/Admin/Js/city-picker.js"></script> 
<script type="text/javascript">
$(".cancle").click(function(){
	$(this).parent().parent('.jbox').hide();
	$('#albums-overlay').hide();
})
</script> 
<!--添加分类--> 
<script type="text/javascript">
$("#city-picker").citypicker({
	province: '<?php echo ($cache["country"][0]); ?>',
	city: '<?php echo ($cache["country"][1]); ?>',
	district: '<?php echo ($cache["country"][2]); ?>'
});
$(".BtnAddClass").click(function(){
	$('.addfenlei').show();
	$('#albums-overlay').show();
})
</script> 
<script type="text/javascript">
$("#addcategory").click(function(){
	var username = $('.username').val(); 
	var password = $('.password').val();
	var cate = $('.cate').val();
	var country = $("#city-picker1").val();
	if (username == '') {
		$('.username').focus();
		dialog.showTips("登陆账号不能为空！","warn");  return false;
	}
	if (password == '') {
		$('.password').focus();
		dialog.showTips("登陆密码不能为空！","warn"); return false;
	}
	if(country == ''){
		dialog.showTips("地区不能为空！","warn"); return false;
	}
	var data = {username: username,password: password,cate: cate,country:country};
	$.ajax({
		url: "<?php echo U('/Admin/System/addAdmin');?>",
		type: "post",
		dataType: "json",
		data: data,
	}).done(function (g) {
		if (g.status == 1) {
			dialog.showTips(g.info,"",1); return false;
		} else {
			dialog.showTips(msg,"warn"); return false;
		}
	})
})
</script> 
<!--添加分类end--> 

<!--修改分类--> 
<script type="text/javascript">
var categoryid;
$(".j-editClass").click(function(){
	$('.editfenlei').show();
	$('#albums-overlay').show();
	var categoryname=$(this).attr('data-title');
	var adminid=$(this).attr('data-id');
	var cate=$(this).attr('data-cate');
	var province=$(this).attr('data-province');
	var city=$(this).attr('data-city');
	var district=$(this).attr('data-district');
	$('#editclassname').val(categoryname);
	$('#adminid').val(adminid);
	$('#city-picker').val(province+"/"+city+"/"+district);
	$(".city-picker-span .placeholder").html(province+"/"+city+"/"+district);
	$('.cate').val(cate);
})
function setSelectChecked(checkValue){  
	var select = document.getElementById('editcate');  
	for(var i=0; i<select.options.length; i++){  
		if(select.options[i].value == checkValue){  
			select.options[i].selected = true;  
			break;  
		}  
	}  
};  
$("#editcategory").click(function(){
	var username = $('#editclassname').val();  //分类名称
	var password = $('#editpassword').val();
	var cate = $('#editcate').val();           //排序
	var adminid = $('#adminid').val();           //排序
	var country = $("#city-picker").val();
	if (username == '') {
		dialog.showTips(msg,"warn");	return false;
	}
	$.ajax({
		url: "<?php echo U('/Admin/System/editAdmin');?>",
		type: "post",
		dataType: "json",
		data: {
			username: username,
			password: password,
			cate: cate, 
			id: adminid,
			country:country
		}
	}).done(function (g) {
		if (g.status == 1) {
			dialog.showTips(g.info,"",1);	return false;
		} else {
			dialog.showTips(msg,"warn");	return false;
		}

	})
})
$('.j-able').click(function(){
	var id = $(this).attr("data-id");
	var able = $(this).attr("data-able");
	$.ajax({
		url: "<?php echo U('/Admin/System/ableAdmin');?>",
		type: "post",
		dataType: "json",
		data: {
			id: id,
			able: able
		}
	}).done(function (g) {
		if (g.status == 1) {
		   dialog.showTips(g.info,"",1);	return false;
		} else {
		   dialog.showTips(msg,"warn");	return false;
		}
	})
})
$('.j-delClass').click(function(){
	var is_ture = confirm('确定要删除吗？');
	if(is_ture)
	{
		var id = $(this).attr("data-id");
		$.ajax({
			url: "<?php echo U('/Admin/System/deladmin');?>",
			type: "post",
			dataType: "json",
			data: {
				id: id
			}
		}).done(function (g) {
			if (g.status == 1) {
				dialog.showTips(g.info,"",1);	return false;
			} else {
				dialog.showTips(msg,"warn");	return false;
			}
		})
	}
})
</script> 
<!--修改分类end-->