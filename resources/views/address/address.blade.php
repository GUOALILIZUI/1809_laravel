<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>地址管理</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/address.css">
    <link rel="stylesheet" href="css/sm.css">
    <link rel="stylesheet" href="/layui/css/layui.css"  media="all">




</head>
<body>
    
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">地址管理</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/addreAdd" class="m-index-icon">添加</a>
</div>
<div class="addr-wrapp">
    <div class="addr-list">
        @foreach($data as $v)

        <ul>
            <li class="clearfix">
                <span class="fl">{{$v->site_name}}</span>
                <span class="fr">{{$v->site_tel}}</span>
            </li>
            <li>
                <p>{{$v->site_address}}</p>
            </li>
            <li class="a-set">
                <s <?php if($v->is_default==2){?>
                class="z-set"
                <?php }else{?>
                class="z-defalt"
                        <?php }?>
                        sstyle="margin-top: 6px;" site_id="{{$v->site_id}}"></s>
                <span>设为默认</span>
                <div class="fr">
                    <span class="edit"><a href="addp?site_id={{$v->site_id}}">编辑</a></span>
                    <span class="del" site_id="{{$v->site_id}}">删除</span>
                </div>
            </li>
        </ul>
        @endforeach

    </div>

</div>


<script src="js/zepto.js" charset="utf-8"></script>
<script src="js/sm.js"></script>
<script src="js/sm-extend.js"></script>

<script src="/js/jquery-3.2.1.min.js"></script>
<script src="js/all.js"></script>
<script src="layui/layui.js"></script>
<!-- 单选 -->
<script>
    

     // 删除地址
    // $(document).on('click','span.remove', function () {
    //     var buttons1 = [
    //         {
    //           text: '删除',
    //           bold: true,
    //           color: 'danger',
    //           onClick: function() {
    //             $.alert("您确定删除吗？");
    //           }
    //         }
    //       ];
    //       var buttons2 = [
    //         {
    //           text: '取消',
    //           bg: 'danger'
    //         }
    //       ];
    //       var groups = [buttons1, buttons2];
    //       $.actions(groups);
    // });
</script>
<script src="js/jquery-1.8.3.min.js"></script>
<script>
    var $$=jQuery.noConflict();
    $$(document).ready(function(){
            // jquery相关代码
            $$('.addr-list .a-set s').toggle(
            function(){
                if($$(this).hasClass('z-set')){

                }else{
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }
            },
            function(){
                if($$(this).hasClass('z-defalt')){
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }

            }
        )

    });

    
</script>
</body>
</html>

<script>
    $(function(){
        layui.use(['layer'],function(){
            var layer=layui.layer

         $('.del').click(function(){
             var _this=$(this)
             var site_id=_this.attr('site_id')
             layer.confirm('是否确认删除',function(index){
                 layer.close(index)
                 $.post(
                     '/addrDel',
                     {site_id:site_id},
                     function(result){
                        layer.msg(result.font,{icon:result.code});
                        if(result.code==1){
                            _this.parents('ul').remove();
                        }
                     },
                     'json'
                 )

             })



         })


            $('.z-defalt').click(function(){

                var site_id=$(this).attr('site_id')

                $.ajax({
                    type:'POST',
                    data:{site_id:site_id},
                    dataType:'json',
                    url:'defa',
                    success:function(msg){

                        if(msg.status==1){
                            // layer.msg(msg.msg)
                    window.location.href="address";
                        }else {
                            // layer.msg(msg.msg)

                        }
                    }
                })
            })
        })
    })
</script>
