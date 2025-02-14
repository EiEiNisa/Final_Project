<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthZone2 extends Model
{
    use HasFactory;

    protected $table = 'health_zone2';

    protected $fillable = [
        'recorddata_id',
        'zone2_normal',
        'zone2_risk_group',
        'zone2_good_control',
        'zone2_watch_out',
        'zone2_danger',
        'zone2_critical',
        'zone2_complications',
        'zone2_heart',
        'zone2_eye',
    ];

    public function recorddata()
    {
        return $this->belongsTo(Recorddata::class, 'recorddata_id');
    }
}
