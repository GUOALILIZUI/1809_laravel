<?php

namespace App\Http\Controllers\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Goods;
use App\Models\Address;

class AddressController extends Controller
{
    //收货地址视图
    public function address(){
        $data=Address::where('address_status',1)->get();
        return view('address.address',['data'=>$data]);
    }

    //收货地址添加视图
    public function addreAdd(){
        return view('address.writeaddr');
    }

    //收货地址添加
    public function addreDo(Request $request){
        $data=$request->input();


        $l_id=session('l_id');
        if(empty($l_id)){
            //未登录跳转登录页面
            $aar=array(
                'status'=>2,
                'msg'=>'请先登录'
            );
            return $aar;
        }else{
            //判断是否为默认收货地址
            if($data['is_default']=='true'){
                $data['is_default']=2;
                $data=[
                    'l_id'=>$l_id,
                    'site_name'=>$data['site_name'],
                    'site_tel'=>$data['site_tel'],
                    'all_site'=>$data['all_site'],
                    'site_address'=>$data['site_address'],
                    'is_default'=>$data['is_default'],
                    'ctime'=>time(),
                ];
                $dataDO=[
                    'is_default'=>1
                ];
                Address::where(['l_id'=>$l_id])->update($dataDO);
                $res3=Address::insert($data);
//            $res3=Address::where([])
                if($res3){
                    $aar=array(
                        'status'=>1,
                        'msg'=>'保存成功'
                    );
                    return $aar;
                }else{
                    $aar=array(
                        'status'=>0,
                        'msg'=>'保存失败'
                    );
                    return $aar;
                }
            }else{
                $data['is_default']=1;
                $data=[
                    'l_id'=>$l_id,
                    'site_name'=>$data['site_name'],
                    'site_tel'=>$data['site_tel'],
                    'all_site'=>$data['all_site'],
                    'site_address'=>$data['site_address'],
                    'is_default'=>$data['is_default'],
                    'ctime'=>time(),
                ];
                $res3=Address::insert($data);
//            $res3=Address::where([])
                if($res3){
                    $aar=array(
                        'status'=>1,
                        'msg'=>'保存成功'
                    );
                    return $aar;
                }else{
                    $aar=array(
                        'status'=>0,
                        'msg'=>'保存失败'
                    );
                    return $aar;
                }
            }

        }
    }

    //收获地址删除
    public function addrDel(Request $request){
        $site_id=$request->input('site_id');
        $addressWhere=[
            'site_id'=>$site_id
        ];
        $addressInfo=[
            'address_status'=>2
        ];
        $res1=Address::where($addressWhere)->update($addressInfo);
        if($res1){
            $msg=array(
                'code'=>1,
                'font'=>'删除成功'
            );
            return $msg;
        }else{
            $msg=array(
                'code'=>0,
                'font'=>'删除失败'
            );
            return $msg;
        }

    }

    //设置默认地址
    public function defa(Request $request){
        $site_id=$request->input('site_id');
        $l_id=session('l_id');
        $data=[
            'is_default'=>1
        ];
        Address::where(['l_id'=>$l_id])->update($data);
        $res2=Address::where(['site_id'=>$site_id])->update(['is_default'=>2]);
        if($res2){
            $msg=array(
                'status'=>1,
                'msg'=>'设置成功'
            );
            return $msg;
        }else{
            $msg=array(
                'status'=>0,
                'msg'=>'设置失败'
            );
            return $msg;
        }
    }

    //修改地址视图
    public function addp(Request $request){
        $site_id=$request->input('site_id');
        $arr=Address::where(['site_id'=>$site_id])->get();
        return view('address.writedo',['arr'=>$arr]);

    }

    //修改地址
    public function addUpd(Request $request){
        $data=$request->input();

        $site_id=$data['site_id'];
        $res1=Address::where(['site_id'=>$site_id])->update($data);
        if($res1){
            $msg=array(
                'status'=>1,
                'msg'=>'修改成功'
            );
            return $msg;
        }else{
            $msg=array(
                'status'=>0,
                'msg'=>'修改失败'
            );
            return $msg;
        }

    }

    //我的潮购视图
    public function Cord(){
        $data=DB::table('order_detail')->where('goods_status',1)->get();
        return view('address.buyrecord',['data'=>$data]);
    }
}
