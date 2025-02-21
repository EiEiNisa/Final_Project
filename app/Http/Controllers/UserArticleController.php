<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('User.article', compact('article'));
    }
}