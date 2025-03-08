<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = ['name', 'label', 'field_type', 'options'];

    public function recorddata(): BelongsTo
    {
        return $this->belongsTo(Recorddata::class, 'recorddata_id');
    }
}

