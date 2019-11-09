<?php

namespace App\Http\Controllers\admin;

use App\am_customer;
use App\am_payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ac_payment extends Controller
{
    public function add(Request $request){
        $payment=new am_payment();
        $payment->customerid=$request->customerid;
        $lastRemaining=$this->getLastPayment($request->customerid);
        if($request->type=="paid"){
            if($lastRemaining==0){
                return redirect('/payments')->with([
                    'type'=>'error',
                    'message'=>"Previous payment not exists. So you can't use 'Paid' method."
                ]);
            }
            if($lastRemaining<$request->amount){
                return redirect('/payments')->with([
                    'type'=>'error',
                    'message'=>"Your remained amount is less than your entered amount. Please enter correct amount"
                ]);
            }
            $payment->remained=$lastRemaining-$request->amount;
            $payment->paid=$request->amount;
            $payment->method=$request->method;
           if($request->resource)
            $payment->resource=$request->resource;
            else
                $payment->resource="Direct";
        }
        else if($request->type=="purchased"){
            $payment->purchased=$request->amount;
            $payment->method="Credit";
            $payment->remained=$lastRemaining+$request->amount;
        }
        $payment->save();
        if($payment->remained==0)
            return redirect('/customer/'.$payment->customerid.'/details')->with([
                'exportconfirmation'=>true
            ]);
        return redirect('/payments')->with([
            'type'=>'info',
            'message'=>'Payment has been added Successfully'
        ]);
    }
    public function getLastPayment($customerId){
        $customer= am_payment::where('customerid',$customerId)->orderBy('id','desc')->first();
        if($customer){
            return $customer->remained;
        }
        return 0;
    }
    public function getOne($id){
        return am_payment::find($id);
    }
    public function getAll(){
        return view('admin.list.payments')->with([
            'customers'=>am_customer::select(['id','name','phone'])->get()
        ]);
    }
    public function delete(Request $request){
        $this->getOne($request->id)->delete();
        return redirect('/payments')->with([
            'type'=>'info',
            'message'=>'Payment has been deleted Successfully'
        ]);
    }
}
