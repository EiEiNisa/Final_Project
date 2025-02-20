<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recorddata;
use App\Models\HealthRecord;
use App\Models\HealthZone;
use App\Models\HealthZone2;
use App\Models\Disease;
use App\Models\LifestyleHabit;
use App\Models\ElderlyInformation;
use Illuminate\Support\Facades\Schema;
use App\AnotherNamespace\Checkup;
use Carbon\Carbon;

class RecorddataController
{
    public function index()
    {
        $recorddata = Recorddata::orderBy('id', 'desc')->paginate(20);
        $disease = Disease::all();
        return view('admin.record', compact('recorddata', 'disease'));
    }
    
    public function create() 
{
    $users = User::where('role', 'แอดมิน')->get();
    if ($users->isEmpty()) {
        return back()->with('error', 'ไม่มีข้อมูลผู้ใช้ในระบบ');
    }

    $recorddata = Recorddata::first(); 

    // ดึง extra_fields จากฐานข้อมูล
    $extra_fields_recorddata = $recorddata ? json_decode($recorddata->extra_fields, true) : [];


    $columns_health_records = Schema::getColumnListing('health_records');
    $exclude_columns_health_records = [
        'id', 'recorddata_id', 'sys', 'dia', 'pul', 'body_temp', 'blood_oxygen', 'blood_level', 'created_at', 'updated_at'
    ];
    $extra_fields_health_records = array_diff($columns_health_records, $exclude_columns_health_records);

    return view('admin.addrecord', compact('extra_fields_recorddata', 'extra_fields_health_records', 'users', 'recorddata'));
}


public function store(Request $request)
{
    $extra_fields = $request->input('extra_fields');  

    // ดึงข้อมูลที่มีอยู่
    $existing_extra_fields = []; // อาจจะใช้สำหรับตรวจสอบในกรณีต้องการข้อมูลเก่า
    if ($request->has('existing_extra_fields')) {
        $existing_extra_fields = json_decode($request->input('existing_extra_fields'), true);
    }

    $formatted_extra_fields = [];

    if (isset($extra_fields) && is_array($extra_fields)) {
        // ถ้าใช้ existing_extra_fields ให้ใช้ข้อมูลเก่าเป็นพื้นฐาน
        foreach ($existing_extra_fields as $field) {
            $formatted_extra_fields[] = [
                'label' => $field['label'],
                'value' => isset($extra_fields[$field['label']]) ? $extra_fields[$field['label']] : $field['value']
            ];
        }
    }

    // บันทึกข้อมูลหลัก
    $recorddata = Recorddata::firstOrCreate(
        ['id_card' => $request->input('id_card')],
        [
            'prefix' => $request->input('prefix'),
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'housenumber' => $request->input('housenumber'),
            'birthdate' => $request->input('birthdate'),
            'age' => (int) $request->input('age'),
            'blood_group' => $request->input('blood_group'),
            'weight' => (float) $request->input('weight'),
            'height' => (float) $request->input('height'),
            'waistline' => (float) $request->input('waistline'),
            'bmi' => (float) $request->input('bmi'),
            'phone' => $request->input('phone'),
            'idline' => $request->input('idline'),
            'user_id' => intval($request->input('user_id')),
        ]
    );

    if (!$recorddata) {
        return redirect()->back()->with('error', 'ไม่สามารถบันทึกข้อมูลได้');
    }

    $recorddata->extra_fields = json_encode($formatted_extra_fields, JSON_UNESCAPED_UNICODE);
    $recorddata->save();

        
        if (!$recorddata) {
            return redirect()->back()->with('error', 'ไม่สามารถบันทึกข้อมูลได้');
        }
        //$table->unsignedBigInteger('user_id')->nullable(false);


        $healthRecord = HealthRecord::create([
            'recorddata_id' => $recorddata->id,
            'sys' => $request->input('sys'),
            'dia' => $request->input('dia'),
            'pul' => $request->input('pul'),
            'body_temp' => $request->input('body_temp'),
            'blood_oxygen' => $request->input('blood_oxygen'),
            'blood_level' => $request->input('blood_level'),
        ]);

        $healthZone = HealthZone::create([
            'recorddata_id' => $recorddata->id,
            'zone1_normal' => filter_var($request->input('zone1_normal', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_risk_group' => filter_var($request->input('zone1_risk_group', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_good_control' => filter_var($request->input('zone1_good_control', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_watch_out' => filter_var($request->input('zone1_watch_out', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_danger' => filter_var($request->input('zone1_danger', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_critical' => filter_var($request->input('zone1_critical', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_complications' => filter_var($request->input('zone1_complications', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_heart' => filter_var($request->input('zone1_heart', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_cerebrovascular' => filter_var($request->input('zone1_cerebrovascular', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_kidney' => filter_var($request->input('zone1_kidney', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_eye' => filter_var($request->input('zone1_eye', false), FILTER_VALIDATE_BOOLEAN),
            'zone1_foot' => filter_var($request->input('zone1_foot', false), FILTER_VALIDATE_BOOLEAN),
        ]);

        $healthZone2 = HealthZone2::create([
            'recorddata_id' => $recorddata->id,
            'zone2_normal' => filter_var($request->input('zone2_normal', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_risk_group' => filter_var($request->input('zone2_risk_group', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_good_control' => filter_var($request->input('zone2_good_control', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_watch_out' => filter_var($request->input('zone2_watch_out', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_danger' => filter_var($request->input('zone2_danger', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_critical' => filter_var($request->input('zone2_critical', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_complications' => filter_var($request->input('zone2_complications', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_heart' => filter_var($request->input('zone2_heart', false), FILTER_VALIDATE_BOOLEAN),
            'zone2_eye' => filter_var($request->input('zone2_eye', false), FILTER_VALIDATE_BOOLEAN),
        ]);

        $disease = Disease::create([
            'recorddata_id' => $recorddata->id,
            'diabetes' => filter_var($request->input('diabetes', false), FILTER_VALIDATE_BOOLEAN),
            'cerebral_artery' => filter_var($request->input('cerebral_artery', false), FILTER_VALIDATE_BOOLEAN),
            'kidney' => filter_var($request->input('kidney', false), FILTER_VALIDATE_BOOLEAN),
            'blood_pressure' => filter_var($request->input('blood_pressure', false), FILTER_VALIDATE_BOOLEAN),
            'heart' => filter_var($request->input('heart', false), FILTER_VALIDATE_BOOLEAN),
            'eye' => filter_var($request->input('eye', false), FILTER_VALIDATE_BOOLEAN),
            'other' => filter_var($request->input('other', false), FILTER_VALIDATE_BOOLEAN),
        ]);

        $lifestyle = LifestyleHabit::create([
            'recorddata_id' => $recorddata->id,
            'drink' => filter_var($request->input('drink', false),  FILTER_VALIDATE_BOOLEAN),
            'drink_sometimes' => filter_var($request->input('drink_sometimes', false),  FILTER_VALIDATE_BOOLEAN),
            'dont_drink' => filter_var($request->input('dont_drink', false),  FILTER_VALIDATE_BOOLEAN),
            'smoke' => filter_var($request->input('smoke', false),  FILTER_VALIDATE_BOOLEAN),
            'sometime_smoke' => filter_var($request->input('sometime_smoke', false),  FILTER_VALIDATE_BOOLEAN),
            'dont_smoke' => filter_var($request->input('dont_smoke', false),  FILTER_VALIDATE_BOOLEAN),
            'troubled' => filter_var($request->input('troubled', false),  FILTER_VALIDATE_BOOLEAN),
            'dont_live' => filter_var($request->input('dont_live', false),  FILTER_VALIDATE_BOOLEAN),
            'bored' => filter_var($request->input('bored', false),  FILTER_VALIDATE_BOOLEAN),
        ]);

        $hlderlyinformation = ElderlyInformation::create([
            'recorddata_id' => $recorddata->id,
            'help_yourself' => filter_var($request->input('help_yourself', false),  FILTER_VALIDATE_BOOLEAN),
            'can_help' => filter_var($request->input('can_help', false),  FILTER_VALIDATE_BOOLEAN),
            'cant_help' => filter_var($request->input('cant_help', false),  FILTER_VALIDATE_BOOLEAN),
            'caregiver' => filter_var($request->input('caregiver', false),  FILTER_VALIDATE_BOOLEAN),
            'have_caregiver' => filter_var($request->input('have_caregiver', false),  FILTER_VALIDATE_BOOLEAN),
            'no_caregiver' => filter_var($request->input('no_caregiver', false),  FILTER_VALIDATE_BOOLEAN),
            'group1' => filter_var($request->input('group1', false),  FILTER_VALIDATE_BOOLEAN),
            'group2' => filter_var($request->input('group2', false),  FILTER_VALIDATE_BOOLEAN),
            'group3' => filter_var($request->input('group3', false),  FILTER_VALIDATE_BOOLEAN),
            'house' => filter_var($request->input('house', false),  FILTER_VALIDATE_BOOLEAN),
            'society' => filter_var($request->input('society', false),  FILTER_VALIDATE_BOOLEAN),
            'bed_ridden' => filter_var($request->input('bed_ridden', false),  FILTER_VALIDATE_BOOLEAN),
        ]);

        return redirect()->route('recorddata.index')->with('success', 'บันทึกข้อมูลสำเร็จ');
    }

public function edit($id, Request $request)
{

    $recorddata = Recorddata::findOrFail($id);
    $user = User::find($recorddata->user_id);
    
    $searchDate = $request->input('search_date');
        
    if ($searchDate) {
        $searchDate = \Carbon\Carbon::createFromFormat('Y-m-d', $searchDate)->toDateString();
        $healthRecordsQuery->whereDate('created_at', $searchDate);
    }


    $healthRecordsQuery = HealthRecord::where('recorddata_id', $id);

    $extra_fields_recorddata = $recorddata->extra_fields ? json_decode($recorddata->extra_fields, true) : null;

    $healthRecords = $healthRecordsQuery->orderBy('created_at', 'desc')->get();
    if ($healthRecords->isEmpty()) {
        return back()->with('error', 'ไม่พบข้อมูล healthRecords');
    }

    // Filter healthZones by the current recorddata_id
    $healthZones = HealthZone::where('recorddata_id', $id)->orderBy('created_at', 'desc')->get();
    $zones = $healthZones->map(function ($zone) {
        $zoneData = [];
        // ตรวจสอบว่าแต่ละ field มีค่าเป็น 1 หรือไม่
        if ($zone->zone1_normal == 1) $zoneData[] = 'ปกติ';
        if ($zone->zone1_risk_group == 1) $zoneData[] = 'กลุ่มเสี่ยง';
        if ($zone->zone1_good_control == 1) $zoneData[] = 'คุมได้ดี';
        if ($zone->zone1_watch_out == 1) $zoneData[] = 'เฝ้าระวัง';
        if ($zone->zone1_danger == 1) $zoneData[] = 'อันตราย';
        if ($zone->zone1_critical == 1) $zoneData[] = 'วิกฤต';
        if ($zone->zone1_complications == 1) $zoneData[] = 'โรคแทรกซ้อน';
        if ($zone->zone1_heart == 1) $zoneData[] = 'หัวใจ';
        if ($zone->zone1_cerebrovascular == 1) $zoneData[] = 'หลอดเลือดสมอง';
        if ($zone->zone1_kidney == 1) $zoneData[] = 'ไต';
        if ($zone->zone1_eye == 1) $zoneData[] = 'ตา';
        if ($zone->zone1_foot == 1) $zoneData[] = 'เท้า';
        
        return $zoneData; // ส่งคืนค่าของ zone ที่มีค่าเป็น 1
    });
    //dd($zones);    

    // Filter healthZones2 by the current recorddata_id
    $healthZones2 = HealthZone2::where('recorddata_id', $id)->orderBy('created_at', 'desc')->get();
    $zones2 = $healthZones2->map(function ($zone2) {
        $zoneData2 = [];
        if ($zone2->zone2_normal == 1) $zoneData2[] = 'ปกติ';
        if ($zone2->zone2_risk_group == 1) $zoneData2[] = 'กลุ่มเสี่ยง';
        if ($zone2->zone2_good_control == 1) $zoneData2[] = 'คุมได้ดี';
        if ($zone2->zone2_watch_out == 1) $zoneData2[] = 'เฝ้าระวัง';
        if ($zone2->zone2_danger == 1) $zoneData2[] = 'อันตราย';
        if ($zone2->zone2_critical == 1) $zoneData2[] = 'วิกฤต';
        if ($zone2->zone2_complications == 1) $zoneData2[] = 'โรคแทรกซ้อน';
        if ($zone2->zone2_heart == 1) $zoneData2[] = 'หัวใจ';
        if ($zone2->zone2_eye == 1) $zoneData2[] = 'ตา'; 
        return $zoneData2;
    });
    //dd($zones2); 

    $diseases = Disease::where('recorddata_id', $recorddata->id)
    ->orderBy('created_at', 'desc')
    ->get();

    $diseases = Disease::where('recorddata_id', $recorddata->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $diseaseNames = $diseases->map(function ($disease) { 
        $names = [];
        if ($disease->diabetes == 1) $names[] = 'เบาหวาน';
        if ($disease->cerebral_artery == 1) $names[] = 'หลอดเลือดสมอง';
        if ($disease->kidney == 1) $names[] = 'ไต';
        if ($disease->blood_pressure == 1) $names[] = 'ความดันโลหิตสูง';
        if ($disease->heart == 1) $names[] = 'หัวใจ';
        if ($disease->eye == 1) $names[] = 'ตา';
        if ($disease->other == 1) $names[] = 'อื่น ๆ';
        return ['id' => $disease->id, 'names' => implode(' ', $names)];
    });
    //dd($diseaseNames); 

    $lifestyles = LifestyleHabit::where('recorddata_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();
    //dd($lifestyles);

    $lifestylesHabit = $lifestyles->map(function ($lifestyle) { 
        $lifestyleshabit = [];
        if ($lifestyle->drink) $lifestyleshabit[] = 'ดื่มแอลกอฮอล์';
        if ($lifestyle->drink_sometimes) $lifestyleshabit[] = 'ดื่มแอลกอฮอล์บ้างบางครั้ง';
        if ($lifestyle->dont_drink) $lifestyleshabit[] = 'ไม่ดื่มแอลกอฮอล์';
        if ($lifestyle->smoke) $lifestyleshabit[] = 'สูบบุหรี่';
        if ($lifestyle->sometime_smoke) $lifestyleshabit[] = 'สูบบุหรี่บางครั้ง';
        if ($lifestyle->dont_smoke) $lifestyleshabit[] = 'ไม่สูบบุหรี่';
        if ($lifestyle->troubled) $lifestyleshabit[] = 'ทุกข์ใจ ซึม เศร้า';
        if ($lifestyle->dont_live) $lifestyleshabit[] = 'ไม่อยากมีชีวิตอยู่';
        if ($lifestyle->bored) $lifestyleshabit[] = 'เบื่อ';
    
        return [
            'id' => $lifestyle->id, 
            'lifestyleshabit' => implode(' ', $lifestyleshabit)
        ];
    });
    
    //dd($lifestylesHabit); // Check the output


    $elderlyInfos = ElderlyInformation::where('recorddata_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

$elderlyInfo = $elderlyInfos->map(function ($info) { 
    $elderly = [];
    if ($info->help_yourself) $elderly[] = 'ช่วยเหลือตัวเองได้';
    if ($info->can_help) $elderly[] = 'ช่วยเหลือตัวเองได้';
    if ($info->cant_help) $elderly[] = 'ช่วยเหลือตัวเองไม่ได้';
    if ($info->caregiver) $elderly[] = 'ผู้ดูแล';
    if ($info->have_caregiver) $elderly[] = 'มีผู้ดูแล';
    if ($info->no_caregiver) $elderly[] = 'ไม่มีมีผู้ดูแล';
    if ($info->group1) $elderly[] = 'กลุ่มที่ 1 ผู้สูงอายุช่วยตัวเองและผู้อื่นได้';
    if ($info->group2) $elderly[] = 'กลุ่มที่ 2 ผู้สูงอายุช่วยตัวเองแต่มีโรคเรื้อรัง';
    if ($info->group3) $elderly[] = 'กลุ่มที่ 3 ผู้สูงอายุ/ผู้ป่วยดูแลตัวเองไม่ได้';
    if ($info->house) $elderly[] = 'ติดบ้าน';
    if ($info->society) $elderly[] = 'ติดสังคม';
    if ($info->bed_ridden) $elderly[] = 'ติดเตียง';

    return [
        'id' => $info->id, 
        'lifestyleshabit' => implode(' ', $elderly)
    ];
});

    return view('admin.editrecord', compact(
        'recorddata', 'healthRecords', 'healthZones', 'zones', 'zones2', 
        'diseaseNames', 'lifestylesHabit','elderlyInfo', 'user' , 'extra_fields_recorddata', 
    ));
}

public function view($id, Request $request)
{
    $recorddata = Recorddata::findOrFail($id);
    $user = User::find($recorddata->user_id);
    
    $searchDate = $request->input('search_date');
    $healthRecordsQuery = HealthRecord::where('recorddata_id', $id);

    if ($searchDate) {
        $searchDate = \Carbon\Carbon::createFromFormat('Y-m-d', $searchDate)->toDateString();
        $healthRecordsQuery->whereDate('created_at', $searchDate);
    }

    $healthRecords = $healthRecordsQuery->orderBy('created_at', 'desc')->get();
    if ($healthRecords->isEmpty()) {
        return back()->with('error', 'ไม่พบข้อมูล healthRecords');
    }

    // Filter healthZones by the current recorddata_id
    $healthZones = HealthZone::where('recorddata_id', $id)->orderBy('created_at', 'desc')->get();
    $zones = $healthZones->map(function ($zone) {
        $zoneData = [];
        // ตรวจสอบว่าแต่ละ field มีค่าเป็น 1 หรือไม่
        if ($zone->zone1_normal == 1) $zoneData[] = 'ปกติ';
        if ($zone->zone1_risk_group == 1) $zoneData[] = 'กลุ่มเสี่ยง';
        if ($zone->zone1_good_control == 1) $zoneData[] = 'คุมได้ดี';
        if ($zone->zone1_watch_out == 1) $zoneData[] = 'เฝ้าระวัง';
        if ($zone->zone1_danger == 1) $zoneData[] = 'อันตราย';
        if ($zone->zone1_critical == 1) $zoneData[] = 'วิกฤต';
        if ($zone->zone1_complications == 1) $zoneData[] = 'โรคแทรกซ้อน';
        if ($zone->zone1_heart == 1) $zoneData[] = 'หัวใจ';
        if ($zone->zone1_cerebrovascular == 1) $zoneData[] = 'หลอดเลือดสมอง';
        if ($zone->zone1_kidney == 1) $zoneData[] = 'ไต';
        if ($zone->zone1_eye == 1) $zoneData[] = 'ตา';
        if ($zone->zone1_foot == 1) $zoneData[] = 'เท้า';
        
        return $zoneData; // ส่งคืนค่าของ zone ที่มีค่าเป็น 1
    });
    //dd($zones);    

    // Filter healthZones2 by the current recorddata_id
    $healthZones2 = HealthZone2::where('recorddata_id', $id)->orderBy('created_at', 'desc')->get();
    $zones2 = $healthZones2->map(function ($zone2) {
        $zoneData2 = [];
        if ($zone2->zone2_normal == 1) $zoneData2[] = 'ปกติ';
        if ($zone2->zone2_risk_group == 1) $zoneData2[] = 'กลุ่มเสี่ยง';
        if ($zone2->zone2_good_control == 1) $zoneData2[] = 'คุมได้ดี';
        if ($zone2->zone2_watch_out == 1) $zoneData2[] = 'เฝ้าระวัง';
        if ($zone2->zone2_danger == 1) $zoneData2[] = 'อันตราย';
        if ($zone2->zone2_critical == 1) $zoneData2[] = 'วิกฤต';
        if ($zone2->zone2_complications == 1) $zoneData2[] = 'โรคแทรกซ้อน';
        if ($zone2->zone2_heart == 1) $zoneData2[] = 'หัวใจ';
        if ($zone2->zone2_eye == 1) $zoneData2[] = 'ตา'; 
        return $zoneData2;
    });
    //dd($zones2); 

    $diseases = Disease::where('recorddata_id', $recorddata->id)
    ->orderBy('created_at', 'desc')
    ->get();

    $diseases = Disease::where('recorddata_id', $recorddata->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $diseaseNames = $diseases->map(function ($disease) { 
        $names = [];
        if ($disease->diabetes == 1) $names[] = 'เบาหวาน';
        if ($disease->cerebral_artery == 1) $names[] = 'หลอดเลือดสมอง';
        if ($disease->kidney == 1) $names[] = 'ไต';
        if ($disease->blood_pressure == 1) $names[] = 'ความดันโลหิตสูง';
        if ($disease->heart == 1) $names[] = 'หัวใจ';
        if ($disease->eye == 1) $names[] = 'ตา';
        if ($disease->other == 1) $names[] = 'อื่น ๆ';
        return ['id' => $disease->id, 'names' => implode(' ', $names)];
    });
    //dd($diseaseNames); 

    $lifestyles = LifestyleHabit::where('recorddata_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();
    //dd($lifestyles);

    $lifestylesHabit = $lifestyles->map(function ($lifestyle) { 
        $lifestyleshabit = [];
        if ($lifestyle->drink) $lifestyleshabit[] = 'ดื่ม';
        if ($lifestyle->drink_sometimes) $lifestyleshabit[] = 'ดื่มบ้างบางครั้ง';
        if ($lifestyle->dont_drink) $lifestyleshabit[] = 'ไม่ดื่ม';
        if ($lifestyle->smoke) $lifestyleshabit[] = 'สูบ';
        if ($lifestyle->sometime_smoke) $lifestyleshabit[] = 'สูบบางครั้ง';
        if ($lifestyle->dont_smoke) $lifestyleshabit[] = 'ไม่สูบ';
        if ($lifestyle->troubled) $lifestyleshabit[] = 'ทุกข์ใจ ซึม เศร้า';
        if ($lifestyle->dont_live) $lifestyleshabit[] = 'ไม่อยากมีชีวิตอยู่';
        if ($lifestyle->bored) $lifestyleshabit[] = 'เบื่อ';
    
        // Return an array with 'id' and 'lifestyleshabit' as a string
        return [
            'id' => $lifestyle->id, 
            'lifestyleshabit' => implode(' ', $lifestyleshabit) // Join the array into a string
        ];
    });
    
    //dd($lifestylesHabit); // Check the output


    $elderlyInfos = ElderlyInformation::where('recorddata_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

$elderlyInfo = $elderlyInfos->map(function ($info) { 
    $elderly = [];
    if ($info->help_yourself) $elderly[] = 'ช่วยเหลือตัวเองได้';
    if ($info->can_help) $elderly[] = 'ได้';
    if ($info->cant_help) $elderly[] = 'ไม่ได้';
    if ($info->caregiver) $elderly[] = 'ผู้ดูแล';
    if ($info->have_caregiver) $elderly[] = 'มีผู้ดูแล';
    if ($info->no_caregiver) $elderly[] = 'ไม่มี';
    if ($info->group1) $elderly[] = 'กลุ่มที่ 1 ผู้สูงอายุช่วยตัวเองและผู้อื่นได้';
    if ($info->group2) $elderly[] = 'กลุ่มที่ 2 ผู้สูงอายุช่วยตัวเองแต่มีโรคเรื้อรัง';
    if ($info->group3) $elderly[] = 'กลุ่มที่ 3 ผู้สูงอายุ/ผู้ป่วยดูแลตัวเองไม่ได้';
    if ($info->house) $elderly[] = 'ติดบ้าน';
    if ($info->society) $elderly[] = 'ติดสังคม';
    if ($info->bed_ridden) $elderly[] = 'ติดเตียง';

    return [
        'id' => $info->id, 
        'lifestyleshabit' => implode(' ', $elderly)
    ];
});

    return view('User.viewrecord', compact(
        'recorddata', 'healthRecords', 'healthZones', 'zones', 'zones2', 
        'diseaseNames', 'lifestylesHabit','elderlyInfo', 'user' , 'extra_fields_health_records', 
    ));
}


public function searchByDate(Request $request)
{
    //dd($request->all()); // ตรวจสอบค่าที่ส่งมาจากฟอร์ม

    $searchDate = $request->input('search_date');
    dd($searchDate); 
    if (!$searchDate) {
        return back()->with('error', 'กรุณากรอกวันที่');
    }

    try {
        // ค้นหาตามวันที่
        $searchDate = \Carbon\Carbon::createFromFormat('Y-m-d', $searchDate)->toDateString();
        $healthRecords = HealthRecord::whereDate('created_at', $searchDate)->get();

        if ($healthRecords->isEmpty()) {
            return view('admin.editrecord', ['healthRecords' => null]);
        }

        return redirect()->route('recorddata.edit', ['id' => $healthRecords->first()->id]);
    } catch (\Exception $e) {
        return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
    }
}


public function update(Request $request, $id) 
{
    $data = Recorddata::findOrFail($id);
    
    // ดึงค่า extra_fields ที่มีอยู่
    $existing_extra_fields = json_decode($data->extra_fields, true);
    
    $extra_fields = $request->input('extra_fields');  

    if (isset($extra_fields) && is_array($extra_fields)) {
        foreach ($existing_extra_fields as $key => $field) {
            // ใช้ label ในการค้นหา value ที่จะอัปเดต
            if (isset($extra_fields[$field['label']])) {
                // อัปเดตเฉพาะค่า value
                $existing_extra_fields[$key]['value'] = $extra_fields[$field['label']];
            }
        }
    }

    // แปลงกลับเป็น JSON และบันทึกลงในฐานข้อมูล
    $data->extra_fields = json_encode($existing_extra_fields, JSON_UNESCAPED_UNICODE);

    // อัปเดตข้อมูลอื่นๆ
    $data->prefix = $request->input('prefix');
    $data->name = $request->input('name');
    $data->surname = $request->input('surname');
    $data->housenumber = $request->input('housenumber');
    $data->birthdate = $request->input('birthdate');
    $data->age = (int) $request->input('age');
    $data->blood_group = $request->input('blood_group');
    $data->weight = (float) $request->input('weight');
    $data->height = (float) $request->input('height');
    $data->waistline = (float) $request->input('waistline');
    $data->bmi = (float) $request->input('bmi');
    $data->phone = $request->input('phone');
    $data->idline = $request->input('idline');

    // บันทึกข้อมูลลงฐานข้อมูล
    $data->save();

    return back()->with('success', 'ข้อมูลถูกบันทึกแล้ว');
}


    public function destroy($id)
    {
        try {
            $recorddata = Recorddata::findOrFail($id);
            $recorddata->delete();
            return redirect()->route('recorddata.index')->with('success', 'ข้อมูลถูกลบแล้ว');
        } catch (\Exception $e) {
            return redirect()->route('recorddata.index')->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
        }
    }

    public function disease()
    {
        return $this->hasMany(Disease::class, 'recorddata_id');    
    }
    
    public function search(Request $request)
{
    // เริ่มสร้าง query สำหรับค้นหาข้อมูล
    $query = Recorddata::query();

    // ค้นหาตามเลขบัตรประจำตัวประชาชน
    if ($request->filled('id_card')) {
        $query->where('id_card', 'like', '%' . $request->input('id_card') . '%');
    }

    // ค้นหาตามชื่อและนามสกุล
    if ($request->filled('name')) {
        $searchTerm = $request->input('name');
        $query->where(function ($q) use ($searchTerm) {
            $q->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%$searchTerm%"]);
        });
    }

    // ค้นหาตามบ้านเลขที่
    if ($request->filled('housenumber')) {
        $query->where('housenumber', '=', $request->input('housenumber'));
    }

    // ค้นหาตามโรคประจำตัว
    if ($request->has('diseases') && $request->diseases != '') {
        $disease = $request->diseases;
        $query->whereHas('diseases', function($query) use ($disease) {
            $query->where($disease, 1); // เช็คว่าโรคนั้นๆ ถูกเลือก
        });
    }
    $disease = $request->input('diseases');
    // ทำการค้นหาจาก query ที่กำหนดและทำการแบ่งหน้า
    $recorddata = $query->orderBy('id', 'desc')->paginate(20);

    // ดึงข้อมูลผู้ใช้และโรคประจำตัว
    $users = User::all();
    $diseases = Disease::all();

    // ส่งข้อมูลไปยัง view
    return view('admin.record', compact('recorddata', 'users', 'diseases'));
}


public function Usersearch(Request $request)
{
    // เริ่มสร้าง query สำหรับค้นหาข้อมูล
    $query = Recorddata::query();

    if ($request->filled('name')) {
        $searchTerm = $request->input('name');
        $query->where(function ($q) use ($searchTerm) {
            $q->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%$searchTerm%"]);
        });
    }

    if ($request->filled('housenumber')) {
        $query->where('housenumber', '=', $request->input('housenumber'));
    }

    if ($request->filled('diseases')) {
        $query->whereHas('disease', function ($q) use ($request) {
            // ค้นหาผู้ที่มีโรคนี้ โดยเช็คว่าโรคมีค่าคือ 1 (มีโรค)
            $q->where($request->input('diseases'), 1); // ค่าของโรคที่เลือก (จากฟอร์ม select)
        });
    }

    $recorddata = $query->orderBy('id', 'desc')->paginate(20);

    $users = User::all();
    $diseases = Disease::all();

    return view('User.record', compact('recorddata', 'users', 'diseases'));
}


public function edit_general_information(Request $request, $recorddata_id, $checkup_id)
{
    // ค้นหา recorddata โดยใช้ recorddata_id
    $recorddata = Recorddata::findOrFail($recorddata_id);

    if (!$recorddata->user_id) {
        return back()->with('error', 'ไม่พบ user_id');
    }
    //dd($checkup_id);
    //$checkup = Checkup::findOrFail($checkup_id);
    $userList = User::where('role', 'แอดมิน')->get();
    $users = User::where('id', $recorddata->user_id)->first();

    if (!$users) {
        return back()->with('error', 'ไม่พบข้อมูลผู้ใช้');
    }

    $healthRecord = HealthRecord::where('recorddata_id', $recorddata_id)->first();
//dd($healthRecord);

if (!$healthRecord) {
    return back()->with('error', 'ไม่พบข้อมูล healthRecord');
}

    // ค้นหา healthZone ตาม recorddata_id
    $healthZone = HealthZone::where('recorddata_id', $recorddata_id)
                    ->first();
                    //dd($healthZone);
    if ($healthZone) {
        $zones = [
            'zone1_normal' => ['value' => $healthZone->zone1_normal, 'label' => 'ปกติ'],
            'zone1_risk_group' => ['value' => $healthZone->zone1_risk_group, 'label' => 'กลุ่มเสี่ยง'],
            'zone1_good_control' => ['value' => $healthZone->zone1_good_control, 'label' => 'คุมได้ดี'],
            'zone1_watch_out' => ['value' => $healthZone->zone1_watch_out, 'label' => 'เฝ้าระวัง'],
            'zone1_danger' => ['value' => $healthZone->zone1_danger, 'label' => 'อันตราย'],
            'zone1_critical' => ['value' => $healthZone->zone1_critical, 'label' => 'วิกฤต'],
            'zone1_complications' => ['value' => $healthZone->zone1_complications, 'label' => 'โรคแทรกซ้อน'],
            'zone1_heart' => ['value' => $healthZone->zone1_heart, 'label' => 'หัวใจ'],
            'zone1_cerebrovascular' => ['value' => $healthZone->zone1_cerebrovascular, 'label' => 'หลอดเลือดสมอง'],
            'zone1_kidney' => ['value' => $healthZone->zone1_kidney, 'label' => 'ไต'],
            'zone1_eye' => ['value' => $healthZone->zone1_eye, 'label' => 'ตา'],
            'zone1_foot' => ['value' => $healthZone->zone1_foot, 'label' => 'เท้า']
        ];
    } else {
        return back()->with('error', 'ไม่พบข้อมูล health_zone');
    }

    // ค้นหา healthZone2 ตาม recorddata_id
    $healthZone2 = HealthZone2::where('recorddata_id', $recorddata_id)
                    ->first();
    if ($healthZone2) {
        $zones2 = [
            'zone2_normal' => ['value' => $healthZone2->zone2_normal, 'label' => 'ปกติ'],
            'zone2_risk_group' => ['value' => $healthZone2->zone2_risk_group, 'label' => 'กลุ่มเสี่ยง'],
            'zone2_good_control' => ['value' => $healthZone2->zone2_good_control, 'label' => 'คุมได้ดี'],
            'zone2_watch_out' => ['value' => $healthZone2->zone2_watch_out, 'label' => 'เฝ้าระวัง'],
            'zone2_danger' => ['value' => $healthZone2->zone2_danger, 'label' => 'อันตราย'],
            'zone2_critical' => ['value' => $healthZone2->zone2_critical, 'label' => 'วิกฤต'],
            'zone2_complications' => ['value' => $healthZone2->zone2_complications, 'label' => 'โรคแทรกซ้อน'],
            'zone2_heart' => ['value' => $healthZone2->zone2_heart, 'label' => 'หัวใจ'],
            'zone2_eye' => ['value' => $healthZone2->zone2_eye, 'label' => 'ตา'],
        ];
    } else {
        return back()->with('error', 'ไม่พบข้อมูล health_zone2');
    }

    // ค้นหา diseases ตาม recorddata_id
    $diseases = Disease::where('recorddata_id', $recorddata_id)
                ->first();

    if ($diseases) {
        $diseases = [
            'diabetes' => $diseases->diabetes,
            'cerebral_artery' => $diseases->cerebral_artery,
            'kidney' => $diseases->kidney,
            'blood_pressure' => $diseases->blood_pressure,
            'heart' => $diseases->heart,
            'eye' => $diseases->eye,
            'other' => $diseases->other,
        ];
    } else {
        return back()->with('error', 'ไม่พบข้อมูลโรคประจำตัว');
    }

    // ค้นหา lifestyles ตาม recorddata_id
    $lifestyles = LifestyleHabit::where('recorddata_id', $recorddata_id)
                    ->first();
    if ($lifestyles) {
        $lifestyles = [
            'drink' => $lifestyles->drink,
            'drink_sometimes' => $lifestyles->drink_sometimes,
            'dont_drink' => $lifestyles->dont_drink,
            'smoke' => $lifestyles->smoke,
            'sometime_smoke' => $lifestyles->sometime_smoke,
            'dont_smoke' => $lifestyles->dont_smoke,
            'troubled' => $lifestyles->troubled,
            'dont_live' => $lifestyles->dont_live,
            'bored' => $lifestyles->bored,
        ];
    } else {
        return back()->with('error', 'ไม่พบข้อมูล LifestyleHabit');
    }

    // ค้นหา elderlyInfos ตาม recorddata_id
    $elderlyInfos = ElderlyInformation::where('recorddata_id', $recorddata_id)
                        ->first();
    if ($elderlyInfos) {
        $elderlyInfos = [
            'help_yourself' => $elderlyInfos->help_yourself,
            'can_help' => $elderlyInfos->can_help,
            'cant_help' => $elderlyInfos->cant_help,
            'caregiver' => $elderlyInfos->caregiver,
            'have_caregiver' => $elderlyInfos->have_caregiver,
            'no_caregiver' => $elderlyInfos->no_caregiver,
            'group1' => $elderlyInfos->group1,
            'group2' => $elderlyInfos->group2,
            'group3' => $elderlyInfos->group3,
            'house' => $elderlyInfos->house,
            'society' => $elderlyInfos->society,
            'bed_ridden' => $elderlyInfos->bed_ridden,
        ];
    } else {
        return back()->with('error', 'ไม่พบข้อมูล Elderly Information');
    }

    // ส่งข้อมูลไปยังหน้า view
    return view('admin.editrecord_general_information', compact(
        'recorddata', 'healthRecord', 'healthZone', 'healthZone2', 'zones', 'zones2', 
        'diseases', 'lifestyles', 'elderlyInfos', 'users' ,'checkup_id' , 'userList'
    ));
}


public function update_general_information(Request $request, $recorddata_id = null, $checkup_id = null) 
{
    
    //dd($request->all());
    //dd($recorddata_id, $checkup_id);

    // หากมี recorddata_id และ checkup_id ให้ทำการอัพเดตข้อมูล
    if ($recorddata_id && $checkup_id) {
        // ค้นหา recorddata โดยใช้ recorddata_id
        $recorddata = Recorddata::findOrFail($recorddata_id);

        if (!$recorddata->user_id) {
            return back()->with('error', 'ไม่พบ user_id');
        }

        // ค้นหา healthRecord โดยใช้ recorddata_id และ checkup_id
        $healthRecord = HealthRecord::where('recorddata_id', $recorddata_id)

                                    ->first();
//dd($healthRecord);
        if (!$healthRecord) {
            return back()->with('error', 'ไม่พบข้อมูล healthRecords');
        }

        $updated = $healthRecord->update([
            'sys' => $request->input('sys'),
            'dia' => $request->input('dia'),
            'pul' => $request->input('pul'),
            'body_temp' => $request->input('body_temp'),
            'blood_oxygen' => $request->input('blood_oxygen'),
            'blood_level' => $request->input('blood_level'),
        ]);
        
        //dd($updated);
        
        // อัปเดตข้อมูล HealthZone
        $healthZone = HealthZone::where('recorddata_id', $recorddata_id)->first();
        if ($healthZone) {
            $healthZone->update([
                'zone1_normal' => $request->has('zone1_normal') ? 1 : 0,
                'zone1_risk_group' => $request->has('zone1_risk_group') ? 1 : 0,
                'zone1_good_control' => $request->has('zone1_good_control') ? 1 : 0,
                'zone1_watch_out' => $request->has('zone1_watch_out') ? 1 : 0,
                'zone1_danger' => $request->has('zone1_danger') ? 1 : 0,
                'zone1_critical' => $request->has('zone1_critical') ? 1 : 0,
                'zone1_complications' => $request->has('zone1_complications') ? 1 : 0,
                'zone1_heart' => $request->has('zone1_heart') ? 1 : 0,
                'zone1_cerebrovascular' => $request->has('zone1_cerebrovascular') ? 1 : 0,
                'zone1_kidney' => $request->has('zone1_kidney') ? 1 : 0,
                'zone1_eye' => $request->has('zone1_eye') ? 1 : 0,
                'zone1_foot' => $request->has('zone1_foot') ? 1 : 0,
            ]);
        } else {
            return back()->with('error', 'ไม่พบข้อมูล health_zone');
        }

        // อัปเดตข้อมูล HealthZone2
        $healthZone2 = HealthZone2::where('recorddata_id', $recorddata_id)->first();
        if ($healthZone2) {
            $healthZone2->update([
                'zone2_normal' => $request->has('zone2_normal') ? 1 : 0,
                'zone2_risk_group' => $request->has('zone2_risk_group') ? 1 : 0,
                'zone2_good_control' => $request->has('zone2_good_control') ? 1 : 0,
                'zone2_watch_out' => $request->has('zone2_watch_out') ? 1 : 0,
                'zone2_danger' => $request->has('zone2_danger') ? 1 : 0,
                'zone2_critical' => $request->has('zone2_critical') ? 1 : 0,
                'zone2_complications' => $request->has('zone2_complications') ? 1 : 0,
                'zone2_heart' => $request->has('zone2_heart') ? 1 : 0,
                'zone2_eye' => $request->has('zone2_eye') ? 1 : 0,
            ]);
        } else {
            return back()->with('error', 'ไม่พบข้อมูล health_zone2');
        }

        // อัปเดตข้อมูล Diseases
        $diseases = Disease::where('recorddata_id', $recorddata_id)->first();
        if ($diseases) {
            $diseases->update([
                'diabetes' => $request->input('diabetes', 0),
                'cerebral_artery' => $request->input('cerebral_artery', 0),
                'kidney' => $request->input('kidney', 0),
                'blood_pressure' => $request->input('blood_pressure', 0),
                'heart' => $request->input('heart', 0),
                'eye' => $request->input('eye', 0),
                'other' => $request->input('other', 0),
            ]);
        } else {
            return back()->with('error', 'ไม่พบข้อมูลโรคประจำตัว');
        }

        // อัปเดตข้อมูล LifestyleHabit
        $lifestyles = LifestyleHabit::where('recorddata_id', $recorddata_id)->first();
        if ($lifestyles) {
            $lifestyles->update([
                'drink' => $request->input('drink', 0),
                'drink_sometimes' => $request->input('drink_sometimes', 0),
                'dont_drink' => $request->input('dont_drink', 0),
                'smoke' => $request->input('smoke', 0),
                'sometime_smoke' => $request->input('sometime_smoke', 0),
                'dont_smoke' => $request->input('dont_smoke', 0),
                'troubled' => $request->input('troubled', 0),
                'dont_live' => $request->input('dont_live', 0),
                'bored' => $request->input('bored', 0),
            ]);
        } else {
            return back()->with('error', 'ไม่พบข้อมูล LifestyleHabit');
        }

        // อัปเดตข้อมูล ElderlyInformation
        $elderlyInfos = ElderlyInformation::where('recorddata_id', $recorddata_id)->first();
        if ($elderlyInfos) {
            $elderlyInfos->update([
                'help_yourself' => $request->input('help_yourself', 0),
                'can_help' => $request->input('can_help', 0),
                'cant_help' => $request->input('cant_help', 0),
                'caregiver' => $request->input('caregiver', 0),
                'have_caregiver' => $request->input('have_caregiver', 0),
                'no_caregiver' => $request->input('no_caregiver', 0),
                'group1' => $request->input('group1', 0),
                'group2' => $request->input('group2', 0),
                'group3' => $request->input('group3', 0),
                'house' => $request->input('house', 0),
                'society' => $request->input('society', 0),
                'bed_ridden' => $request->input('bed_ridden', 0),
            ]);
        } else {
            return back()->with('error', 'ไม่พบข้อมูล Elderly Information');
        }

        return redirect()->route('recorddata.edit', ['id' => $recorddata->id])->with('success', 'อัปเดตข้อมูลสำเร็จเรียบร้อย!');
    }

    // หากไม่มี recorddata_id และ checkup_id ให้ทำการค้นหาข้อมูลด้วย id_card
    else {
        try {
            $idCard = $request->input('id_card');
            $data = Recorddata::where('id_card', $idCard)->first();

            if ($data) {
                // ส่งกลับเป็น JSON
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            } else {
                // ถ้าไม่พบข้อมูล ส่งกลับ JSON ที่บอกว่าไม่พบข้อมูล
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่พบข้อมูล',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Search ID Card error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage(),
            ]);
        }
    }
}

public function searchIdCard(Request $request)
{
    try {
        $idCard = $request->input('id_card');
        $data = Recorddata::where('id_card', $idCard)->first();

        if ($data) {
            // ส่งกลับเป็น JSON
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } else {
            // ถ้าไม่พบข้อมูล ส่งกลับ JSON ที่บอกว่าไม่พบข้อมูล
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูล',
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Search ID Card error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage(),
        ]);
    }
}


public function edit_form()
{
    // ดึงรายชื่อคอลัมน์
    $columns = Schema::getColumnListing('recorddata');

    // กำหนดคอลัมน์ที่ไม่ต้องการ
    $excludeColumns = ['user_id', 'created_at', 'updated_at', 'file_name', 'file_path', 'id'];

    // กรองคอลัมน์
    $columns = array_diff($columns, $excludeColumns);

    // ดึงข้อมูลจากฐานข้อมูล (ถ้าต้องการ)
    $recorddata = Recorddata::first();  // ดึงข้อมูลตัวอย่างจากฐานข้อมูล

    // ดึง extra_fields และแปลงจาก JSON เป็น Array
    $extra_fields = json_decode($recorddata->extra_fields, true) ?: [];

    // กำหนด label ที่ต้องการ
    $labels = [
        'surname' => 'นามสกุล',
        'name' => 'ชื่อ',
        'id_card' => 'เลขบัตรประจำตัวประชาชน',
        'prefix' => 'คำนำหน้าชื่อ',
        'housenumber' => 'บ้านเลขที่',
        'birthdate' => 'วัน / เดือน / ปีเกิด',
        'age' => 'อายุ',
        'blood_group' => 'กรุ๊ปเลือด',
        'weight' => 'น้ำหนัก',
        'height' => 'ส่วนสูง',
        'waistline' => 'รอบเอว',
        'bmi' => 'ดัชนีมวล BMI',
        'phone' => 'เบอร์โทรศัพท์',
        'idline' => 'ID Line',

    ];

    // ส่งข้อมูลไปที่ View
    return view('admin.edit_form_record', compact('columns', 'extra_fields', 'recorddata', 'labels'));
}



public function update_record(Request $request) 
{
    $extra_fields = $request->input('extra_fields');

    if ($extra_fields) {
    // สร้าง array ที่เก็บข้อมูลที่ต้องการจะบันทึก
    $extra_data = [];

    foreach ($extra_fields as $field) {
        // ตรวจสอบให้มั่นใจว่า $field เป็น array และมี 'value' และ 'label'
        if (is_array($field) && isset($field['value']) && isset($field['label'])) {
            // แปลงค่าจาก Unicode เป็นข้อความที่ต้องการ
            $decoded_value = json_decode('"' . $field['value'] . '"'); // แปลงจาก Unicode เป็นข้อความ
            $decoded_label = json_decode('"' . $field['label'] . '"'); // แปลงจาก Unicode เป็นข้อความ

            // ตรวจสอบว่าเป็น array แล้วแปลงเป็น string ถ้าจำเป็น
            if (is_array($decoded_value)) {
                $decoded_value = json_encode($decoded_value);
            }

            if (is_array($decoded_label)) {
                $decoded_label = json_encode($decoded_label);
            }

            // เก็บข้อมูลที่ได้
            $extra_data[] = ['label' => $decoded_label, 'value' => $decoded_value];
        } else {
            // หาก $field ไม่ใช่ array หรือไม่มี 'value' และ 'label' ให้ข้ามการทำงานนี้
            continue;
        }
    }

    // ดึงข้อมูลทั้งหมดจากตาราง Recorddata
    $records = Recorddata::all();

    // สร้างตัวแปรเพื่อเก็บค่าที่เกิดขึ้นซ้ำ
    $duplicate_values = [];

    foreach ($records as $record) {
        // ถ้ามีค่าใน extra_fields ของ record แล้ว ให้ทำการอัปเดต
        $existing_extra_fields = json_decode($record->extra_fields, true) ?: [];

        // ตรวจสอบว่าค่าใน extra_data มีค่าไหนที่ซ้ำกับข้อมูลที่มีอยู่ใน extra_fields หรือไม่
        foreach ($extra_data as $data) {
            $value = $data['value']; // ค่า value
            if (in_array($value, $existing_extra_fields)) {
                $duplicate_values[] = $value; // ถ้ามีค่าซ้ำ ให้เก็บค่าไว้ใน array
            }
        }

        // ถ้ามีค่าซ้ำ ให้ไม่ทำการบันทึกและแจ้งเตือน
        if (count($duplicate_values) > 0) {
            return redirect()->back()->with('error', 'ค่าที่ระบุมีอยู่ในฐานข้อมูลแล้ว: ' . implode(', ', $duplicate_values) . '. กรุณาใช้ชื่ออื่น');
        }

        // รวมข้อมูลใหม่เข้าไปใน extra_fields (ถ้ามีค่าใหม่ก็จะเพิ่ม)
        $updated_extra_fields = array_merge($existing_extra_fields, $extra_data);

        // แปลงข้อมูลกลับเป็น JSON และบันทึก
        $record->extra_fields = json_encode($updated_extra_fields, JSON_UNESCAPED_UNICODE);
        $record->save();
    }

    return redirect()->route('recorddata.create')->with('success', 'อัปเดตฟิลด์เรียบร้อย!');
}
    // รับข้อมูลคอลัมน์ที่ลบ
    $deletedFields = $request->input('deleted_fields');

    // ตรวจสอบค่าคอลัมน์ที่ลบ
    dd($deletedFields);  // ตรวจสอบว่าได้ค่าคอลัมน์จริงๆ หรือไม่

    // หากมีฟิลด์ที่ต้องการลบ
    if ($deletedFields) {
        foreach ($deletedFields as $field) {
            Schema::table('recorddata', function ($table) use ($field) {
                $table->dropColumn($field); // ลบคอลัมน์
            });
        }
        return redirect()->route('admin.edit_form_record')->with('success', 'ลบฟิลด์เรียบร้อย!');
    }

    return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
}

public function deleteExtraField(Request $request)
{
    // รับค่า label ที่จะลบ
    $label = $request->input('label');

    // ดึงข้อมูลทุก recorddata ที่มี extra_fields
    $recorddata = Recorddata::all();  // ดึงทุก recorddata

    // ตรวจสอบหากไม่พบข้อมูล
    if ($recorddata->isEmpty()) {
        return response()->json(['message' => 'ไม่พบข้อมูล'], 404);
    }

    // ลบข้อมูลใน extra_fields สำหรับทุก recorddata ที่มี label ตรงกัน
    foreach ($recorddata as $data) {
        // แปลง extra_fields จาก JSON เป็น array
        $extra_fields = json_decode($data->extra_fields, true);

        // ลบข้อมูลที่มี label ตรงกัน
        $extra_fields = array_filter($extra_fields, function($field) use ($label) {
            return $field['label'] !== $label;
        });

        // รีเซ็ตค่า array ที่ลบ
        $data->extra_fields = json_encode(array_values($extra_fields));

        // บันทึกข้อมูลใหม่ในฐานข้อมูล
        $data->save();
    }

    return response()->json(['success' => true]);
}


public function edit_form_general_information()
{
    // ดึงรายชื่อคอลัมน์จาก health_records
    $healthRecordColumns = Schema::getColumnListing('health_records');
    $excludeColumnsHealthRecord = ['recorddata_id', 'created_at', 'updated_at', 'file_name', 'file_path', 'id'];
    $filteredHealthRecordColumns = array_diff($healthRecordColumns, $excludeColumnsHealthRecord);

    // ส่งค่ากลับไปยัง View
    return view('admin.edit_form_general_information', compact(
        'filteredHealthRecordColumns', 
    ));
}


public function update_form_general_information(Request $request)
{
    // รับข้อมูลที่ส่งมาจากฟอร์ม
    $extra_fields = $request->input('extra_fields');
    $deletedFields = $request->input('deleted_fields');

    // ตรวจสอบและเพิ่มฟิลด์ใหม่
    if ($extra_fields) {
        foreach ($extra_fields as $field) {
            Schema::table('health_records', function ($table) use ($field) {
                $table->string($field['value'])->nullable();
            });
        }
        return redirect()->route('recorddata.index')->with('success', 'อัปเดตฟิลด์เรียบร้อย!');
    }

    // ถ้ามีฟิลด์ที่ถูกลบ
    if ($deletedFields) {
        foreach ($deletedFields as $field) {
            Schema::table('health_records', function ($table) use ($field) {
                $table->dropColumn($field);
            });
        }
        return redirect()->route('admin.edit_form_general_information')->with('success', 'ลบฟิลด์เรียบร้อย!');
    }

    return redirect()->back()->with('warning', 'ไม่มีการเปลี่ยนแปลงใด ๆ');
}

public function edit_form_disease()
{
    $diseaseColumns = Schema::getColumnListing('disease');
    $excludeColumnsDiseases = ['id', 'recorddata_id', 'created_at', 'updated_at'];
    $filteredDiseaseColumns = array_diff($diseaseColumns, $excludeColumnsDiseases);

    return view('admin.edit_form_disease', compact(
        'filteredDiseaseColumns'
    ));
}

public function update_disease(Request $request)
{
    // รับข้อมูลที่ส่งมาจากฟอร์ม
    $extra_fields = $request->input('extra_fields');
    $deletedFields = $request->input('deleted_fields');

    // ตรวจสอบและเพิ่มฟิลด์ใหม่
    if ($extra_fields) {
        foreach ($extra_fields as $field) {
            Schema::table('disease', function ($table) use ($field) {
                $table->string($field['value'])->nullable();
            });
        }
        return redirect()->route('recorddata.index')->with('success', 'อัปเดตฟิลด์เรียบร้อย!');
    }

    // ถ้ามีฟิลด์ที่ถูกลบ
    if ($deletedFields) {
        foreach ($deletedFields as $field) {
            Schema::table('disease', function ($table) use ($field) {
                $table->dropColumn($field);
            });
        }
        return redirect('/admin/edit_form_general_information')->with('success', 'ลบฟิลด์เรียบร้อย!');
    }

    return redirect()->back()->with('warning', 'ไม่มีการเปลี่ยนแปลงใด ๆ');
}


}