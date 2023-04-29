<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Models\CustomerLogin;
use App\Models\Order;
use App\Models\BillingDetails;
use App\Models\OrderProduct;
use App\Models\customerpasswordreset;
use App\Models\CustomerEmailVerify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\customerpasswordresetnotification;
use Auth;
use PDF;

class CustomerController extends Controller
{
    public function customer_profile(){
        return view('frontend.customer_profile');
    }

    public function customer_profile_update(Request $request){
        if($request->password == ''){
            if($request->photo == ''){
                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                ]);
                return back();
            }
            else{
                $uploaded_file = $request->photo;
                $extension = $uploaded_file->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id().'.'.$extension;
                Image::make($uploaded_file)->save(public_path('uploads/customer/'.$file_name));

                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back();
            }
        }
        else {
            if($request->photo == ''){
                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                ]);
                return back();
            }
            else{
                $uploaded_file = $request->photo;
                $extension = $uploaded_file->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id().'.'.$extension;
                Image::make($uploaded_file)->save(public_path('uploads/customer/'.$file_name));

                CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'country'=>$request->country,
                    'phone'=>$request->phone,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back();
            }
        }
    }

    public function my_order(){
        $myorders = Order::where('customer_id',Auth::guard('customerlogin')->id())->get();
        return view('frontend.my_order',compact('myorders'));
    }

    public function download_invoice($order_id){
        $order_info = Order::find($order_id);
        $billing_info = BillingDetails::where('order_id',$order_info->order_id)->get();
        $order_product = OrderProduct::where('order_id',$order_info->order_id)->get();
        $invoice = PDF::loadView('Invoice.download_invoice', [
            'order_info'=>$order_info,
            'billing_info'=>$billing_info,
            'order_product'=>$order_product,
        ]);
        return $invoice->download('invoice.pdf');
    }

    public function password_reset_req_form(){
        return view('password_reset.password_reset');
    }
    public function password_reset_req_send(Request $request){
        $customer_email = CustomerLogin::where('email',$request->email)->firstOrFail();
        customerpasswordreset::where('customer_id',$customer_email->id)->delete();

        $customer_info = customerpasswordreset::create([
            'customer_id'=>$customer_email->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);
        
        Notification::send($customer_email, new customerpasswordresetnotification($customer_info));
        return back()->with('req.send','we have send you a password reset link! please check your email');
    }
    public function customer_password_reset_form($token){
        return view('password_reset.password_reset_form',[
            'token'=>$token,
        ]);
    }
    public function password_reset_confirm(Request $request){
        $customer = customerpasswordreset::where('token', $request->token)->firstOrFail();
            CustomerLogin::find($customer->customer_id)->update([
                'password'=>bcrypt($request->password),
            ]);
            $customer->delete();
            return back()->with('success', 'password reset successfully');
        
    }

    public function customer_email_verify($token){
        $customer = CustomerEmailVerify::where('token',$token)->firstOrFail();
        CustomerLogin::find($customer->customer_id)->update([
            'email_verified_at'=>Carbon::now()->format('Y-m-d'),
        ]);
        $customer->delete();
        return back()->with('verify', 'Email Verification Success');
    }
    
}
