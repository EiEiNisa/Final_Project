<?php

namespace App\Exports;

use App\Models\Recorddata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings
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
}
