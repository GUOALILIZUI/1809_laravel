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
    <a href="javascript:;" class="m-index-icon" >保存</a>
</div>
<div class=""></div>
<!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">  
  
</form> -->
<form class="layui-form" action="">
  <div class="addrcon">
    <ul>
      <li><em>收货人</em><input type="text" name="site_name" id="site_name" order_id="order_id" placeholder="请填写真实姓名" style="height:25px"></li>
      <li ><em>手机号码</em><input type="number" name="site_tel" id="site_tel"  placeholder="请输入手机号" style="height:25px"></li>
      <li ><em>所在区域</em><input type="text" name="all_site" id="all_site"  placeholder="输入内容" style="height:25px"></li>
        {{--<li>--}}
            {{--<em>所在区域</em>--}}
            {{--<em style="width:150px">--}}
                {{--<select name="site_province" id="site_province" class="area" >--}}
                    {{--<option value="0">请选择...</option>--}}
                    {{--{volist name="province" id="v"}--}}
                    {{--<option value="{$v.id}">{$v.name}</option>--}}
                    {{--{/volist}--}}
                {{--</select>--}}
            {{--</em>--}}
            {{--<em style="width:150px">--}}
                {{--<select name="site_city" class="area" id="site_city">--}}
                    {{--<option value="0">请选择...</option>--}}
                {{--</select>--}}
            {{--</em>--}}
            {{--<em style="width:150px">--}}
                {{--<select name="site_district" class="area" id="site_district">--}}
                    {{--<option value="0">请选择...</option>--}}
                {{--</select>--}}

            {{--</em>--}}
        {{--</li>--}}



      <li class="addr-detail"><em>详细地址</em><input type="text" name="site_address" id="site_address" placeholder="20个字以内" class="addr"></li>
    </ul>
    {{--<div class="setnormal"><span>设为默认地址</span>--}}
      <div class="setnormal"><span>设为默认地址</span><input type="checkbox" name="is_default" id="is_default" lay-skin="switch">  </div>

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
            var data={};
            var site_name=$('#site_name').val();
            // var order_id=$('#site_name').attr('order_id').val();
            var site_tel=$('#site_tel').val();
            var all_site=$('#all_site').val();
            var site_address=$('#site_address').val();
            var is_default=$('#is_default').prop('checked');

            data.site_name=site_name
            data.site_tel=site_tel
            data.all_site=all_site
            data.site_address=site_address
            data.is_default=is_default

            $.ajax({
                type:'POST',
                data:data,
                dataType:'json',
                url:'addreDo',
                success:function(msg){
                    if(msg.status==2){
                        layer.msg(msg.msg)
                        window.location.href='/login'
                    }else if(msg.status==0){
                        layer.msg(msg.msg)
                    }else{
                        layer.msg(msg.msg)
                        window.location.href='address'

                    }
                }
            })

        })




    });

    });


</script>


</body>
</html>
