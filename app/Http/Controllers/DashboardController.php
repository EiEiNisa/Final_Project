<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recorddata;
use App\Models\Disease;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
{
    // Fetch the necessary data
    $total = RecordData::count();
    $female = RecordData::whereIn('prefix', ['นาง', 'นางสาว', 'ด.ญ.'])->count();
    $male = RecordData::whereIn('prefix', ['นาย', 'ด.ช.'])->count();

    // Get disease options for the select filter
    $disease_options = [
        ['value' => 'all', 'text' => 'ทั้งหมด'],
        ['value' => 'diabetes', 'text' => 'เบาหวาน'],
        ['value' => 'cerebral_artery', 'text' => 'หลอดเลือดในสมอง'],
        ['value' => 'kidney', 'text' => 'ไต'],
        ['value' => 'blood_pressure', 'text' => 'ความดันโลหิตสูง'],
        ['value' => 'heart', 'text' => 'หัวใจ'],
        ['value' => 'eye', 'text' => 'ตา'],
        ['value' => 'other', 'text' => 'อื่นๆ'],
    ];

    return view('dashboard.index', compact('total', 'female', 'male', 'disease_options'));
}

public function fetchData()
{
    // ข้อมูลทั้งหมด
    $total = RecordData::count();
    $female = RecordData::whereIn('prefix', ['นาง', 'นางสาว', 'ด.ญ.'])->count();
    $male = RecordData::whereIn('prefix', ['นาย', 'ด.ช.'])->count();

    // ข้อมูลกลุ่มอายุ
    $age_groups = ['0-6', '7-14', '15-34', '34-59', '60+'];
    $age_data = [];
    $age_labels = [];
    foreach ($age_groups as $group) {
        if ($group == '0-6') {
            $age_data[] = RecordData::whereBetween('age', [0, 6])->count();
        } elseif ($group == '7-14') {
            $age_data[] = RecordData::whereBetween('age', [7, 14])->count();
        } elseif ($group == '15-34') {
            $age_data[] = RecordData::whereBetween('age', [15, 34])->count();
        } elseif ($group == '34-59') {
            $age_data[] = RecordData::whereBetween('age', [34, 59])->count();
        } else {
            $age_data[] = RecordData::where('age', '>=', 60)->count();
        }
        $age_labels[] = $group;
    }

    // ข้อมูลโรคประจำตัวแยกตามเดือน
    $months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม'];  // แสดงเดือนที่บันทึกข้อมูล
    $diseases = [
        'diabetes' => [],
        'cerebral_artery' => [],
        'kidney' => [],
        'blood_pressure' => [],
        'heart' => [],
        'eye' => [],
        'other' => []
    ];

    // ใช้ Carbon เพื่อแปลงชื่อเดือนเป็นหมายเลขเดือน
    $month_map = [
        'มกราคม' => '01',
        'กุมภาพันธ์' => '02',
        'มีนาคม' => '03'
    ];

    foreach ($months as $month) {
        $monthNumber = $month_map[$month]; // แปลงชื่อเดือนเป็นตัวเลข

        foreach ($diseases as $disease => &$values) {
            // ใช้ whereMonth และ whereYear เพื่อให้สามารถดึงข้อมูลตามเดือนที่ถูกต้อง
            $count = Disease::whereMonth('created_at', $monthNumber)->where($disease, 1)->count();
            $values[] = $count;
        }
    }

    $disease_labels = ['ทั้งหมด', 'เบาหวาน', 'หลอดเลือดในสมอง', 'ไต', 'ความดันโลหิตสูง', 'หัวใจ', 'ตา', 'อื่นๆ'];

    // ส่งข้อมูลในรูปแบบ JSON
    return response()->json([
        'total' => $total,
        'female' => $female,
        'male' => $male,
        'age_labels' => $age_labels,
        'age_data' => $age_data,
        'diseases' => $diseases,
        'disease_labels' => $disease_labels,
        'months' => $months
    ]);
    
}
}