<?php

namespace App\Http\Controllers\Dimension;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;



class DimenSionController extends Controller
{


    //access
    public function accessToken()
    {
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

    //二维码支付接口
    public function DimeTest(Request $request){
        $redis=new \redis();
        $redis->connect('127.0.0.1',6379);
        $id=$redis->incr('id');
        $l_id=session('l_id');
        $hkey="id_$id";
        $lkey="qq";
        $redis->hset($hkey,'id',$id);
        $redis->hset($hkey,'l_id',$l_id);
        $redis->rPush($lkey,$hkey);


        $url="https://api.mch.weixin.qq.com/pay/unifiedorder";
        $str=md5(time());
        $key="7c4a8d09ca3762af61e59520943AB26Q";
        $orderId=$request->input('order_number');
        //$orderId=$orderId.rand(1000,30000);
        $ip=$_SERVER['REMOTE_ADDR'];
        $notify_url="http://119.23.184.175/wstatus";
        $arr=array(
            'appid'=>"wxd5af665b240b75d4",
            'mch_id'=>"1500086022",
            'nonce_str'=>$str,
            'sign_type'=>"MD5",
            'body'=>"aadd",
            'out_trade_no'=>$orderId,
            'total_fee'=>1,
            'spbill_create_ip'=>$ip,
            'notify_url'=>$notify_url,
            'trade_type'=>"NATIVE",
        );
        //签名算法
        ksort($arr);
        $strParams=urldecode(http_build_query($arr));
        $strParams.="&key=$key";
        $endStr=md5($strParams);
        $arr['sign']=$endStr;

        $objUrl=new \url();
        $strJson=$objUrl->arrXml($arr);
        $info=$objUrl->sendPost($url,$strJson);
        $objXml=simplexml_load_string($info);
        $codeUrl=$objXml->code_url;
        return view('dimen.pay',['codeUrl'=>$codeUrl]);
    }

    //二维码支付验签
    public function wstatus(Request $request){
        $xml=file_get_contents("php://input");
        file_put_contents("/tmp/xml.log",$xml,FILE_APPEND);
        $arr=json_decode(json_encode(simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
        file_put_contents("/tmp/aaa.log",var_export($arr,true),FILE_APPEND);
        $sign=$arr['sign'];
        //$sign="aaa:$sign\n";
        unset($arr['sign']);
        $newsStr=$this->checksign($arr);
        $newsStr=strtoupper($newsStr);
        //$newsStr="bbb:{$newsStr}\n";
        if($sign==$newsStr){
            file_put_contents("/tmp/sign.log",$sign,FILE_APPEND);
            file_put_contents("/tmp/sign.log",$newsStr,FILE_APPEND);
            $order_number=$arr['out_trade_no'];
//            print_r($order_number);exit;

            DB::table('order')->where('order_number',$arr['out_trade_no'])->update(['pay_do'=>2,'order_status'=>2,'pay_status'=>2]);
            DB::table('order_detail')->where('order_number',$arr['out_trade_no'])->update(['pay_do'=>2,'goods_status'=>2]);


            $orderInfo=DB::table('order_detail')->where('order_number',$order_number)->get();

            foreach ($orderInfo as $k=>$v){
                $goods_name=$v->goods_name;
                $goods_selfprice=$v->goods_selfprice;
                $goods_status=$v->goods_status;
                $time=$v->ctime;
            }
            $time=date('Y-m-d H:i:s',$time);
//            if($goods_status==1){
                $accessToken = $this->accessToken();
                $tempUrl="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$accessToken";
                $arr=array(
                    "touser"=>"ofb0E1V3FgwNLIY7NYq9QTqYmh8c",
                    "template_id"=>"u_dibKg624P06Cb01m5-hPg022u5mYr8eV8rPRsGdt8",
                    "data"=>array(
                        "first"=>[
                            "value"=>"提示：恭喜你购买成功！",
                            "color"=>"#173177"
                        ],
                        "goods_name"=>[
                            "value"=>"商品：".$goods_name,
                            "color"=>"#173177"
                        ],
                        "self_price"=>[
                            "value"=>"价格：".$goods_selfprice,
                            "color">"#173177"

                        ],
                        "time"=>[
                            "value"=>"时间：".$time,
                            "color"=>"#173177"
                        ],
                        "remark"=>[
                            "value"=>"提示：欢迎再次购买！",
                            "color"=>"#173177"
                        ]
                    ),
                );
                $tempStr = json_encode($arr);
                $objUrl = new \url();
                $info = $objUrl->sendPost($tempUrl,$tempStr);
                var_dump($info);
//            }

        }
    }

    //
    private function checksign($arr){
        ksort($arr);
        $key="7c4a8d09ca3762af61e59520943AB26Q";
        $strParams=urldecode(http_build_query($arr));
        $strParams.="&key=$key";
        $endstr=md5($strParams);
        return $endstr;

    }
}
