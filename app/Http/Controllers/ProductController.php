<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\subcategory;
use Str;
use App\Models\Product;
use App\Models\color;
use App\Models\size;
use App\Models\Thumbnail;
use App\Models\Inventory;
use Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function product(){
        $categories = Category::all();
        $subcategories = subcategory::all();
        return view('admin.product.index',compact('categories'));
    }
    public function getsubcategory(Request $request){
        $subcategories = subcategory::where('category_id',$request->category)->get();

        $str = '<option value="">--select category--</option>';
        foreach($subcategories as $subcategori){
            $str .= '<option value="'.$subcategori->id.'">'.$subcategori->subcategory_name.'</option>';
        }
        echo $str;
    }
    public function product_store(Request $request){
        $slug = Str::lower(str_replace(' ','-',$request->product_name)).'-'.rand(0,100000000);

        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'product_name'=>$request->product_name,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=>$request->price - ($request->price*$request->discount/100),
            'brand'=>$request->brand,
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'slug'=>$slug,
        ]);

        $product_preview = $request->preview;
        $extension = $product_preview->getClientOriginalExtension();
        $file_name = Str::random(3).rand(100,999).'.'.$extension;
        $img = Image::make($product_preview)->save(public_path('uploads/product/preview/'.$file_name));

        Product::find($product_id)->update([
            'preview'=>$file_name,
        ]);

        foreach($request->thumbnail as $thumbnail){
            $extension = $thumbnail->getClientOriginalExtension();
            $file_name = Str::random(3).rand(100,999).'.'.$extension;
            $img2 = Image::make($thumbnail)->save(public_path('uploads/product/thumbnail/'.$file_name));
            Thumbnail::insert([
                'product_id'=>$product_id,
                'thumbnail'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);

        }

        return back()->with('success','product insert successfully');
    }
    public function product_list(){
        $products = Product::all();
        return view('admin.product.product-list',compact('products'));
    }
    public function product_variation(){
        $sizes = size::all();
        $colors = color::all();
        return view('admin.product.variation',compact('colors','sizes'));
    }
    public function variation_store(Request $request){
        if($request->btn == 1){
            color::insert([
                'color_name'=>$request->color_name,
                'color_code'=>$request->color_code,
            ]);
            return back();
        }
        else{
            size::insert([
                'size_name'=>$request->size_name,
            ]);
            return back();
        }
        
    }
    public function product_inventory($inventory_id){
        $colors = color::all();
        $sizes = size::all();
        $inventories = Inventory::where('product_id',$inventory_id)->get();
        $products = product::find($inventory_id);
        return view('admin.product.inventory',compact('colors','sizes','products','inventories'));
    }
    public function inventory_store(Request $request){
        inventory::insert([
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
        ]);
        return back();
    }
}
