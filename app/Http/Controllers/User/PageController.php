<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class PageController extends Controller
{
    //视图
    public function page(){
        $url=urlencode("http://119.23.184.175/token");
        $appId="wxdd0d451ebdddd4f9";
        $scope="snsapi_userinfo";
        $objUrl="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appId&redirect_uri=$url&response_type=code&scope=$scope&state=STATE#wechat_redirect";

//        print_r($objUrl);exit;
        return view('userpage.userpage',['objUrl'=>$objUrl]);
    }

    //微信登录
    public function token(Request $request){
        $arr=$request->input();
//        print_r($arr);exit;
        $code=$arr['code'];
        $appId="wxdd0d451ebdddd4f9";
        $secret="3a0980e46f62a1f9b759fa11adaab484";
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appId&secret=$secret&code=$code&grant_type=authorization_code";
        $data=file_get_contents($url);
        $info=json_decode($data,true);
//        print_r($info);
        $openID=$info['openid'];
        $l_tel=session('l_tel');
//        print_r($l_tel);exit;
        $openid=DB::table('login')->where('l_tel',$l_tel)->where('openid',$openID)->first();
//        var_dump($openid);exit;

        if($openid){
            echo "已绑定";
        }else{
            return view('userpage.show',['openId'=>$openID]);

        }

    }

    public function wshow(Request $request){
        $openId=$request->input('openId');
        $txt=$request->input('txt');
//        print_r($txt);
        $info=DB::table('login')->where('l_tel',$txt)->update(['openid'=>$openId]);
//        var_dump($info);
        if($info){
            $arr=array(
                'status'=>1,
                'msg'=>'绑定成功'
            );
            return $arr;
        }else{
            $arr=array(
                'status'=>0,
                'msg'=>'绑定失败'
            );
            return $arr;
        }
    }
}