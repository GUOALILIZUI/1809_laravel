<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form action="upd" method="post" onsubmit="return false" id="sll">
    <input type="hidden" name="id" value="{{$arr->id}}" id="l">
    <table border="2">
        <tr>
            <td>&nbsp;&nbsp;名称</td>
            <td><input type="text" name="name" value="{{$arr->name}}"></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;分类</td>
            <td>
                <select name="c_id" id="" value="{{$arr->c_id}}">
                    @foreach($cate as $v)
                        @if($v->c_id==$arr->c_id)
                            <option value="{{$v->c_id}}" selected>{{$v->cate_name}}</option>
                        @else
                            <option value="{{$v->c_id}}" >{{$v->cate_name}}</option>
                        @endif
                     @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;描述</td>
            <td>
                <textarea name="desc" id="" cols="30" rows="10">
{{$arr->desc}}
                </textarea>
            </td>
        </tr>
        <tr>
            <td>是否热卖</td>
            <td>

                <input type="radio" name="is_hot" value="1" @if($arr->is_hot==1) checked @endif>是
                <input type="radio" name="is_hot" value="2" @if($arr->is_hot==2) checked @endif>否

            </td>
        </tr>
        <tr>
            <td>是否上架</td>
            <td>
                <input type="radio" name="is_sell"  value="1" @if($arr->is_sell==1) checked @endif>是
                <input type="radio" name="is_sell" value="2" @if($arr->is_sell==2) checked @endif>否
            </td>
        </tr>
<tr>
    <td><input type="button" value="submit" class="btn"></td>
</tr>
</table>
</form>
</body>
</html>
<script src="/js/jquery-3.2.1.min.js"></script>
<script>
$(function(){
    $('.btn').click(function(){
        var data=$('#sll').serialize();

        $.ajax({
            url: "upd",
            method: "POST",
            data:data,
            success:function(res){
                if(res==1){
                    alert('修改成功');
                    location.href='list';
                }else{
                    alert('修改失败');
                    location.href='list';
                }
            }
        })


    })
})

</script>