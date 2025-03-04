<?php

namespace App\Exports;

use App\Models\Recorddata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DataExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
{
    public function collection()
    {
        return Recorddata::select(
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
            'user_name'
        )
        ->get()
        ->makeHidden(['id', 'created_at', 'updated_at']); // ซ่อนคอลัมน์ที่ไม่ต้องการ
    }

    public function headings(): array
    {
        return [
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
            'user_name'
        ];
    }

    public function map($row): array
    {
        return [
            (string) $row->id_card, // แปลงให้เป็น String โดยตรง
            $row->prefix,
            $row->name,
            $row->surname,
            $row->housenumber,
            $row->birthdate,
            $row->age,
            $row->blood_group,
            $row->weight,
            $row->height,
            $row->waistline,
            $row->bmi,
            $row->phone,
            $row->idline,
            $row->user_name
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // กำหนดให้คอลัมน์ A (id_card) เป็น Text
        ];
    }
}
