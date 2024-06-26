<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
   public function index(){
    return view('frontend.index');
   } //End Method


   public function Profile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.edit_profile',compact('profileData'));
   }//End Method

   public function UserLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notificaton = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );


        return redirect('/login')->with($notificaton);
    }

    public function UserProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){

            if($request->oldimg){
             $oldImage = public_path('upload/user_images/' . $request->oldimg);
            unlink($oldImage);
            }
            $file = $request->file('photo');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['photo'] = $filename;
        };

        $data->save();

        $notificaton = array(
            'message' => 'User Profile Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notificaton);
    }//End Method

    public function UserChangePassword(){
        return view('frontend.dashboard.user_change_password');
    }//End Method

    public function UserPasswordUpdate(Request $request){
        //validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password,auth::user()->password)) {
            $notificaton = array(
                'message' => 'Old Password Does Not Match',
                'alert-type' => 'error'
            );
            return back()->with($notificaton);
        }

        //Update the new Password

        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        $notificaton = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notificaton);


    }//End Method



















}
