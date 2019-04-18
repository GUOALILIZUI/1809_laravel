<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<style>
    table{border:1px solid #666;border-collapse: collapse;width:900px;margin:10px auto;font-size: 14px;color:#666;}
    th,td{border:1px solid #666;height:25px;text-align:center;}
    a{border:1px solid #666;text-decoration: none;padding: 0 5px;border-radius: 5px;color:#666;}
    a:hover,a.current{border:1px solid plum;color:plum;}
    ul li{
        text-decoration: none;
        padding: 0 5px;
        border-radius: 5px;
        color:orange;
        list-style:none;
        float:left;
        font-size:20px;
        margin-left:10px;

    }
    ul li a{
        text-decoration: none;
    }
    ul{
        margin-left:400px;

    }
</style>
<body>
<div align="center">
<select name="" id="">
    <option value="">--请选择--</option>
    <option value="">热销</option>
    <option value="">不热销</option>
</select>
<select name="" id="">
    <option value="">--请选择--</option>
    <option value="">上架</option>
    <option value="">下架</option>
</select>
<input type="button" nam="" value="搜索">
</div>
<form action="/form2" method="post">
    <table border="6">
        <tr>
            <td>id</td>
            <td>名称</td>
            <td>分类</td>
            <td>描述</td>
            <td>是否热卖</td>
            <td>是否上架</td>
            <td>操作</td>
        </tr>
        @foreach($arr as $v)
        <tr ></tr>
        <tr>
            <td>{{$v->id}}</td>
            <td>
                <div class="div_test" >
                    <span class="clk">{{$v->name}}</span>
                    <input type="text" class="imp" field="name" value="{{$v->name}}" id="{{$v->id}}" style="display:none">
                </div>
            </td>
            <td>{{$v->cate_name}}</td>
            <td>{{$v->desc}}</td>
            <td>
                @if($v->is_hot==1)
                    热销
                 @else
                    不热销
                 @endif
            </td>
            <td>
                @if($v->is_hot==1)
                    上架
                @else
                    下架
                @endif
            </td>
            <td>
                <a href="javascript:;" class="del" id="{{$v->id}}">del</a>
                <a href="javascript:;" class="upd" id="{{$v->id}}">upd</a>
            </td>
        </tr>
        @endforeach
    </table>

</form>
</body>
</html>
{{ $arr->links() }}
<script src="/js/jquery-3.2.1.min.js"></script>
<script>
    $(function(){

        //即点即改
        $('.clk').click(function(){
            var _this=$(this)
            //把span隐藏  文本框展示
            _this.hide();
            _this.next('input').show();
        })
        //给文本框失去焦点事件
        $('.imp').blur(function(){
            var _this=$(this);
            var value=_this.val();
            var field=_this.attr('field');
            var id=_this.attr('id');
            $.ajax({
                url:'ufield',
                method:'POST',
                data:{value:value,field:field,id:id},
                success:function(msg){
                    if(msg==1){
                        alert('修改成功')
                        location.href='list'
                    }else{
                        alert('修改失败')
                        location.href='list'

                    }
                }
            })
        })
        //删除
        $('.del').click(function(){
            var _this=$(this);
            // alert('132')
            var a=confirm('是否确认删除？');
            if(a==true){
                _this.parents('tr').remove();
                var id=_this.attr('id')
                // alert(id)

                $.ajax({
                    url: "del",
                    method: "POST",
                    data:{id:id},
                    success:function(res){
                        if(res==1){
                            alert('删除成功');
                            location.href='list';
                        }else{
                            alert('删除失败');
                            location.href='list';
                        }
                    }
                })
            }else{
                location.href='list';

            }
        })
        //修改
        $('.upd').click(function(){
            var _this=$(this)
            var id=_this.attr('id')
            location.href="update?id="+id

        })
    })
</script>