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
.btn-success {
	margin-top: 12px;
}
.access-padding {
	padding: 3px;
}
.access-padding div {
	float: left;
	margin-right: 5px;
}
/*.level-1{
    background: #eee;
}
.level-2{
    background: #ddd;
}
.level-3{
    background: #ccc;
}
.level-4{
    background: #bbb;
}*/
.access-padding a:hover {
	color: red;
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
    <h1 class="content-right-title">权限分配————[<?php echo ($per_name); ?>]</h1>
    <div class="alert alert-info disable-del">建议将[首页]——[后台主页]——[主页]——[主页]勾选，避免出现用户无法登入后台的现象。 <a href="javascript:;" class="alert-delete" title="隐藏"><i class="gicon-remove"></i></a> </div>
    <form action="" method="post">
      <div class="clearfix"> <a href="javascript:;" class="btn btn-success fl check-all">全选</a></div>
    </form>
    <table class="wxtables">
      <colgroup>
      <col width="100%">
      </colgroup>
      <tbody>
        <?php if(is_array($cache)): foreach($cache as $key=>$v1): ?><tr>
            <td class="access-padding level-1"> [头部导航] <input type="checkbox" value="<?php echo ($v1["id"]); ?>" data-pid="<?php echo ($v1["pid"]); ?>" data-pid2="<?php echo ($v1["pid2"]); ?>" data-pid3="<?php echo ($v1["pid3"]); ?>" class="checkbox table-ckbs" data-id="<?php echo ($v1["id"]); ?>" 
              <?php if(in_array($v1['id'],$node_arr)): ?>checked<?php endif; ?>
              data-name=""> <b><?php echo ($v1["classname"]); ?> </b></td>
          </tr>
          <?php if(is_array($v1['nodes'])): foreach($v1['nodes'] as $key=>$v2): ?><tr>
              <td class="access-padding  level-2">&nbsp;&nbsp;[左侧标签] <input type="checkbox" value="<?php echo ($v2["id"]); ?>" data-pid="<?php echo ($v2["pid"]); ?>" data-pid2="<?php echo ($v2["pid2"]); ?>" data-pid3="<?php echo ($v2["pid3"]); ?>"  class="checkbox table-ckbs" data-id="<?php echo ($v2["id"]); ?>" 
                <?php if(in_array($v2['id'],$node_arr)): ?>checked<?php endif; ?>
                data-name="">
                <?php echo ($v2["classname"]); ?> </td>
            </tr>
            <?php if(is_array($v2['nodes'])): foreach($v2['nodes'] as $k=>$v3): ?><tr>
                <td class="access-padding  level-3">&nbsp;&nbsp;&nbsp;&nbsp;[左侧导航] <input type="checkbox" value="<?php echo ($v3["id"]); ?>" data-pid="<?php echo ($v3["pid"]); ?>" data-pid2="<?php echo ($v3["pid2"]); ?>" data-pid3="<?php echo ($v3["pid3"]); ?>" class="checkbox table-ckbs" data-id="<?php echo ($v3["id"]); ?>" 
                  <?php if(in_array($v3['id'],$node_arr)): ?>checked<?php endif; ?>
                  data-name="">
                  <?php echo ($v3["classname"]); ?> </td>
              </tr>
              <?php
 if($v3["nodes"]){?>
              <tr>
                <td class="access-padding  level-4"><div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[内容节点]</div>
                  <?php
 foreach($v3["nodes"] as $v4){?>
                  <div>
                    <input type="checkbox" value="<?php echo $v4['id']?>" data-pid="<?php echo $v4['pid']?>" data-pid2="<?php echo $v4['pid2']?>" data-pid3="<?php echo $v4['pid3']?>" class="checkbox table-ckbs" data-id="<?php echo $v4['id']?>" data-name="" <?php if(in_array($v4['id'], $node_arr)){echo "checked";} ?>>
                    <?php echo $v4['classname']?> </div>
                  <?php  }?></td>
              </tr>
              <?php  } endforeach; endif; endforeach; endif; endforeach; endif; ?>
      </tbody>
    </table>
    <div class="panel-single panel-single-light mgt20 txtCenter"> <a href="" class="btn" onclick="history.back()">返回</a>
      <input type="button" id="sub" class="btn btn-primary" value="保存">
    </div>
    
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
<script>
    $(".check-all").click(function (){
        $("input[type=checkbox]").prop("checked", $("input[type=checkbox]").prop("checked")^1);
    })
    $("#sub").click(function (){
        var id = "<?php echo ($id); ?>";
        var str = "";
        $("input[type=checkbox]:checked").each(function (i){
            str += $(this).val()+",";
        })
        $.post("<?php echo U('Admin/System/addRoleNode');?>", {id:id,ids:str}, function (data){
            if(data.status){
				dialog.showTips(data.info,"",'/Admin/system/rolelist');
            }
			dialog.showTips(data.info,"warn");
        }, "json")
    })
    $(".wxtables input[type=checkbox]").click(function (){
        var that = $(this);
        setTimeout(function (){
            var id = that.val();
            var status = that.prop("checked");
            $("input[type=checkbox][data-pid="+id+"]").prop("checked",status);
            $("input[type=checkbox][data-pid2="+id+"]").prop("checked",status);
            $("input[type=checkbox][data-pid3="+id+"]").prop("checked",status);
        }, 0)
    })
</script>