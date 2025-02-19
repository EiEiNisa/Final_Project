<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Article;

class HomepageController extends Controller
{
    public function adminhomepage() {
        $articles = Article::all(); // หรือใช้การค้นหาอย่างอื่นตามที่คุณต้องการ
        return view('admin.homepage', compact('articles'));
    }
    
    public function userHomepage()
{
    return view('User.homepage');
}
}