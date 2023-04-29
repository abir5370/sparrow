<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Thumbnail;
use App\Models\inventory;
use App\Models\size;
use App\Models\cart;
use App\Models\Coupon;
use App\Models\OrderProduct;
use App\Models\subcategory;
use Carbon\Carbon;

use Auth;
use Cookie;
use Arr;

class FrontendController extends Controller
{
    public function index(){
        //cookies
        $resent_viewed_product = json_decode(Cookie::get('recent_view'),true);
        
        if($resent_viewed_product == null){
            $resent_viewed_product = [];
            $after_unique = array_unique($resent_viewed_product);
        }
        else{
            $after_unique = array_unique($resent_viewed_product);
        }
        $resent_viewed_product = Product::find($after_unique);

    

        $categories = Category::all();
        $products = Product::paginate('4');
        $best_selling_product = OrderProduct::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->orderBy('quantity','Desc')
        ->havingRaw('sum >= 1')
        ->get();
        return view('frontend.index',compact('categories','products','best_selling_product','resent_viewed_product'));
    } 

    public function category_product($category_id){
        $sub_categorys = subcategory::where('category_id',$category_id)->get();
        $find_product = Product::where('category_id', $category_id)->paginate('4');
        return view('frontend.category_product',[
            'find_product'=>$find_product,
            'sub_categorys'=>$sub_categorys,
        ]);
    }


    public function details($slug){
        $product_info = Product::where('slug',$slug)->get();
        $related_product = Product::where('category_id',$product_info->first()->category_id)->where('id','!=',$product_info->first()->id)->get();
        $thamnails = Thumbnail::where('product_id',$product_info->first()->id)->get();

        $reviews = OrderProduct::where('product_id',$product_info->first()->id)->whereNotNull('review')->get();
        $total_review = OrderProduct::where('product_id',$product_info->first()->id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id',$product_info->first()->id)->whereNotNull('review')->sum('star');

        $availabe_colors = inventory::where('product_id', $product_info->first()->id)
        ->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')->get();
        $sizes = size::all();

        //cookies
        $product_id = $product_info->first()->id;
        $al = Cookie::get('recent_view');
        if(!$al){
            $al = "[]";
        }
        $all_info = json_decode($al,true);
        $all_info = Arr::prepend($all_info,$product_id);
        $recent_product_id = json_encode($all_info);
        Cookie::queue('recent_view',$recent_product_id, 1000);

        return view('frontend.details',compact('product_info','thamnails','availabe_colors','sizes','related_product','reviews','total_review','total_star'));
    }
    public function getsize(Request $request){

        $sizes = inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->get();
        $str = '';

        foreach($sizes as $size){
            $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="size_id" id="'.$size->rel_to_size->id.'" value="'.$size->rel_to_size->id.'">
                    <label class="form-option-label" for="'.$size->rel_to_size->id.'">'.$size->rel_to_size->size_name.'</label>
                    </div>';
        }
        echo $str;
       
    }
    public function customer_register_login(){
        return view('frontend.customer_reg_log');
    }
    public function cart_view(Request $request){
        $coupon = $request->coupon;
        $message = null;
        $type = null;

        if($coupon == ''){
            $discount = 0;
        }
        else {
            if(Coupon::where('coupon_name', $coupon)->exists()){
                if(Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon)->first()->expire){
                    $discount = 0;
                    $message = 'Coupon Code Expired!';
                }
                else{
                    $discount = Coupon::where('coupon_name', $coupon)->first()->discount;
                    $type = Coupon::where('coupon_name', $coupon)->first()->type;
                    
                } 
            }
            else{
                $discount = 0;
                $message = 'Invalid Coupon Code!';
            }
        }
        $carts = cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart',[
            'carts'=>$carts,
            'message'=>$message,
            'discount'=>$discount,
            'type'=>$type,
        ]);
    }
    
    //review

    public function review_store(Request $request){
        OrderProduct::where('customer_id',$request->customer_id)->where('product_id',$request->product_id)->update([
            'review'=>$request->review,
            'star'=>$request->star,
        ]);
        return back();
    }
}









