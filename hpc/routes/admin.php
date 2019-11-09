<?php

Route::get('/admin','admin\ac_home@getData');
Route::post('/updateself','admin\ac_home@updateSelf');

Route::get('/users','admin\ac_user@getAll');
//Route::get('/user/{id}','admin\ac_user@getOne');
Route::get('/user/edit/{id}','admin\ac_user@edit');
Route::post('/user/add','admin\ac_user@add');
Route::post('/user/delete','admin\ac_user@delete');
Route::post('/user/update','admin\ac_user@update');
Route::post('/user/resetPassword','admin\ac_user@resetPassword');

Route::get('/repositories','admin\ac_repository@getAll');
//Route::get('/repository/{id}','admin\ac_repository@getOne');
Route::get('/repository/edit/{id}','admin\ac_repository@edit');
Route::post('/repository/add','admin\ac_repository@add');
Route::post('/repository/delete','admin\ac_repository@delete');
Route::post('/repository/update','admin\ac_repository@update');

Route::get('/companies','admin\ac_company@getAll');
//Route::get('/company/{id}','admin\ac_company@getOne');
Route::get('/company/edit/{id}','admin\ac_company@edit');
Route::post('/company/add','admin\ac_company@add');
Route::post('/company/delete','admin\ac_company@delete');
Route::post('/company/update','admin\ac_company@update');

Route::get('/products','admin\ac_product@getAll');
//Route::get('/product/{id}','admin\ac_product@getOne');
Route::get('/product/edit/{id}','admin\ac_product@edit');
Route::post('/product/add','admin\ac_product@add');
Route::post('/product/delete','admin\ac_product@delete');
Route::post('/product/update','admin\ac_product@update');


Route::get('/stockin','admin\ac_stockin@getAll');
Route::get('/stockin/{id}','admin\ac_stockin@getOne');
Route::get('/stockin/edit/{id}','admin\ac_stockin@edit');
Route::get('/stockin/details/{id}','admin\ac_stockin@details');
Route::post('/stockin/add','admin\ac_stockin@add');
Route::post('/stockin/close','admin\ac_stockin@close');
Route::post('/stockin/delete','admin\ac_stockin@delete');
Route::post('/stockin/update','admin\ac_stockin@update');


//Route::get('/stockin/{id}','admin\ac_stockin@getOne');
Route::get('/stockindetails/edit/{id}','admin\ac_stockindetails@edit');
Route::post('/stockindetails/add','admin\ac_stockindetails@add');
Route::post('/stockindetails/delete','admin\ac_stockindetails@delete');
Route::post('/stockindetails/update','admin\ac_stockindetails@update');


Route::get('/customers','admin\ac_customer@getAll');
Route::get('/customer/{id}/details','admin\ac_customer@getDetails');
Route::get('/customer/edit/{id}','admin\ac_customer@edit');
Route::post('/customer/add','admin\ac_customer@add');
Route::post('/customer/delete','admin\ac_customer@delete');
Route::post('/customer/update','admin\ac_customer@update');
Route::post('/customer/{id}/clearDetails','admin\ac_customer@clearDetails');


Route::get('/payments','admin\ac_payment@getAll');
Route::post('/payment/add','admin\ac_payment@add');
Route::post('/payment/delete','admin\ac_payment@delete');

Route::get('/biltihistory','admin\ac_biltihistory@getAll');
Route::get('/biltihistory/edit/{number}','admin\ac_biltihistory@edit');
Route::post('/biltihistory/add','admin\ac_biltihistory@add');
Route::post('/biltihistory/delete','admin\ac_biltihistory@delete');
Route::post('/biltihistory/update','admin\ac_biltihistory@update');


Route::get('/sale/{id}/details','admin\ac_home@getSale');
Route::post('/sale/search','admin\ac_home@saleSearch');


