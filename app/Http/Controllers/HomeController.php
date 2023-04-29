<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function user(){
        $users = User::where('id','!=',auth::id())->get();
        return view('admin.user.user',compact('users'));
    }
    public function destroy($user_id){
        $user = User::find($user_id);
        $user->delete();
        return back()->with('success','user deleted');
    }
    public function profile(){
        return view('admin.user.profile');
    }
    public function profile_update(Request $request){
        $user = User::find(auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return back()->with('success','profile updated!');
    }
    public function update_password(Request $request){
        $this->validate($request,[
            'old_password'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required'
        ]);
        if(Hash::check($request->old_password, auth::user()->password)){
            User::find(auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('password', 'password updated');
        }
        else{
            return back()->with('failed','wrong old password');
        }
    }
    public function update_photo(Request $request){
        $photo = auth::user()->photo;
        if($photo == null){
            $uploaded_photo = $request->photo;
            $extension = $uploaded_photo->getClientOriginalExtension();
            $file_name = auth::id().'.'.$extension;
            $img = Image::make($uploaded_photo)->save(public_path('uploads/user/'.$file_name));

            User::find(auth::id())->update([
                'photo'=>$file_name,
            ]);
            return back()->with('image','image updated');
        }
        else{

            $delete_form = public_path('uploads/user/'.$photo);
            unlink($delete_form);
           
            $uploaded_photo = $request->photo;
            $extension = $uploaded_photo->getClientOriginalExtension();
            $file_name = auth::id().'.'.$extension;

            $img = Image::make($uploaded_photo)->save(public_path('uploads/user/'.$file_name));

            User::find(auth::id())->update([
                'photo'=>$file_name,
            ]);
            return back()->with('image','image updated');
        }
    }
}
