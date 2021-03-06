<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class UsersController extends Controller
{
    function getLogin(){
      return view('users.login');
    }

    function postLogin(Request $request){
      $this->validate($request,[
        'username'=>'required',
        'password'=>'required']);

      if(Auth::attempt(['username'=>$request->username,
        'password'=>$request->password]))
      {
        return redirect('');
      }
      else
      {
        return redirect('login')->with('alert','Login fail. Please try again');
      }
    }

    function getSignup(){
      return view('users.signup');
    }

    function postSignup(Request $request){
      $this->validate($request,[
        'username'=>'required',
        'email'=>'required',
        'fullname'=>'required',
        'password'=>'required',
        'password_confirmation'=>'required|same:password']);

      $user = new User;
      $user->username = $request->username;
      $user->email = $request->email;
      $user->fullname = $request->fullname;
      $user->password = bcrypt($request->password);
      $user->purpose = $request->purpose;
      $user->save();
      Auth::login($user);

      return redirect('')->with('alert', 'Signup successfully.');
    }

    function logout(){
      Auth::logout();
      return redirect('');
    }
}
