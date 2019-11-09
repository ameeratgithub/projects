<?php

namespace App\Http\Controllers;

use App\am_user;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class uc_auth extends Controller
{
    public function login(Request $request){
        $authenticated=Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        if(!$authenticated)
            return back()->with([
                'type'=>'error',
                'message'=>'Incorrect Email or password'
            ]);
        am_user::where('id',Auth::id())->update([
            'lastlogin'=>Carbon::now()
        ]);
        if(Auth::user()->role==="admin")
            return redirect('/');
        else
            return redirect('/cashier');

    }
    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }
    public function changePassword(Request $request){
        $oldpassword=$request->oldpassword;
        $newpassword=$request->newpassword;
        if(!Hash::check($oldpassword,Auth::user()->password))
            return back()->with([
               'type'=>'error',
                'message'=>'Please enter correct old password...!'
            ]);
        if(am_user::where('id',Auth::id())->update([
            'password'=>Hash::make($newpassword)
        ]))
        return back()->with([
           'type'=>'info',
            'message'=>'Your password has been changed successfully...!'
        ]);
        else
            return back()->with([
                'type'=>'error',
                'message'=>'Error occured while changing your password...!'
            ]);
    }
}
