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

    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'recorddata_disease', 'recorddata_id', 'disease_id');
    }

    // เชื่อมกับ elderly_information (เปลี่ยนชื่อให้ถูกต้อง)
    public function elderlyInformations()
    {
        return $this->hasMany(ElderlyInformation::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ health_zones
    public function healthZones()
    {
        return $this->hasMany(HealthZone::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ health_zone2
    public function healthZones2()
    {
        return $this->hasMany(HealthZone2::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ health_records
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ lifestyle_habits
    public function lifestyleHabits()
    {
        return $this->hasMany(LifestyleHabit::class, 'recorddata_id', 'id');
    }
}


