<?php

namespace App\Http\Controllers\admin;

use App\am_companies;
use App\am_product;
use App\am_stockin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ac_stockin extends Controller
{
    public function add(Request $request){
        $stockin=new am_stockin();
        $stockin->date=$request->date;
        $stockin->vehicleno=$request->vehicleno;
        $stockin->gatepass=$request->gatepass;
        $stockin->drivername=$request->drivername;
        $stockin->save();
        return redirect('/stockin/details/'.$stockin->id);
    }
    public function getOne($id){
        return am_stockin::find($id);
    }
    public function getAll(){
        $open=am_stockin::where('closed',false)->first();
        if($open)
            return redirect('/stockin/details/'.$open->id);
        else{
            $stockin=am_stockin::paginate(10);
            return view('admin.list.stockin')->with('stockin',$stockin);
        }
    }
    public function delete(Request $request){
        am_stockin::where('id',$request->id)->delete();
        return redirect('/stockin')->with([
            'type'=>'info',
            'message'=>'Stock in has been deleted Successfully'
        ]);
    }
    private function updateProduct($productcode,$quantity){
        $stock=am_product::where('code',$productcode)->first()->stock;
        $stock+=$quantity;
        am_product::where('code',$productcode)->update([
            'stock'=>$stock
        ]);
    }
    public function edit($id){
        return view('admin.edit.stockin')->with('stockin',$this->getOne($id));
    }
    public function close(Request $request){
        $stockin=$this->getOne($request->id);
        foreach($stockin->details as $detail){
            $this->updateProduct($detail->productcode,$detail->quantity);
        }
        $stockin->closed=true;
        $stockin->save();
        return redirect('/stockin/details/'.$stockin->id)->with([
            'type'=>'info',
            'message'=>'Stock in has been closed '
        ]);
    }
    public function details($id){
        return view('admin.list.stockindetails')->with([
            'stockin'=>$this->getOne($id),
            'products'=>am_product::select(['code','companyid'])->get(),
            'companies'=>am_companies::select(['id','name'])->get()
        ]);
    }
    public function update(Request $request){
        $stockin=$this->getOne($request->id);
        $stockin->date=$request->date;
        $stockin->vehicleno=$request->vehicleno;
        $stockin->gatepass=$request->gatepass;
        $stockin->drivername=$request->drivername;
        $stockin->save();
        return redirect('/stockin')->with([
            'type'=>'info',
            'message'=>'Stockin has been updated Successfully'
        ]);
    }
}
