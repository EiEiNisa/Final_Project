<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Slideshow;

Route::get('/slides', function () {
    return response()->json(Slideshow::orderBy('order')->get());
});
