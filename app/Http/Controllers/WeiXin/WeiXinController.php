<?php

namespace App\Http\Controllers\WeiXin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class WeiXinController extends Controller
{
    //商品
    public function check(Request $request){
        $str=file_get_contents("php://input");
        file_put_contents("/tmp/weixin.log",$str,FILE_APPEND);
        $objXml=simplexml_load_string($str);

        $type=$objXml->EventKey;
        $openId=$objXml->FromUserName;
        $time=time();
        $this->redis($type,$openId,$time);


        //客服聊天信息
        $MsgType=$objXml->MsgType;
        if($MsgType=='text'){
            $openid=$objXml->FromUserName;
            $Content=$objXml->Content;


            $redis=new \redis();
            $redis->connect('127.0.0.1',6379);
            $id=$redis->incr('id');
            $hkey="chat_".$id;
            $lkey="chat";
            $redis->hset($hkey,'id',"$id");
            $redis->hset($hkey,'openid',"$openid");
            $redis->hset($hkey,'content',"$Content");
            $redis->rpush($lkey,$hkey);
        }


    }

    //
    public function redis($type,$openId,$time){
        $redis=new \redis();
        $redis->connect('127.0.0.1',6379);
        $id=$redis->incr('id');
        $hkey="code_{$id}";
        $lkey="aa";
        $setKey='setkey'.$type;
        $ty=$redis->sadd($setKey,"$openId");
        if($ty){
            $redis->hset($hkey,'id',$id);
            $redis->hset($hkey,'type',"$type");
            $redis->hset($hkey,'openid',"$openId");
            $redis->hset($hkey,'time',"$time");
            $redis->rpush($lkey,$hkey);
        }
    }
}




