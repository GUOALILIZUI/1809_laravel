<?php

namespace App\Http\Controllers\WeiXin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;



class WeiXinController extends Controller
{

    public function accessToken(){
        $value = Cache::get('access');
        if (!$value) {
            $appid = "wxdd0d451ebdddd4f9";
            $appkey = "3a0980e46f62a1f9b759fa11adaab484";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appkey";
            $url_class = new \url();
            $res = $url_class->sendGet($url);
            $info = json_decode($res);
            $value = $info->access_token;
            cache(['access' => $value], 3600);
        }
        return $value;

    }


    //商品
    public function check(Request $request){
        $str=file_get_contents("php://input");
        file_put_contents("/tmp/weixin.log",$str,FILE_APPEND);
        $objXml=simplexml_load_string($str);
        $Event=$objXml->Event;
        $FromUserName=$objXml->FromUserName;
        $ToUserName=$objXml->ToUserName;
        $CreateTime=$objXml->CreateTime;
        $MsgType=$objXml->MsgType;
        $Content=$objXml->Content;

        //接收到文本信息
        if($Content=="天气"){
            $version = 'v1';
            $ip = $_SERVER['REMOTE_ADDR'];
            $appid = 'wxdd0d451ebdddd4f9';
            $appsecret = '3a0980e46f62a1f9b759fa11adaab484';
            $url = "https://www.tianqiapi.com/api/?version=$version&ip=$ip&appid=$appid&appsecret=$appsecret";
            $data = file_get_contents($url);
            $json = json_decode($data, true);
            $arr1= '北京' . '天气:';
            $arr2= '更新时间: ' . $json['update_time'] ;
            $list = $json['data'];
            if ($version == 'v1') {
                for ($i = 0; $i < count($list); $i++) {
                    $arr3=$list[$i]['date'] . ' ' . $list[$i]['wea'] . ' ' . $list[$i]['tem1'] . '/' . $list[$i]['tem2'] . ' ' . $list[$i]['win'][0] . ' ' . $list[$i]['win_speed'];
                }
            }
            $info=$arr1.$arr2.$arr3;
            $str3="<xml>
            <ToUserName><![CDATA[$FromUserName]]></ToUserName>
            <FromUserName><![CDATA[$ToUserName]]></FromUserName>
            <CreateTime>$CreateTime</CreateTime>
             <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[$info]]></Content>
                </xml>";
            echo $str3;
        }




        $where=[
            'openid'=>"$FromUserName"
        ];
        $res=DB::table('attention')->where($where)->first();
        if(empty($res)){
            DB::table('attention')->insert($where);
            $time=time();
            $content="欢迎关注本公众号";
            $youStr="
                    <xml>
                      <ToUserName><![CDATA[$FromUserName]]></ToUserName>
                      <FromUserName><![CDATA[$ToUserName]]></FromUserName>
                      <CreateTime>$time</CreateTime>
                      <MsgType><![CDATA[text]]></MsgType>
                      <Content><![CDATA[$content]]></Content>
                    </xml>
                ";
            echo $youStr;
        }else{
            $accessToken = $this->accessToken();
            $tempUrl="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$FromUserName&lang=zh_CN";
            $objUrl = new \url();
            $info = $objUrl->sendGet($tempUrl);
            $data=json_decode($info,JSON_UNESCAPED_UNICODE);
            $name=$data['nickname'];
            $content2="欢迎".$name."回来";
            $time1=time();
            $youStr22="
                    <xml>
                      <ToUserName><![CDATA[$FromUserName]]></ToUserName>
                      <FromUserName><![CDATA[$ToUserName]]></FromUserName>
                      <CreateTime>$time1</CreateTime>
                      <MsgType><![CDATA[text]]></MsgType>
                      <Content><![CDATA[$content2]]></Content>
                    </xml>
                ";
            echo $youStr22;

        }
    }
}