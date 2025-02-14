<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;

class HomepageController extends Controller
{
    public function adminHomepage()
    {
        return view('admin.homepage');
    }

    public function userHomepage()
{
    return view('User.homepage');
}
}
