<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthRecord extends Model
{
    use HasFactory;

    protected $table = 'health_records';

    protected $fillable = [
        'recorddata_id',
        'sys',
        'dia',
        'pul',
        'body_temp',
        'blood_oxygen',
        'blood_level',
    ];

    public function recorddata()
    {
        return $this->belongsTo(Recorddata::class, 'recorddata_id');
    }
}