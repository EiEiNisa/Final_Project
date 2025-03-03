@extends('layoutadmin')

@section('content')
<style>
.card-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    /* เพิ่มเงาให้ดูมีมิติ */
    padding: 25px 30px;
    margin-bottom: 30px;
    transition: all 0.3s ease-in-out;
}

.card-container:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    /* เงาเข้มขึ้นเมื่อ hover */
}

.card-header {
    color: #020364;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    /* ใช้สำหรับขีดด้านล่าง */
}

/* ข้อความ h4 */
.card-header h4 {
    font-size: 24px;
    font-weight: bold;
    margin: 0;
}

/* ปุ่มกลับ */
.card-header .btn-back {
    background: rgba(255, 255, 255, 0.3);
    color: #000;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease-in-out;
}

.card-header .btn-back:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* ขีดเส้นใต้ */
.card-header::after {
    content: "";
    position: absolute;
    bottom: -2px;
    /* ขีดอยู่ด้านล่าง */
    left: 0;
    width: 100%;
    height: 4px;
    background-color: #020364;
    /* สีของเส้น */
}

.card-body {
    padding: 20px;
}

.btn-edit {
    background-color: #4A90E2;
    color: white;
    border-radius: 8px;
    padding: 10px 16px;
    border: none;
    transition: all 0.3s ease-in-out;
}

.btn-edit:hover {
    background-color: #1C3F7C;
}

.custom-accordion {
    width: 100%;
}

.custom-accordion-item {
    border: 1px solid #e0e0e0;
    /* เปลี่ยนสีเส้นขอบ */
    border-radius: 8px;
    /* เพิ่มความโค้งมน */
    overflow: hidden;
    margin-bottom: 10px;
    /* เพิ่มระยะห่างระหว่างรายการ */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    /* เพิ่มเงา */
}

.custom-accordion-item .accordion-header {
    background-color: #f0f8ff;
    /* เปลี่ยนสีพื้นหลัง header */
}

.custom-accordion-item .accordion-button {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    text-align: left;
    padding: 1.2rem 1.5rem;
    /* เพิ่ม padding */
    border: none;
    background: transparent;
    box-shadow: none;
    color: #333;
    /* เปลี่ยนสีตัวหนังสือ */
}

.custom-accordion-item .accordion-button:focus {
    box-shadow: none;
}

.custom-accordion-item .accordion-button:not(.collapsed) {
    background-color: #e0f2fe;
    /* เปลี่ยนสีพื้นหลังเมื่อเปิด */
}

.custom-accordion-item .checkup-title {
    font-weight: 600;
    /* ปรับความหนาตัวหนังสือ */
    color: #020364;
    /* เปลี่ยนสีตัวหนังสือ title */
}

.custom-accordion-item .checkup-date {
    color: #555;
    /* เปลี่ยนสีตัวหนังสือ date */
    margin-left: 1rem;
    /* เพิ่มระยะห่างระหว่าง title และ date */
}

.custom-accordion-item .accordion-body {
    padding: 1.5rem;
    /* เพิ่ม padding */
    background-color: #fff;
    /* เปลี่ยนสีพื้นหลัง body */
}

.custom-accordion-item .form-group {
    margin-bottom: 1.2rem;
    /* เพิ่มระยะห่าง */
}

.custom-accordion-item .form-group label {
    display: block;
    margin-bottom: 0.6rem;
    font-weight: 500;
    /* ปรับความหนาตัวหนังสือ label */
    color: #444;
    /* เปลี่ยนสีตัวหนังสือ label */
}

.custom-accordion-item .form-group .form-control {
    width: 100%;
    padding: 0.6rem 1rem;
    /* เพิ่ม padding */
    border: 1px solid #ccc;
    /* เปลี่ยนสีเส้นขอบ input */
    border-radius: 6px;
    /* เพิ่มความโค้งมน input */
    box-sizing: border-box;
    color: #333;
    /* เปลี่ยนสีตัวหนังสือ input */
    background-color: #f9f9f9;
    /* เปลี่ยนสีพื้นหลัง input */
}

.custom-accordion-item .btn-secondary {
    margin-top: 1.5rem;
    /* เพิ่มระยะห่าง */
    background-color: #6c757d;
    /* เปลี่ยนสีปุ่ม */
    border-color: #6c757d;
    /* เปลี่ยนสีเส้นขอบปุ่ม */
    color: #fff;
    /* เปลี่ยนสีตัวหนังสือปุ่ม */
    padding: 0.6rem 1.2rem;
    /* เพิ่ม padding ปุ่ม */
    border-radius: 6px;
    /* เพิ่มความโค้งมนปุ่ม */
}

.custom-accordion-item .btn-secondary:hover {
    background-color: #5a6268;
    /* เปลี่ยนสีปุ่มเมื่อ hover */
    border-color: #5a6268;
    /* เปลี่ยนสีเส้นขอบปุ่มเมื่อ hover */
}

.form-group,
.form-group1 {
    flex: 1 1 calc(50% - 20px);
    min-width: 200px;
}

.form-group label,
.form-group1 label {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    transition: all 0.3s ease;
}

.accordion-button:focus,
.accordion-button:active {
    width: 100%;
    /* กำหนดความกว้างให้เต็มที่เมื่อกดปุ่ม */
    transition: width 0.3s ease;
    /* เพิ่มการเปลี่ยนแปลงความกว้าง */
}

form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    width: 100%;
    padding-left: 30px;
    padding-right: 30px;
}

.form-group label {
    font-size: 15px;
    font-weight: bold;
    color: #020364;
}


.form-group {
    display: flex;
    flex-direction: column;
    flex: 1 1 calc((100% - (2 * 20px)) / 3);
    color: #020364;
}

.form-group1 label {
    font-size: 15px;
    font-weight: bold;
    color: #020364;
}

.form-group1 {
    display: flex;
    flex-direction: column;
    flex: 1 1 calc((100% - (4 * 10px)) / 5);
    color: #020364;
}

.form-group2 label {
    font-size: 15px;
    font-weight: bold;
    color: #020364;
}

.form-group2 {
    display: flex;
    flex-direction: column;
    flex: 1 1 calc((100% - (3 * 10px)) / 2);
    color: #020364;
}

.form-group3 {
    display: flex;
    flex-direction: column;
    padding-top: 20px;
    padding-botton: 40px;
    flex: 1 1 calc(100% - 10px);
    color: #020364;
}

.circle-container {
    display: flex;
    gap: 3px;
    color: #020364;
    font-size: 15px;
    font-weight: bold;
}

.circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    padding-bottom: 10px;
}

#saveBtn {
    border: none;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: bold;
    color: white;
}

#editBtn {
    border: none;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: bold;
    color: white;
}

@media (max-width: 768px) {
    .accordion-button {
        padding: 10px 15px;
        width: 100%;
        /* ให้ปุ่มกว้างเต็มพื้นที่ในมือถือ */
        box-sizing: border-box;
    }

    .accordion-body {
        padding: 15px;
        max-height: 400px;
        /* กำหนดความสูงสูงสุด */
        overflow-y: auto;
        /* เพิ่มแถบเลื่อนแนวตั้ง */
    }

    .form-group {
        margin-bottom: 10px;
        /* ลดระยะห่างระหว่างฟอร์ม */
    }

    .form-control {
        width: 100%;
        /* ฟอร์มกรอกข้อมูลให้เต็มพื้นที่ */
        margin-bottom: 10px;
        /* เพิ่มระยะห่างระหว่างช่องกรอกข้อมูล */
    }

    .circle-container {
        font-size: 16px;
        /* เพิ่มขนาดตัวอักษรเล็กน้อยเพื่อให้เห็นชัดเจน */
    }

    .circle {
        width: 35px;
        height: 35px;
    }

    .accordion-item {
        margin-bottom: 15px;
    }

    .checkup-title {
        font-size: 14px;
    }

    .checkup-date {
        font-size: 12px;
    }

    .form-group label,
    .form-group1 label {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .form-group .form-control,
    .form-group1 .form-control {
        width: 100%;
        font-size: 14px;
        /* ปรับขนาดฟอนต์ให้พอเหมาะ */
    }

    .accordion-body .form-group1 {
        margin-bottom: 10px;
    }

    .accordion-button:focus {
        background-color: #f8f9fa;
        border-color: #6c757d;
    }
}
</style>

<div class="card-container">
    <br>
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

    <div class="card-header">
        <h4><strong>แก้ไขข้อมูล</strong></h4>
        <a href="/admin/record" class="btn btn-secondary btn-back">กลับ</a>
    </div>

    <div class="card-body">
        <form action="{{ route('recorddata.update', $recorddata->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group3">
                <h4><strong>ข้อมูลประจำตัว</strong></h4>
            </div>

            <div class="form-group1">
                <label for="id_card" class="form-label">เลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="form-control" id="id_card" name="id_card"
                    value="{{ old('id_card', $recorddata->id_card) }}" maxlength="13" readonly>
            </div>

            <div class="form-group1">
                <label for="prefix" class="form-label">คำนำหน้าชื่อ</label>
                <select class="form-control" id="prefix" name="prefix">
                    <option value="ด.ช." {{ old('prefix', $recorddata->prefix) == 'ด.ช.' ? 'selected' : '' }}>ด.ช.
                    </option>
                    <option value="ด.ญ." {{ old('prefix', $recorddata->prefix) == 'ด.ญ.' ? 'selected' : '' }}>ด.ญ.
                    </option>
                    <option value="นาย" {{ old('prefix', $recorddata->prefix) == 'นาย' ? 'selected' : '' }}>นาย</option>
                    <option value="นาง" {{ old('prefix', $recorddata->prefix) == 'นาง' ? 'selected' : '' }}>นาง</option>
                    <option value="นางสาว" {{ old('prefix', $recorddata->prefix) == 'นางสาว' ? 'selected' : '' }}>นางสาว
                    </option>
                </select>
            </div>

            <div class="form-group1">
                <label for="name" class="form-label">ชื่อ</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $recorddata->name) }}">
            </div>

            <div class="form-group1">
                <label for="surname" class="form-label">นามสกุล</label>
                <input type="text" class="form-control" id="surname" name="surname"
                    value="{{ old('surname', $recorddata->surname) }}">
            </div>

            <div class="form-group1">
                <label for="housenumber" class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" id="housenumber" name="housenumber"
                    value="{{ old('housenumber', $recorddata->housenumber) }}">
            </div>

            <div class="form-group1">
                <label for="birthdate" class="form-label">วัน / เดือน / ปีเกิด</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate"
                    value="{{ old('birthdate', $recorddata->birthdate) }}" readonly>
            </div>

            <div class="form-group1">
                <label for="age" class="form-label">อายุ</label>
                <input type="number" class="form-control" id="age" name="age" value="{{ old('age', $recorddata->age) }}"
                    readonly>
            </div>

            <script>
            document.getElementById('birthdate').addEventListener('change', function() {
                const birthdate = new Date(this.value);
                const today = new Date();

                if (!isNaN(birthdate.getTime())) {
                    let age = today.getFullYear() - birthdate.getFullYear();
                    const monthDiff = today.getMonth() - birthdate.getMonth();
                    const dayDiff = today.getDate() - birthdate.getDate();

                    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                        age--;
                    }
                    document.getElementById('age').value = age;
                } else {
                    document.getElementById('age').value = '';
                }
            });
            </script>

            <div class="form-group1">
                <label for="blood_group" class="form-label">กรุ๊ปเลือด</label>
                <select name="blood_group" id="blood_group" class="form-control">
                    <option value="A" {{ old('blood_group', $recorddata->blood_group) == 'A' ? 'selected' : '' }}>A
                    </option>
                    <option value="B" {{ old('blood_group', $recorddata->blood_group) == 'B' ? 'selected' : '' }}>B
                    </option>
                    <option value="AB" {{ old('blood_group', $recorddata->blood_group) == 'AB' ? 'selected' : '' }}>AB
                    </option>
                    <option value="O" {{ old('blood_group', $recorddata->blood_group) == 'O' ? 'selected' : '' }}>O
                    </option>
                </select>
            </div>


            <div class="form-group1">
                <label for="weight" class="form-label">น้ำหนัก</label>
                <input type="number" class="form-control" id="weight" name="weight"
                    value="{{ old('weight', $recorddata->weight) }}">
            </div>

            <div class="form-group1">
                <label for="height" class="form-label">ส่วนสูง</label>
                <input type="number" class="form-control" id="height" name="height"
                    value="{{ old('height', $recorddata->height) }}">
            </div>

            <div class="form-group1">
                <label for="waistline" class="form-label">รอบเอว</label>
                <input type="number" class="form-control" id="waistline" name="waistline"
                    value="{{ old('waistline', $recorddata->waistline) }}">
            </div>

            <div class="form-group1">
                <label for="bmi" class="form-label">ดัชนีมวล BMI</label>
                <input type="number" class="form-control" id="bmi" name="bmi" value="{{ old('bmi', $recorddata->bmi) }}"
                    readonly>
            </div>

            <script>
            document.getElementById('height').addEventListener('input', calculateBMI);
            document.getElementById('weight').addEventListener('input', calculateBMI);

            function calculateBMI() {
                let weight = parseFloat(document.getElementById('weight').value); // น้ำหนัก
                let height = parseFloat(document.getElementById('height').value); // ส่วนสูง

                // ตรวจสอบว่าไม่มีค่าว่างและค่าผิดปกติ
                if (!isNaN(weight) && weight > 0 && !isNaN(height) && height > 0) {
                    height = height / 100;

                    let bmi = weight / (height * height);
                    document.getElementById('bmi').value = bmi.toFixed(1);
                } else {
                    document.getElementById('bmi').value = '';
                }
            }
            </script>

            <div class="form-group1">
                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $recorddata->phone) }}" maxlength="10">
            </div>

            <div class="form-group1">
                <label for="idline" class="form-label">ID Line</label>
                <input type="text" class="form-control" id="idline" name="idline"
                    value="{{ old('idline', $recorddata->idline) }}">
            </div>

            @if ($extra_fields_recorddata)
            <div class="extra-fields">
                @foreach ($extra_fields_recorddata as $key => $value)
                <div class="form-group">
                    <label for="{{ $key }}">{{ htmlspecialchars($value['label'] ?? $key) }}</label>
                    <input type="text" name="extra_fields[{{ $value['label'] }}]" id="{{ $key }}"
                        value="{{ old('extra_fields.' . $value['label'], $value['value'] ?? '') }}"
                        class="form-control">
                </div>
                @endforeach
            </div>
            @endif

            <button type="submit" class="btn btn-primary" id="saveBtn">บันทึกข้อมูล</button>

            <!--ข้อมูลทั่วไป-->
            <div class="form-group3">
                <h4><strong>ข้อมูลทั่วไป</strong></h4>
            </div>

            <div class="accordion custom-accordion" id="accordionExample">
                @foreach($healthRecords as $index => $healthRecord)
                <div class="custom-accordion-item" style="margin-bottom: 10px;">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                            aria-controls="collapse{{ $index }}">

                            <span class="checkup-title">ตรวจครั้งที่ {{ count($healthRecords) - $index }}</span>
                            <span
                                class="checkup-date">{{ \Carbon\Carbon::parse($healthRecord->created_at)->format('d') }}/{{ \Carbon\Carbon::parse($healthRecord->created_at)->translatedFormat('F') }}/{{ \Carbon\Carbon::parse($healthRecord->created_at)->year + 543 }}
                            </span>
                        </button>
                    </h2>

                    <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $index }}">

                        <div class="accordion-body">
                            <div class="form-group">
                                <label for="sys{{ $index }}">ความดัน SYS</label>
                                <input type="text" class="form-control" id="sys{{ $index }}" name="sys[{{ $index }}]"
                                    value="{{ old('sys.' . $index, $healthRecord->sys ?? '') }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="dia{{ $index }}">ความดัน DIA</label>
                                <input type="text" class="form-control" id="dia{{ $index }}" name="dia[{{ $index }}]"
                                    value="{{ old('dia.' . $index, $healthRecord->dia ?? '') }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="pul{{ $index }}">ชีพจร</label>
                                <input type="text" class="form-control" id="pul{{ $index }}" name="pul[{{ $index }}]"
                                    value="{{ old('pul.' . $index, $healthRecord->pul ?? '') }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="body_temp{{ $index }}">อุณหภูมิร่างกาย</label>
                                <input type="text" class="form-control" id="body_temp{{ $index }}"
                                    name="body_temp[{{ $index }}]"
                                    value="{{ old('body_temp.' . $index, $healthRecord->body_temp ?? '') }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="blood_oxygen{{ $index }}">ออกซิเจนในเลือด</label>
                                <input type="text" class="form-control" id="blood_oxygen{{ $index }}"
                                    name="blood_oxygen[{{ $index }}]"
                                    value="{{ old('blood_oxygen.' . $index, $healthRecord->blood_oxygen ?? '') }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="blood_level{{ $index }}">ระดับน้ำตาลในเลือด</label>
                                <input type="text" class="form-control" id="blood_level{{ $index }}"
                                    name="blood_level[{{ $index }}]"
                                    value="{{ old('blood_level.' . $index, $healthRecord->blood_level ?? '') }}"
                                    readonly>
                            </div>

                            <div class="form-group3">
                                <label for="health_zone_{{ $index }}">blood pressure zone</label>
                                <input type="text" class="form-control" id="health_zone_{{ $index }}"
                                    name="health_zone_{{ $index }}"
                                    value="{{ isset($zones[$index]) ? implode(' ', $zones[$index]) : '' }}" readonly>
                            </div>


                            <div class="form-group3">
                                <label for="health_zone2">blood pressure zone</label>
                                <input type="text" class="form-control" id="health_zone2_{{ $index }}"
                                    name="health_zone2{{ $index }}"
                                    value="{{ isset($zones2[$index]) ? implode(' ', $zones2[$index]) : '' }}" readonly>
                            </div>
                            @if(isset($lifestylesHabit[$index]))
                            <div class="form-group1">
                                <label
                                    for="lifestyleshabit_{{ $lifestylesHabit[$index]['id'] }}">พฤติกรรม-สุขภาพจิต</label>
                                <input type="text" class="form-control"
                                    id="lifestyleshabit_{{ $lifestylesHabit[$index]['id'] }}"
                                    name="lifestyleshabit[{{ $lifestylesHabit[$index]['id'] }}]"
                                    value="{{ $lifestylesHabit[$index]['lifestyleshabit'] ?? '' }}" readonly>
                            </div>
                            @endif

                            @if(isset($elderlyInfo[$index]))
                            <div class="form-group1">
                                <label for="elderlyhabit_{{ $elderlyInfo[$index]['id'] }}">ข้อมูลผู้สูงอายุ</label>
                                <input type="text" class="form-control"
                                    id="elderlyhabit_{{ $elderlyInfo[$index]['id'] }}"
                                    name="elderlyhabit[{{ $elderlyInfo[$index]['id'] }}]"
                                    value="{{ $elderlyInfo[$index]['lifestyleshabit'] }}" readonly>
                            </div>
                            @endif

                            <div class="form-group">
                                <label for="user_name">ผู้บันทึกข้อมูล</label>
                                <input type="text" class="form-control" id="user_name" name="user_name"
                                    value="{{ old('user_name', $recorddata->user_name) }}"
                                    {{ $recorddata->user_name ? 'readonly' : '' }}>
                            </div>

                            <a href="{{ route('recorddata.edit_general_information', ['recorddata_id' => $recorddata->id, 'checkup_id' => count($healthRecords) - $index]) }}"
                                class="btn btn-secondary" id="#editBtn">
                                แก้ไขข้อมูล
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".accordion-button").forEach(button => {
                    button.addEventListener("click", function() {
                        let target = document.querySelector(this.getAttribute(
                        "data-bs-target"));
                        let collapse = bootstrap.Collapse.getInstance(target);
                        if (collapse) {
                            collapse.toggle();
                        } else {
                            new bootstrap.Collapse(target, {
                                toggle: true
                            });
                        }
                    });
                });
            });
            </script>

    </div>
    </form>
</div>
</div>
@endsection