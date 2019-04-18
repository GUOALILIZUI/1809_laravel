<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function select()
    {
        $sql = "select * from cate";
        $arr = DB::select($sql);
//        print_r($arr);exit;
        return view('zhouyi.show', ['arr' => $arr]);
    }

    public function insert(Request $request)
    {
        $arr=$request->input();
//        print_r($arr);exit;
        $res=Db::table('sele')->insert($arr);
        if($res){
            return "1";
        }else{
            return "2";
        }
    }

    public function list(){
        $arr=DB::table('sele')
            ->join('cate','sele.c_id','=','cate.c_id')
            ->where('status','=','1')
            ->select()
            ->paginate(5);
        return view('zhouyi.list',['arr'=>$arr]);
    }

    public function del(Request $request){
//        echo 111;exit;
        $id=$request->input('id');
//        print_r($id);exit;
        $arr="update sele set status=2 where id=$id";
        $res=DB::update($arr);
        if($res){
            return "1";
        }else{
            return "2";
        }
    }

    public function update(Request $request){
        $id=$request->input('id');
        $arr=DB::table('sele')->where('id','=',$id)->first();
        $sql="select * from cate";
        $cate=Db::select($sql);
        return view('zhouyi.update',['arr'=>$arr,'cate'=>$cate]);
    }

    public function upd(Request $request){
        $data=$request->input();
//        print_r($data);exit;
        $res=DB::table('sele')->where('id','=',$data['id'])->update($data);
        if($res){
            return 1;
        }else{
            return 2;
        }

    }

    public function ufield(Request $request){
        $value=$request->input('value');
        $field=$request->input('field');
        $id=$request->input('id');
        $data=[
            $field=>$value
        ];

        $res=DB::table('sele')
            ->where('id','=',$id)
            ->update($data);
        if($res){
            return 1;
        }else{
            return 2;
        }


    }
}