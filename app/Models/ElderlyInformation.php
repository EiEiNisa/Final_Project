<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RecordData;

class ElderlyInformation extends Model
{
    use HasFactory;

    protected $table = 'elderly_information';

    protected $fillable = [
        'recorddata_id',
        'help_yourself',
        'can_help',
        'cant_help',
        'caregiver',
        'have_caregiver',
        'no_caregiver',
        'group1',
        'group2',
        'group3',
        'house',
        'society',
        'bed_ridden',
    ];


public function elderlyInformation()
{
    return $this->hasMany(ElderlyInformation::class, 'recorddata_id');
}

public function recordData()
{
    return $this->belongsTo(RecordData::class, 'recorddata_id');  // ใช้ชื่อคอลัมน์ที่เชื่อมโยงจริง
}


}