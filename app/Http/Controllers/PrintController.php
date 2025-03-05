<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recorddata;
use App\Models\HealthRecord;
use App\Models\HealthZone;
use App\Models\HealthZone2;
use App\Models\Disease;
use App\Models\LifestyleHabit;
use App\Models\ElderlyInformation;
use Carbon\Carbon;

class PrintController extends Controller
{
    public function showPrintPage($id)
{
    $recorddataList = Recorddata::paginate(30);
    $groupedData = $recorddataList->groupBy('section');
    $currentYear = Carbon::now()->year;

    $healthRecords = HealthRecord::where('recorddata_id', $id)
        ->whereYear('created_at', $currentYear)
        ->get();

    $healthZones = HealthZone::where('recorddata_id', $id)
        ->whereYear('created_at', $currentYear)
        ->get();

    $healthZones2 = HealthZone2::where('recorddata_id', $id)
        ->whereYear('created_at', $currentYear)
        ->get();

    $diseases = Disease::where('recorddata_id', $id)
        ->whereYear('created_at', $currentYear)
        ->get();

    $lifestyleHabits = LifestyleHabit::where('recorddata_id', $id)
        ->whereYear('created_at', $currentYear)
        ->get();

    $elderlyInformations = ElderlyInformation::where('recorddata_id', $id)
        ->whereYear('created_at', $currentYear)
        ->get();

    //$user = $recorddata-> user_id ?? 'ไม่มีข้อมูล';
    //$userFullName = isset($recorddata->user_id) ? $recorddata->user_id->name . ' ' . $recorddata->user_id->surname : 'ไม่มีข้อมูล';
    //dd($userFullName);


    $inspections = collect();

    $inspectionCount = max(
        $healthRecords->count(),
        $healthZones->count(),
        $healthZones2->count(),
        $diseases->count(),
        $lifestyleHabits->count(),
        $elderlyInformations->count()
    );

    for ($i = 0; $i < $inspectionCount; $i++) {
        $healthRecord = isset($healthRecords[$i]) ? $healthRecords[$i] : null;

        $healthZone = isset($healthZones[$i]) ? $healthZones[$i] : null;

        $healthZone2 = isset($healthZones2[$i]) ? $healthZones2[$i] : null;

        $disease = isset($diseases[$i]) ? $diseases[$i] : null;
        $diseaseNames = [];

        if ($disease) {
            if ($disease->diabetes == 1) $diseaseNames[] = 'เบาหวาน';
            if ($disease->cerebral_artery == 1) $diseaseNames[] = 'หลอดเลือดสมอง';
            if ($disease->kidney == 1) $diseaseNames[] = 'ไต';
            if ($disease->blood_pressure == 1) $diseaseNames[] = 'ความดันโลหิตสูง';
            if ($disease->heart == 1) $diseaseNames[] = 'หัวใจ';
            if ($disease->eye == 1) $diseaseNames[] = 'ตา';
            if ($disease->other == 1) $diseaseNames[] = 'อื่น ๆ';
        }

        $lifestyleHabit = isset($lifestyleHabits[$i]) ? $lifestyleHabits[$i] : null;
    $habits = [];

    if ($lifestyleHabit) {
        if ($lifestyleHabit->drink == 1) $habits[] = 'ดื่มแอลกอฮอล์';
        if ($lifestyleHabit->drink_sometimes == 1) $habits[] = 'ดื่มแอลกอฮอล์บ้างบางครั้ง';
        if ($lifestyleHabit->dont_drink == 1) $habits[] = 'ไม่ดื่มแอลกอฮอล์';
        if ($lifestyleHabit->smoke == 1) $habits[] = 'สูบบุหรี่';
        if ($lifestyleHabit->sometime_smoke == 1) $habits[] = 'สูบบุหรี่บางครั้ง';
        if ($lifestyleHabit->dont_smoke == 1) $habits[] = 'ไม่สูบบุหรี่';
        if ($lifestyleHabit->troubled == 1) $habits[] = 'ทุกข์ใจ ซึม เศร้า';
        if ($lifestyleHabit->dont_live == 1) $habits[] = 'ไม่อยากมีชีวิตอยู่';
        if ($lifestyleHabit->bored == 1) $habits[] = 'เบื่อ';
    }
    $elderlyInformation = isset($elderlyInformations[$i]) ? $elderlyInformations[$i] : null;
    $elderlyHabits = [];

    if ($elderlyInformation) {
        if ($elderlyInformation->help_yourself == 1) $elderlyHabits[] = 'ช่วยเหลือตัวเองได้';
        if ($elderlyInformation->can_help == 1) $elderlyHabits[] = 'ช่วยเหลือตัวเองได้';
        if ($elderlyInformation->cant_help == 1) $elderlyHabits[] = 'ช่วยเหลือตัวเองไม่ได้';
        if ($elderlyInformation->caregiver == 1) $elderlyHabits[] = 'ผู้ดูแล';
        if ($elderlyInformation->have_caregiver == 1) $elderlyHabits[] = 'มีผู้ดูแล';
        if ($elderlyInformation->no_caregiver == 1) $elderlyHabits[] = 'ไม่มีผู้ดูแล';
        if ($elderlyInformation->group1 == 1) $elderlyHabits[] = 'กลุ่มที่ 1 ผู้สูงอายุช่วยตัวเองและผู้อื่นได้';
        if ($elderlyInformation->group2 == 1) $elderlyHabits[] = 'กลุ่มที่ 2 ผู้สูงอายุช่วยตัวเองแต่มีโรคเรื้อรัง';
        if ($elderlyInformation->group3 == 1) $elderlyHabits[] = 'กลุ่มที่ 3 ผู้สูงอายุ/ผู้ป่วยดูแลตัวเองไม่ได้';
        if ($elderlyInformation->house == 1) $elderlyHabits[] = 'ติดบ้าน';
        if ($elderlyInformation->society == 1) $elderlyHabits[] = 'ติดสังคม';
        if ($elderlyInformation->bed_ridden == 1) $elderlyHabits[] = 'ติดเตียง';
    }

        $inspections->push([
            'inspection_number' => $i + 1,
            
            'date' => $recorddata->created_at->format('d/m/Y'),
            'health_record' => $healthRecord ? [
                'sys' => $healthRecord->sys ?? 'ไม่มีข้อมูล',
                'dia' => $healthRecord->dia ?? 'ไม่มีข้อมูล',
                'pul' => $healthRecord->pul ?? 'ไม่มีข้อมูล',
                'body_temp' => $healthRecord->body_temp ?? 'ไม่มีข้อมูล',
                'blood_oxygen' => $healthRecord->blood_oxygen ?? 'ไม่มีข้อมูล',
                'blood_level' => $healthRecord->blood_level ?? 'ไม่มีข้อมูล',
            ] : null,
            'health_zone_id' => $healthZone ? $healthZone->id : 'ไม่มีข้อมูล',
            'health_zone' => $healthZone ? $this->getHealthZoneData($healthZone) : 'ไม่มีข้อมูล',
            'health_zone2_id' => $healthZone2 ? $healthZone2->id : 'ไม่มีข้อมูล',
            'health_zone2' => $healthZone2 ? $this->getHealthZone2Data($healthZone2) : 'ไม่มีข้อมูล',
            'disease' => $diseaseNames ?: 'ไม่มีข้อมูล',
            'inspection_number' => $i + 1,
            'lifestyle_habits' => $habits ?: 'ไม่มีข้อมูล',
            'inspection_number' => $i + 1,
            'elderly_information' => $elderlyHabits ?: 'ไม่มีข้อมูล',
        ]);
    }

    return view('admin.print', compact('recorddata', 'inspections', 'healthRecords'));
}

private function getHealthZoneData($healthZone)
{
    if (!$healthZone) return 'ไม่มีข้อมูล';

    // ตรวจสอบค่าที่ได้รับ
    //dd($healthZone->toArray());

    $zoneData = [];

    if ($healthZone->zone1_normal == 1) $zoneData[] = 'ปกติ';
    if ($healthZone->zone1_risk_group == 1) $zoneData[] = 'กลุ่มเสี่ยง';
    if ($healthZone->zone1_good_control == 1) $zoneData[] = 'คุมได้ดี';
    if ($healthZone->zone1_watch_out == 1) $zoneData[] = 'เฝ้าระวัง';
    if ($healthZone->zone1_danger == 1) $zoneData[] = 'อันตราย';
    if ($healthZone->zone1_critical == 1) $zoneData[] = 'วิกฤต';
    if ($healthZone->zone1_complications == 1) $zoneData[] = 'โรคแทรกซ้อน';
    if ($healthZone->zone1_heart == 1) $zoneData[] = 'หัวใจ';
    if ($healthZone->zone1_cerebrovascular == 1) $zoneData[] = 'หลอดเลือดสมอง';
    if ($healthZone->zone1_kidney == 1) $zoneData[] = 'ไต';
    if ($healthZone->zone1_eye == 1) $zoneData[] = 'ตา';
    if ($healthZone->zone1_foot == 1) $zoneData[] = 'เท้า';

    return $zoneData;
}

private function getHealthZone2Data($healthZone2)
{
    if (!$healthZone2) return 'ไม่มีข้อมูล';

    $zone2Data = [];

    if ($healthZone2->zone2_normal == 1) $zone2Data[] = 'ปกติ';
    if ($healthZone2->zone2_risk_group == 1) $zone2Data[] = 'กลุ่มเสี่ยง';
    if ($healthZone2->zone2_good_control == 1) $zone2Data[] = 'คุมได้ดี';
    if ($healthZone2->zone2_watch_out == 1) $zone2Data[] = 'เฝ้าระวัง';
    if ($healthZone2->zone2_danger == 1) $zone2Data[] = 'อันตราย';
    if ($healthZone2->zone2_critical == 1) $zone2Data[] = 'วิกฤต';
    if ($healthZone2->zone2_complications == 1) $zone2Data[] = 'โรคแทรกซ้อน';
    if ($healthZone2->zone2_heart == 1) $zone2Data[] = 'หัวใจ';
    if ($healthZone2->zone2_eye == 1) $zone2Data[] = 'ตา';

    return $zone2Data;
}

}