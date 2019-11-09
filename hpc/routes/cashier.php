<?php

Route::get('/cashier','cashier\cc_home@index');
Route::get('/cashier/checkout','cashier\cc_home@getCheckOutView');
Route::post('cashier/sales/save','cashier\cc_home@saveSale');
Route::get('/cashier/printData','cashier\cc_home@getPrintData');
