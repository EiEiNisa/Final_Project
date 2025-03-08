<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recorddata;

class CustomFieldData extends Model
{
    use HasFactory;

    protected $fillable = [
        'recorddata_id',
        'custom_field_id',
        'value',
        'field_type',
        'option_values',
    ];

    // Define relationship with RecordData
    public function recordData()
    {
        return $this->belongsTo(RecordData::class, 'recorddata_id');
    }

    // Define relationship with CustomField
    public function customField()
    {
        return $this->belongsTo(CustomField::class, 'custom_field_id');
    }
}
