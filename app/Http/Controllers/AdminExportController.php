<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminExportController extends Controller
{
    public function export()
    {
        return Excel::download(new DataExport, 'Thung_Setthi_Community.xlsx');
    }
}

