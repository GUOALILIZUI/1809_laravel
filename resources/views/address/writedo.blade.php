<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>填写收货地址</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/writeaddr.css">
    <link rel="stylesheet" href="/layui/css/layui.css">
    <link rel="stylesheet" href="dist/css/LArea.css">
</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">填写收货地址</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="javascript:;" class="m-index-icon">保存</a>
</div>
<div class=""></div>
<!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">  
  
</form> -->
<form class="layui-form" action="">
  <div class="addrcon">

    <ul>
        @foreach($arr as $v)
            <input type="hidden" value="{{$v->site_id}}" name="site_id">
      <li><em>收货人</em><input type="text" name="site_name" value="{{$v->site_name}}" id="site_name" placeholder="请填写真实姓名" style="height:25px"></li>
      <li ><em>手机号码</em><input type="number" name="site_tel" id="site_tel" value="{{$v->site_tel}}" placeholder="请输入手机号" style="height:25px"></li>
      <li ><em>所在区域</em><input type="text" name="all_site" id="all_site" value="{{$v->all_site}}" placeholder="输入内容" style="height:25px"></li>

      <li class="addr-detail"><em>详细地址</em><input type="text" name="site_address" value="{{$v->site_address}}" id="site_address" placeholder="20个字以内" class="addr"></li>
    @endforeach
    </ul>

    {{--<div class="setnormal"><span>设为默认地址</span>--}}
      {{--<div class="setnormal"><span>设为默认地址</span>--}}

          {{--<input type="checkbox" name="is_default" id="is_default" lay-skin="switch">--}}
      {{--</div>--}}

      {{--</div>--}}
  </div>
</form>

<!-- SUI mobile -->
<script src="dist/js/LArea.js"></script>
<script src="dist/js/LAreaData1.js"></script>
<script src="dist/js/LAreaData2.js"></script>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="layui/layui.js"></script>

<script>
    $(function(){
    //Demo
    layui.use(['form','layer'], function(){
        var layer = layui.layer;
        var form = layui.form;

        $('.m-index-icon').click(function(){
            var data=$('form').serialize()

            $.ajax({
                type:'POST',
                data:data,
                dataType:'json',
                url:'addUpd',
                success:function(msg){
                    if(msg.status==1){
                        layer.msg(msg.msg)
                        window.location.href='/address'
                    }else {
                        layer.msg(msg.msg)
                    }
                }
            })

        })




    });

    });


</script>


</body>
</html>
