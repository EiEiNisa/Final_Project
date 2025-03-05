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
    public function showPrintPage(Request $request)
{
    $ids = $request->input('ids');  // รับค่า ids[] จาก URL

    // ตรวจสอบว่ามีค่าจาก ids[] หรือไม่
    if (!$ids) {
        return redirect()->route('admin.print')->with('error', 'No items selected.');
    }

    $recorddataList = Recorddata::whereIn('id', $ids)->get();  // Use the selected IDs to filter the records

    $currentYear = Carbon::now()->year;

    $inspections = collect();  // Initialize inspections collection

    foreach ($ids as $id) {
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
            $lifestyleHabit = isset($lifestyleHabits[$i]) ? $lifestyleHabits[$i] : null;
            $elderlyInformation = isset($elderlyInformations[$i]) ? $elderlyInformations[$i] : null;

            // Continue processing each record as per your existing logic

            $inspections->push([  // Push the current inspection data to the inspections collection
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
                'lifestyle_habits' => $habits ?: 'ไม่มีข้อมูล',
                'elderly_information' => $elderlyHabits ?: 'ไม่มีข้อมูล',
            ]);
        }
    }

    return view('admin.print', compact('recorddataList', 'inspections', 'healthRecords'));
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