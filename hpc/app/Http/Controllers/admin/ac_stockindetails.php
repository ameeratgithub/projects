<?php

namespace App\Http\Controllers\admin;

use App\am_product;
use App\am_stockin;
use App\am_stockindetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ac_stockindetails extends Controller
{
    public function add(Request $request){
        $stockindetails=new am_stockindetail();
        $stockindetails->stockinid=$request->stockinid;
        $stockindetails->productcode=$request->productcode;
        $stockindetails->quantity=$request->quantity;
        try{
            $stockindetails->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Product in the stock already exists. Please try another";
            else if($errorcode==1452)
                $message="Product doesn't exist. Please try another";
            else
                $message=$ex->getMessage();
            return redirect('/stockin/details/'.$stockindetails->stockinid)->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/stockin/details/'.$stockindetails->stockinid);
    }

    public function getOne($id){
        return am_stockindetail::find($id);
    }
    public function delete(Request $request){
        am_stockindetail::find($request->id)->delete();
        return redirect('/stockin/details/'.$request->stockinid)->with([
            'type'=>'info',
            'message'=>'Stockin detail has been deleted Successfully'
        ]);
    }
    public function update(Request $request){
        $stockindetails=$this->getOne($request->id);
        $stockindetails->productcode=$request->productcode;
        $stockindetails->quantity=$request->quantity;
        try{
            $stockindetails->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Product in the stock already exists. Please try another";
            else
                $message="Another error occured";
            return redirect('/stockin/details/'.$stockindetails->stockinid)->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/stockin/details/'.$stockindetails->stockinid)->with([
            'type'=>'info',
            'message'=>'Stockin detail has been updated Successfully'
        ]);
    }
}
