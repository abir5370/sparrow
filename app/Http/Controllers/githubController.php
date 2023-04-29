<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLogin;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use Auth;

class githubController extends Controller
{
    public function github_redirect(){
        return Socialite::driver('github')->redirect();
    }
    public function github_callback(){
        $user = Socialite::driver('github')->user();

        if(customerlogin::where('email', $user->getEmail())->exists()){
            if(Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'abc@123'])) {
                return redirect('/');
            }
        }
        else{
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
