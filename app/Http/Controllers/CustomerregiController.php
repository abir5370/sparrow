<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLogin;
use App\Models\CustomerEmailVerify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\customerEmailNotification;
use Carbon\Carbon;

class CustomerregiController extends Controller
{
   public function customer_regi(Request $request){
    CustomerLogin::insert([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
        'created_at'=>Carbon::now(),
    ]);

    $customer = CustomerLogin::where('email',$request->email)->firstOrFail();
    $customer_info = CustomerEmailVerify::create([
        'customer_id'=>$customer->id,
        'token'=>uniqid(),
        'created_at'=>Carbon::now(),
    ]);
    Notification::send($customer, new customerEmailNotification($customer_info));
    return back()->withSuccess('We have sent you a varification email! Please check your email');

   }
}
