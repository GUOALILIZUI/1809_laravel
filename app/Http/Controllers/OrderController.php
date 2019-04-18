<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //路由映射控制器
    public function index(){
        echo 555;
    }
    //控制器传参数
    public function show(Request $request){
        $arr=$request->input();
//        print_r($arr);
//        return view('order');
        $url=url('admin/msg');
        return redirect($url);
    }

    //url
    public function msg(){
        echo 6;
    }

    public function doadd(){
        echo 789;
    }

    public function demo(){
        return view('zhouyi.demo');
    }





}
