<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomFieldGeneral extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'label', 'field_type', 'options'];
    
}
