<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    protected $table = 'slideshows'; // ระบุชื่อ Table
    protected $fillable = ['order', 'path']; // อนุญาตให้เพิ่มข้อมูลในคอลัมน์นี้ได้
}

