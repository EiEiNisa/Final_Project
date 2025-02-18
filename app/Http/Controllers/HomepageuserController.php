<?php

namespace App\Http\Controllers;

use App\Models\Article; // หรือ Model ที่เกี่ยวข้องกับบทความ
use Illuminate\Http\Request;

class HomepageuserController extends Controller
{
    public function showHomepage()
    {
        // ดึงข้อมูลบทความทั้งหมด
        $articles = Article::all();

        // ส่งข้อมูลบทความไปยัง View
        return view('User.homepage', compact('articles'));
    }
}