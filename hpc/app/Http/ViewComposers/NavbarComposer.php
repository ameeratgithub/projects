<?php
/**
 * Created by PhpStorm.
 * User: Ameer Hamza
 * Date: 10/22/2017
 * Time: 5:10 PM
 */

namespace App\Http\ViewComposers;


use App\am_self;
use Illuminate\View\View;

class NavbarComposer
{
public function compose(View $view){
    $view->with('self',am_self::find(1));
}
}