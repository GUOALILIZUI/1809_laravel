<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>登录</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/layui/css/layui.css">

    <link href="css/vccode.css" rel="stylesheet" type="text/css" />
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">微信绑定</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="home-icon"></i></a>
</div>

<div class="wrapper">
    <div class="registerCon">
        <div class="binSuccess5">
            <ul>
                <li class="accAndPwd">
                    <dl>
                        <input type="hidden" id="openId" value="{{$openId}}">
                        <div class="txtAccount">
                            <input name="l_tel" id="txtAccount" type="text" placeholder=""><i></i>
                        </div>
                        <cite class="passport_set" style="display: none"></cite>
                    </dl>
                </li>
            </ul>
            <a id="btnLogin" href="javascript:;" class="orangeBtn loginBtn">绑定微信</a>
        </div>
    </div>
</div>

<div class="footer clearfix" style="display:none;">
    <ul>
        <li class="f_home"><a href="/v44/index.do" ><i></i>潮购</a></li>
        <li class="f_announced"><a href="/v44/lottery/" ><i></i>最新揭晓</a></li>
        <li class="f_single"><a href="/v44/post/index.do" ><i></i>晒单</a></li>
        <li class="f_car"><a id="btnCart" href="/v44/mycart/index.do" ><i></i>购物车</a></li>
        <li class="f_personal"><a href="/v44/member/index.do" ><i></i>我的潮购</a></li>
    </ul>
</div>
</body>
</html>
<script src="layui/layui.js"></script>
<script src="js/jquery-1.11.2.min.js"></script>

<script>
    $(function(){
        layui.use(['form','layer'],function(){
            var layer=layui.layer;
            var data={};




            $('#btnLogin').click(function(){
                var txt=$('#txtAccount').val();
                var openId=$('#openId').val();
                // console.log(openId);
                // console.log(txt);

                data.txt=txt;
                data.openId=openId;
                $.ajax({
                    type:"POST",
                    data:data,
                    dataType:"json",
                    url:'ishow',
                    success:function(msg){
                        // console.log(msg);
                        if(msg.status==0){
                            layer.msg(msg.msg)
                        }else{
                            layer.msg(msg.msg)
                            window.location.href='/login'
                        }
                    }
                })
            })


        })
    })
</script>
