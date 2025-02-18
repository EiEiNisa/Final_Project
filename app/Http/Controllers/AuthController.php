<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
 public function showLoginForm()
 {
     return view('login'); 
 }

 public function login(Request $request)
 {
     $request->validate([
         'email' => 'required|email',
         'password' => 'required|min:8',
     ], [
         'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
     ]);
 
     $user = User::where('email', $request->email)->first();
 
     if ($user && password_verify($request->password, $user->password)) {
        $request->session()->put('register', $user); 
 
         \Log::info('User Logged In', ['user' => $user]);
         
         if ($user->role == 'แอดมิน') {
             return redirect()->route('admin.homepage');
         } else {
             return redirect()->route('User.homepage');
         }
     }
 
     return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
 }
 
 public function logout(Request $request)
 {
     Auth::logout();
     return redirect()->route('login.form');
 }
 
}