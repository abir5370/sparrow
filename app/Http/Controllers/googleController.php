<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLogin;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use Auth;

class googleController extends Controller
{
    public function google_redirect(){
        return Socialite::driver('google')->redirect();
    }
    public function google_callback(){
        $user = Socialite::driver('google')->user();

        if(CustomerLogin::where('email',$user->getEmail())->exists()){
            if(Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'abc@123'])) {
                return redirect('/');
            }
        }
        else {
            CustomerLogin::insert([
                'name'=> $user->getName(),
                'email'=>$user->getEmail(),
                'password'=>bcrypt('abc@123'),
                'created_at'=>Carbon::now(),
            ]);  
            if(Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'abc@123'])) {
                return redirect('/');
            }
        }
        
        
    }
}
