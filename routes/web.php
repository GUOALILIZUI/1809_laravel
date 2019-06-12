<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
//    echo phpinfo();

});
Route::get('mongo1','Mongo\MongoController@mongo1');
Route::get('mongo2','Mongo\MongoController@mongo2');
Route::get('mongo3','Mongo\MongoController@mongo3');
Route::get('chat','Mongo\MongoController@chat');
Route::get('chat1','Mongo\MongoController@chat1');

//基本路由
//Route::get('order1',function(){
//   echo 39427;
//});
//
////路由映射控制器
//Route::get('order2',"OrderController@index");
//
////显示视图
//Route::get('order3',function(){
//    return view('order');
//});
//
////路由判断+重定向
//Route::get('order4/{id}',function($id){
//    if($id<3){
//        return redirect('http://ww.baidu.com');
//    }else{
//        return view('order');
//    }
//});

//创建控制器
//php artisan make:controller 控制器名;

//控制器传参数
//Route::get('order5',("OrderController@show"));
//
//// 前缀
//Route::prefix('admin')->group(function(){
//   Route::get('order9',function(){
//       echo 123;
//   }) ;
//    //辅助函数url
//    Route::get('order10','OrderController@msg');
//});
//
//Route::get('form1',function(){
//    return view('zhouyi.ce');
//});
//Route::post('form2','OrderController@doadd');
//
//
//Route::get('select1',function(){
//   return view('zhouyi.show');
//});
//Route::get('select2','ShowController@select');
//Route::post('insert','ShowController@insert');
//Route::get('list','ShowController@list');
//Route::post('del','ShowController@del');
//Route::get('update','ShowController@update');
//Route::post('upd','ShowController@upd');
//Route::post('ufield','ShowController@ufield');




