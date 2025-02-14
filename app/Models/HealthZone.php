<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthZone extends Model
{
    use HasFactory;

    protected $table = 'health_zone1';

    protected $fillable = [
        'recorddata_id',
        'zone1_normal',
        'zone1_risk_group',
        'zone1_good_control',
        'zone1_watch_out',
        'zone1_danger',
        'zone1_critical',
        'zone1_complications',
        'zone1_heart',
        'zone1_cerebrovascular',
        'zone1_kidney',
        'zone1_eye',
        'zone1_foot',
    ];

    public function recorddata()
    {
        return $this->belongsTo(Recorddata::class, 'recorddata_id');
    }
}
