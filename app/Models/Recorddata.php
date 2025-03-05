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

    // เชื่อมกับ health_zones (แก้จาก hasOne เป็น hasMany ถ้ามีหลายแถว)
    public function healthZones()
    {
        return $this->hasMany(HealthZone::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ health_zone2 (ถ้ามีหลายแถว ใช้ hasMany)
    public function healthZones2()
    {
        return $this->hasMany(HealthZone2::class, 'recorddata_id', 'id');
    }

    // เชื่อมกับ health_records (ต้องใช้ hasMany เพราะมีหลายรายการ)
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

