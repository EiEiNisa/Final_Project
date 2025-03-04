<?php

namespace App\Exports;

use App\Models\Recorddata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataExport implements FromCollection, WithHeadings, WithMapping
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
            'user_id'
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
            'user_id'
        ];
    }

    public function map($row): array
    {
        return [
            "'" . $row->id_card, // เพิ่มเครื่องหมาย ' เพื่อให้ Excel อ่านเป็น text
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
            $row->user_id
        ];
    }
}
