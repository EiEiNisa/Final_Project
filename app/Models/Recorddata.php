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
        'user_id',
        'extra_fields',
    ];

    public function diseases()
{
    return $this->hasOne(Disease::class, 'recorddata_id', 'id');
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
