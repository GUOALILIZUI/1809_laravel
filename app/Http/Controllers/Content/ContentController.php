<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Goods;
use App\Models\Cart;




class ContentController extends Controller
{
    //显示视图
    public function content(Request $request){
        $l_id=session('l_id');
        $goods_id=$request->input('goods_id');
        /*
        if($l_id){
            $info=DB::table('login')->where('l_id',$l_id)->first();
            print_r($info);exit;
            $openid=$info->openid;
            $data1=[
                'goods_id'=>$goods_id,
                'openid'=>$openid,
                'time'=>time()
            ];
            $this->hreDis($data1);

        }else{
            $data1=[
                'goods_id'=>$goods_id,
                'time'=>time()
            ];
            $this->hreDis($data1);
        }
        */

        //接收id
        //根据id查询数据
        $sql="select * from goods where goods_id=$goods_id";
        $arr=DB::select($sql);
        //做小购物车++
        $where=[
            'l_id'=>$l_id
        ];
        $numb=Cart::where($where)->pluck('buy_num')->toArray();
        $numb1=array_sum($numb);
        return view('content.content',['arr'=>$arr,'numb1'=>$numb1]);
    }

    //数据
    public function half(Request $request){
        //接收传过来的值
        $goods_id=$request->input('goods_id');
        $buy_num=$request->input('buy_num');
        //取出session
        $l_id=session('l_id');
        if(empty($l_id)){
            $aar=array(
                'status'=>2,
                'msg'=>'请先登录'
            );
            return $aar;
        }

        //根据ID查询一条数据
        $count=Goods::where('goods_id',$goods_id)->count();
        $goodsInfo=Goods::where('goods_id',$goods_id)->first();
        $cartInfo=Cart::where('goods_id',$goods_id)->first();
        if(empty($cartInfo)){
            //判断商品是否存在
            if($count<=0){
                $aar=array(
                    'status'=>0,
                    'msg'=>'商品不存在'
                );
                return $aar;exit;
            }
            //判断库存
            if($goodsInfo['goods_num']<$buy_num){
                $aar=array(
                    'status'=>0,
                    'msg'=>'您选的数量大于库存量了喔'
                );
                return $aar;exit;
            }
            //入库
            $arr=[
                'goods_id'=>$goods_id,
                'l_id'=>$l_id,
                'buy_num'=>$buy_num,
                'status'=>1,
                'create_time'=>time()
            ];
            $info=Cart::insert($arr);

            //做小购物车++
            $l_id=session('l_id');
            $where=[
                'l_id'=>$l_id
            ];
            $numb=Cart::where($where)->pluck('buy_num')->toArray();
            $numb1=array_sum($numb);



            $aar=array(
                'status'=>1,
                'msg'=>'加入购物车成功',
                'num'=>$numb1
            );
            return $aar;

        }else{
            $num=$cartInfo->buy_num;
            $cart_id=$cartInfo->cart_id;
            $number=$num+$buy_num;

            $updateWhere=[
                'cart_id'=>$cart_id
            ];
            $updataInfo=[
                'buy_num'=>$number
            ];
            $res=DB::table('cart')->where($updateWhere)->update($updataInfo);

            //做小购物车++
            $l_id=session('l_id');
            $where=[
                'l_id'=>$l_id,
                'status'=>1
            ];
            $allInfo=[
                'status'=>1
            ];
            Cart::where('goods_id',$goods_id)->update($allInfo);
            $numb=Cart::where($where)->pluck('buy_num')->toArray();
            $numb1=array_sum($numb);


            $aar=array(
                'status'=>1,
                'msg'=>'加入购物车成功',
                'num'=>$numb1

            );
            return $aar;
        }


    }

    //浏览记录存redis
    public function hreDis($data1){
        $hreDis=new \redis();
        $hreDis->connect('127.0.0.1',6379);
        $id=$hreDis->incr('id');
        $hkey="history_{$id}";
        $lkey="history";
        $l_id=session('l_id');

        if($l_id){
//            $hreDis->hset($hkey,'id',$id);
            $hreDis->hset($hkey,'goods_id',$data1['goods_id']);
            $hreDis->hset($hkey,'l_id',$l_id);
            $hreDis->hset($hkey,'openid',$data1['openid']);
            $hreDis->hset($hkey,'time',$data1['time']);
        }else{
//            $hreDis->hset($hkey,'id',$id);
            $hreDis->hset($hkey,'goods_id',$data1['goods_id']);
            $hreDis->hset($hkey,'time',$data1['time']);
        }
        $hreDis->rpush($lkey,$hkey);


    }

}
