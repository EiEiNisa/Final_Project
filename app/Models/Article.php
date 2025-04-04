<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles'; // ชื่อของตารางในฐานข้อมูล
    protected $fillable = ['title', 'description', 'author', 'post_date', 'image','video_link','video_upload'];
}
