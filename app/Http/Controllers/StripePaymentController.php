<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\cart;
use App\Models\Country;
use App\Models\City;
use App\Models\Order;
use App\Models\BillingDetails;
use App\Models\OrderProduct;
use App\Models\Inventory;
use Carbon\Carbon;
use Str;
use Auth;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $data = session('data');

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" =>$request->total*100,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
      
        $order_id = '#'.Str::upper(Str::random(3)).'-'.rand(99999999,1000000000);

        Order::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'sub_total'=>$data['sub_total'],
            'total'=>$data['sub_total'] + $data['charge'],
            'discount'=>$data['discount'],
            'charge'=>$data['charge'],
            'payment_method'=>$data['payment_method'],
            'created_at'=>Carbon::now(),
        ]);

        BillingDetails::insert([
            'order_id'=>$order_id,
            'customer_id'=>Auth::guard('customerlogin')->id(),
            'name'=>$data['name'],
            'email'=>$data['email'],
            'company'=>$data['company'],
            'mobile'=>$data['mobile'],
            'address'=>$data['address'],
            'country_id'=>$data['country_id'],
            'city_id'=>$data['city_id'],
            'zip'=>$data['zip'],
            'notes'=>$data['notes'],
            'created_at'=>Carbon::now(),
        ]);

        $carts = cart::where('customer_id',Auth::guard('customerlogin')->id())->get();

        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'product_id'=>$cart->product_id,
                'price'=>$cart->rel_to_product->after_discount,
                'color_id'=>$cart->color_id,
                'size_id'=>$cart->size_id,
                'quantity'=>$cart->quantity,
                'created_at'=>Carbon::now(),
            ]);
            Inventory::where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->decrement('quantity',$cart->quantity);
        }
        // send invoice mail
         Mail::to($data['email'])->send(new InvoiceMail($order_id));


        //clear cart after order
        Cart::where('customer_id',Auth::guard('customerlogin')->id())->delete();

        $abc = substr($order_id, 1,13);
        return redirect()->route('order.success',$abc)->with('success','adaa');
    }
}