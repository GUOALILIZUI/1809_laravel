<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>聊天室</title>
</head>
<body>

<script>
    var ws_server='ws://1809a.ws.com:9502/';
    var ws=new WebSocket(ws_server);

    ws.onopen=function(){
        ws.send("hello ");
    }

    ws.onmessage=function(d){
        console.log(d.data)
        alert(d.data);
    }
    console.log(ws);
</script>


</body>
</html>
