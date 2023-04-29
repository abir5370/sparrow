<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Coupon;

class CuponController extends Controller
{
    public function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',compact('coupons'));
    }
    public function add_coupon(Request $request){
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'discount'=>$request->discount,
            'expire'=>$request->expire_date,
            'type'=>$request->type,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('coupon','Added Coupon!');
    }
    public function coupon_delete($coupon_id){
        Coupon::find($coupon_id)->delete();
        return back()->with('coupon_delete','Coupon Deleted!');
    }
}
