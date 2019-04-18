<?php

namespace App\Http\Controllers\Payment;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Goods;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderDetail;



class PaymentController extends Controller
{
    //订单表显示视图
    public function payAll(Request $request){
        $order_id=$request->input('order_id');
//        print_r($order_id);exit;

        $order_id=explode(',',$order_id);
        $where=[
            'goods_status'=>1
        ];
        $arr=DB::table('order_detail')
            ->join('order','order.order_id','=','order_detail.order_id')
            ->where($where)
            ->whereIn('order_detail.order_id',$order_id)
            ->get();
        return view('payment.payall',['arr'=>$arr]);
    }


    //接口
    public function showIndex(){
        return view("payment.showindex");
}

    //
    public function pay(Request $request){
        $order_id=$request->input('order_id');

        $data=Order::where(['order_id'=>$order_id])->get();
        $l_id=session('l_id');

        $arr=DB::table('login')->where('l_id',$l_id)->get();
        //print_r($data);exit;
        return view("payment.pay",['data'=>$data,'arr'=>$arr]);
    }

    //
    public function sell(Request $request){
        $arr=$request->input();
//        print_r($arr);exit;
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $arr['WIDout_trade_no'];
        //订单名称，必填
        $subject = $arr['WIDsubject'];
        //付款金额，必填
        $total_amount = $arr['WIDtotal_amount'];
        //商品描述，可空
        $body = $arr['WIDbody'];
        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

          $configInfo=app_path()."/extend/alipay/config.php";
            $config=require_once($configInfo) ;
//            print_r($config);
        $payResponse = new \AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return ;

    }
    //异步
    public function tell(Request $request){
        $arr=$_REQUEST;
        $str=var_export($arr,true);
        file_put_contents("/tmp/alipay.log",$str,FILE_APPEND);
        $configPath=app_path()."/extend/alipay/config.php";
        $config=require_once($configPath);
        $alipaySevice=new \AlipayTradeService($config);
        $result=$alipaySevice->check($arr);
        if($result) {//验证成功
            $out_trade_no = $_POST['out_trade_no'];
            $order_amount = $_POST['total_amount'];
            if($arr['trade_status'] == 'TRADE_FINISHED') {


            }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                $orderWhere=[
                    'order_number'=>$out_trade_no,
                    'order_amount'=>$order_amount
                ];
                $orderInfo=Order::where($orderWhere)->first();
                if($orderInfo){
                    //修改订单表的状态
                    $orderUpdate=DB::table('order')->where('order_number',$out_trade_no)->update(['order_status'=>2]);
                    //修改订单详情表的数据
                    $orderDetailUpdate=DB::table('order_detail')->where('order_number',$out_trade_no)->update(['goods_status'=>2]);
                    //查询出商品订单详情表的数据
                    $orderDetailInfo=DB::table('order_detail')->where('order_number',$out_trade_no)->get();
//                    var_dump();
                    foreach($orderDetailInfo as $k=>$v){
                        $goodsInfo=DB::table('goods')->where('goods_id',$v[0]->goods_id)->first();
                        $goods_num=$goodsInfo['goods_num']-$v[0]->buy_number;
                        $goodsUpdate=DB::table('goods')->where('goods_id',$v[0]->goods_id)->update(['goods_num'=>$goods_num]);
                    }
                }
            }
            echo "success";		//请不要修改或删除
        }else {
            //验证失败
            echo "fail";	//请不要修改或删除
        }
    }
    //同步
    public function result(){
        $where=[
            'goods_up'=>1
        ];
        $arr=Goods::where($where)->orderBy('goods_salenum','asc')->limit(4)->get();
        return view('payment.paysucc',['arr'=>$arr]);
    }
}
