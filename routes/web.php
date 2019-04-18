<?php

Route::get('index','IndexController@index');
Route::get('register','IndexController@register');
Route::get('login','IndexController@login');
Route::post('add','IndexController@add');
Route::post('log','IndexController@log');
Route::post('t1','IndexController@t1');
Route::any('like','IndexController@adddo');
Route::any('itoKen','IndexController@itoKen');
Route::any('ishow','IndexController@ishow');
Route::any('accessToken','IndexController@accessToken');
Route::any('hello','IndexController@hello');


Route::get('demo','OrderController@demo');
Route::any('all','Detail\DetailController@all');
Route::any('catedo','Detail\DetailController@catedo');
Route::any('content','Content\ContentController@content');
Route::any('half','Content\ContentController@half');
//Route::any('buynumber','Content\ContentController@buynumber');
Route::any('cart','Cart\CartController@cart');
Route::any('del','Cart\CartController@del');
Route::any('showNum','Cart\CartController@showNum');
Route::any('allDel','Cart\CartController@allDel');
Route::any('textbox','Cart\CartController@textBox');
Route::any('payment','Cart\CartController@payment');
Route::any('payAll','Payment\PaymentController@payAll');
Route::any('address','Address\AddressController@address');
Route::any('addreAdd','Address\AddressController@addreAdd');
Route::any('addrDel','Address\AddressController@addrDel');
Route::any('addreDo','Address\AddressController@addreDo');
Route::any('defa','Address\AddressController@defa');
Route::any('addp','Address\AddressController@addp');
Route::any('addUpd','Address\AddressController@addUpd');
Route::any('cord','Address\AddressController@Cord');
Route::any('showIndex','Payment\PaymentController@showIndex');
Route::any('pay','Payment\PaymentController@pay');
Route::any('sell','Payment\PaymentController@sell');
Route::any('tell','Payment\PaymentController@tell');
Route::any('result','Payment\PaymentController@result');
Route::any('paysucc','Payment\PaymentController@paySucc');


Route::any('check','WeiXin\WeiXinController@check');
Route::any('redis','WeiXin\WeiXinController@redis');
Route::any('Attention',"Weixin\AttentionController@Attention");
Route::any('accessYou',"Weixin\WeiXinController@accessToken");
//


Route::any('page','User\PageController@page');
Route::any('token','User\PageController@token');
Route::any('wshow','User\PageController@wshow');


Route::any('DimeTest','Dimension\DimenSionController@DimeTest');
Route::any('wstatus','Dimension\DimenSionController@wstatus');
Route::any('checksign','Dimension\DimenSionController@checksign');
Route::any('timSuccess','Dimension\DimenSionController@timSuccess');
Route::any('accessDime','Dimension\DimenSionController@accessToken');




//二维码支付
Route::get('NativePay','Native\WeiXinPayController@NativePay');
Route::post('payBack','Native\WeiXinPayController@payBack');






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

//Route::get('/', function () {
//    return view('welcome');
//});

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




