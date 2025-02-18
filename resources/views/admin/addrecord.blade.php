@extends('layoutadmin')

@section('content')
<style>
.head {
    color: #020364;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.title {
    color: #020364;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-left: 30px;
    padding-right: 30px;
    padding-bottom: 20px;
    padding-top: 30px;
}

.rectangle-box {
    margin-bottom: 50px;
    width: 100%;
    padding: 20px;
    border-radius: 5px;
    background-color: #6D91C9;
    display: flex;
    justify-content: center;
    align-items: center;
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


.blood-pressure-zone {
    background-color: #f0f0f0;
    color: #020364;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.blood-pressure-zone label {
    font-size: 14px;
}

.blood-pressure-zone {
    margin: 10px;
}

.section-title {
    color: #020364;
    padding-bottom: 10px;
    text-align: center;
}

.circle-container {
    display: flex;
    justify-content: flex-start;
    gap: 30px;
    flex-wrap: nowrap;
    overflow-x: auto;
}

.circle-group {
    text-align: center;
    width: 180px;
}

.circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-bottom: 10px;
    display: inline-block;
}

.form-check {
    margin-bottom: 10px;
}

.form-check-container label {
    font-size: 15px;
    font-weight: bold;
    color: #020364;
    text-align: left;
    /* Ensure text is aligned left */
}

.condition-checks {
    display: flex;
    justify-content: center;
    gap: 30px;
    padding-top: 20px;
}

.form-check-inline {
    margin-right: 15px;
}

.save {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding-top: 10px;
    padding-bottom: 30px;
    width: 100%;
    gap: 10px;
}

.zone-health {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
    padding-top: 15px;
    font-size: 14px;
    font-weight: bold;
    color: #020364;
}

.elderly-checkbox-container {
    color: #020364;
    font-size: 15px;
    font-weight: bold;
    display: flex;
    flex-wrap: wrap;
    gap: 60px;
    /* Add spacing between groups */
    justify-content: space-between;
    width: 100%;
    /* Ensure it takes up full width */
}


@media (max-width: 768px) {
    .head {
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
    }

    .head a.btn {
        width: auto;
        text-align: right;
    }

    .title {
        flex-direction: column;
        padding-left: 10px;
        padding-right: 10px;
        padding-bottom: 10px;
    }

    .rectangle-box {
        padding: 10px;
        margin-bottom: 20px;
    }

    form {
        flex-direction: column;
        padding-left: 10px;
        padding-right: 10px;
        gap: 10px;
    }

    .form-group,
    .form-group1,
    .form-group2,
    .form-group3 {
        flex: 1 1 100%;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="password"],
    input[type="phone"],
    input[type="tel"],
    input[type="date"] {
        width: 90%;
    }

    select[name="blood_group"],
    select[name="prefix"] {
        width: 90%;
    }

    .circle-container {
        display: flex;
        flex-direction: column;
        /* วงกลมจะเรียงแนวตั้ง */
        align-items: flex-start;
        /* ชิดซ้าย */
    }

    .circle-group {
        display: flex;
        flex-direction: row;
        /* เรียงวงกลม, label, และ checkbox เป็นแนวนอน */
        align-items: center;
        /* ให้วงกลม, label, และ checkbox อยู่ในแนวเดียวกัน */
        margin-bottom: 20px;
        /* ระยะห่างระหว่างกลุ่ม */
        width: 100%;
        /* ให้ใช้พื้นที่ทั้งหมด */
    }

    .circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
        /* ระยะห่างระหว่างวงกลมกับข้อความ */
    }

    label {
        margin-right: 10px;
        /* ระยะห่างระหว่าง label กับ checkbox */
        text-align: left;
        /* ให้ข้อความชิดซ้าย */
    }

    .form-check {
        display: flex;
        align-items: center;
        /* จัดให้ checkbox อยู่ในแนวเดียวกับ label */
        margin-right: 10px;
        /* ระยะห่างระหว่าง checkbox กับกลุ่มถัดไป */
    }

    .form-check-input {
        margin-right: 5px;
    }

    .button-container {
        justify-content: center;
        flex-direction: row;
        gap: 10px;
    }

    .elderly-checkbox-container {
        flex-direction: column;
        /* Stack groups vertically on smaller screens */
        gap: 10px;
        /* Reduce the gap between groups */
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
    <div class="head">
        <h4><strong>HEALTH CARD</strong></h4>
        <a href="/admin/record" type="button" class="btn btn-secondary">กลับ</a>
    </div>

    <div class="rectangle-box">
        <form id="Recorddata" action="{{ route('recorddata.store') }}" method="POST">
            @csrf
            <!--ข้อมูลประจำตัว-->
            <div class="d-flex justify-content-between align-items-center p-3 w-100">
                <h4 class="fw-bold m-0" style="color:#020364;">ข้อมูลประจำตัว</h4>
                <a href="{{ route('edit_form_record') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> แก้ไขแบบฟอร์ม
                </a>
            </div>


            <div class="form-group1">
                <label for="id_card">เลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="form-control" id="id_card" name="id_card" maxlength="13"
                    value="{{ old('id_card') }}" placeholder="กรอกเลขบัตรประจำตัวประชาชน" required>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const idCardInput = document.getElementById('id_card');
                const prefixInput = document.getElementById('prefix');
                const nameInput = document.getElementById('name');
                const surnameInput = document.getElementById('surname');
                const housenumberInput = document.getElementById('housenumber');
                const birthdateInput = document.getElementById('birthdate');
                const ageInput = document.getElementById('age');
                const bloodgroupInput = document.getElementById('blood_group');
                const weightInput = document.getElementById('weight');
                const heightInput = document.getElementById('height');
                const waistlineInput = document.getElementById('waistline');
                const bmiInput = document.getElementById('bmi');
                const phoneInput = document.getElementById('phone');
                const idlineInput = document.getElementById('idline');
                const extraFieldsInput = document.getElementById('extra_fields'); // สำหรับแสดงค่า extra_fields

                function calculateAge(birthdate) {
                    const birthDate = new Date(birthdate);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    return age;
                }

                if (idCardInput) {
                    idCardInput.addEventListener('change', function() {
                        const idCard = idCardInput.value;
                        console.log('ID Card:', idCard);

                        if (idCard) {
                            fetch('/search-id_card', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        id_card: idCard
                                    })
                                })
                                .then(response => response
                                    .json()) // เปลี่ยนที่นี่เพื่อให้ได้ข้อมูลจาก response
                                .then(data => {
                                    console.log("Response from server:", data);
                                    if (data && data
                                        .success) { // ตรวจสอบว่า data และ data.success มีค่าหรือไม่
                                        alert('ข้อมูลนี้มีอยู่ในระบบ');

                                        // ดึงข้อมูลและแสดงในฟอร์ม
                                        if (prefixInput) prefixInput.value = data.data.prefix || '';
                                        if (nameInput) nameInput.value = data.data.name || '';
                                        if (surnameInput) surnameInput.value = data.data.surname ||
                                            '';
                                        if (housenumberInput) housenumberInput.value = data.data
                                            .housenumber || '';
                                        if (birthdateInput) birthdateInput.value = data.data
                                            .birthdate || '';
                                        if (ageInput) ageInput.value = calculateAge(data.data
                                            .birthdate) || '';
                                        if (bloodgroupInput) bloodgroupInput.value = data.data
                                            .blood_group || '';
                                        if (weightInput) weightInput.value = data.data.weight || '';
                                        if (heightInput) heightInput.value = data.data.height || '';
                                        if (waistlineInput) waistlineInput.value = data.data
                                            .waistline || '';
                                        if (bmiInput) bmiInput.value = data.data.bmi || '';
                                        if (phoneInput) phoneInput.value = data.data.phone || '';
                                        if (idlineInput) idlineInput.value = data.data.idline || '';

                                        if (data.data.extra_fields) {
                                            const extraFields = JSON.parse(data.data.extra_fields);
                                            extraFields.forEach(field => {
                                                const inputElement = document
                                                    .getElementById(field.label);
                                                if (inputElement) {
                                                    inputElement.value = field.value ||
                                                    ''; // ใส่ค่าจาก extra_fields ใน input
                                                }
                                            });
                                        }
                                    } else {
                                        console.log('ไม่พบข้อมูล');
                                    }
                                })
                                .catch(error => {
                                    console.error('เกิดข้อผิดพลาด:', error);
                                });
                        }
                    });
                }
            });
            </script>

            <div class="form-group1">
                <label for="prefix">คำนำหน้าชื่อ</label>
                <select class="form-control" id="prefix" name="prefix">
                    <option value="" disabled {{ old('prefix') == '' ? 'selected' : '' }}>กรุณาเลือกคำนำหน้าชื่อ
                    </option>
                    <option value="ด.ช.">ด.ช.</option>
                    <option value="ด.ญ.">ด.ญ.</option>
                    <option value="นาย">นาย</option>
                    <option value="นาง">นาง</option>
                    <option value="นางสาว">นางสาว</option>
                </select>
            </div>

            <div class="form-group1">
                <label for="name">ชื่อ</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                    placeholder="กรอกชื่อ" required>
            </div>

            <div class="form-group1">
                <label for="surname">นามสกุล</label>
                <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}"
                    placeholder="กรอกนามสกุล" required>
            </div>

            <div class="form-group1">
                <label for="housenumber">บ้านเลขที่</label>
                <input type="text" class="form-control" id="housenumber" name="housenumber"
                    value="{{ old('housenumber') }}" placeholder="กรอกบ้านเลขที่" required>
            </div>

            <div class="form-group1">
                <label for="birthdate">วัน / เดือน / ปีเกิด</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"
                    placeholder="วัน/เดือน/ปีเกิด" required>
            </div>

            <div class="form-group1">
                <label for="age">อายุ</label>
                <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}"
                    placeholder="กรอกอายุ" readonly>
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
                <label for="blood_group">กรุ๊ปเลือด</label>
                <select name="blood_group" id="blood_group" class="form-control" required>
                    <option value="" disabled {{ old('blood_group') == '' ? 'selected' : '' }}>กรุณาเลือกกรุ๊ปเลือด
                    </option>
                    <option value="A" {{ old('blood_group') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('blood_group') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="AB" {{ old('blood_group') == 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O" {{ old('blood_group') == 'O' ? 'selected' : '' }}>O</option>
                </select>

            </div>

            <div class="form-group1">
                <label for="weight" style="margin-bottom: 5px; text-align: left; color: #020364;">น้ำหนัก</label>
                <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight') }}"
                    placeholder="กรอกน้ำหนัก" step="0.1" required>
            </div>

            <div class="form-group1">
                <label for="height" style="margin-bottom: 5px; text-align: left; color: #020364;">ส่วนสูง</label>
                <input type="number" class="form-control" id="height" name="height" value="{{ old('height') }}"
                    placeholder="กรอกส่วนสูง" step="0.1" required>
            </div>

            <div class="form-group1">
                <label for="waistline" style="margin-bottom: 5px; text-align: left; color: #020364;">รอบเอว
                    (ซม.)</label>
                <input type="number" class="form-control" id="waistline" name="waistline" value="{{ old('waistline') }}"
                    placeholder="กรอกรอบเอว" step="0.1" required>
            </div>


            <div class="form-group1">
                <label for="bmi" style="margin-bottom: 5px; text-align: left; color: #020364;">ดัชนีมวล BMI</label>
                <input type="number" class="form-control" id="bmi" name="bmi" value="{{ old('bmi') }}"
                    placeholder="กรอกดัชนีมวล BMI" step="0.1" required>
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
                <label for="phone" style="margin-bottom: 5px; text-align: left; color: #020364;">เบอร์โทรศัพท์</label>
                <input type="tel" class="form-control" id="phone" name="phone" maxlength="10" value="{{ old('phone') }}"
                    placeholder="กรอกหมายเลขโทรศัพท์" required>
            </div>

            <div class="form-group1">
                <label for="idline" style="margin-bottom: 5px; text-align: left; color: #020364;">ID Line</label>
                <input type="text" class="form-control" id="idline" name="idline" value="{{ old('idline') }}"
                    placeholder="กรอกไอดีไลน์" required>
            </div>

            @php
            $extra_fields = json_decode($recorddata->extra_fields, true) ?: []; // แปลง JSON string เป็น array
            @endphp

            @foreach($extra_fields as $field)
            @if(is_array($field) && isset($field['label'], $field['value']))
            @php
            $label = $field['label'] ?? 'ไม่มี label';
            $value = $field['value'] ?? 'ไม่มี value';
            @endphp
            <div class="form-group1">
                <label for="{{ $label }}" style="margin-bottom: 5px; text-align: left; color: #020364;">
                    {{ $label }}
                </label>
                <input type="text" class="form-control" id="{{ $label }}" name="extra_fields[{{ $label }}]"
                    value="{{ $value }}" placeholder="กรอก{{ $label }}">
            </div>
            @endif
            @endforeach

            <div class="d-flex justify-content-between align-items-center p-3 w-100">
                <h4 class="fw-bold m-0" style="color:#020364;">ข้อมูลทั่วไป</h4>

            </div>

            <div class="form-group">
                <label for="sys" style="margin-bottom: 5px; text-align: left; color: #020364;">SYS
                    (mmHg)</label>
                <input type="number" class="form-control" id="sys" name="sys" value="{{ old('sys') }}"
                    placeholder="กรอกค่าSYS" required>
            </div>

            <div class="form-group">
                <label for="dia" style="margin-bottom: 5px; text-align: left; color: #020364;">DIA (mmHg)
                </label>
                <input type="number" class="form-control" id="dia" name="dia" value="{{ old('dia') }}"
                    placeholder="กรอกDIA" required>
            </div>
            <div class="form-group">
                <label for="pul" style="margin-bottom: 5px; text-align: left; color: #020364;">PUL (min)</label>
                <input type="number" class="form-control" id="pul" name="pul" value="{{ old('pul') }}"
                    placeholder="กรอกPUL" required>
            </div>
            <div class="form-group">
                <label for="body_temp"
                    style="margin-bottom: 5px; text-align: left; color: #020364;">อุณหภูมิร่างกาย</label>
                <input type="number" class="form-control" id="body_temp" name="body_temp" value="{{ old('body_temp') }}"
                    placeholder="กรอกค่าอุณหภูมิร่างกาย" required>
            </div>
            <div class="form-group">
                <label for="blood_oxygen"
                    style="margin-bottom: 5px; text-align: left; color: #020364;">ความเข้มข้นของออกซิเจนในเลือด
                </label>
                <input type="number" class="form-control" id="blood_oxygen" name="blood_oxygen"
                    value="{{ old('blood_oxygen') }}" placeholder="กรอกความเข้มข้นของออกซิเจนในเลือด" required>
            </div>
            <div class="form-group">
                <label for="blood_level"
                    style="margin-bottom: 5px; text-align: left; color: #020364;">ระดับน้ำตาลในเลือด</label>
                <input type="number" class="form-control" id="blood_level" name="blood_level"
                    value="{{ old('blood_level') }}" placeholder="กรอกระดับน้ำตาลในเลือด" required>
            </div>

            @foreach($extra_fields_health_records as $field)
            <div class="form-group1">
                <label for="{{ $field }}"
                    style="margin-bottom: 5px; text-align: left; color: #020364;">{{ ucfirst($field) }}</label>
                <input type="text" class="form-control" id="{{ $field }}" name="extra_fields[{{ $field }}]"
                    value="{{ old('extra_fields.' . $field) }}" placeholder="กรอก {{ ucfirst($field) }}">
            </div>
            @endforeach

            <div class="blood-pressure-zone">
                <h4>Blood Pressure Zone</h4>
                <div class="circle-container">
                    <div>
                        <div class="circle" style="background-color: #FFFFFF;"></div>
                        <label>≤ 120/80 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_normal" name="zone1_normal" value="1">
                            <label for="zone1_normal">ปกติ</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #BEE5B6;"></div>
                        <label>120/80 - 139/89 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_risk_group" name="zone1_risk_group" value="1">
                            <label for="zone1_risk_group">กลุ่มเสี่ยง</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #558136;"></div>
                        <label>
                            < 139/89 mmHg</label>
                                <div class="form-check">
                                    <input type="checkbox" id="zone1_good_control" name="zone1_good_control" value="1">
                                    <label for="zone1_good_control">คุมได้ดี</label>
                                </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #FEFB18;"></div>
                        <label>140/90 - 159/99 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_watch_out" name="zone1_watch_out" value="1">
                            <label for="zone1_watch_out">เฝ้าระวัง</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #FF9600;"></div>
                        <label>160/100 - 179/109 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_danger" name="zone1_danger" value="1">
                            <label for="zone1_danger">อันตราย</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #FF0200;"></div>
                        <label>≥ 180/110 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_critical" name="zone1_critical" value="1">
                            <label for="zone1_critical">วิกฤต</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #090001;"></div>
                        <label>โรคแทรกซ้อน</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_complications" name="zone1_complications" value="1">
                            <label for="zone1_complications">โรคแทรกซ้อน</label>
                        </div>
                    </div>
                </div>

                <div class="zone-health">
                    <div class="form-check">
                        <input type="checkbox" id="zone1_heart" name="zone1_heart" value="1">
                        <label for="zone1_heart">หัวใจ</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="zone1_cerebrovascular" name="zone1_cerebrovascular" value="1">
                        <label for="zone1_cerebrovascular">หลอดเลือดสมอง</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="zone1_kidney" name="zone1_kidney" value="1">
                        <label for="zone1_kidney">ไต</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="zone1_eye" name="zone1_eye" value="1">
                        <label for="zone1_eye">ตา</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="zone1_foot" name="zone1_foot" value="1">
                        <label for="zone1_foot">เท้า</label>
                    </div>
                </div>
            </div>

            <!-- Blood Pressure Zone 2 -->
            <div class="blood-pressure-zone">
                <h4>Blood Pressure Zone</h4>
                <div class="circle-container">
                    <div>
                        <div class="circle" style="background-color: #FFFFFF;"></div>
                        <label>≤ 100 mg/dl</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_normal" name="zone2_normal" value="1">
                            <label for="zone2_normal">ปกติ</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #BEE5B6;"></div>
                        <label>100-125 mg/dl</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_risk_group" name="zone2_risk_group" value="1">
                            <label for="zone2_risk_group">กลุ่มเสี่ยง</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #558136;"></div>
                        <label>125 mg/dl</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_good_control" name="zone2_good_control" value="1">
                            <label for="zone2_good_control">คุมได้ดี</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #FEFB18;"></div>
                        <label>126-154 mg/dl HbA1c < 7</label>
                                <div class="form-check">
                                    <input type="checkbox" id="zone2_watch_out" name="zone2_watch_out" value="1">
                                    <label for="zone2_watch_out">เฝ้าระวัง</label>
                                </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #FF9600;"></div>
                        <label>155-182 mg/dl HbA1c 7-7.9</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_danger" name="zone2_danger" value="1">
                            <label for="zone2_danger">อันตราย</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #FF0200;"></div>
                        <label>≥ 183 mg/dl HbA1c 8%</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_critical" name="zone2_critical" value="1">
                            <label for="zone2_critical">วิกฤต</label>
                        </div>
                    </div>
                    <div>
                        <div class="circle" style="background-color: #090001;"></div>
                        <label>โรคแทรกซ้อน</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_complications" name="zone2_complications" value="1">
                            <label for="zone2_complications">โรคแทรกซ้อน</label>
                        </div>
                    </div>
                </div>
                <div class="zone-health">
                    <div class="form-check">
                        <input type="checkbox" id="zone2_heart" name="zone2_heart" value="1">
                        <label for="zone2_heart">หัวใจ</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="zone2_eye" name="zone2_eye" value="1">
                        <label for="zone2_eye">ตา</label>
                    </div>
                </div>
            </div>

            <!--โรคประจำตัว-->
            <div class="d-flex justify-content-between align-items-center p-3 w-100">
                <h4 class="fw-bold m-0" style="color:#020364;">โรคประจำตัว</h4>

            </div>

            <div class="congenital_disease">
                <div style="color: #020364; font-size: 15px; font-weight: bold;">
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="diabetes" value="0">
                        <input class="form-check-input" type="checkbox" name="diabetes" id="diabetes" value="1"
                            {{ old('diabetes') ? 'checked' : '' }}>
                        <label class="form-check-label" for="diabetes">เบาหวาน</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="cerebral_artery" value="0">
                        <input class="form-check-input" type="checkbox" name="cerebral_artery" id="cerebral_artery"
                            value="1" {{ old('cerebral_artery') ? 'checked' : '' }}>
                        <label class="form-check-label" for="cerebral_artery">หลอดเลือดสมอง</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="kidney" value="0">
                        <input class="form-check-input" type="checkbox" name="kidney" id="kidney" value="1"
                            {{ old('kidney') ? 'checked' : '' }}>
                        <label class="form-check-label" for="kidney">ไต</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="blood_pressure" value="0">
                        <input class="form-check-input" type="checkbox" name="blood_pressure" id="blood_pressure"
                            value="1" {{ old('blood_pressure') ? 'checked' : '' }}>
                        <label class="form-check-label" for="blood_pressure">ความดันโลหิตสูง</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="heart" value="0">
                        <input class="form-check-input" type="checkbox" name="heart" id="heart" value="1"
                            {{ old('heart') ? 'checked' : '' }}>
                        <label class="form-check-label" for="heart">หัวใจ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="eye" value="0">
                        <input class="form-check-input" type="checkbox" name="eye" id="eye" value="1"
                            {{ old('eye') ? 'checked' : '' }}>
                        <label class="form-check-label" for="eye">ตา</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="other" value="0">
                        <input class="form-check-input" type="checkbox" name="other" id="other" value="1"
                            {{ old('other') ? 'checked' : '' }}>
                        <label class="form-check-label" for="other">อื่น ๆ</label>
                    </div>
                </div>
            </div>

            <!--พฤติกรรม-สุขภาพจิต-->
            <div class="d-flex justify-content-between align-items-center p-3 w-100">
                <h4 class="fw-bold m-0" style="color:#020364;">พฤติกรรม-สุขภาพจิต</h4>

            </div>
            <div class="behavior">
                <div style="color: #020364; font-size: 15px; font-weight: bold;">
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="drink" value="0">
                        <input class="form-check-input" type="checkbox" name="drink" id="drink" value="1" disabled
                            {{ old('drink') ? 'checked' : '' }}>
                        <label class="form-check-label" for="drink">ดื่ม</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="hidden" name="drink_sometimes" value="0">
                        <input class="form-check-input" type="checkbox" name="drink_sometimes" id="drink_sometimes"
                            value="1" {{ old('drink_sometimes') ? 'checked' : '' }}>
                        <label class="form-check-label" for="drink_sometimes">ดื่มบ้างบางครั้ง</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="dont_drink" value="0">
                        <input class="form-check-input" type="checkbox" name="dont_drink" id="dont_drink" value="1"
                            {{ old('dont_drink') ? 'checked' : '' }}>
                        <label class="form-check-label" for="dont_drink">ไม่ดื่ม</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="smoke" value="0">
                        <input class="form-check-input" type="checkbox" name="smoke" id="smoke" value="1" disabled
                            {{ old('smoke') ? 'checked' : '' }}>
                        <label class="form-check-label" for="smoke">สูบ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="sometime_smoke" value="0">
                        <input class="form-check-input" type="checkbox" name="sometime_smoke" id="sometime_smoke"
                            value="1" {{ old('sometime_smoke') ? 'checked' : '' }}>
                        <label class="form-check-label" for="sometime_smoke">สูบบางครั้ง</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="dont_smoke" value="0">
                        <input class="form-check-input" type="checkbox" name="dont_smoke" id="dont_smoke" value="1"
                            {{ old('dont_smoke') ? 'checked' : '' }}>
                        <label class="form-check-label" for="dont_smoke">ไม่สูบ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="troubled" value="0">
                        <input class="form-check-input" type="checkbox" name="troubled" id="troubled" value="1"
                            {{ old('troubled') ? 'checked' : '' }}>
                        <label class="form-check-label" for="troubled">ทุกข์ใจ ซึม เศร้า</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="dont_live" value="0">
                        <input class="form-check-input" type="checkbox" name="dont_live" id="dont_live" value="1"
                            {{ old('dont_live') ? 'checked' : '' }}>
                        <label class="form-check-label" for="dont_live">ไม่อยากมีชีวิตอยู่</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="bored" value="0">
                        <input class="form-check-input" type="checkbox" name="bored" id="bored" value="1"
                            {{ old('bored') ? 'checked' : '' }}>
                        <label class="form-check-label" for="bored">เบื่อ</label>
                    </div>
                </div>
            </div>

            <!--ข้อมูลผู้สูงอายุ-->
            <div class="d-flex justify-content-between align-items-center p-3 w-100">
                <h4 class="fw-bold m-0" style="color:#020364;">ข้อมูลผู้สูงอายุ</h4>

            </div>
            <div class="elderly_information">
                <div class="elderly-checkbox-container" style="color: #020364; font-size: 15px; font-weight: bold;">
                    <!-- ช่วยเหลือตัวเอง -->
                    <div class="form-check-container">
                        <div class="form-check">
                            <input type="hidden" name="help_yourself" value="0">
                            <input class="form-check-input" type="checkbox" name="help_yourself" id="help_yourself"
                                value="1" {{ old('help_yourself') ? 'checked' : '' }}>
                            <label class="form-check-label" for="help_yourself">ช่วยเหลือตัวเองได้</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="can_help" value="0">
                            <input class="form-check-input" type="checkbox" name="can_help" id="can_help" value="1"
                                {{ old('can_help') ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_help">ได้</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="cant_help" value="0">
                            <input class="form-check-input" type="checkbox" name="cant_help" id="cant_help" value="1"
                                {{ old('cant_help') ? 'checked' : '' }}>
                            <label class="form-check-label" for="cant_help">ไม่ได้</label>
                        </div>
                    </div>

                    <!-- ผู้ดูแล -->
                    <div class="form-check-container">
                        <div class="form-check">
                            <input type="hidden" name="caregiver" value="0">
                            <input class="form-check-input" type="checkbox" name="caregiver" id="caregiver" value="1"
                                {{ old('caregiver') ? 'checked' : '' }}>
                            <label class="form-check-label" for="caregiver">ผู้ดูแล</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="have_caregiver" value="0">
                            <input class="form-check-input" type="checkbox" name="have_caregiver" id="have_caregiver"
                                value="1" {{ old('have_caregiver') ? 'checked' : '' }}>
                            <label class="form-check-label" for="have_caregiver">มีผู้ดูแล</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="no_caregiver" value="0">
                            <input class="form-check-input" type="checkbox" name="no_caregiver" id="no_caregiver"
                                value="1" {{ old('no_caregiver') ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_caregiver">ไม่มี</label>
                        </div>
                    </div>

                    <!-- กลุ่ม -->
                    <div class="form-check-container">
                        <div class="form-check">
                            <input type="hidden" name="group1" value="0">
                            <input class="form-check-input" type="checkbox" name="group1" id="group1" value="1"
                                {{ old('group1') ? 'checked' : '' }}>
                            <label class="form-check-label" for="group1">กลุ่มที่ 1
                                ผู้สูงอายุช่วยตัวเองและผู้อื่นได้</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="group2" value="0">
                            <input class="form-check-input" type="checkbox" name="group2" id="group2" value="1"
                                {{ old('group2') ? 'checked' : '' }}>
                            <label class="form-check-label" for="group2">กลุ่มที่ 2
                                ผู้สูงอายุช่วยตัวเองแต่มีโรคเรื้อรัง</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="group3" value="0">
                            <input class="form-check-input" type="checkbox" name="group3" id="group3" value="1"
                                {{ old('group3') ? 'checked' : '' }}>
                            <label class="form-check-label" for="group3">กลุ่มที่ 3
                                ผู้สูงอายุ/ผู้ป่วยดูแลตัวเองไม่ได้</label>
                        </div>
                    </div>

                    <!-- สถานะ -->
                    <div class="form-check-container">
                        <div class="form-check">
                            <input type="hidden" name="house" value="0">
                            <input class="form-check-input" type="checkbox" name="house" id="house" value="1"
                                {{ old('house') ? 'checked' : '' }}>
                            <label class="form-check-label" for="house">ติดบ้าน</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="society" value="0">
                            <input class="form-check-input" type="checkbox" name="society" id="society" value="1"
                                {{ old('society') ? 'checked' : '' }}>
                            <label class="form-check-label" for="society">ติดสังคม</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="bed-ridden" value="0">
                            <input class="form-check-input" type="checkbox" name="bed-ridden" id="bed-ridden" value="1"
                                {{ old('bed-ridden') ? 'checked' : '' }}>
                            <label class="form-check-label" for="bed-ridden">ติดเตียง</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-100 text-end fw-bold" style="color: #020364;">
                <div class="d-flex flex-column align-items-end">
                    <label for="user_id">ผู้บันทึกข้อมูล</label>
                    <select id="user_id" name="user_id" class="form-control w-50">
                        <option value="">เลือกผู้บันทึก</option>
                        @foreach($users->where('role', 'แอดมิน') as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} {{ $user->surname }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>



            <div class="save">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#saveModal">
                    บันทึก
                </button>

                <div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="saveModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="saveModalLabel">
                                    ยืนยันการบันทึกข้อมูล
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                คุณยินยอมให้เก็บข้อมูลนี้หรือไม่
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="submit" class="btn btn-success" id="confirmSave">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                document
                    .getElementById(
                        'confirmSave'
                    )
                    .addEventListener(
                        'click',
                        function() {
                            // บันทึกข้อมูลในฟอร์ม
                            document
                                .querySelector(
                                    'form'
                                )
                                .submit(); // ส่งฟอร์มไปที่เซิร์ฟเวอร์

                            // ปิด Modal
                            const
                                saveModal =
                                new bootstrap
                                .Modal(
                                    document
                                    .getElementById(
                                        'saveModal'
                                    )
                                );
                            saveModal
                                .hide();

                            // แสดงข้อความยืนยัน (ถ้าต้องการ)
                            alert
                                (
                                    'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
                        }
                    );
                </script>


                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#resetModal">ยกเลิก</button>

                <!-- Modal -->
                <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="resetModalLabel">
                                    ยืนยันการยกเลิก
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                คุณต้องการยกเลิกข้อมูลทั้งหมดใช่หรือไม่?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                                <button type="button" class="btn btn-danger" id="confirmReset">ยกเลิกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                document
                    .getElementById(
                        'confirmReset'
                    )
                    .addEventListener(
                        'click',
                        function() {
                            const
                                form =
                                document
                                .getElementById(
                                    'Recorddata'
                                );
                            if (
                                form) {
                                form
                                    .reset(); // รีเซ็ตข้อมูลฟอร์ม
                            }

                            // ปิด Modal ก่อน
                            const
                                resetModal =
                                new bootstrap
                                .Modal(
                                    document
                                    .getElementById(
                                        'resetModal'
                                    )
                                );
                            resetModal
                                .hide();

                            // ใช้ setTimeout เพื่อให้การแสดง alert เกิดขึ้นหลังจากการทำงานหลัก
                            setTimeout
                                (function() {
                                        alert
                                            (
                                                'ข้อมูลถูกรีเซ็ตเรียบร้อยแล้ว');
                                    },
                                    0
                                ); // การใช้ 0 จะทำให้ alert แสดงหลังจากการรีเซ็ตและปิด Modal ทันที
                        }
                    );
                </script>
        </form>
    </div>
</div>
</div>
@endsection