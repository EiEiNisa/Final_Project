<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Article;

class HomepageController extends Controller
{
    public function adminHomepage() {
        $articles = Article::all();
        return view('admin.homepage', compact('articles'));
    }
    
    public function userHomepage()
{
    return view('User.homepage');
}
}