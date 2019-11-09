<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    if(!\Illuminate\Support\Facades\Auth::check())
        return redirect('/login');
    else{
        if(\Illuminate\Support\Facades\Auth::user()->role=="admin")
            return redirect('/admin');
        if(\Illuminate\Support\Facades\Auth::user()->role=="cashier")
            return redirect('/cashier');
    }
});
Route::get('/login',function(){
    if(\Illuminate\Support\Facades\Auth::check())
        return redirect('/');
   return view('auth.login');
});
Route::get('/check',function(\Illuminate\Http\Request $request){
    return view('test');
});
Route::post('/disabled',function(\Illuminate\Http\Request $request){
    return $request->disabled;
});
Route::post('/login',"uc_auth@login");
Route::post('/logout',"uc_auth@logout");

Route::post('/changepassword','uc_auth@changePassword')->middleware('auth');

Route::group(['middleware'=>['auth','authorization.admin']],function(){
    require_once "admin.php";
});
Route::group(['middleware'=>['auth','authorization.cashier']],function(){
    require_once "cashier.php";
});