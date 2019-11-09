<?php

namespace App\Http\Controllers\admin;

use App\am_product;
use App\am_sale;
use App\am_self;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ac_home extends Controller
{
    public function getData(){
        $reorderables=am_product::whereRaw('products.stock<=products.reorderrate')->get();
      return view('admin.home')->with([
          'reorderableproducts'=>$reorderables
      ]);
    }
   public function updateSelf(Request $request){
       am_self::where('id',1)->update([
          'ptclno'=>$request->selfptclno,
           'mobileno'=>$request->selfmobileno,
           'address'=>$request->selfaddress,
       ]);
       return redirect('/admin');
   }
    public function saleSearch(Request $request){
        return redirect('/sale/'.$request->invoiceid.'/details');
    }
    public function getSale($id){
        return view('admin.list.saledetails')->with([
            'invoice'=>am_sale::find($id)
        ]);
    }
}
