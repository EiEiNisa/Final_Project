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
    
        // ดึงคอลัมน์จากตาราง recorddata
        $columns_recorddata = Schema::getColumnListing('recorddata');
        $exclude_columns_recorddata = [
            'id','user_id', 'id_card', 'prefix','name','surname','housenumber','birthdate',
            'age','blood_group','weight','height','bmi','waistline','phone','idline','created_at', 'updated_at' ,'file_name',
            'file_path'
        ];
        $extra_fields_recorddata = array_diff($columns_recorddata, $exclude_columns_recorddata);
    
        // ดึงคอลัมน์จากตาราง health_records
        $columns_health_records = Schema::getColumnListing('health_records');
        $exclude_columns_health_records = [
            'id', 'recorddata_id', 'sys', 'dia', 'pul', 'body_temp', 'blood_oxygen', 'blood_level', 'created_at', 'updated_at'
        ];
        $extra_fields_health_records = array_diff($columns_health_records, $exclude_columns_health_records);
    
        // ส่งค่าคอลัมน์ที่ถูกกรองแล้วไปยัง view
        return view('admin.addrecord', compact('extra_fields_recorddata', 'extra_fields_health_records', 'users'));
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
    
    // ตรวจสอบวันที่จาก request (หากมี)
    $searchDate = $request->input('search_date');
    $healthRecordsQuery = HealthRecord::where('recorddata_id', $id);

    // ถ้ามีวันที่ให้เลือก ค้นหาข้อมูลจากวันที่ที่เลือก
    if ($searchDate) {
        $searchDate = \Carbon\Carbon::createFromFormat('Y-m-d', $searchDate)->toDateString();
        $healthRecordsQuery->whereDate('created_at', $searchDate); // ค้นหาตามวันที่
    }
    
    // ดึงข้อมูล healthRecords ที่ตรงกับเงื่อนไข
    $healthRecords = $healthRecordsQuery->orderBy('created_at', 'desc')->get();
    if ($healthRecords->isEmpty()) {
        return back()->with('error', 'ไม่พบข้อมูล healthRecords');
    }

    $healthZones = HealthZone::where('recorddata_id', $recorddata->id)
        ->orderBy('created_at', 'desc')
        ->get();
    if ($healthZones->isEmpty()) {
        return back()->with('error', 'ไม่พบข้อมูล health_zone');
    }

    $zones = [];
    foreach ($healthZones as $index => $healthZone) {
        // ตรวจสอบการแสดงผลแต่ละ zone ตามลำดับที่
        $checkupIndex = $index + 1;
        if ($healthZone->zone1_normal) { $zones[$checkupIndex][] = 'ปกติ'; }
        if ($healthZone->zone1_risk_group) { $zones[$checkupIndex][] = 'กลุ่มเสี่ยง'; }
        if ($healthZone->zone1_good_control) { $zones[$checkupIndex][] = 'คุมได้ดี'; }
        if ($healthZone->zone1_watch_out) { $zones[$checkupIndex][] = 'เฝ้าระวัง'; }
        if ($healthZone->zone1_danger) { $zones[$checkupIndex][] = 'อันตราย'; }
        if ($healthZone->zone1_critical) { $zones[$checkupIndex][] = 'วิกฤต'; }
        if ($healthZone->zone1_complications) { $zones[$checkupIndex][] = 'โรคแทรกซ้อน'; }
        if ($healthZone->zone1_heart) { $zones[$checkupIndex][] = 'หัวใจ'; }
        if ($healthZone->zone1_cerebrovascular) { $zones[$checkupIndex][] = 'หลอดเลือดสมอง'; }
        if ($healthZone->zone1_kidney) { $zones[$checkupIndex][] = 'ไต'; }
        if ($healthZone->zone1_eye) { $zones[$checkupIndex][] = 'ตา'; }
        if ($healthZone->zone1_foot) { $zones[$checkupIndex][] = 'เท้า'; }
    }
    //dd($zones);
    $healthZones2 = HealthZone2::where('recorddata_id', $recorddata->id)
        ->orderBy('created_at', 'desc')
        ->get();
    if ($healthZones2->isEmpty()) {
        return back()->with('error', 'ไม่พบข้อมูล health_zone');
    }

    $zones2 = [];
    foreach ($healthZones2 as $index => $healthZone2) {
        $checkupIndex = $index + 1; // ใช้การตรวจครั้งที่เพิ่มตามลำดับ
        $zones2[$checkupIndex] = [];
        if ($healthZone2->zone2_normal) { $zones2[$checkupIndex][] = 'ปกติ'; }
        if ($healthZone2->zone2_risk_group) { $zones2[$checkupIndex][] = 'กลุ่มเสี่ยง'; }
        if ($healthZone2->zone2_good_control) { $zones2[$checkupIndex][] = 'คุมได้ดี'; }
        if ($healthZone2->zone2_watch_out) { $zones2[$checkupIndex][] = 'เฝ้าระวัง'; }
        if ($healthZone2->zone2_danger) { $zones2[$checkupIndex][] = 'อันตราย'; }
        if ($healthZone2->zone2_critical) { $zones2[$checkupIndex][] = 'วิกฤต'; }
        if ($healthZone2->zone2_complications) { $zones2[$checkupIndex][] = 'โรคแทรกซ้อน'; }
        if ($healthZone2->zone2_heart) { $zones2[$checkupIndex][] = 'หัวใจ'; }
        if ($healthZone2->zone2_eye) { $zones2[$checkupIndex][] = 'ตา'; }
    }

    $zones = array_map(function ($zone) {
        return implode(' ', $zone);
    }, $zones);

    $zones2 = array_map(function ($zone) {
        return implode(' ', $zone);
    }, $zones2);

    
    $diseases = Disease::where('recorddata_id', $recorddata->id)
        ->orderBy('created_at', 'desc')
        ->get();
    if ($diseases->isEmpty()) {
        return back()->with('error', 'ไม่พบข้อมูลโรค');
    }

    $diseaseNames = [];
    foreach ($diseases as $disease) {
        if ($disease->diabetes) $diseaseNames[] = 'เบาหวาน';
        if ($disease->cerebral_artery) $diseaseNames[] = 'หลอดเลือดสมอง';
        if ($disease->kidney) $diseaseNames[] = 'ไต';
        if ($disease->blood_pressure) $diseaseNames[] = 'ความดันโลหิตสูง';
        if ($disease->heart) $diseaseNames[] = 'หัวใจ';
        if ($disease->eye) $diseaseNames[] = 'ตา';
        if ($disease->other) $diseaseNames[] = 'อื่น ๆ';
    }

    $lifestyles = LifestyleHabit::where('recorddata_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    $lifestyleshabit = [];
    foreach ($lifestyles as $lifestyle) {
        if ($lifestyle->drink) $lifestyleshabit[] = 'ดื่ม';
        if ($lifestyle->drink_sometimes) $lifestyleshabit[] = 'ดื่มบ้างบางครั้ง';
        if ($lifestyle->dont_drink) $lifestyleshabit[] = 'ไม่ดื่ม';
        if ($lifestyle->smoke) $lifestyleshabit[] = 'สูบ';
        if ($lifestyle->sometime_smoke) $lifestyleshabit[] = 'สูบบางครั้ง';
        if ($lifestyle->dont_smoke) $lifestyleshabit[] = 'ไม่สูบ';
        if ($lifestyle->troubled) $lifestyleshabit[] = 'ทุกข์ใจ ซึม เศร้า';
        if ($lifestyle->dont_live) $lifestyleshabit[] = 'ไม่อยากมีชีวิตอยู่';
        if ($lifestyle->bored) $lifestyleshabit[] = 'เบื่อ';
    }

    $elderlyInfos = ElderlyInformation::where('recorddata_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    $elderly = [];
    foreach ($elderlyInfos as $info) {
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
    }

    return view('admin.editrecord', compact(
        'recorddata', 'healthRecords', 'healthZones', 'zones', 'zones2', 
        'diseaseNames', 'lifestyleshabit', 'elderly', 'user'
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
    // ค้นหาข้อมูลที่ต้องการแก้ไข
    $data = Recorddata::findOrFail($id);

    // อัพเดทข้อมูลจากฟอร์ม
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
    // รับข้อมูลฟิลด์ที่ต้องการเพิ่มใหม่
    $extra_fields = $request->input('extra_fields');
    
    if ($extra_fields) {
        foreach ($extra_fields as $field) {
            Schema::table('recorddata', function ($table) use ($field) {
                $table->string($field['value'])->nullable();
            });
        }
        return redirect()->route('recorddata.index')->with('success', 'อัปเดตฟิลด์เรียบร้อย!');
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


public function update_general_information(Request $request)
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