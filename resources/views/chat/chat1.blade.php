<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>聊天室</title>
</head>
<style>
    .box {
        float: right;
        border:7px solid pink;
        width:300px;
        height:500px;
        border-radius:12px;
        overflow:auto;
        position: fixed ;
        right: 800px;
        top:120px;

    }
    .box-1::-webkit-scrollbar{
        width: 10px;     /*高宽分别对应横竖滚动条的尺寸*/
        height: 1px;
    }
    .box-1::-webkit-scrollbar-thumb {/*滚动条里面小方块*/
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        background: #fffc99;
    }
    .box-1::-webkit-scrollbar-track {/*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        border-radius: 10px;
        background: #EDEDED;
    }
    .pp{
        position: fixed ;
        left: 845px;
        top:700px;
    }
</style>
<body>

    <div align="center" class="vv">
        <h1 style="color: teal;">这是聊天室🦄</h1>
        <div id="rea"  class="box box-1">

        </div>
        <p class="pp">
            <input type="text" style="border:1px solid #5a6268; width:200px;height:30px; border-radius:50px" name="" id="msg">
            <input type="button" style="border:1px solid #5a6268; width:50px;height:30px; border-radius:50px;background: pink" value="SEND" id="but">
        </p>
    </div>
</body>
</html>
<script src="/js/jquery.min.js"></script>
<script>
    var ws_server='ws://1809a.ws.com:9502/';
    var ws=new WebSocket(ws_server);

    ws.onopen=function(){
        $('#but').click(function(){
            var msg=$('#msg').val();
            ws.send(msg)
        })

        
        ws.onmessage=function(result){
//            console.log(result.data)
            $('#rea').append("<h5 style='color: #7ab5d3 ;'>"+result.data+"</h5>");
            $('#msg').val('');
        }
    }
</script>