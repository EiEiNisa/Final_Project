<?php

namespace App\Imports;

use App\Models\Recorddata;
use App\Models\HealthRecord;
use App\Models\HealthZone;
use App\Models\HealthZone2;
use App\Models\Disease;
use App\Models\LifestyleHabit;
use App\Models\ElderlyInformation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
{
    $data = $request->json()->all()['data'];
    //dd($row);

    $recorddata = Recorddata::firstOrCreate([
        'id_card' => $row['id_card'],
        'prefix' => $row['prefix'],
        'name' => $row['name'],
        'surname' => $row['surname'],
        'housenumber' => $row['housenumber'],
        'birthdate' => $row['birthdate'],
        'age' => $row['age'],
        'blood_group' => $row['blood_group'],
        'weight' => $row['weight'],
        'height' => $row['height'],
        'waistline' => $row['waistline'],
        'bmi' => $row['bmi'],
        'phone' => $row['phone'],
        'idline' => $row['idline'],
        'user_id' => $row['user_id'],
    ]);

    HealthRecord::create([
        'recorddata_id' => $recorddata->id,
        'sys' => isset($row['sys']) ? $row['sys'] : null, 
        'dia' => isset($row['dia']) ? $row['dia'] : null, 
        'pul' => isset($row['pul']) ? $row['pul'] : null, 
        'body_temp' => isset($row['body_temp']) ? $row['body_temp'] : null, 
        'blood_oxygen' => isset($row['blood_oxygen']) ? $row['blood_oxygen'] : null, 
        'blood_level' => isset($row['blood_level']) ? $row['blood_level'] : null, 
    ]);

    HealthZone::create([
        'recorddata_id' => $recorddata->id,
        'zone1_normal' => filter_var($row['zone1_normal'], FILTER_VALIDATE_BOOLEAN),
        'zone1_risk_group' => filter_var($row['zone1_risk_group'], FILTER_VALIDATE_BOOLEAN),
        'zone1_good_control' => filter_var($row['zone1_good_control'], FILTER_VALIDATE_BOOLEAN),
        'zone1_watch_out' => filter_var($row['zone1_watch_out'], FILTER_VALIDATE_BOOLEAN),
        'zone1_danger' => filter_var($row['zone1_danger'], FILTER_VALIDATE_BOOLEAN),
        'zone1_critical' => filter_var($row['zone1_critical'], FILTER_VALIDATE_BOOLEAN),
        'zone1_complications' => filter_var($row['zone1_complications'], FILTER_VALIDATE_BOOLEAN),
        'zone1_heart' => filter_var($row['zone1_heart'], FILTER_VALIDATE_BOOLEAN),
        'zone1_cerebrovascular' => filter_var($row['zone1_cerebrovascular'], FILTER_VALIDATE_BOOLEAN),
        'zone1_kidney' => filter_var($row['zone1_kidney'], FILTER_VALIDATE_BOOLEAN),
        'zone1_eye' => filter_var($row['zone1_eye'], FILTER_VALIDATE_BOOLEAN),
        'zone1_foot' => filter_var($row['zone1_foot'], FILTER_VALIDATE_BOOLEAN),
    ]);

    HealthZone2::create([
        'recorddata_id' => $recorddata->id,
        'zone2_normal' => filter_var($row['zone2_normal'], FILTER_VALIDATE_BOOLEAN),
        'zone2_risk_group' => filter_var($row['zone2_risk_group'], FILTER_VALIDATE_BOOLEAN),
        'zone2_good_control' => filter_var($row['zone2_good_control'], FILTER_VALIDATE_BOOLEAN),
        'zone2_watch_out' => filter_var($row['zone2_watch_out'], FILTER_VALIDATE_BOOLEAN),
        'zone2_danger' => filter_var($row['zone2_danger'], FILTER_VALIDATE_BOOLEAN),
        'zone2_critical' => filter_var($row['zone2_critical'], FILTER_VALIDATE_BOOLEAN),
        'zone2_complications' => filter_var($row['zone2_complications'], FILTER_VALIDATE_BOOLEAN),
        'zone2_heart' => filter_var($row['zone2_heart'], FILTER_VALIDATE_BOOLEAN),
        'zone2_eye' => filter_var($row['zone2_eye'], FILTER_VALIDATE_BOOLEAN),
    ]);
    
    Disease::create([
        'recorddata_id' => $recorddata->id,
        'diabetes' => filter_var($row['diabetes'], FILTER_VALIDATE_BOOLEAN),  // ใช้เครื่องหมายคำพูด
        'cerebral_artery' => filter_var($row['cerebral_artery'], FILTER_VALIDATE_BOOLEAN),
        'kidney' => filter_var($row['kidney'], FILTER_VALIDATE_BOOLEAN),
        'blood_pressure' => filter_var($row['blood_pressure'], FILTER_VALIDATE_BOOLEAN),
        'heart' => filter_var($row['heart'], FILTER_VALIDATE_BOOLEAN),
        'eye' => filter_var($row['eye'], FILTER_VALIDATE_BOOLEAN),
        'other' => filter_var($row['other'], FILTER_VALIDATE_BOOLEAN),
    ]);

    LifestyleHabit::create([
        'recorddata_id' => $recorddata->id,
        'drink' => filter_var($row['drink'], FILTER_VALIDATE_BOOLEAN),
        'drink_sometimes' => filter_var($row['drink_sometimes'], FILTER_VALIDATE_BOOLEAN),
        'dont_drink' => filter_var($row['dont_drink'], FILTER_VALIDATE_BOOLEAN),
        'smoke' => filter_var($row['smoke'], FILTER_VALIDATE_BOOLEAN),
        'sometime_smoke' => filter_var($row['sometime_smoke'], FILTER_VALIDATE_BOOLEAN),
        'dont_smoke' => filter_var($row['dont_smoke'], FILTER_VALIDATE_BOOLEAN),
        'troubled' => filter_var($row['troubled'], FILTER_VALIDATE_BOOLEAN),
        'dont_live' => filter_var($row['dont_live'], FILTER_VALIDATE_BOOLEAN),
        'bored' => filter_var($row['bored'], FILTER_VALIDATE_BOOLEAN),
    ]);

    ElderlyInformation::create([
        'recorddata_id' => $recorddata->id,
        'help_yourself' => filter_var($row['help_yourself'], FILTER_VALIDATE_BOOLEAN),
        'can_help' => filter_var($row['can_help'], FILTER_VALIDATE_BOOLEAN),
        'cant_help' => filter_var($row['cant_help'], FILTER_VALIDATE_BOOLEAN),
        'caregiver' => filter_var($row['caregiver'], FILTER_VALIDATE_BOOLEAN),
        'have_caregiver' => filter_var($row['have_caregiver'], FILTER_VALIDATE_BOOLEAN),
        'no_caregiver' => filter_var($row['no_caregiver'], FILTER_VALIDATE_BOOLEAN),
        'group1' => filter_var($row['group1'], FILTER_VALIDATE_BOOLEAN),
        'group2' => filter_var($row['group2'], FILTER_VALIDATE_BOOLEAN),
        'group3' => filter_var($row['group3'], FILTER_VALIDATE_BOOLEAN),
        'house' => filter_var($row['house'], FILTER_VALIDATE_BOOLEAN),
        'society' => filter_var($row['society'], FILTER_VALIDATE_BOOLEAN),
        'bed_ridden' => filter_var($row['bed_ridden'], FILTER_VALIDATE_BOOLEAN),
    ]);
}

    }
