<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Goods;
use App\Models\Cart;
use App\Models\Order;

class CartController extends Controller
{

    //显示视图
    public function cart(){
        //查询购物车的所有数据
        $l_id=session('l_id');
        $cartWhere=[
            'l_id'=>$l_id,
            'status'=>1
        ];
        $cartInfo=DB::table('goods')
            ->join('cart','goods.goods_id','=','cart.goods_id')
            ->where($cartWhere)
            ->get();

        //查询人气推荐数据
        $goodsInfo=Goods::orderBy('goods_num','desc')->limit(4)->get();

        return view('cart.cart',['cartInfo'=>$cartInfo,'goodsInfo'=>$goodsInfo]);
    }

    //逻辑删除
    public function del(Request $request){
        $goods_id=$request->input('goods_id');
        $cart_id=$request->input('cart_id');

        $delWhere=[
            'cart_id'=>$cart_id
        ];
        $delInfo=[
            'buy_num'=>0,
            'status'=>2,
            'create_time'=>time()
        ];

        $res=Cart::where($delWhere)->update($delInfo);
        if($res){
            $aar=array(
                'status'=>1,
                'msg'=>'删除成功'
            );
            return $aar;
        }else{
            $aar=array(
                'status'=>0,
                'msg'=>'删除失败'
            );
            return $aar;
        }


    }

    //加减号入数据库
    public function showNum(Request $request){
        $type=$request->input('type');
        $goods_id=$request->input('goods_id');


        //根据id查询数据
        $cartInfo=Cart::where('goods_id',$goods_id)->first();
        $goodsInfo=Goods::where('goods_id',$goods_id)->first();

        //取出库存和购买数量
        $goods_num=$goodsInfo->goods_num;
        $buy_num=$cartInfo->buy_num;

       //判断库存
        if($type==1){
            if($buy_num+1<=$goods_num){
                $numInfo=[
                    'buy_num'=>$buy_num+1
                ];
                $data=Cart::where('goods_id',$goods_id)->update($numInfo);

            }else{
                    $aar=array(
                        'status'=>0,
                        'msg'=>'超过了最大库存'
                    );
                    return $aar;

            }
        }else{
            $numInfo=[
                'buy_num'=>$buy_num-1,

            ];
            Cart::where('goods_id',$goods_id)->update($numInfo);

        }

    }

    //批量删除
    public function allDel(Request $request){
        $goods_id=$request->input('goods_id');
        $l_id=session('l_id');
        $where=[
            'l_id'=>$l_id,
            'goods_id'=>$goods_id
        ];
        $goodsId=[
            'buy_num'=>0,
            'status'=>2,
            'create_time'=>time()
        ];
       $res1= Cart::whereIn('goods_id',$goods_id)->update($goodsId);
        if($res1){
            $aar=array(
                'status'=>1,
                'msg'=>'删除成功'
            );
            return $aar;
        }else{
            $aar=array(
                'status'=>0,
                'msg'=>'删除失败'
            );
            return $aar;
        }

    }

    //文本框
    public function textBox(Request $request){
        $goods_id=$request->input('goods_id');
        $buy_num=$request->input('buy_num');

        //根据id查询数据
        $cartInfo=Cart::where('goods_id',$goods_id)->first();
        $goodsInfo=Goods::where('goods_id',$goods_id)->first();

        //取出库存
        $goods_num=$goodsInfo->goods_num;

        if($buy_num<=$goods_num){
            $numInfo=[
                'buy_num'=>$buy_num
            ];
            $data=Cart::where('goods_id',$goods_id)->update($numInfo);

        }else{
            $aar=array(
                'status'=>0,
                'msg'=>'超过了最大库存'
            );
            return $aar;

        }



    }

    //总金额
    public function Payment(Request $request){
        $goods_id=$request->input('goods_id');
//        print_r($goods_id);exit;
        $price=$request->input('price');
        $price=trim($price,'￥');

        //验证商品是否为空
        if(empty($goods_id)){
            $aar=array(
                'status'=>0,
                'msg'=>'商品不能空'
            );
            return $aar;
        }else{
            //有数据就取session 用来判断是否登录
            $l_id=session('l_id');
            if(empty($l_id)){
                //未登录跳转登录页面
                $aar=array(
                    'status'=>2,
                    'msg'=>'请先登录'
                );
                return $aar;
            }else{
                //判断库存
                $data=[];
                $info=DB::table('goods')
                    ->join('cart','goods.goods_id','=','cart.goods_id')
                    ->whereIn('goods.goods_id',$goods_id)
                    ->get();
//                print_r($info);exit;
                foreach ($info as $k=>$v){
                    if($v->buy_num>$v->goods_num){
                        $data[]=$v->goods_name;
                    }
                }
                if($data){
                    $name=implode(',',$data);
                    $aar=array(
                        'status'=>0,
                        'msg'=>$name.'商品不能空'
                    );
                    return $aar;
                }
                //生成订单号
                $order_number=date("YmdHis".time()).rand(1000,9999);
                $l_id=session('l_id');
                $orderInfo=[
                    'order_number'=>$order_number,
                    'l_id'=>$l_id,
                    'order_amount'=>$price,
                    'ctime'=>time()
                ];
                $res=Order::insert($orderInfo);
                $orderData=Order::where('order_number',$order_number)->get(['order_id']);
//                print_r($orderData);exit;
                $order_id=$orderData[0]->order_id;
                foreach ($info as $v){
                    $all2=[
                        'order_id'=>$orderData[0]->order_id,
                        'l_id'=>$l_id,
                        'order_number'=>$order_number,
                        'goods_id'=>$v->goods_id,
                        'buy_number'=>$v->buy_num,
                        'goods_name'=>$v->goods_name,
                        'goods_selfprice'=>$v->goods_selfprice,
                        'goods_img'=>$v->goods_img,
                        'goods_status'=>1,
                        'ctime'=>time()

                    ];
                    $res33=DB::table('order_detail')->insert($all2);
                }

                $res1=Cart::whereIn('goods_id',$goods_id)->where('l_id',$l_id)->update(['status'=>2,'buy_num'=>0]);

                if($res1){
                    $aar=array(
                        'status'=>1,
                        'order_id'=>$order_id,
                    );
                    return $aar;
                }


            }
        }

    }
}
