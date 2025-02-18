<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class GuestArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('guest.article', compact('article'));
    }
}