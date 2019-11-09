<?php

namespace App\Http\Controllers\admin;

use App\am_user;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ac_user extends Controller
{
    public function add(Request $request){
        $user=new am_user();
        if($this->userExists($request->email))
            return redirect('/users')->with([
                'type'=>'error',
                'message'=>'Email already exists...!'
            ]);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->role=$request->role;
        $user->password=Hash::make('pak123');
        $user->phone=$request->phone;
        $user->address=$request->address;
        try{
            $user->save();
        }
        catch(QueryException $ex){
            $errorcode=$ex->errorInfo[1];
            $message='';
            if($errorcode==1062)
                $message="Email or Phone Number already exists. Please try another";
            else
                $message="Another error ocurred";
            return redirect('/users')->with([
                'type'=>'error',
                'message'=>$message
            ]);
        }
        return redirect('/users')->with([
            'type'=>'info',
            'message'=>'User has been added successfully...!'
        ]);
    }
    public function getOne($id){
        return am_user::find($id);
    }
    public function userExists($email){
        return am_user::where('email',$email)->first()?true:false;
    }
    public function getAll(){
        $users=am_user::where('id','>',2)->paginate(10);
        return view('admin.list.users')->with('users',$users);
    }
    public function delete(Request $request){
        am_user::where('id',$request->userid)->delete();
        return redirect('/users')->with([
            'type'=>'info',
            'message'=>'User has been deleted successfully...!'
        ]);
    }
    public function edit($id){
        return view('admin.edit.user')->with('user',$this->getOne($id));
    }
    public function update(Request $request){
        $user=$this->getOne($request->userid);
        $user->name=$request->name;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->role=$request->role;
        $user->save();
        return redirect('/users')->with([
            'type'=>'info',
            'message'=>'User has been updated successfully'
        ]);
    }
    public function resetPassword(Request $request){
        am_user::where('id',$request->userid)->update([
            'password'=>Hash::make('pak123')
        ]);
        return redirect('/users')->with([
            'type'=>'info',
            'message'=>'Password has been reset successfully'
        ]);
    }

}