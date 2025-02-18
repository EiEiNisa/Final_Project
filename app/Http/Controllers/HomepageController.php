<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Article;

class HomepageController extends Controller
{
    public function adminHomepage() {
        $articles = Article::all(); // หรือการดึงข้อมูลจาก Model
        return view('admin.homepage', compact('articles'));
    }
    
    // ฟังก์ชันสำหรับหน้า user
    public function userHomepage()
{
    return view('User.homepage');
}
}