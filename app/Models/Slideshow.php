<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    protected $table = 'slideshows'; 

    protected $fillable = ['slide1', 'slide2', 'slide3', 'slide4', 'slide5', 'slide6']; // เพิ่มฟิลด์ที่ต้องการอนุญาตให้ mass assignment
}
