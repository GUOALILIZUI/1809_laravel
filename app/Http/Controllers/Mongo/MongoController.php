<?php

namespace App\Http\Controllers\Mongo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MongoDB\Client;

class MongoController extends Controller
{

    //
    public function mongo1(){
        $db_host='mongodb://127.0.0.1:27017';
        $client=new Client($db_host);
        $collection=$client->a1809->mdb;  //选择数据库 选择表

        //写入文档记录
        $doc=
            [
                'name'=>'alili',
                'age'=>3
            ];
        $res=$collection->insertOne($doc);
        var_dump($res);
    }

    public function mongo2(){
        $db_host='mongodb://127.0.0.1:27017';
        $client=new Client($db_host);
        $collection=$client->a1809->mdb;  //选择数据库 选择表

        //写入多个文档记录
        $doc=[
            [
                'name'=>'alili1',
                'age'=>3
            ],
            [
                'name'=>'alili2',
                'age'=>5
            ],
        ];
        $res=$collection->insertMany($doc);
        var_dump($res);
    }

    public function mongo3(){
        $db_host='mongodb://127.0.0.1:27017';
        $client=new Client($db_host);
        $collection=$client->a1809->mdb;  //选择数据库 选择表


        //查询记录
        $record=$collection->findOne(['name'=>'alili1']);
        print_r($record);
    }

    public function server(){
        $server = new swoole_websocket_server("127.0.0.1", 9502);

        $server->on('open', function($server, $req) {
            echo "connection open: {$req->fd}\n";
        });

        $server->on('message', function($server, $frame) {
            echo "received message: {$frame->data}\n";
            $server->push($frame->fd, json_encode(["hello", "world"]));
        });

        $server->on('close', function($server, $fd) {
            echo "connection close: {$fd}\n";
        });

        $server->start();
    }

    public function chat(){
        return view('chat.chat');
    }

    public function chat1(){
        return view('chat.chat1');
    }

}
