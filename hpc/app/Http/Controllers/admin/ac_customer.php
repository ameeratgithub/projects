<?php

namespace App\Http\Controllers\admin;

use App\am_customer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ac_customer extends Controller
{
    public function add(Request $request){
        $customer=new am_customer();
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->address=$request->address;
        $customer->registeredby=2;
        try{
            $customer->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Phone number of customer already exists. Please try another";
            return redirect('/customers')->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/customers')->with([
            'type'=>'info',
            'message'=>'Customer has been added successfully...!'
        ]);
    }
    public function getOne($id){
        return am_customer::find($id);
    }
    public function getDetails($id){
        return view('admin.list.customerdetails')->with([
            'customer'=>am_customer::find($id)
        ]);
    }
    public function getAll(){
        $customers=am_customer::paginate(10);
        return view('admin.list.customers')->with('customers',$customers);
    }
    public function delete(Request $request){
        $customer=am_customer::find($request->id);
        if($customer->payments->last())
            if($customer->payments->last()->remained>0)
                return redirect('/customers')->with([
                    'type'=>'error',
                    'message'=>"You can't delete customer having remained amount...!"
                ]);
        $customer->delete();
        return redirect('/customer/'.$request->id.'/details');
    }
    public function clearDetails($id){
        $customer=am_customer::find($id);
        //$customer->payments->delete();
        foreach($customer->payments as $payment){

            $payment->where('id',$payment->id)->delete();
        }
        return redirect('/customer/'.$id.'/details');
    }
    public function edit($id){
        return view('admin.edit.customer')->with('customer',$this->getOne($id));
    }
    public function update(Request $request){
        $customer=$this->getOne($request->id);
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->address=$request->address;
        $customer->updatedby=2;
        try{
            $customer->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Phone number of customer already exists. Please try another";
            return redirect('/customers')->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/customers')->with([
            'type'=>'info',
            'message'=>'Customer has been updated successfully...!'
        ]);
    }
}
