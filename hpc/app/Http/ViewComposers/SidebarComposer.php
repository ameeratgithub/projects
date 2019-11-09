<?php
/**
 * Created by PhpStorm.
 * User: Ameer Hamza
 * Date: 10/9/2017
 * Time: 3:49 PM
 */

namespace App\Http\ViewComposers;


use App\am_biltihistory;
use App\am_companies;
use App\am_customer;

use App\am_product;
use App\am_repository;
use App\am_stockin;
use App\am_user;
use Illuminate\View\View;

class SidebarComposer
{
public function compose(View $view){
    $customers=am_customer::all();
    $tpayments=0;
    foreach($customers as $customer){
        if($customer->payments->last()){
            $tpayments++;
        }
    }
    $view->with([
        'tusers'=>am_user::count(),
        'trepositories'=>am_repository::count(),
        'tcompanies'=>am_companies::count(),
        'tproducts'=>am_product::count(),
        'tstockin'=>am_stockin::count(),
        'tcustomers'=>am_customer::count(),
        'tpayments'=>$tpayments,
        'tbiltihistory'=>am_biltihistory::count(),
    ]);
}
}