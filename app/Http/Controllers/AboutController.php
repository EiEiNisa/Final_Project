<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordData;
use App\Models\HealthZone;
use App\Models\Disease;
use App\Models\ElderlyInformation;

class AboutController extends Controller
{
    public function userIndex() {
        $data = [
            'populationCount' => RecordData::count(),
            'maleCount' => RecordData::whereIn('prefix', ['นาย', 'ด.ช.'])->count(),
            'femaleCount' => RecordData::whereIn('prefix', ['นาง', 'นางสาว', 'ด.ญ.'])->count(),
            'age_0_6' => RecordData::whereBetween('age', [0, 6])->count(),
            'age_7_14' => RecordData::whereBetween('age',  [7,14])->count(),
            'age_15_34' => RecordData::whereBetween('age',  [15,34])->count(),
            'age_35_59' => RecordData::whereBetween('age',  [35,59])->count(),
            'age_60_plus' => RecordData::where('age', '>=', 60)->count(),
            'house' => ElderlyInformation::where('house', 1)->count(),
            'society' => ElderlyInformation::where('society', 1)->count(),
            'bed_ridden' => ElderlyInformation::where('bed_ridden', 1)->count(),
            'diabetesCount' => Disease::whereHas('recordData', function ($query) {
                $query->where('diabetes', 1);
            })->count(),
            'hypertensionCount' => Disease::whereHas('recordData', function ($query) {
                $query->where('blood_pressure', 1);
            })->count(),
            'kidneyDiseaseCount' => Disease::whereHas('recordData', function ($query) {
                $query->where('kidney', 1);
            })->count(),
            'waist_male_90_plus' => RecordData::where('prefix', ['นาย', 'ด.ช.'])->where('waistline', '>', 90)->count(),
            'waist_female_80_plus' => RecordData::where('prefix', ['นาง', 'นางสาว','ด.ญ.'])->where('waistline', '>', 80)->count(),
        ];
    
        return view('user.about', $data);
    }
    public function adminIndex() {
        $data = [
            'populationCount' => RecordData::count(),
            'maleCount' => RecordData::whereIn('prefix', ['นาย', 'ด.ช.'])->count(),
            'femaleCount' => RecordData::whereIn('prefix', ['นาง', 'นางสาว', 'ด.ญ.'])->count(),
            'age_0_6' => RecordData::whereBetween('age', [0, 6])->count(),
            'age_7_14' => RecordData::whereBetween('age', [7, 14])->count(),
            'age_15_34' => RecordData::whereBetween('age', [15, 34])->count(),
            'age_35_59' => RecordData::whereBetween('age', [35, 59])->count(),
            'age_60_plus' => RecordData::where('age', '>=', 60)->count(),
            'house' => ElderlyInformation::where('house', 1)->count(),
            'society' => ElderlyInformation::where('society', 1)->count(),
            'bed_ridden' => ElderlyInformation::where('bed_ridden', 1)->count(),
            'diabetesCount' => Disease::whereHas('recordData', function ($query) {
                $query->where('diabetes', 1);
            })->count(),
            'hypertensionCount' => Disease::whereHas('recordData', function ($query) {
                $query->where('blood_pressure', 1);
            })->count(),
            'kidneyDiseaseCount' => Disease::whereHas('recordData', function ($query) {
                $query->where('kidney', 1);
            })->count(),
            'waist_male_90_plus' => RecordData::whereIn('prefix', ['นาย', 'ด.ช.'])->where('waistline', '>', 90)->count(),
            'waist_female_80_plus' => RecordData::whereIn('prefix', ['นาง', 'นางสาว', 'ด.ญ.'])->where('waistline', '>', 80)->count(),
        ];
    
        return view('admin.about', $data);
    }
    
}