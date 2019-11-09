<?php

namespace App\Http\Controllers\admin;

use App\am_companies;
use App\am_product;
use App\am_repository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ac_product extends Controller
{
    public function add(Request $request){
        $product=new am_product();
        $product->code=$request->code;
        $product->description=$request->description;
        $product->companyid=$request->companyid;
        $product->type=$request->type;
        $product->quantity=$request->quantity;
        $product->reorderrate=$request->reorderrate;
        $product->repositoryno=$request->repositoryno;
        try{
            $product->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Product code already exists. Please try another code";
            else $message=$ex->getMessage();
            return redirect('/products')->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/products')->with([
            'type'=>'info',
            'message'=>'Product has been added successfully'
        ]);
    }
    public function getOne($code){
        return am_product::where('code',$code)->first();
    }
    public function getCompanies($products){
        foreach($products as $product){
            $product['company']=$product->company->name;
        }
        return $products;
    }
    public function getAll(){
        $products=am_product::paginate(10);
        $repositories=am_repository::all();
        $companies=collect(am_companies::select(['id','name'])->orderBy('name')->get());
        return view('admin.list.products')->with([
            'products'=>$products,
            'companies'=>json_encode($companies),
            'repositories'=>$repositories
        ]);
    }
    public function delete(Request $request){
        if(am_product::where('code',$request->code)->delete())
        return redirect('/products')->with([
            'type'=>'info',
            'message'=>'Product has been deleted successfully'
        ]);
        return redirect('/products')->with([
            'type'=>'error',
            'message'=>'Error in deletion...@'
        ]);
    }
    public function edit($code){
        $repositories=am_repository::all();
        $companies=collect(am_companies::select(['id','name'])->orderBy('name')->get());
        return view('admin.edit.product')->with([
            'product'=>$this->getOne($code),
            'companies'=>json_encode($companies),
            'repositories'=>$repositories
        ]);
    }
    public function update(Request $request){

            try{
                if(am_product::where('code',$request->oldcode)->update([
                    'code'=>$request->newcode,
                    'description'=>$request->description,
                    'companyid'=>$request->companyid,
                    'repositoryno'=>$request->repositoryno,
                    'type'=>$request->type,
                    'quantity'=>$request->quantity,
                    'reorderrate'=>$request->reorderrate,
                ]))
                    return redirect('/products')->with([
                        'type'=>'info',
                        'message'=>'Product has been updated successfully'
                    ]);
            }
            catch(QueryException $ex){
                $errorcode=$ex->errorInfo[1];
                $message='';
                if($errorcode==1062)
                    $message="Product code already exists. Please try another code";
                else $message=$ex->getMessage();
                return redirect('/products')->with([
                    'type'=>'error',
                    'message'=>$message
                ]);
            }

    }
}
