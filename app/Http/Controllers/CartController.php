<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\cart;
use App\Models\Inventory;

class CartController extends Controller
{
   public function add_cart(Request $request){
    if(Auth::guard('customerlogin')->id()){
      $request->validate([
         'color_id'=>'required',
         'size_id'=>'required',
         'quantity'=>'required',
      ]);

      $quantity = Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->first()->quantity;

      if($quantity >= $request->quantity){
         if(cart::where('product_id',$request->product_id)->where('customer_id',Auth::guard('customerlogin')->id())->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){
            cart::where('product_id',$request->product_id)->where('customer_id',Auth::guard('customerlogin')->id())->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);
            return back()->with('success','Cart update Successfull');
         }
         else{
            cart::insert([
               'customer_id'=>Auth::guard('customerlogin')->id(),
               'product_id'=>$request->product_id,
               'color_id'=>$request->color_id,
               'size_id'=>$request->size_id,
               'quantity'=>$request->quantity,
               'created_at'=>Carbon::now(),
            ]);
            return back()->with('success','Cart Added Successfull');
         }
      }
      else{
         return back()->with('stock','out of stock, total stock:'.$quantity);
      }
      
    }
    else {
         return redirect()->route('customer.reglogin')->with('Login', 'Please Login To Add Card');
    }
   }

   public function cart_remove($cart_id){
      cart::find($cart_id)->delete();
      return back();
   }
   public function cart_update(Request $request){
      $carts = $request->all();
      foreach($carts['quantity'] as $cart_id=>$quantity){
        cart::find($cart_id)->update([
            'quantity'=>$quantity,
        ]);
      }
      return back();
   }
}
