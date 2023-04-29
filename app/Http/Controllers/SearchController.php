<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;

class SearchController extends Controller
{
    public function search(Request $request){

        //search code
        $data = $request->all();

        $based_on = 'created_at';
        $order = 'DESC';

        if(!empty($data['short']) && $data['short'] != '' && $data['short'] != 'undefined'){
            if($data['short'] == 1 ){
                $based_on = 'product_name';
                $order = 'ASC';
            }
            elseif ($data['short'] ==2 ) {
                $based_on = 'product_name';
                $order = 'DESC';
            }
            elseif($data['short'] == 3){
                $based_on = 'after_discount';
                $order = 'ASC';
            }
            elseif($data['short'] == 4){
                $based_on = 'after_discount';
                $order = 'DESC';
            }
            else {
                $based_on = 'created_at';
                $order = 'DESC';
            }
        }

        $search_product = Product::where(function($q) use ($data){
            if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $q->where('product_name','like','%'.$data['q'].'%');
                    $q->orwhere('long_desp','like','%'.$data['q'].'%');
                });
            }
            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                $q->where('category_id', $data['category_id']);
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                $q->whereHas('rel_to_inventories',function($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                        $q->whereHas('rel_to_color',function($q) use ($data){
                            $q->where('colors.id',$data['color_id']);
                        });
                    }
                    if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                        $q->whereHas('rel_to_size',function($q) use ($data){
                            $q->where('sizes.id',$data['size_id']);
                        });
                    }
                });
            }
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $q->whereBetween('after_discount', [$data['min'],$data['max']]);
            }
        })->OrderBy($based_on, $order)->get();


        $all_category = Category::all();
        $all_color = Color::all();
        $all_size = Size::all();
        return view('frontend.search',[
            'search_product'=>$search_product,
            'all_category'=>$all_category,
            'all_color'=>$all_color,
            'all_size'=>$all_size,
        ]);
    }
}
