<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFieldGeneral extends Model
{
    protected $fillable = ['name', 'label', 'field_type', 'options'];

}
