<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function check(Request $request){
        //return $request->input();
        //Validate requests
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
       ]);
       $userInfo = Admin::where('email','=', $request->email)->first();

       if(!$userInfo){
           return back()->with('fail','We do not recognize your email address');
       }
     else{
           //check password
          if(Hash::check($request->password, $userInfo->password)){
             $request->session()->put('LoggedUser', $userInfo->id);
              return redirect('admin/dashboard');
           }
           else{
               return back()->with('fail','Incorrect password');
           }
       }
   }

   public function logout(){
    if(session()->has('LoggedUser')){
        session()->pull('LoggedUser');
        return redirect('/auth/login');
    }
}
public function dashboard(){
    $data = ['LoggedUserInfo'=>Admin::where('id','=', session('LoggedUser'))->first()];
    return view('admin.dashboard', $data);
   // admin/dashboard
}

} 