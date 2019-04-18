<?php

namespace App\Http\Controllers\Detail;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Goods;
use App\Models\Cart;



class DetailController extends Controller
{
    //显示视图
    public function all(){
        $where=[
            'pid'=>0
        ];
        $nWhere=[
            'goods_up'=>1
        ];
        $data=DB::table('category')->where($where)->get();
        $arr=DB::table('goods')->where($nWhere)->get();
        return view('detail.all',['data'=>$data,'arr'=>$arr]);
    }

    //数据
    public function cateDo(Request $request){

        $arr=array();
        $cate_id=$request->input('cate_id');
        $goodsInfo=Goods::where('goods_up',1)->orderBy('goods_salenum','desc');
        if($cate_id){
            $cateInfo=Category::get();
            $cate_id=$this->getCateId($cateInfo,$cate_id);
            $goodsInfo=$goodsInfo->whereIn('cate_id',$cate_id);
        }






        $goodsAll=$goodsInfo->get();
        $view= view('detail.goodshow',['goodsAll'=>$goodsAll]);
        $content=response($view)->getContent();
        $arr['info']=$content;
        return $arr;

    }


    //处理分类 递归
    public function getCateId($cateInfo, $pid){
        static $cateId = [];
        foreach ($cateInfo as $k => $v) {
            if ($v['pid'] == $pid) {
                $cateId[] = $v['cate_id'];
                $this->getCateId($cateInfo, $v['cate_id']);
            }
        }
        return $cateId;
    }




}
