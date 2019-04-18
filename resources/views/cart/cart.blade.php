<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购物车</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link href="css/cartlist.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/layui/css/layui.css">

</head>
<body id="loadingPicBlock" class="g-acc-bg">
    <input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
    <div>
        <!--首页头部-->
        <div class="m-block-header">
            <a href="/" class="m-public-icon m-1yyg-icon"></a>
            <a href="/" class="m-index-icon">编辑</a>
        </div>
        <!--首页头部 end-->
        <div class="g-Cart-list">
            <ul id="cartBody">
                @foreach($cartInfo as $v)
                    <input type="hidden" id='goods_num'>

                    <li  goods_id="{{$v->goods_id}}" id="alll">
                        <s class="xuan current" ></s>
                    <a class="fl u-Cart-img" href="/v44/product/12501977.do">
                        <img src="{{URL::asset('goodsimg/'.$v->goods_img)}}" border="0" alt="">
                    </a>
                    <div class="u-Cart-r">
                        <a href="/v44/product/12501977.do" class="gray6">{{$v->goods_name}}</a>
                        <span class="gray9">
                            <em>剩余124人次</em>
                        </span>
                        <div class="num-opt">
                            <em class="num-mius min" id="chang_num" flag="1"><i></i></em>
                            <input class="text_box" name="num" maxlength="6" type="number" value="{{$v->buy_num}}" goods_id="{{$v->goods_id}}" goods_num="{{$v->goods_num}}" codeid="12501977" money="{{$v->goods_selfprice}}">
                            <em class="num-add add" id="chang_num" flag="2"><i></i></em>
                        </div>
                        <a href="javascript:;" name="delLink" cid="12501977" isover="0" class="z-del" goods_id="{{$v->goods_id}}" cart_id="{{$v->cart_id}}">
                            <s></s>
                        </a>
                    </div>    
                </li>
                    @endforeach
               
            </ul>
            <div id="divNone" class="empty "  style="display: none"><s></s><p>您的购物车还是空的哦~</p><a href="https://m.1yyg.com" class="orangeBtn">立即潮购</a></div>
        </div>
        <div id="mycartpay" class="g-Total-bt g-car-new" style="">
            <dl>
                <dt class="gray6">
                    <s class="quanxuan current"></s>全选
                    <p class="money-total">合计<em class="orange total"><span>￥</span>17.00</em></p>
                    
                </dt>
                <dd>
                    <a href="javascript:;" id="a_payments" class="orangeBtn w_account remove" >删除</a>
                    <a href="javascript:;" onclick="payment()" id="a_payment" class="orangeBtn w_account">去结算</a>
                </dd>
            </dl>
        </div>
        <div class="hot-recom">
            <div class="title thin-bor-top gray6">
                <span><b class="z-set"></b>人气推荐</span>
                <em></em>
            </div>
            <div class="goods-wrap thin-bor-top">
                <ul class="goods-list clearfix">
                    @foreach($goodsInfo as $v)
                    <li>
                        <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                            <img src="{{URL::asset('goodsimg/'.$v->goods_img)}}" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="https://m.1yyg.com/v44/products/23458.do">{{$v->goods_name}}</a>
                        </p>
                        <ins class="gray9">价值:￥{{$v->goods_selfprice}}</ins>
                        <div class="btn-wrap">
                            <div class="Progress-bar">
                                <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                                </p>
                            </div>
                            <div class="gRate" data-productid="23458">
                                <a href="javascript:;"><s></s></a>
                            </div>
                        </div>
                    </li>
                        @endforeach
                </ul>
            </div>
        </div>
       
        

<div class="footer clearfix">
    <ul>
        <li class="f_home"><a href="/index" ><i></i>潮购</a></li>
        <li class="f_announced"><a href="/v41/lottery/" ><i></i>最新揭晓</a></li>
        <li class="f_single"><a href="/v41/post/index.do" ><i></i>晒单</a></li>
        <li class="f_car"><a id="btnCart" href="/cart" class="hover"><i></i>购物车</a></li>
        <li class="f_personal"><a href="/cord" ><i></i>我的潮购</a></li>
    </ul>
</div>

<script src="js/jquery-1.11.2.min.js"></script>
<script>
    /**去结算*/
    function payment(){
        var goods_id=[];
        $(".xuan.current").each(function () {
            if ($(this).hasClass("current")) {
                goods_id.push($(this).parent().attr('goods_id'));
            }
        })
        var price=$('.total').text();

        $.ajax({
            type:'POST',
            data:{goods_id:goods_id,price:price},
            dataType:'json',
            url:'payment',
            success:function(msg){
                var order_id=msg.order_id
                if(msg.status==2){
                    layer.msg(msg.msg)
                    window.location.href='/login'
                }else if(msg.status==0){
                    layer.msg(msg.msg)
                }else{
                    // layer.msg(msg.msg)
                    window.location.href='/payAll?order_id='+order_id

                }
            }
        })


    }
</script>
<!---商品加减算总数---->
    <script type="text/javascript">
    $(function () {
        layui.use(['layer'], function () {
            var layer = layui.layer
            //加号
            $(".add").click(function () {
                var _this = $(this).attr('class');//当前对象
                var goods_id = $(this).prev().attr('goods_id');//当前对象的上一个兄弟的自定义商品id
                var t = $(this).prev();
                t.val(parseInt(t.val()) + 1);
                num(_this, goods_id,)
                GetCount();
            })
            //减号
            $(".min").click(function () {
                var _this = $(this).attr('class');//当前对象
                var goods_id = $(this).next().attr('goods_id');//当前对象的上一个兄弟的自定义商品id
                // var buy_num = $(this).prev().attr('buy_num');//当前对象的上一个兄弟的自定义商品id

                var t = $(this).next();
                if (t.val() > 1) {
                    t.val(parseInt(t.val()) - 1);
                    num(_this, goods_id,)
                    GetCount();
                }
            })

            //加减号数据
            function num(_this, goods_id) {
                if (_this == "num-add add") {
                    $.ajax({
                        type: 'post',
                        data: {goods_id: goods_id,type: 1},
                        dataType: 'json',
                        url: 'showNum',
                        success: function (msg) {
                            if(msg.status==0){
                                layer.msg(msg.msg)
                                location.reload()
                            }
                        }
                    })
                } else {
                    $.ajax({
                        type: 'post',
                        data: {goods_id:goods_id,type: 2},
                        dataType: 'json',
                        url: 'showNum',
                        success: function (msg) {
                            console.log(msg)
                        }
                    })

                }
            }


        })
    })
    </script>
    <script>

    // 全选        
    $(".quanxuan").click(function () {
        if($(this).hasClass('current')){
            $(this).removeClass('current');

             $(".g-Cart-list .xuan").each(function () {
                if ($(this).hasClass("current")) {
                    $(this).removeClass("current"); 
                } else {
                    $(this).addClass("current");
                } 
            });
            GetCount();
        }else{
            $(this).addClass('current');

             $(".g-Cart-list .xuan").each(function () {
                $(this).addClass("current");
                // $(this).next().css({ "background-color": "#3366cc", "color": "#ffffff" });
            });
            GetCount();
        }
        
        
    });
    // 单选
    $(".g-Cart-list .xuan").click(function () {
        if($(this).hasClass('current')){
            

            $(this).removeClass('current');

        }else{
            $(this).addClass('current');
        }
        if($('.g-Cart-list .xuan.current').length==$('#cartBody li').length){
                $('.quanxuan').addClass('current');

            }else{
                $('.quanxuan').removeClass('current');
            }
        // $("#total2").html() = GetCount($(this));
        GetCount();
        //alert(conts);
    });
  // 已选中的总额
    function GetCount() {
        var conts = 0;
        var aa = 0; 
        $(".g-Cart-list .xuan").each(function () {
            if ($(this).hasClass("current")) {
                for (var i = 0; i < $(this).length; i++) {
                    conts += parseInt($(this).parents('li').find('input.text_box').val())*parseInt($(this).parents('li').find('input.text_box').attr('money'));
                    // aa += 1;
                }
            }
        });
        // console.log(conts)
        
         $(".total").html('<span>￥</span>'+(conts).toFixed(2));


    }
    GetCount();
</script>
</body>
</html>
<script src="layui/layui.js"></script>

<script>
    $(function(){
        layui.use(['layer'],function(){
            var layer=layui.layer

            //点击删除
            $(document).on('click','.z-del',function(){
                var _this=$(this)
                var goods_id=_this.attr('goods_id');
                var cart_id=_this.attr('cart_id');

                $.ajax({
                    type:"post",
                    data:{goods_id:goods_id,cart_id:cart_id},
                    dataType:'json',
                    url:'del',
                    success:function(msg){
                       if(msg.status==0){
                           layer.msg(msg.msg)
                       }else{
                           layer.msg(msg.msg)
                           _this.parents('li').remove();
                       }
                    }
                })

            })

            //批量删除
            $('#a_payments').click(function(){
                var goods_id=[];

                $(".g-Cart-list .xuan").each(function () {
                    if ($(this).hasClass("current")) {
                        goods_id.push($(this).parents('li').attr('goods_id'));
                    }
                    // alert(goods_id)
                    var _this=$(this)
                    var data={};
                    data.goods_id=goods_id

                    $.ajax({
                        type:'POST',
                        data:data,
                        dataType:'json',
                        url:'allDel',
                        success:function(msg){
                            if(msg.status==0){
                                layer.msg(msg.msg)
                            }else{
                                layer.msg(msg.msg)
                                $('#alll').remove();
                            }
                        }
                    })
                })
                })

            //文本框
            $('.text_box').blur(function(){
                var _this=$(this);
                var goods_id=$(this).attr('goods_id');
                var goods_num=$(this).attr('goods_num');
                var buy_num=$(this).val();
                // alert(goods_num)

                if(buy_num>=goods_num){
                    _this.val(goods_num)
                }else if(buy_num<=0){
                    _this.val(1)
                }

                $.ajax({
                    type:'post',
                    data:{goods_id:goods_id,buy_num:buy_num},
                    dataType:'json',
                    url:'textBox',
                    success:function(msg){

                        if(msg.status==0){
                            layer.msg(msg.msg)
                            // _this.val(goods_num);
                        }
                    }
                })

            })

            //总金额








        })
    })
</script>
