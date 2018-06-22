// 会员道首页脚本
$(function(){


//  图表接口
// /Index/point_count    发放积分走向，取最近7天的数据
// /Index/consume_count  消费积分走向，取最近7天的数据
// /Index/user_count     会员总数，取最近7天的数据
// /Index/point_group    积分发放组成

    //订单总数
    $.ajax({
        url: '/Shop/orderTotal',
        type: 'post',
        dataType: 'json',
        success:function(data){
            if(data.status==1){
                var tmpdata=data.orderList;
                $('#ddzs_t').text(tmpdata.series_today[6]);
                $('#ddzs_y').text(tmpdata.series_today[5]);
                $('#chart_ddzs').text("").highcharts({
                    chart:{
                        backgroundColor:"#eee",
                        events:{
                            load:function(){
                                $("#loading_chart_ddzs").hide();
                                $("#chart_ddzs").show();
                            }
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    subtitle: {
                        text: null
                    },
                    xAxis: {
                        // categories:["07-01","07-02","07-03","07-04","07-05","07-06","07-07"]
                        categories:tmpdata.day
                    },
                    yAxis: {
                        title: {
                            text: null
                        }
                    },
                    series: [
                        {
                            name:"订单笔数",
                            type:"line",
                            color:"#ff9e00",
                            // data: [1, 20, 3, 4, 5, 6, 7],
                            data: tmpdata.series_today
                        }
                    ]
                });
            }
            else{
                $("#loading_chart_ddzs").hide();
                $("#chart_ddzs").css("height","auto").text("暂无数据").show();
            }
        }
    });

    //fx订单总数
    $.ajax({
        url: '/Shop/orderFxTotal',
        type: 'post',
        dataType: 'json',
        success:function(data){
            if(data.status==1){
                var tmpdata=data.orderList;
                $('#fxddzs_t').text(tmpdata.series_today[6]);
                $('#fxddzs_y').text(tmpdata.series_today[5]);
                $('#chart_fxddzs').text("").highcharts({
                    chart:{
                        backgroundColor:"#eee",
                        events:{
                            load:function(){
                                $("#loading_chart_fxddzs").hide();
                                $("#chart_fxddzs").show();
                            }
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    subtitle: {
                        text: null
                    },
                    xAxis: {
                        // categories:["07-01","07-02","07-03","07-04","07-05","07-06","07-07"]
                        categories:tmpdata.day
                    },
                    yAxis: {
                        title: {
                            text: null
                        }
                    },
                    series: [
                        {
                            name:"分销订单笔数",
                            type:"line",
                            color:"#ff9e00",
                            // data: [1, 20, 3, 4, 5, 6, 7],
                            data: tmpdata.series_today
                        }
                    ]
                });
            }
            else{
                $("#loading_chart_fxddzs").hide();
                $("#chart_fxddzs").css("height","auto").text("暂无数据").show();
            }
        }
    });


    //会员总数
    $.ajax({
        url:"/Shop/orderPriceTotal",
        type:"post",
        dataType:"json",
        success:function(data){
            if(data.status==1){
                var tmpdata=data.orderList;
                $('#chart_ddje').text("").highcharts({
                    chart: {
                        type: 'column',
                        backgroundColor:"#eee",
                        events:{
            				load:function(){
                                $("#loading_chart_ddje").hide();
            					$("#chart_ddje").show();
            				}
            			}
                    },
                    credits: {
            			enabled: false
            		},
                    title: {
                        text: null
                    },
                    xAxis: {
                        // categories:["07-01","07-02","07-03","07-04","07-05","07-06","07-07"]
                        categories:tmpdata.day
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text:null
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold',
                                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            }
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.x +'</b><br/>'+
                                this.series.name +': '+ this.y +'<br/>';

                        }

                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.1,
                            borderWidth: 0
                        }
                    },
                    series:[
                        {
                            name:"当天全部订单金额",
                            data: tmpdata.t,
                            // data: [2, 21, 30, 40, 50, 6, 7],
                        },
                        {
                            name:"当天分销订单金额",
                            color:"#ff9e00",
                            data: tmpdata.f,
                            // data: [1, 20, 3, 4, 5, 3, 2],
                        }
                    ]
                });
            }
            else{
                $("#loading_chart_ddje").hide();
                $("#chart_ddje").css("height","auto").text("暂无数据").show();
            }
        }
    });
    
    //总发放积分组成
    $.ajax({
        url:"/Shop/orderPie",
        type:"post",
        dataType:"json",
        success:function(data){
            if(data.status==1){
                var tmpdata=data.orderList;
                $('#chart_ddtjpei').text("").highcharts({
            		chart: {
                    	backgroundColor:"#eee",
                    	events:{
            				load:function(){
                                $("#loading_chart_ddtjpei").hide();
            					$("#chart_ddtjpei").show();
            				}
            			}
                    },
                    colors:[
                        '#7cb5ec',
                        'rgba(255,183,25,1)'
                    ],
                    title: {
                        text: null
                    },
                    credits: {
            			enabled: false
            		},
                    tooltip: {
                	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true,
                        }
                    },
                    series: [{
                type: 'pie',
                name: '占',
                data: [
                    ['全部订单金额',   tmpdata.total_fee],
                    ['分销订单金额',   tmpdata.Ftotal_fee],
                ]
            }]
                });
            }
            else{
                $("#loading_chart_ddtjpei").hide();
                $("#chart_ddtjpei").css("height","auto").text("暂无数据").show();
            }
        }
    });

    // 最新1分钟内成交的商家(完成付款)
    // 
    ;(function(){
        // 获取滚屏相应数据
        var first_Obj = $('.fxsitem').find('.fxsinfo').slice(0, 16),
            second_Obj = $('.fxsitem').find('.fxsinfo').slice(16, 32),
            third_Obj = $('.fxsitem').find('.fxsinfo').slice(32, 48),
            last_Obj = $('.fxsitem').find('.fxsinfo').slice(48, 64);
        // 创建相关盒子存放滚屏数据
        var BoxWrapper = '<div class="allWrapper"><div class="fxswrapper exta-wraper0 clearfix"></div><div class="fxswrapper exta-wraper1 clearfix"></div><div class="fxswrapper exta-wraper2 clearfix"></div><div class="fxswrapper exta-wraper3 clearfix"></div></div>';
        $('.fxsmain').children('.fxsitem').append(BoxWrapper);
        $('.exta-wraper0').append(first_Obj);
        $('.exta-wraper1').append(second_Obj);
        $('.exta-wraper2').append(third_Obj);
        $('.exta-wraper3').append(last_Obj);

        var fxslistScroll = function(count){
            
            var ScrollIndex = $('.fxspageicon').children('span.cur').index();
            var speed = 500,
                count = count;
            if(ScrollIndex != 3){
                count = count ? count : ScrollIndex + 1
            }else{
                count = 0
            }
            $('.allWrapper').animate({
                top: '-260px'},
                speed, function() {
                var firstdom = $(this).children('.fxswrapper').eq(0);
                $('.allWrapper').css('top', '0').append(firstdom);
                $('.fxspageicon').children('span').eq(count).addClass('cur').siblings('span').removeClass('cur');
            });
        }
        var timer = setInterval(function(){
            fxslistScroll();
        },3000);
        $('.fxsitem').hover(function() {
            clearInterval(timer)
            timer = null;
        }, function() {
            timer = setInterval(function(){
                fxslistScroll();
            },3000);
        });
        // 显示二维码
        $('.fxsinfo').live({
            mouseover:function(){
                $(this).children('.fxscode,.fxscode2').show();
            },
            mouseleave:function(){
                $(this).children('.fxscode,.fxscode2').hide();
            }
        })
    })();
});