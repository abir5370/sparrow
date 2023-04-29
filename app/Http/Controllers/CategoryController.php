<?php

namespace App\Http\Controllers;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;
use auth;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function category_index(){
        $categorys = Category::all();
        $trash_categorys = Category::onlyTrashed()->get();
        return view('admin.category.category',compact('categorys','trash_categorys'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'image'=>'required'
        ]);
        $id = Category::insertGetId([
                'name'=>$request->name,
                'icon'=>$request->icon,
                'added_by'=>Auth::id(),
                'created_at'=>Carbon::now(),
        ]);
        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $file_name = $id.'.'.$extension;
        $img = Image::make($image)->resize(300, 200)->save(public_path('uploads/category/'.$file_name));

        Category::find($id)->update([
            'image'=>$file_name,
        ]);
        return back()->with('insert', 'category insert success');
    }
    public function edit($category_id){
        $category = Category::find($category_id);
        return view('admin.category.edit',compact('category'));
    }
    public function update(Request $request){
        if($request->image == ''){
                 Category::find($request->category_id)->update([
                'name'=>$request->name,
            ]);
            return back();
        }
        else{
            $image_delete = Category::where('id',$request->category_id)->first()->image;
            $delete_form = public_path('uploads/category/'.$image_delete);
            unlink($delete_form);
            

            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $file_name = $request->category_id.'.'.$extension;
            $img = Image::make($image)->resize(300, 200)->save(public_path('uploads/category/'.$file_name));

            Category::find($request->category_id)->update([
                'name'=>$request->name,
                'image'=>$file_name,
            ]);
            return back();
        }
    }
    public function category_destroy($category_id){
        $category = Category::find($category_id);
        $category->delete();
        return back()->with('delete', 'category deleted');
    }
    public function category_hard_destroy($category_id){
        $image = Category::onlyTrashed()->where('id', $category_id)->first()->image;
        $delete_form = public_path('uploads/category/'.$image);
        unlink($delete_form);

        $category = Category::onlyTrashed()->find($category_id);
        $category->forceDelete();
        return back()->with('hard_delete', 'category deleted');
    }
    public function restore($category_id){
        $restore = Category::onlyTrashed()->find($category_id);
        $restore->restore();
        return back()->with('success', 'category restore');
    }
}
