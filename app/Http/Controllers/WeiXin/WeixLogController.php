<?php

namespace App\Http\Controllers\WeiXin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class WeiXinController extends Controller
{
    //商品
    public function check(Request $request){
//        echo 111;
//        exit;
        //echo $request->input('echostr');
        $str=file_get_contents("php://input");
        file_put_contents("/tmp/weixin.log",$str,FILE_APPEND);


        $objxml=simplexml_load_string($str);

////        exit;
//
//        $ToUserName=$objxml->ToUserName;
//        $CreateTime=$objxml->CreateTime;
//        $MsgType=$objxml->MsgType;
//        $Event=$objxml->Event;
//        $FromUserName=$objxml->FromUserName;
//        $Content=$objxml->Content;
//
//        $con=mysqli_connect('127.0.0.1','root','123456','item');
//        $sql="insert into xml(ToUserName,FromUserName,CreateTime,MsgType,Event) values('$ToUserName','$FromUserName','$CreateTime','$MsgType','$Event')";
//        $res=mysqli_query($con,$sql);
//
//
//        $data=DB::table('goods')->where('goods_name','like',"%$Content%")->first();
//        $goods_name=$data->goods_name;
//        $goods_selfprice=$data->goods_selfprice;
//        if($data){
//            $goods_img="http://119.23.184.175/goodsimg/$data->goods_img";
//            $title="$goods_name";
//            $description1="$goods_selfprice";
//            $time=time();
//            $strPl="
//        <xml>
//            <ToUserName><![CDATA[$FromUserName]]></ToUserName>
//            <FromUserName><![CDATA[$ToUserName]]></FromUserName>
//            <CreateTime>$time</CreateTime>
//            <MsgType><![CDATA[news]]></MsgType>
//            <ArticleCount>1</ArticleCount>
//            <Articles>
//                <item>
//                    <Title><![CDATA[$title]]></Title>
//                    <Description><![CDATA[$description1]]></Description>
//                    <PicUrl><![CDATA[$goods_img]]></PicUrl>
//                    <Url><![CDATA[$goods_img]]></Url>
//                </item>
//            </Articles>
//    </xml>
//    ";
//            echo $strPl;
//        }else{
//
//        }


    }
}

