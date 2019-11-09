<?php

namespace App\Http\Controllers\admin;

use App\am_repository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ac_repository extends Controller
{
    public function add(Request $request){
        $repository=new am_repository();
        $repository->number=$request->number;
        try{
            $repository->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Repository already exists. Please try another number";
            return redirect('/repositories')->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/repositories')->with([
            'type'=>'info',
            'message'=>'Repository has been added Successfully'
        ]);
    }
    public function getOne($number){
        return am_repository::where('number',$number)->first();
    }
    public function getAll(){
        $repositories=am_repository::paginate(10);
        return view('admin.list.repositories')->with('repositories',$repositories);
    }
    public function delete(Request $request){
        am_repository::where('number',$request->number)->delete();
        return redirect('/repositories')->with([
            'type'=>'info',
            'message'=>'Repository has been deleted successfully'
        ]);
    }
    public function edit($number){
        return view('admin.edit.repository')->with('repository',$this->getOne($number));
    }
    public function update(Request $request){
        am_repository::where('number',$request->oldnumber)->update([
            'number'=>$request->newnumber
        ]);
        return redirect('/repositories')->with([
            'type'=>'info',
            'message'=>'Repository has been updated successfully'
        ]);
    }
}
