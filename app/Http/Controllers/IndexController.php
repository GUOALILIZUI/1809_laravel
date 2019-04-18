<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class IndexController extends Controller
{
    //首页视图
    public function Index(){
        $sql="select * from goods where goods_hot=2 ";
        $arr=DB::select($sql);

        $where=[
            'is_tell'=>1
        ];
        $sql2='select * from goods where is_tell=1 limit 2';
//        $data=DB::table('goods')->where($where)->select();
        $data=DB::select($sql2);


        return view('index.index',['arr'=>$arr,'data'=>$data]);
    }

    //注册视图
    public function Register(){
        return view('index.register');
    }

    //登录视图
    public function login(){
        $url=urlencode("http://119.23.184.175/itoKen");
        $appId="wxdd0d451ebdddd4f9";
        $scope="snsapi_userinfo";
        $objUrl="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appId&redirect_uri=$url&response_type=code&scope=$scope&state=STATE#wechat_redirect";

        return view('index.login',['objUrl'=>$objUrl]);
    }

    //
    public function accessToken(){
        $value = Cache::pull('access');
        if (!$value) {
            $appid = "wxdd0d451ebdddd4f9";
            $appkey = "3a0980e46f62a1f9b759fa11adaab484";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appkey";
            $url_class = new \url();
            $res = $url_class->sendGet($url);
            $info = json_decode($res);
            $value = $info->access_token;
            cache(['access' => $value], 7200);
            print_r($value);
        }
        return $value;

    }

    //注册
    public function add(Request $request){
        $arr=$request->input();
        $l_tel=$arr['l_tel'];
        $l_pwd=$arr['l_pwd'];
        $conpwd=$arr['conpwd'];
        $code=$arr['code'];
//        echo $code;exit;

            if($l_pwd !==$conpwd){
                $nul=array(
                    'status'=>0,
                    'msg'=>'密码与确认密码保持一致',
                );
                return $nul;exit;
            }
            $time=time();
            $codeWhere=[
                'tel'=>$l_tel,
                'code'=>$code,
                'status'=>1
            ];
            $code=DB::table('codes')->where($codeWhere)->first();

            if($code){
                if($time>$code->timeout){
                    $nul=[
                        'status'=>0,
                        'msg'=>'验证码已失效'
                    ];
                    return $nul;
                }
            }else{
                $nul=[
                    'status'=>0,
                    'msg'=>'验证码错误'
                ];
                return $nul;
            }

            $res=DB::table('login')->where('l_tel',$l_tel)->first();
            if(!empty($res)){
                $nul=array(
                    'status'=>0,
                    'msg'=>'手机号已存在',
                );
                return $nul;
            }
            $pwd=md5($l_pwd);
            $arrInfo=array(
                'l_tel'=>$l_tel,
                'l_pwd'=>$pwd
            );

            $register=DB::table('login')->insert($arrInfo);
            if($register){
                $nul=array(
                    'status'=>1,
                    'msg'=>'注册成功',
                );
                return $nul;
            }



    }

    //登录
    public function log(Request $request){
        $arr=$request->input();
        $l_tel=$arr['l_tel'];
        $l_pwd=$arr['l_pwd'];

        //print_r($info);exit;

        $pwd=md5($l_pwd);
        $where=['l_tel'=>$l_tel,'l_pwd'=>$pwd];
        $arrInfo=DB::table('login')->where($where)->first();

//        var_dump($arrInfo);exit;
/*微信提示yu
        if($arrInfo){
            $id=$arrInfo->l_id;
            $l_tel=$arrInfo->l_tel;
            session(['l_id'=>$id,'l_tel'=>$l_tel]);

            $openid=$arrInfo->openid;
            $accessToken = $this->accessToken();
            $tempUrl="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$accessToken";
            $arr=array(
                'touser'=>$openid,
                'template_id'=>'Pqd6QTFk-ACSoLIORlBxpGIUKNl1ck4QrcCSyf-GILk',
                "data"=>array(
                    "info"=>[
                        'value'=>"欢迎".$l_tel."登陆"
                    ]
                ),
            );
            
            $tempStr = json_encode($arr);
            $objUrl = new \url();
            $info = $objUrl->sendPost($tempUrl,$tempStr);
//            var_dump($info);die;
*/
        if($arrInfo){
                $id=$arrInfo->l_id;
                $l_tel=$arrInfo->l_tel;
                session(['l_id'=>$id,'l_tel'=>$l_tel]);

            return array('status'=>1,'msg'=>'登陆成功');
        }else{
            return array('status'=>0,'msg'=>'登录失败');

        }
    }

    //验证码
    public function t1(Request $request){
        $tel=$request->input('tel');
        //创建验证码
        $num=rand(1000,9999);
//        $obj= new \send();
//        $bol=$obj->show($tel,$num);
        $bol=100;
        if($bol==100){
            $arr=array(
                'tel'=>$tel,
                'code'=>$num,
                'timeout'=>time()+60,
                'status'=>1
            );
            $res=DB::table('codes')->insert($arr);
            var_dump($res);

        }





    }

    //猜你喜欢
    public function adddo(Request $request){
        //空数组
        $arr=array();
        //拿到当前页码  默认为第一页
        $page=$request->input('page',1);
        //每页显示条数
        $pageNum=2;
        //求出第几页  偏移量
        $offset=($page-1) * $pageNum;
        //查询表里数据
        $dataInfo=DB::table('goods')->offset($offset)->limit($pageNum)->get();
        //查询总条数
        $count=DB::table('goods')->count();
        //总条数/每页显示条数
        $pageCount=ceil($count/$pageNum);
        //显示视图
        $objView=view('index.like',['arr'=>$dataInfo]);
        //response获取页面原始代码
        $content=response($objView)->getContent();
        $arr['info']=$content;
        $arr['page']=$pageCount;

        return $arr;





    }

    //微信登录
    public function itoKen(Request $request){

        $arr=$request->input();
        $code=$arr['code'];
        $appId="wxdd0d451ebdddd4f9";
        $secret="3a0980e46f62a1f9b759fa11adaab484";
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appId&secret=$secret&code=$code&grant_type=authorization_code";
        $data=file_get_contents($url);
        $info=json_decode($data,true);
        $openID=$info['openid'];
        $l_tel=session('l_tel');
        $openid=DB::table('login')->where('openid',$openID)->first();

        $access=$this->accessToken();
        $urll="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access&openid=$openID&lang=zh_CN";
        $objUrl=new \url();
        $info1=$objUrl->sendGet($urll);
        $arr=json_decode($info1,true);
        $nickname=$arr['nickname'];




        if($openid){
            session(['openid'=>$openID]);
            $data1=[
                'nickname'=>$nickname,
                'openid'=>$openID
            ];
            $this->redis($data1);
//            $this->hello();
//            echo 11;
            return redirect('/index');



        }else{
            return view('index.wshow',['openId'=>$openID]);

        }

    }

    //数据
    public function ishow(Request $request){
        $openId=$request->input('openId');
        $txt=$request->input('txt');

        $access=$this->accessToken();
        $urll="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access&openid=$openId&lang=zh_CN";
        $objUrl=new \url();
        $info1=$objUrl->sendGet($urll);
        $arr=json_decode($info1,true);
        $nickname=$arr['nickname'];
        $info=DB::table('login')->where('l_tel',$txt)->first();
        $l_id=$info->l_id;
        $data1=[
            'nickname'=>$nickname,
            'openid'=>$openId
        ];
        if($info){
            $data=DB::table('login')->where('l_tel',$txt)->update(['openid'=>$openId]);
            session(['l_id'=>$l_id,'l_tel'=>$txt]);
            $this->redis($data1);
            if($data){
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
        }else{
            $arr=DB::table('login')->insert(['l_tel'=>$txt,'openid'=>$openId]);
            session(['openid'=>$openId,'l_tel'=>$txt]);
            $this->redis($data1);
            if($arr){
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

    //缓存
    public function redis($data1){

        $redis=new \redis();
        $redis->connect('127.0.0.1',6379);
        $id=$redis->incr('id');
        $hkey="id_$id";
        $lkey="aaa";

        $redis->hset($hkey,'id',$id);
        $redis->hset($hkey,'openid',$data1['openid']);
        $redis->hset($hkey,'nickname',$data1['nickname']);
        $redis->hset($hkey,'time',time());

        $redis->rpush($lkey,$hkey);
    }

//    //发消息
//    public function hello(){
//
//    }
}
