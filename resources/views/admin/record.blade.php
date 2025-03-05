@extends('layoutadmin')

@section('content')
<style>
.title {
    color: #020364;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    /* เพื่อให้ปุ่มแตกแถวในหน้าจอเล็ก */
}

.btn-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    /* เพื่อให้ปุ่มแตกแถวในหน้าจอเล็ก */
}

.table {
    margin-top: 10px;
    margin-bottom: 10px;
    width: 100%;
}

.table th {
    background-color: #020364;
    color: #fff !important;
    /* ใช้ !important เพื่อบังคับให้ตัวหนังสือเป็นสีขาว */
    text-align: center;
}

.table td {
    background-color: #7DA7D8;
    color: #fff !important;
    word-wrap: break-word;
    max-width: 200px;
    text-align: center;
}

.table td:hover,
.table th:hover {
    color: #fff !important;
}

.rectangle-box {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin: 20px;
}

.form-group-horizontal {
    display: flex;
    flex-wrap: nowrap;
    overflow: hidden;
}

.form-group {
    min-width: 200px;
    /* ขนาดขั้นต่ำของแต่ละฟอร์มกลุ่ม */
    margin-right: 15px;
    /* เว้นระยะระหว่างฟอร์มกลุ่ม */
}

button.btn-primary {
    flex: 1 1 100%;
    font-size: 14px;
    padding: 12px 20px;
    margin-top: 10px;
}

label {
    font-size: 14px;
    font-weight: bold;
    color: #020364;
    margin-bottom: 8px;
}

.input-group {
    position: relative;
}

.form-control {
    border-radius: 30px;
    padding: 12px 20px;
    border: 1px solid #ddd;
    box-sizing: border-box;
    width: 100%;
    font-size: 14px;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
}

select.form-control {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 35px;
}

button.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.custom-pagination {
    display: flex;
    justify-content: center;
}

.custom-pagination a,
.custom-pagination span {
    padding: 8px 16px;
    background-color: #6c757d;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    margin: 0;
}

.custom-pagination a:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.custom-pagination .active {
    background-color: #495057;
    font-weight: bold;
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
}

.custom-pagination .disabled {
    background-color: #d6d8db;
    color: #868e96;
    cursor: not-allowed;
    box-shadow: none;
    opacity: 0.6;
}

.custom-pagination .disabled:hover {
    background-color: #d6d8db;
}


.modal-header {
    padding: 15px;
}

.modal-title {
    margin: 0;
}

.close-btn {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.2rem;
    transition: background-color 0.3s, transform 0.2s;
}

.close-btn:hover {
    background-color: #f8d7da;
    color: #721c24;
    transform: scale(1.1);
    cursor: pointer;
}

#previewTable {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
}

#previewTable th,
#previewTable td {
    padding: 8px;
    border: 1px solid #E0E0E0;
    /* เปลี่ยนสีเส้นขอบเป็นเทาอ่อน */
    text-align: left;
    min-width: 100px;
    word-break: break-word;
}

#previewTable thead {
    display: table;
    width: 100%;
    table-layout: fixed;
    background-color: #E8F5E9;
    /* เปลี่ยนสีพื้นหลังหัวตารางเป็นเขียวอ่อน */
}

#previewTable tbody {
    display: block;
    width: 100%;
    overflow-y: auto;
    max-height: 400px;
}

/* เพิ่มการตกแต่งเพิ่มเติม */
#previewTable tr:nth-child(even) {
    background-color: #F5F5F5;
    /* แถวคู่มีพื้นหลังสีเทาอ่อน */
}

#previewTable th {
    font-weight: bold;
}

.print-form-check-label {
    display: flex;
    justify-content: flex-start;
    align-items: center;
}

@media (max-width: 768px) {

    .title {
        font-size: 12px;
        flex-direction: column;
        align-items: center;
    }

    .title h4 {
        margin-bottom: 10px;
    }

    .btn-container {
        font-size: 12px;
        flex-direction: row;
        justify-content: center;
    }

    .btn-container .btn {
        font-size: 12px;
        width: 30%;
        margin-bottom: 10px;
    }

    .rectangle-box {
        display: flex;
        flex-direction: column;
        max-height: 400px;
        /* กำหนดความสูงสูงสุด */
        overflow-y: auto;
        /* ให้เลื่อนในแนวตั้งได้ */
        padding: 15px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group-horizontal {
        display: flex;
        flex-direction: column;
        /* จัดให้อยู่ในแนวตั้ง */
        gap: 10px;
        /* เพิ่มระยะห่าง */
    }

    .form-group {
        display: flex;
        flex-direction: column;
        width: 100%;
        /* ให้ input ขยายเต็ม div */
        min-width: 200px;
    }

    .btn-primary {
        width: 100%;
    }

    /* ปรับขนาด label และ input */
    .form-group label {
        font-size: 12px;
        /* ขนาดฟอนต์เล็กลง */
    }

    .input-group .form-control {
        padding: 8px 15px;
        /* เพิ่มการเติมภายใน */
    }

    .input-group-text {
        padding: 8px;
        /* เพิ่มการเติมภายใน */
    }

    .table,
    .table td {
        font-size: 12px;
    }

    .table th,
    .table td {
        padding: 6px 8px;
    }

    .table td:nth-child(2),
    .table td:nth-child(7) {
        max-width: 120px;
    }

    .table td:nth-child(1),
    .table td:nth-child(3),
    .table td:nth-child(4),
    .table td:nth-child(5),
    .table td:nth-child(6),
    .table td:nth-child(8),
    .table td:nth-child(9) {
        word-wrap: break-word;
        white-space: normal;
    }

    .custom-pagination {
        font-size: 12px;
        padding: 5px;
    }

    .custom-pagination a,
    .custom-pagination span {
        padding: 6px 12px;
    }

    .modal-dialog {
        max-width: 90%;
        margin: 1.75rem auto;
    }

    .modal-content {
        padding: 10px;
    }

    .modal-header {
        padding: 10px;
    }

    .modal-title {
        font-size: 16px;
    }

    .close-btn {
        width: 30px;
        height: 30px;
        font-size: 1rem;
    }

    .modal-body .form-label {
        font-size: 12px;
    }

    .modal-body .form-control {
        padding: 8px;
        font-size: 12px;
    }

    .modal-body .btn-primary {
        padding: 10px;
        font-size: 12px;
    }
}
</style>


<div class="container py-2">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if(session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
    @endif
    <div class="title">
        <h4><strong>บันทึกข้อมูล</strong></h4>
        <div class="btn-container">
            <!-- Import File -->
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                นำเข้าข้อมูล
            </button>

            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">นำเข้าข้อมูล</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <!-- ส่วนแสดงตัวอย่าง -->
                            <div class="mb-4 p-3 border rounded">
                                <h6 class="mb-3">ตัวอย่างโครงสร้างข้อมูล</h6>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>id_card</th>
                                                <th>prefix</th>
                                                <th>name</th>
                                                <th>surname</th>
                                                <th>housenumber</th>
                                                <th>birthdate</th>
                                                <th>age</th>
                                                <th>blood_group</th>
                                                <th>weight</th>
                                                <th>height</th>
                                                <th>waistline</th>
                                                <th>bmi</th>
                                                <th>phone</th>
                                                <th>idline</th>
                                                <th>user_name</th>
                                                <th>sys</th>
                                                <th>dia</th>
                                                <th>pul</th>
                                                <th>body_temp</th>
                                                <th>blood_oxygen</th>
                                                <th>blood_level</th>
                                                <th>zone1_normal</th>
                                                <th>zone1_risk_group</th>
                                                <th>zone1_good_control</th>
                                                <th>zone1_watch_out</th>
                                                <th>zone1_danger</th>
                                                <th>zone1_critical</th>
                                                <th>zone1_complications</th>
                                                <th>zone1_heart</th>
                                                <th>zone1_cerebrovascular</th>
                                                <th>zone1_kidney</th>
                                                <th>zone1_eye</th>
                                                <th>zone1_foot</th>
                                                <th>zone2_normal</th>
                                                <th>zone2_risk_group</th>
                                                <th>zone2_good_control</th>
                                                <th>zone2_watch_out</th>
                                                <th>zone2_danger</th>
                                                <th>zone2_critical</th>
                                                <th>zone2_complications</th>
                                                <th>zone2_heart</th>
                                                <th>zone2_eye</th>
                                                <th>diabetes</th>
                                                <th>cerebral_artery</th>
                                                <th>kidney</th>
                                                <th>blood_pressure</th>
                                                <th>heart</th>
                                                <th>eye</th>
                                                <th>other</th>
                                                <th>other_text</th>
                                                <th>drink</th>
                                                <th>drink_sometimes</th>
                                                <th>dont_drin</th>
                                                <th>sometime_smoke</th>
                                                <th>smoke</th>
                                                <th>dont_smoke</th>
                                                <th>troubled</th>
                                                <th>dont_live</th>
                                                <th>bored</th>
                                                <th>help_yourself</th>
                                                <th>can_help</th>
                                                <th>cant_help</th>
                                                <th>caregiver</th>
                                                <th>have_caregiver</th>
                                                <th>no_caregiver</th>
                                                <th>group1</th>
                                                <th>group2</th>
                                                <th>group3</th>
                                                <th>house</th>
                                                <th>society</th>
                                                <th>bed_ridden</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>7777777777777</td>
                                                <td>นางสาว</td>
                                                <td>ณิศวรา</td>
                                                <td>บางทราย</td>
                                                <td>102/35</td>
                                                <td>2003-01-30</td>
                                                <td>22</td>
                                                <td>A</td>
                                                <td>52</td>
                                                <td>170</td>
                                                <td>26</td>
                                                <td>22.9</td>
                                                <td>123456789</td>
                                                <td>pp</td>
                                                <td>แอดมินข้าว</td>
                                                <td>55</td>
                                                <td>55</td>
                                                <td>55</td>
                                                <td>37</td>
                                                <td>12</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>โรคมะเร็งตับ</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>1</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>1</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <!-- ปุ่มแสดงคำอธิบาย -->
                                <button class="btn btn-success mb-3" onclick="toggleDescription()" style="color: #fff;">
                                    แสดงคำอธิบายคอลัมน์
                                </button>

                                <!-- คำอธิบายคอลัมน์ (ซ่อนตอนเริ่ม) -->
                                <div id="columnDescription" class="mb-3 p-3 border rounded"
                                    style="display: none; background-color: #f8f9fa; color: #020364;">
                                    <h6>คำอธิบายคอลัมน์</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>id_card</strong> - หมายเลขบัตรประชาชน</li>
                                                <li><strong>prefix</strong> - คำนำหน้า (นาย, นางสาว ฯลฯ)</li>
                                                <li><strong>name</strong> - ชื่อจริง</li>
                                                <li><strong>surname</strong> - นามสกุล</li>
                                                <li><strong>housenumber</strong> - บ้านเลขที่</li>
                                                <li><strong>birthdate</strong> - วันเกิด (YYYY-MM-DD)</li>
                                                <li><strong>age</strong> - อายุ (ปี)</li>
                                                <li><strong>blood_group</strong> - กรุ๊ปเลือด (A, B, AB, O)</li>
                                                <li><strong>weight</strong> - น้ำหนัก (กิโลกรัม)</li>
                                                <li><strong>height</strong> - ส่วนสูง (เซนติเมตร)</li>
                                                <li><strong>waist</strong> - รอบเอว (เซนติเมตร)</li>
                                                <li><strong>bmi</strong> - ดัชนีมวลกาย (Body Mass Index)</li>
                                                <li><strong>phone</strong> - เบอร์โทรศัพท์</li>
                                                <li><strong>user_name</strong> - ชื่อผู้ใช้งานระบบ</li>
                                                <li><strong>sys</strong> - ความดันโลหิตค่าบน (mmHg)</li>
                                                <li><strong>dia</strong> - ความดันโลหิตค่าล่าง (mmHg)</li>
                                                <li><strong>pul</strong> - อัตราการเต้นของหัวใจ (ครั้งต่อนาที)</li>
                                                <li><strong>body_temp</strong> - อุณหภูมิร่างกาย (°C)</li>
                                                <li><strong>blood_oxygen</strong> - ปริมาณออกซิเจนในเลือด (%)</li>
                                                <li><strong>blood_level</strong> - ระดับน้ำตาลในเลือด (mg/dL)</li>
                                                <li><strong>zone1_normal</strong> - ค่าโซน 1 ปกติ</li>
                                                <li><strong>zone1_risk_group</strong> - ค่าโซน 1 กลุ่มเสี่ยง</li>
                                                <li><strong>zone1_good_control</strong> - ค่าโซน 1 คุมได้ดี</li>
                                                <li><strong>zone1_watch_out</strong> - ค่าโซน 1 เฝ้าระวัง</li>
                                                <li><strong>zone1_danger</strong> - ค่าโซน 1 อันตราย</li>
                                                <li><strong>zone1_critical</strong> - ค่าโซน 1 วิกฤต</li>
                                                <li><strong>zone1_complications</strong> - ค่าโซน 1 โรคแทรกซ้อน</li>
                                                <li><strong>zone1_heart</strong> - ค่าโซน 1 หัวใจ</li>
                                                <li><strong>zone1_cerebrovascular </strong> - ค่าโซน 1 หลอดเลือดสมอง
                                                </li>
                                                <li><strong>zone1_kidney</strong> - ค่าโซน 1 ไต</li>
                                                <li><strong>zone1_eye</strong> - ค่าโซน 1 ตา</li>
                                                <li><strong>zone1_foot</strong> - ค่าโซน 1 เท้า</li>
                                                <li><strong>zone2_normal</strong> - ค่าโซน 2 ปกติ</li>
                                                <li><strong>zone2_risk_group</strong> - ค่าโซน 2 กลุ่มเสี่ยง</li>
                                                <li><strong>zone2_good_control</strong> - ค่าโซน 2 คุมได้ดี</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><strong>zone2_watch_out</strong> - ค่าโซน 2 เฝ้าระวัง</li>
                                                <li><strong>zone2_danger</strong> - ค่าโซน 2 อันตราย</li>
                                                <li><strong>zone2_critical</strong> - ค่าโซน 2 วิกฤต</li>
                                                <li><strong>zone2_complications</strong> - ค่าโซน 2 โรคแทรกซ้อน</li>
                                                <li><strong>zone2_heart</strong> - ค่าโซน 2 ปกติ</li>
                                                <li><strong>zone2_eye</strong> - ค่าโซน 2 ตา</li>
                                                <li><strong>diabetes</strong> - เป็นโรคเบาหวานหรือไม่</li>
                                                <li><strong>blood_pressure</strong> - เป็นโรคความดันโลหิตสูงหรือไม่</li>
                                                <li><strong>heart</strong> - เป็นโรคหัวใจหรือไม่</li>
                                                <li><strong>kidney</strong> - เป็นโรคไตหรือไม่</li>
                                                <li><strong>cerebral_artery</strong> - เป็นโรคหลอดเลือดสมองหรือไม่</li>
                                                <li><strong>eye</strong> - มีภาวะโรคเกี่ยวกับดวงตาหรือไม่</li>
                                                <li><strong>other</strong> - โรคประจำตัวอื่น ๆ</li>
                                                <li><strong>other_text</strong> - รายละเอียดโรคอื่น ๆ</li>
                                                <li><strong>drink</strong> - ดื่มเครื่องดื่มแอลกอฮอล์หรือไม่</li>
                                                <li><strong>drink_sometimes</strong> - ดื่มแอลกอฮอล์เป็นครั้งคราว</li>
                                                <li><strong>dont_drink</strong> - ไม่ดื่มแอลกอฮอล์</li>
                                                <li><strong>smoke</strong> - สูบบุหรี่หรือไม่</li>
                                                <li><strong>sometime_smoke</strong> - สูบบุหรี่เป็นครั้งคราว</li>
                                                <li><strong>dont_smoke</strong> - ไม่สูบบุหรี่</li>
                                                <li><strong>troubled</strong> - มีความเครียดหรือไม่</li>
                                                <li><strong>dont_live</strong> - เคยมีความคิดอยากฆ่าตัวตาย</li>
                                                <li><strong>bored</strong> - มีอาการเบื่อหน่ายหรือหมดกำลังใจ</li>
                                                <li><strong>help_yourself</strong> - สามารถดูแลตัวเองได้หรือไม่</li>
                                                <li><strong>can_help</strong> - สามารถช่วยเหลือตัวเองได้</li>
                                                <li><strong>cant_help</strong> - ไม่สามารถช่วยเหลือตัวเองได้</li>
                                                <li><strong>caregiver</strong> - มีผู้ดูแลหรือไม่</li>
                                                <li><strong>have_caregiver</strong> - มีผู้ดูแล</li>
                                                <li><strong>no_caregiver</strong> - ไม่มีผู้ดูแล</li>
                                                <li><strong>house</strong> - มีบ้านเป็นของตัวเองหรือไม่</li>
                                                <li><strong>society</strong> - การมีส่วนร่วมในสังคม</li>
                                                <li><strong>bed_ridden</strong> - เป็นผู้ป่วยติดเตียงหรือไม่</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- ส่วนอัปโหลดไฟล์ -->
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="mb-3">อัปโหลดไฟล์</h6>
                                    <form id="uploadForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="excelFile" class="form-label fw-bold">เลือกไฟล์ Excel หรือ
                                                CSV</label>
                                            <input type="file" class="form-control" id="excelFile" name="file"
                                                accept=".xlsx, .xls, .csv" required>
                                        </div>
                                    </form>
                                </div>

                                <!-- ส่วน Preview -->
                                <div class="mb-4 p-3 border rounded">
                                    <h6 class="mb-3">ตัวอย่างข้อมูลที่นำเข้า</h6>
                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-bordered" id="previewTable">
                                            <thead>
                                                <tr id="tableHead"></tr>
                                            </thead>
                                            <tbody id="tableBody"></tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- ปุ่ม Submit -->
                                <button type="button" class="btn btn-success w-100" id="submitDataBtn"
                                    disabled>นำเข้าข้อมูล</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="alertModalLabel" style="color: red;">แจ้งเตือน</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="alertMessage">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function toggleDescription() {
                var desc = document.getElementById("columnDescription");
                if (desc.style.display === "none") {
                    desc.style.display = "block";
                } else {
                    desc.style.display = "none";
                }
            }
            </script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <script>
            let jsonData = [];
            let uploadedFiles = [];

            document.getElementById('excelFile').addEventListener('change', function() {
                let file = this.files[0];
                if (!file) return;

                if (uploadedFiles.includes(file.name)) {
                    showAlert("ไฟล์ " + file.name + " ถูกอัปโหลดไปแล้ว");
                    this.value = "";
                    return;
                }

                let allowedExtensions = ['xlsx', 'xls', 'csv'];
                let fileExtension = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    showAlert("ไฟล์ที่อัปโหลดต้องเป็น .xlsx, .xls หรือ .csv เท่านั้น!");
                    this.value = "";
                    return;
                }

                handleFile(file);
                uploadedFiles.push(file.name);
            });

            function handleFile(file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    try {
                        if (file.name.endsWith(".csv")) {
                            let decoder = new TextDecoder("windows-874");
                            let textData = decoder.decode(e.target.result);
                            parseCSV(textData);
                        } else {
                            parseExcel(e.target.result);
                        }
                    } catch (error) {
                        console.error("Error reading file:", error);
                        showAlert("เกิดข้อผิดพลาดในการอ่านไฟล์");
                    }
                };

                if (file.name.endsWith(".csv")) {
                    reader.readAsArrayBuffer(file);
                } else {
                    reader.readAsBinaryString(file);
                }
            }

            function parseCSV(data) {
                Papa.parse(data, {
                    header: true,
                    skipEmptyLines: true,
                    complete: function(results) {
                        jsonData = results.data.map(obj => {
                            let formattedObj = {};
                            Object.keys(obj).forEach(key => {
                                formattedObj[key] = decodeText(obj[key]);
                            });
                            return formattedObj;
                        });
                        displayPreview([Object.keys(jsonData[0]), ...jsonData.map(Object.values)]);
                    },
                    error: function(error) {
                        console.error("CSV parsing error:", error);
                        showAlert("เกิดข้อผิดพลาดในการอ่านไฟล์ CSV");
                    }
                });
            }

            function parseExcel(data) {
                let workbook = XLSX.read(data, {
                    type: 'binary'
                });
                let firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                jsonData = XLSX.utils.sheet_to_json(firstSheet, {
                    header: 1
                });
                let headers = jsonData[0];
                jsonData = jsonData.slice(1).map(row => {
                    let obj = {};
                    headers.forEach((key, index) => {
                        obj[key] = key === 'birthdate' ? formatExcelDate(row[index]) : row[index];
                    });
                    return obj;
                });
                displayPreview([headers, ...jsonData.map(Object.values)]);
            }

            function formatExcelDate(serial) {
                if (!serial || isNaN(serial)) return serial;
                let excelDate = Math.floor(serial);
                let unixTimestamp = (excelDate - 25569) * 86400;
                let date = new Date(unixTimestamp * 1000);
                return date.toISOString().slice(0, 10);
            }

            function decodeText(text) {
                if (!text) return "";
                try {
                    return decodeURIComponent(escape(text));
                } catch (e) {
                    return text;
                }
            }

            function displayPreview(data) {
                let tableHead = document.getElementById('tableHead');
                let tableBody = document.getElementById('tableBody');
                tableHead.innerHTML = "";
                tableBody.innerHTML = "";

                if (data.length === 0) return;

                let headers = data[0];
                let headerRow = document.createElement('tr');
                headers.forEach(header => {
                    let th = document.createElement('th');
                    th.textContent = header;
                    headerRow.appendChild(th);
                });
                tableHead.appendChild(headerRow);

                data.slice(1).forEach(rowData => {
                    let row = document.createElement('tr');
                    rowData.forEach(cell => {
                        let td = document.createElement('td');
                        td.textContent = cell !== undefined ? cell : "";
                        row.appendChild(td);
                    });
                    tableBody.appendChild(row);
                });
                document.getElementById('submitDataBtn').disabled = false;
            }

            document.getElementById('submitDataBtn').addEventListener('click', async function() {
                console.log("jsonData ก่อนส่งไปบันทึก:", jsonData);

                if (!jsonData || jsonData.length === 0) {
                    showAlert('ไม่มีข้อมูลสำหรับบันทึก');
                    return;
                }

                try {
                    const response = await fetch("https://thungsetthivhv.pcnone.com/admin/importfile", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({
                            data: jsonData
                        })
                    });

                    if (!response.ok) {
                        const errorResponse = await response.json();
                        throw new Error(errorResponse.error ||
                            `เกิดข้อผิดพลาดที่ไม่รู้จัก (${response.status})`);
                    }

                    const result = await response.json();
                    console.log("ผลลัพธ์จากเซิร์ฟเวอร์:", result);
                    window.location.href = "{{ route('recorddata.index') }}";
                } catch (error) {
                    console.error("Fetch error:", error);
                    showAlert(error.message);
                }
            });

            function showAlert(message) {
                console.log("แจ้งเตือน:", message);
                document.getElementById('alertMessage').textContent = message;
                setTimeout(() => {
                    let alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                    alertModal.show();
                }, 100);
            }
            </script>

            <!--  Export File -->
            <a type="button" class="btn btn-secondary" href="{{ url('/admin/export') }}">ส่งออกข้อมูล</a>

            <a type="button" class="btn btn-success" href="/admin/addrecord"><i
                    class="fa-solid fa-plus"></i>&nbsp;เพิ่มข้อมูล</a>
        </div>
    </div>

    <div class="rectangle-box">
        <form action="{{ route('recorddata.search') }}" method="GET">
            <div class="form-group-horizontal">
                <div class="form-group">
                    <label for="id_card">เลขบัตรประจำตัวประชาชน</label>
                    <div class="input-group">
                        <input id="id_card" class="form-control" type="text" name="id_card"
                            placeholder="ค้นหาเลขบัตรประชาชน" aria-label="Search" maxlength="13">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">ชื่อ-นามสกุล</label>
                    <div class="input-group">
                        <input id="name" class="form-control" type="search" name="name" placeholder="ค้นหาชื่อ-นามสกุล"
                            aria-label="Search">
                    </div>
                </div>
                <div class="form-group">
                    <label for="housenumber">บ้านเลขที่</label>
                    <div class="input-group">
                        <input id="housenumber" class="form-control" type="search" name="housenumber"
                            placeholder="ค้นหาบ้านเลขที่" aria-label="Search">
                    </div>
                </div>
                <div class="form-group">
                    <label for="diseases">โรคประจำตัว</label>
                    <select id="diseases" class="form-control" name="diseases">
                        <option value="">เลือกโรคประจำตัว</option>
                        @php
                        $diseases = [
                        'diabetes' => 'เบาหวาน',
                        'cerebral_artery' => 'หลอดเลือดสมอง',
                        'kidney' => 'โรคไต',
                        'blood_pressure' => 'ความดันโลหิตสูง',
                        'heart' => 'โรคหัวใจ',
                        'eye' => 'โรคตา',
                        'other' => 'โรคอื่นๆ'
                        ];
                        @endphp
                        @foreach($diseases as $key => $value)
                        <option value="{{ $key }}" {{ request('diseases') == $key ? 'selected' : '' }}>{{ $value }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">ค้นหา</button>
                </div>
            </div>
        </form>
    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var toggler = document.querySelector('.navbar-toggler');
        toggler.addEventListener('click', function() {
            var navbar = document.getElementById('navbarNav');
            navbar.classList.toggle('show');
        });
    });
    </script>

    @php
    use Carbon\Carbon;
    @endphp

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ลำดับที่</th>
                    <th scope="col">เลขบัตรประจำตัวประชาชน</th>
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col">บ้านเลขที่</th>
                    <th scope="col">วัน/เดือน/ปีเกิด</th>
                    <th scope="col">อายุ</th>
                    <th scope="col">เบอร์โทรศัพท์</th>
                    <th scope="col">โรคประจำตัว</th>
                    <th scope="col">การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recorddata as $key => $data)
                <tr>
                    <td><strong>{{ ($recorddata->firstItem() + $loop->index) }}</strong></td>
                    </td>
                    <td><strong>{{ $data['id_card'] }}</strong></td>
                    <td><strong>{{ $data['name'] }} {{ $data['surname'] }}</strong></td>
                    <td><strong>{{ $data['housenumber'] }}</strong></td>
                    <td><strong>{{ \Carbon\Carbon::parse($data['birthdate'])->translatedFormat('d') }}/{{ \Carbon\Carbon::parse($data['birthdate'])->translatedFormat('F') }}/{{ \Carbon\Carbon::parse($data['birthdate'])->year + 543 }}
                        </strong>
                    </td>
                    <td><strong>{{ $data['age'] }}</strong></td>
                    <td><strong>{{ $data['phone'] }}</strong></td>
                    <td><strong>
                            @if($data->diseases)
                            @php
                            $diseaseLabels = [
                            'diabetes' => 'เบาหวาน',
                            'cerebral_artery' => 'หลอดเลือดสมอง',
                            'kidney' => 'โรคไต',
                            'blood_pressure' => 'ความดันโลหิตสูง',
                            'heart' => 'โรคหัวใจ',
                            'eye' => 'โรคตา'
                            ];

                            $selectedDiseases = collect($data->diseases->toArray())
                            ->filter(fn($value, $key) => $value == 1 && isset($diseaseLabels[$key]))
                            ->keys()
                            ->map(fn($key) => $diseaseLabels[$key])
                            ->implode("\n");

                            // ถ้าเลือก 'other' และมีค่า other_text ให้แสดงแค่ other_text
                            if ($data->diseases->other && !empty($data->diseases->other_text)) {
                            $selectedDiseases .= "" . $data->diseases->other_text;
                            }
                            @endphp
                            {!! nl2br(e($selectedDiseases) ?: 'ไม่มีโรคประจำตัว') !!}
                            @else
                            -
                            @endif
                        </strong></td>
                    <td>

                        <a href="{{ route('recorddata.update', $data->id) }}" type="button"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>
                        </a>

                        <form id="deleteForm{{ $data->id }}"
                            action="{{ route('recorddata.destroy', ['id' => $data->id]) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-button" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $data->id }}" data-id="{{ $data->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                        <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $data->id }}"
                                            style="color:#000;">
                                            ยืนยันการลบ</h5>
                                        <button type="button" class="btn btn-light rounded-circle shadow-sm close-btn"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body" style="color:#000;">
                                        คุณต้องการลบข้อมูลนี้ใช่หรือไม่?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ไม่</button>
                                        <button type="button" class="btn btn-danger confirmDelete"
                                            data-form-id="deleteForm{{ $data->id }}">ยืนยันการลบ</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        // เมื่อกดปุ่ม "ยืนยันการลบ"
                        document.querySelectorAll('.confirmDelete').forEach(button => {
                            button.addEventListener('click', function() {
                                var formId = this.getAttribute(
                                    'data-form-id'); // ดึง ID ของฟอร์มที่ต้องการส่ง
                                var form = document.getElementById(formId); // หาฟอร์มที่มี ID นี้
                                console.log('Submitting form with ID: ' +
                                    formId); // เช็คว่า ID ของฟอร์มถูกดึงมาไหม
                                form.submit(); // ส่งฟอร์ม
                            });
                        });
                        </script>

                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#printModal">
                            <i class="fa-solid fa-print"></i>
                        </button>

                        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content shadow-lg rounded-4">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="printModalLabel">
                                            <i class="fa-solid fa-print"></i> เลือกข้อมูลที่ต้องการพิมพ์
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="printForm" action="{{ route('admin.print') }}" method="GET"
                                            target="_blank">
                                            <div class="mb-3">
                                                <input type="text" id="searchInput" class="form-control"
                                                    placeholder="ค้นหาชื่อ...">
                                            </div>
                                            <div class="accordion" id="dataAccordion">
                                                @foreach ($groupedData ?? [] as $section => $items)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $loop->index }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse{{ $loop->index }}">
                                                            {{ $section }} ({{ $items->count() }})
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $loop->index }}"
                                                        class="accordion-collapse collapse show"
                                                        aria-labelledby="heading{{ $loop->index }}"
                                                        data-bs-parent="#dataAccordion">
                                                        <div class="accordion-body">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <input type="checkbox"
                                                                    class="form-check-input me-2 selectGroup"
                                                                    data-group="{{ $section }}">
                                                                <label
                                                                    class="form-check-label fw-bold text-primary">เลือกทั้งหมดในกลุ่ม</label>
                                                            </div>
                                                            <div class="row">
                                                                @foreach ($recorddataList as $item)
                                                                @if ($item->section == $section)
                                                                <div class="col-md-6 mb-2">
                                                                    <div class="card p-2">
                                                                        <div class="form-check print-form-check">
                                                                            <input class="form-check-input data-item"
                                                                                type="checkbox" name="ids[]"
                                                                                value="{{ $item->id }}"
                                                                                id="check{{ $item->id }}"
                                                                                data-name="{{ $item->name }}"
                                                                                data-department="{{ $section }}">
                                                                            <label class="print-form-check-label"
                                                                                for="check{{ $item->id }}">
                                                                                <i class="fa-solid fa-user"></i>
                                                                                {{ $item->prefix }} {{ $item->name }}
                                                                                {{ $item->surname }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            {{ $recorddataList->links() }} {{-- เพิ่มปุ่มเลื่อน --}}
                                        </form>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary rounded-pill px-4"
                                            data-bs-dismiss="modal">
                                            <i class="fa-solid fa-xmark"></i> ยกเลิก
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4"
                                            onclick="submitPrintForm()">
                                            <i class="fa-solid fa-print"></i> พิมพ์
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const searchInput = document.getElementById('searchInput');
                            const dataItems = document.querySelectorAll('.data-item');

                            searchInput.addEventListener('input', function() {
                                const searchTerm = searchInput.value.toLowerCase();
                                dataItems.forEach(item => {
                                    const name = item.dataset.name.toLowerCase();
                                    const department = item.dataset.department.toLowerCase();
                                    const card = item.closest('.col-md-6');
                                    if (name.includes(searchTerm) || department.includes(
                                            searchTerm)) {
                                        card.style.display = '';
                                    } else {
                                        card.style.display = 'none';
                                    }
                                });
                            });

                            const selectGroups = document.querySelectorAll('.selectGroup');
                            selectGroups.forEach(group => {
                                group.addEventListener('change', function() {
                                    const department = this.dataset.group;
                                    const items = document.querySelectorAll(
                                        `.data-item[data-department="${department}"]`);
                                    items.forEach(item => item.checked = this.checked);
                                });
                            });
                        });

                        function submitPrintForm() {
                            document.getElementById('printForm').submit();
                        }
                        </script>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="custom-pagination mt-3 flex items-center gap-2">
            {{-- ปุ่มย้อนกลับ --}}
            @if ($recorddata->onFirstPage())
            <span class="disabled text-gray-400 px-3 py-2 border rounded-md cursor-not-allowed">ย้อนกลับ</span>
            @else
            <a href="{{ $recorddata->previousPageUrl() }}"
                class="px-3 py-2 border rounded-md hover:bg-gray-200">ย้อนกลับ</a>
            @endif

            {{-- แสดงหมายเลขหน้าแบบกระชับ --}}
            @php
            $totalPages = $recorddata->lastPage();
            $currentPage = $recorddata->currentPage();
            $sidePages = 2; // จำนวนหน้าที่แสดงรอบๆ หน้าปัจจุบัน
            @endphp

            {{-- หน้าแรก --}}
            @if ($currentPage > 1 + $sidePages)
            <a href="{{ $recorddata->url(1) }}" class="px-3 py-2 border rounded-md hover:bg-gray-200">1</a>
            @if ($currentPage > 2 + $sidePages)
            <span class="px-2">...</span>
            @endif
            @endif

            {{-- แสดงหน้ารอบๆ ปัจจุบัน --}}
            @for ($page = max(1, $currentPage - $sidePages); $page <= min($totalPages, $currentPage + $sidePages);
                $page++) @if ($page==$currentPage) <span class="bg-blue-500 text-white px-3 py-2 border rounded-md">
                {{ $page }}</span>
                @else
                <a href="{{ $recorddata->url($page) }}"
                    class="px-3 py-2 border rounded-md hover:bg-gray-200">{{ $page }}</a>
                @endif
                @endfor

                {{-- หน้าสุดท้าย --}}
                @if ($currentPage < $totalPages - $sidePages) @if ($currentPage < $totalPages - $sidePages - 1) <span
                    class="px-2">...</span>
                    @endif
                    <a href="{{ $recorddata->url($totalPages) }}"
                        class="px-3 py-2 border rounded-md hover:bg-gray-200">{{ $totalPages }}</a>
                    @endif

                    {{-- ปุ่มถัดไป --}}
                    @if ($recorddata->hasMorePages())
                    <a href="{{ $recorddata->nextPageUrl() }}"
                        class="px-3 py-2 border rounded-md hover:bg-gray-200">ถัดไป</a>
                    @else
                    <span class="disabled text-gray-400 px-3 py-2 border rounded-md cursor-not-allowed">ถัดไป</span>
                    @endif
        </div>

        <br>
    </div>
</div>
@endsection