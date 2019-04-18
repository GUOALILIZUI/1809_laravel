<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form action="/doadd" method="post" onsubmit="return false" id="all">
    <table border="2">
        <tr>
            <td>&nbsp;&nbsp;名称</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;分类</td>
            <td>
                <select name="c_id" id="">
                    @foreach($arr as $v)
                        <option value="{{$v->c_id}}">{{$v->cate_name}}</option>
                     @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;描述</td>
            <td>
                <textarea name="desc" id="" cols="30" rows="10">

                </textarea>
            </td>
        </tr>
        <tr>
            <td>是否热卖</td>
            <td>
                <input type="radio" name="is_hot" value="1">是
                <input type="radio" name="is_hot" value="1">否
            </td>
        </tr>
        <tr>
            <td>是否上架</td>
            <td>
                <input type="radio" name="is_sell"  value="1">是
                <input type="radio" name="is_sell" value="2">否
            </td>
        </tr>
        <tr>
           <td><input type="button" value="submit" class="er"></td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="/js/jquery-3.2.1.min.js"></script>
<script>
$(function(){

    $('.er').click(function(){
        var data=$('#all').serialize();
        // console.log(data)
        //
        $.ajax({
            url: "insert",
            method: "POST",
            data:data,
            success:function(res){
                if(res==1){
                    alert('添加成功');
                    location.href='list';
                }else{
                    alert('添加失败');
                    location.href='insert';
                }
            }
        })

    })

})

</script>