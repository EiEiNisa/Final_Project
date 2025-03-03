<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disease extends Model
{
    use HasFactory;

    protected $table = 'disease';

    protected $fillable = [
        'recorddata_id',
        'diabetes',
        'cerebral_artery',
        'kidney',
        'blood_pressure',
        'heart',
        'eye',
        'other',
        'other_text',
    ];

    public function recorddata()
    {
        return $this->belongsTo(Recorddata::class, 'recorddata_id');
    }
}
