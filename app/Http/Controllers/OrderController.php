<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;

class OrderController extends Controller
{
    public function orders(){
        $orders = Order::all();
        return view('admin.orders.order',compact('orders'));
    }

    public function orders_status(Request $request){
        $after_explode = explode(',', $request->status);
        Order::where('order_id',$after_explode[0])->update([
            'status'=>$after_explode[1],
        ]);
        return back();
    }
}
