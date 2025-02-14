<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LifestyleHabit extends Model
{
    use HasFactory;

    protected $table = 'lifestyle_habit';

    protected $fillable = [
        'recorddata_id',
        'drink',
        'drink_sometimes',
        'dont_drink',
        'smoke',
        'sometime_smoke',
        'dont_smoke',
        'troubled',
        'dont_live',
        'bored',
    ];

    public function recorddata()
    {
        return $this->belongsTo(Recorddata::class, 'recorddata_id');
    }
}
