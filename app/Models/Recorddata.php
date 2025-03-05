<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recorddata extends Model
{
    use HasFactory;

    protected $table = 'recorddata';

    protected $fillable = [
        'id_card', 
        'prefix',
        'name', 
        'surname', 
        'housenumber', 
        'birthdate', 
        'age',
        'blood_group', 
        'weight', 
        'height', 
        'waistline', 
        'bmi', 
        'phone', 
        'idline',
        'user_name',
    ];

    // เชื่อมกับตาราง diseases
    public function diseases()
    {
        return $this->hasOne(Disease::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ elderly_informations
    public function elderlyInformation()
    {
        return $this->hasOne(ElderlyInformation::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ health_zones
    public function healthZone()
    {
        return $this->hasOne(HealthZone::class, 'recorddata_id', 'id');
    }

    // **เพิ่มเมธอด healthRecords ที่ขาดหายไป**
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class, 'recorddata_id', 'id');
    }
}
