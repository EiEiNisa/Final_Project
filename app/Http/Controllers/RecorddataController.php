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
    $users = User::all();
    if ($users->isEmpty()) {
        return back()->with('error', 'ไม่มีข้อมูลผู้ใช้ในระบบ');
    }

    // ดึงข้อมูล recorddata ตัวอย่าง (เลือก recorddata ตัวแรกหรือเพิ่มการค้นหาที่เหมาะสม)
    $recorddata = Recorddata::first(); // หรือใช้ `Recorddata::find($id)` ตามที่คุณต้องการ

    // ดึงคอลัมน์จากตาราง recorddata
    $columns_recorddata = Schema::getColumnListing('recorddata');
    $exclude_columns_recorddata = [
        'id', 'user_id', 'id_card', 'prefix', 'name', 'surname', 'housenumber', 'birthdate',
        'age', 'blood_group', 'weight', 'height', 'bmi', 'waistline', 'phone', 'idline', 'created_at', 'updated_at', 'file_name',
        'file_path'
    ];
    $extra_fields_recorddata = array_diff($columns_recorddata, $exclude_columns_recorddata);

    // ดึงคอลัมน์จากตาราง health_records
    $columns_health_records = Schema::getColumnListing('health_records');
    $exclude_columns_health_records = [
        'id', 'recorddata_id', 'sys', 'dia', 'pul', 'body_temp', 'blood_oxygen', 'blood_level', 'created_at', 'updated_at'
    ];
    $extra_fields_health_records = array_diff($columns_health_records, $exclude_columns_health_records);

    // ส่งค่าคอลัมน์ที่ถูกกรองแล้วและ recorddata ไปยัง view
    return view('admin.addrecord', compact('extra_fields_recorddata', 'extra_fields_health_records', 'users', 'recorddata'));
}


    public function store(Request $request)
{
    $validated = $request->validate([
        // การตรวจสอบค่า (Validation rules)
        'user_id' => 'required|exists:users,id',
        'id_card' => 'required|digits:13',
        'prefix' => 'required|string',
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'housenumber' => 'required|string|max:255',
        'birthdate' => 'required|date',
        'age' => 'required|integer|min:0',
        'blood_group' => 'required|in:A,B,AB,O',
        'weight' => 'required|numeric|min:0',
        'height' => 'required|numeric|min:0',
        'waistline' => 'required|numeric|min:0',
        'bmi' => 'required|numeric|min:0',
        'phone' => 'required|numeric|digits:10',
        'idline' => 'required|string|max:255',
        
        'zone1_normal' => 'nullable|boolean',
        'zone1_risk_group' => 'nullable|boolean',
        'zone1_good_control' => 'nullable|boolean',
        'zone1_watch_out' => 'nullable|boolean',
        'zone1_danger' => 'nullable|boolean',
        'zone1_critical' => 'nullable|boolean',
        'zone1_complications' => 'nullable|boolean',
        'zone1_heart' => 'nullable|boolean',
        'zone1_cerebrovascular' => 'nullable|boolean',
        'zone1_kidney' => 'nullable|boolean',
        'zone1_eye' => 'nullable|boolean',
        'zone1_foot' => 'nullable|boolean',

        'zone2_normal' => 'nullable|boolean',
        'zone2_risk_group' => 'nullable|boolean',
        'zone2_good_control' => 'nullable|boolean',
        'zone2_watch_out' => 'nullable|boolean',
        'zone2_danger' => 'nullable|boolean',
        'zone2_critical' => 'nullable|boolean',
        'zone2_complications' => 'nullable|boolean',
        'zone2_heart' => 'nullable|boolean',
        'zone2_eye' => 'nullable|boolean',
    ]);

    $extra_fields = $request->input('extra_fields');  // ได้ array ที่ซ้อนกัน
    //$extra_fields = $request->input('extra_fields.extra_fields');  // ถ้า extra_fields ถูกซ้อนภายใน

    // ตรวจสอบว่า extra_fields มีข้อมูลที่คาดหวังหรือไม่
    if (isset($extra_fields) && is_array($extra_fields)) {
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
                'user_id' => $request->user_id,
            ]
        );
    
        // เพิ่มค่าฟิลด์จาก extra_fields ใน Recorddata
        foreach ($extra_fields as $field => $value) {
            $recorddata->{$field} = $value;
        }
    }

        // ตอนนี้ $recorddata ถูกสร้างแล้ว
        foreach ($extra_fields as $field => $value) {
            // เพิ่มค่าฟิลด์ใหม่ในข้อมูลที่ต้องการบันทึก
            $recorddata->{$field} = $value;  // ใส่ค่าในโมเดล
        }

        
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
        //dd($healthZone);
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

    return view('admin.editrecord', compact(
        'recorddata', 'healthRecords', 'healthZones', 'zones', 'zones2', 
        'diseaseNames', 'lifestylesHabit','elderlyInfo', 'user' , 
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
    
    $data->save();

    return redirect()->route('recorddata.index')->with('success', 'ข้อมูลถูกบันทึกแล้ว');
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
    if ($request->filled('diseases')) {
        $query->whereHas('disease', function ($q) use ($request) {
            // ค้นหาผู้ที่มีโรคนี้ โดยเช็คว่าโรคมีค่าคือ 1 (มีโรค)
            $q->where($request->input('diseases'), 1); // ค่าของโรคที่เลือก (จากฟอร์ม select)
        });
    }

    // ทำการค้นหาจาก query ที่กำหนดและทำการแบ่งหน้า
    $recorddata = $query->orderBy('id', 'desc')->paginate(20);

    // ดึงข้อมูลผู้ใช้และโรคประจำตัว
    $users = User::all();
    $diseases = Disease::all();

    // ส่งข้อมูลไปยัง view
    return view('admin.record', compact('recorddata', 'users', 'diseases'));
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

    $healthRecord = HealthRecord::where('recorddata_id', $recorddata_id)
                             ->where('id', $checkup_id)
                             ->first();

    if (!$healthRecord) {
        return back()->with('error', 'ไม่พบข้อมูล healthRecord');
    }

    // ค้นหา healthZone ตาม recorddata_id
    $healthZone = HealthZone::where('recorddata_id', $recorddata_id)
                    ->where('id', $checkup_id)
                    ->first();
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
                    ->where('id', $checkup_id)
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
                ->where('id', $checkup_id)
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
                    ->where('id', $checkup_id)
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
                        ->where('id', $checkup_id)
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


public function update_general_information(Request $request, $recorddata_id, $checkup_id)
{

    //dd($request->all());

    // ค้นหา recorddata โดยใช้ recorddata_id
    $recorddata = Recorddata::findOrFail($recorddata_id);

    if (!$recorddata->user_id) {
        return back()->with('error', 'ไม่พบ user_id');
    }

    //dd($checkup_id);
    // ค้นหา healthRecord โดยใช้ recorddata_id และ checkup_id
    $healthRecord = HealthRecord::where('recorddata_id', $recorddata_id)
                                 ->where('id', $checkup_id)
                                 ->first();

    if (!$healthRecord) {
        return back()->with('error', 'ไม่พบข้อมูล healthRecords');
    }

    $healthRecord->update([
            'sys' => $request->input('sys'),
            'dia' => $request->input('dia'),
            'pul' => $request->input('pul'),
            'body_temp' => $request->input('body_temp'),
            'blood_oxygen' => $request->input('blood_oxygen'),
            'blood_level' => $request->input('blood_level'),
    ]);

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

    // ค้นหา healthZone2 และอัปเดต
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

    // ค้นหา diseases และอัปเดต
    $diseases = Disease::where('recorddata_id', $recorddata_id)->first();
    if ($diseases) {
        $updatediseases = $diseases->update([
            'diabetes' => $request->input('diabetes', 0),
            'cerebral_artery' => $request->input('cerebral_artery', 0),
            'kidney' => $request->input('kidney', 0),
            'blood_pressure' => $request->input('blood_pressure', 0),
            'heart' => $request->input('heart', 0),
            'eye' => $request->input('eye', 0),
            'other' => $request->input('other', 0),
        ]);
        
        //dd($updated); // ค่าควรเป็น true ถ้าอัปเดตสำเร็จ
        
    } else {
        return back()->with('error', 'ไม่พบข้อมูลโรคประจำตัว');
    }

    // ค้นหา LifestyleHabit และอัปเดต
    $lifestyles = LifestyleHabit::where('recorddata_id', $recorddata_id)->first();
    if ($lifestyles) {
        $updatelifestyles = $lifestyles->update([
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

    // ค้นหา ElderlyInformation และอัปเดต
    $elderlyInfos = ElderlyInformation::where('recorddata_id', $recorddata_id)->first();
    if ($elderlyInfos) {
        $updateelderlyInfos = $elderlyInfos->update([
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
    return redirect()->route('recorddata.edit', ['id' => $recorddata->id])->with('success', 'อัปเดตฟิลด์เรียบร้อย!');
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
    $columns = Schema::getColumnListing('recorddata');

    $excludeColumns = ['user_id', 'created_at', 'updated_at', 'file_name', 'file_path', 'id'];

    $columns = array_diff($columns, $excludeColumns);

    return view('admin.edit_form_record', compact('columns'));
}

public function update_record(Request $request) 
{
    $extra_fields = $request->input('extra_fields');

    if ($extra_fields) {
        // สร้าง array ที่เก็บข้อมูลที่ต้องการจะบันทึก
        $extra_data = [];

        foreach ($extra_fields as $field) {
            // แปลงค่าจาก Unicode เป็นข้อความที่ต้องการ
            $decoded_value = json_decode('"' . $field['value'] . '"'); // แปลงจาก Unicode เป็นข้อความ
            $extra_data[] = $decoded_value; // เก็บข้อมูลเป็นค่าล้วน (ไม่เก็บในรูปแบบ key => value)
        }

        // ดึงข้อมูลทั้งหมดจากตาราง Recorddata
        $records = Recorddata::all();

        // สร้างตัวแปรเพื่อเก็บค่าที่เกิดขึ้นซ้ำ
        $duplicate_values = [];

        foreach ($records as $record) {
            // ถ้ามีค่าใน extra_fields ของ record แล้ว ให้ทำการอัปเดต
            $existing_extra_fields = json_decode($record->extra_fields, true) ?: [];

            // ตรวจสอบว่าค่าใน extra_data มีค่าไหนที่ซ้ำกับข้อมูลที่มีอยู่ใน extra_fields หรือไม่
            foreach ($extra_data as $value) {
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