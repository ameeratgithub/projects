<?php

namespace App\Http\Controllers\cashier;

use App\am_companies;
use App\am_customer;
use App\am_payment;
use App\am_product;
use App\am_sale;
use App\am_saledetail;
use App\am_saleoncash;
use App\am_saleoncredit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class cc_home extends Controller
{
    public function index(){
        return view('cashier.home')->with([
            'products'=>am_product::select(['code','description','stock','companyid','reorderrate','quantity','type'])->get(),
            'companies'=>am_companies::select(['id','name'])->get(),
        ]);
    }
    public function getCheckOutView(){
        $customers=am_customer::select(['id','name','phone'])->get();
        $customers=$this->getAmountRemainedAll($customers);
        return view('cashier.checkout')->with([
            'customers'=>$customers
        ]);
    }
    private function getAmountRemainedAll($customers){
        $updatedCustomers=[];
        foreach($customers as $customer){
            $updatedcustomer=[
                'id'=>$customer->id,
                'name'=>$customer->name,
                'phone'=>$customer->phone,
            ];
            $payment=$customer->payments->last();
            if($payment)
            $updatedcustomer["remained"]=$payment->remained;
            array_push($updatedCustomers,$updatedcustomer);
        }
        return json_encode($updatedCustomers);
    }
    private function getAmountRemainedOne($customerid){
        $customer=am_customer::find($customerid);
        if($customer->payments->last())
            return $customer->payments->last()->remained;
        return 0;
    }
    private function deductStock($productcode,$quantity){
        $product=am_product::where('code',$productcode)->first();
        if($product){
            am_product::where('code',$productcode)->update([
                'stock'=>$product->stock-$quantity
            ]);
        }
    }
    public function saveSale(Request $request)
    {
        $sale=json_decode($request->input('sale'));
        $method=$request->method;
        $msale=new am_sale();
        $msale->totalamount=$sale->grandTotal;
        $msale->save();
        foreach($sale->cartItems as $cartItem){
            $saleDetail=new am_saledetail();
            $saleDetail->saleid=$msale->id;
            $saleDetail->productcode=$cartItem->code;
            $saleDetail->quantity=$cartItem->quantity;
            $saleDetail->rate=$cartItem->rate;
            $saleDetail->total=$cartItem->total;
            $saleDetail->save();
            $this->deductStock($saleDetail->productcode,$saleDetail->quantity);
        }
        if($method=="credit"){
            $saleOnCredit=new am_saleoncredit();
            $saleOnCredit->invoiceid=$msale->id;
            $saleOnCredit->customerid=$request->customerid;
            $saleOnCredit->save();
            $msale['lastremaining']=$this->getLastPayment($request->customerid);
            $msale['totalremaining']=$sale->remaining+$this->getLastPayment($request->customerid);
            $payment=new am_payment();
            $payment->customerid=$request->customerid;
            $payment->paid=$sale->paid?$sale->paid:0;
            $payment->purchased=$sale->grandTotal;
            $payment->remained=$this->getAmountRemainedOne($request->customerid)+$sale->remaining;

            $payment->save();
            $msale['billtype']='On Credit';
            $msale['paid']=$sale->paid;
            $msale['remaining']=$sale->remaining;
            $customer=am_customer::find($request->customerid);
            $msale["customername"]=$customer->name;
            $msale["customerphone"]=$customer->phone;

        }
        else if($method=="cash"){
            $saleOnCash=new am_saleoncash();
            $saleOnCash->salesid=$msale->id;
            $saleOnCash->customername=$request->cname;
            $saleOnCash->phone=$request->cphone;
            $saleOnCash->save();
            $msale["customername"]=$request->cname;
            $msale["customerphone"]=$request->cphone;
            $msale['billtype']='On Cash';
            $ccustomer=am_customer::where('phone',$request->cphone)->first();
            if($ccustomer)
            {
                $customerid=$ccustomer->id;
                $msale['totalremaining']=$this->getLastPayment($customerid);
            }
            else $msale['totalremaining']=0;
        }
        Session::put('printData',$msale);
        return redirect('/cashier/printData');
    }
    public function getPrintData(){
        return view('cashier.printpreview');
    }
    private function getLastPayment($customerId){
        $customer= am_payment::where('customerid',$customerId)->orderBy('id','desc')->first();
        if($customer){
            return $customer->remained;
        }
        return 0;
    }
}
