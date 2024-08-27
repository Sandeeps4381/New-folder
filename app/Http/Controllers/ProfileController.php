<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(){
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phone' => 'required|min:10|numeric',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->lname = $request->lname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        
        if ($request->password) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);
            
            $user->password = Hash::make($request->password);
        }
       
        $user->save();
        

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}
