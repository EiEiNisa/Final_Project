<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index($page = 'home')
    {
        $articles = Article::all(); 

        if ($page === 'admin/homepage') {
            return view('admin.homepage', compact('articles'));
        }
        if ($page === 'User/homepage') {
            return view('user.homepage', compact('articles'));
        }        

        return view('home', compact('articles'));
    }
    
    public function destroy($id)
{
    $article = Article::findOrFail($id);
    $article->delete();

    return redirect()->route('admin.homepage')->with('success', 'บทความถูกลบเรียบร้อยแล้ว');
}

public function show($id)
{
    $article = Article::findOrFail($id);
        return view('admin.article', compact('article'));
}
    public function create()
    {
        return view('/admin/form');
    }
    
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'post_date' => 'required|date',
            'author' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }
    
        Article::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'post_date' => $validated['post_date'],
            'author' => $validated['author'],
            'image' => $imagePath,
        ]);
    
        $successMessage = 'เพิ่มบทความสำเร็จ!';
    
        return redirect()->route('admin.homepage')->with('success', $successMessage);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        $articles = Article::where('title', 'like', $query . '%')->get();
    
        return view('search_results', compact('articles', 'query'));
    }
    

}