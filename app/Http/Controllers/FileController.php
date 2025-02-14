<?php

namespace App\Http\Controllers;

use App\Models\Recorddata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function storeFileDataInDatabase()
    {
        // ดึงไฟล์ทั้งหมดจากโฟลเดอร์ public/uploads
        $files = File::allFiles(public_path('uploads'));

        foreach ($files as $file) {
            // ตั้งชื่อไฟล์ใหม่หรือใช้ชื่อเดิม
            $fileName = $file->getFilename();
            $filePath = $file->getRealPath();

            // เก็บข้อมูลไฟล์ลงในฐานข้อมูล
            $recorddata = new Recorddata();
            $recorddata->file_name = $fileName; // หรือชื่อที่คุณต้องการ
            $recorddata->file_path = $filePath; // หรือ public/uploads/$fileName
            $recorddata->save();
        }

        return response()->json(['success' => 'Files have been saved to the database.']);
    }
}


