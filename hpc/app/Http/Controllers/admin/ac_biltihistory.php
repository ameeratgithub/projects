<?php

namespace App\Http\Controllers\admin;

use App\am_biltihistory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ac_biltihistory extends Controller
{
    public function add(Request $request){
        $biltihistory=new am_biltihistory();
        $biltihistory->number=$request->number;
        $biltihistory->adda=$request->adda;
        $biltihistory->invoiceid=$request->invoiceid;
        try{
            $biltihistory->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Bilti number already exists. Please try another";
            else
                $message="Another error occured...!";
            return redirect('/biltihistory')->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/biltihistory')->with([
            'type'=>'info',
            'message'=>'Bilti Record has been added Successfully'
        ]);
    }
    public function getOne($number){
        return am_biltihistory::find($number);
    }
    public function getAll(){
        $biltihistory=am_biltihistory::paginate(10);
        return view('admin.list.biltihistory')->with('biltihistory',$biltihistory);
    }
    public function delete(Request $request){
        am_biltihistory::where('number',$request->number)->delete();
        return redirect('/biltihistory')->with([
            'type'=>'info',
            'message'=>'Bilti Record has been deleted Successfully'
        ]);
    }
    public function edit($number){
        return view('admin.edit.biltihistory')->with('biltihistory',$this->getOne($number));
    }
    public function update(Request $request){
        $biltihistory=$this->getOne($request->oldnumber);
        $biltihistory->number=$request->newnumber;
        $biltihistory->adda=$request->adda;
        $biltihistory->invoiceid=$request->invoiceid;
        try{
            $biltihistory->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Bilti Number already exists. Please try another";
            return redirect('/biltihistory')->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/biltihistory')->with([
            'type'=>'info',
            'message'=>'Bilti Record has been updated Successfully'
        ]);
    }
}
