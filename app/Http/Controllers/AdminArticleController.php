<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.article', compact('article'));
    }
}