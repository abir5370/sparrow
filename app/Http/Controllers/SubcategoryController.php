<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\subcategory;
use Intervention\Image\ImageManagerStatic as Image;
use auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function subcategory() {
        $categories = Category::all();
        $subcategories = subcategory::all();
        return view('admin.subcategory.subcategory',compact('categories','subcategories'));
    }
    public function subcategory_store(Request $request){
        $id = subcategory::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
        ]);
        $subcategory_img = $request->subcategory_image;
        $extension = $subcategory_img->getClientOriginalExtension();
        $file_name = Str::random(3).rand(300,900).'.'.$extension;
        $img = Image::make($subcategory_img)->resize(300,400)->save(public_path('uploads/subcategory/'.$file_name));

        subcategory::find($id)->update([
            'subcategory_image'=>$file_name,
        
        ]);
        return back();
            
    }
    public function subcategory_edit($subcategory_id){
        $categories = Category::all();
        $subcategorys = Subcategory::find($subcategory_id);
        return view('admin.subcategory.subcategory_edit',compact('subcategorys','categories'));
    }

    public function subcategory_update(Request $request){
        if($request->subcategory_image == ''){
            Subcategory::find($request->id)->update([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
            ]);
            return back()->with('success','subcategory updated');
        }
        else{
            $image_delete = subcategory::where('id',$request->id)->first()->subcategory_image;
            $delete_form = public_path('uploads/subcategory/'.$image_delete);
            unlink($delete_form);

            $uploaded_file = $request->subcategory_image;
            $extension = $uploaded_file->getClientOriginalExtension();
            $file_name = Str::random(3).rand(100,900).'.'.$extension;
            $image = Image::make($uploaded_file)->save(public_path('uploads/subcategory/'.$file_name));

            subcategory::find($request->id)->update([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
                'subcategory_image'=>$file_name,
            ]);
        }
        return back()->with('success','subcategory updated');
    }
    public function subcategory_delete($delete_id){

        $image = subcategory::where('id',$delete_id)->first()->subcategory_image;
        $delete_form = public_path('uploads/subcategory/'.$image);
        unlink($delete_form);

        $delete = subcategory::find($delete_id);
        $delete->delete();
        return back();
    }
}
