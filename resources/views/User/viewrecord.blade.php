@extends('layoutuser')

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

.custom-accordion {
    width: 100%;
}

.custom-accordion-item {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.custom-accordion-item .accordion-header {
    background-color: #f0f8ff;
}

.custom-accordion-item .accordion-button {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    text-align: left;
    padding: 1.2rem 1.5rem;
    border: none;
    background: transparent;
    box-shadow: none;
    color: #333;
}

.custom-accordion-item .accordion-button:focus {
    box-shadow: none;
}

.custom-accordion-item .accordion-button:not(.collapsed) {
    background-color: #e0f2fe;
}

.custom-accordion-item .checkup-title {
    font-weight: 600;
    color: #020364;
}

.custom-accordion-item .checkup-date {
    color: #555;
    margin-left: 1rem;
}

.custom-accordion-item .accordion-body {
    padding: 1.5rem;
    background-color: #fff;
    display: block;
}

.custom-accordion-item .form-group {
    margin-bottom: 1.2rem;
    display: block;
}

.custom-accordion-item .form-group label {
    display: block;
    margin-bottom: 0.6rem;
    font-weight: 500;
    color: #444;
}

.custom-accordion-item .form-group .form-control {
    width: 100%;
    padding: 0.6rem 1rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    color: #333;
    background-color: #f9f9f9;
    display: block;
}

.custom-accordion-item .btn-secondary {
    margin-top: 1.5rem;
    background-color: #6c757d;
    border-color: #6c757d;
    color: #fff;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
}

.custom-accordion-item .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
}

label {
    font-weight: bold;
    font-size: 15px;
    color: #020364;
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

.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
    outline: none;
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

@media (max-width: 768px) {
    .title {
        padding-left: 15px;
        padding-right: 15px;
    }

    .rectangle-box {
        padding: 15px;
    }

    #accordionExample {
        padding: 10px;
    }

    .accordion-item {
        margin-bottom: 15px;
    }

    .accordion-button {
        padding: 12px;
    }

    .checkup-title {
        font-size: 14px;
    }

    .checkup-date {
        font-size: 12px;
    }

    .form-group,
    .form-group1 {
        flex-direction: column;
        /* ถ้าหน้าจอเล็กลง จะจัดเรียงในแนวตั้ง */
        align-items: flex-start;
    }

    .form-group label,
    .form-group1 label {
        margin-right: 0;
        margin-bottom: 5px;
        /* ระยะห่างระหว่าง label และ input/select */
    }

    .form-group .form-control,
    .form-group1 .form-control {
        width: 100%;
        /* ทำให้ input/select ขยายเต็มความกว้าง */
    }



    .circle-container {
        font-size: 14px;
    }

    .circle {
        width: 30px;
        height: 30px;
    }
}
</style>

<div class="card-container">

    <div class="card-header">
        <h4><strong>ดูข้อมูล</strong></h4>
        <a href="#" class="btn btn-secondary btn-back" id="backButton">กลับ</a>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            let previousUrl = document.referrer;

            if (previousUrl.includes("admin/record?page=")) {
                document.getElementById("backButton").href = previousUrl;
            } else {
                document.getElementById("backButton").href = "https://thungsetthivhv.pcnone.com/User/record";
            }
        });
        </script>
    </div>

    <div class="card-body">
        <form action="{{ route('recorddata.update', $recorddata->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group3">
                <h4><strong>ข้อมูลประจำตัว</strong></h4>
            </div>

            <div class="form-group1">
                <label for="prefix" class="form-label">คำนำหน้าชื่อ</label>
                <select class="form-control" id="prefix" name="prefix" required disabled>
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
                    value="{{ old('name', $recorddata->name) }}" disabled>
            </div>

            <div class="form-group1">
                <label for="surname" class="form-label">นามสกุล</label>
                <input type="text" class="form-control" id="surname" name="surname"
                    value="{{ old('surname', $recorddata->surname) }}" disabled>
            </div>

            <div class="form-group1">
                <label for="housenumber" class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" id="housenumber" name="housenumber"
                    value="{{ old('housenumber', $recorddata->housenumber) }}" disabled>
            </div>

            <div class="form-group1">
                <label for="birthdate" class="form-label">วัน / เดือน / ปีเกิด</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate"
                    value="{{ old('birthdate', $recorddata->birthdate) }}" disabled>
            </div>

            <div class="form-group1">
                <label for="age" class="form-label">อายุ</label>
                <input type="number" class="form-control" id="age" name="age" value="{{ old('age', $recorddata->age) }}"
                    disabled>
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
                <select name="blood_group" id="blood_group" class="form-control" required disabled>
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
                    value="{{ old('weight', $recorddata->weight) }}" disabled>
            </div>

            <div class="form-group1">
                <label for="height" class="form-label">ส่วนสูง</label>
                <input type="number" class="form-control" id="height" name="height"
                    value="{{ old('height', $recorddata->height) }}" disabled>
            </div>

            <div class="form-group1">
                <label for="waistline" class="form-label">รอบเอว</label>
                <input type="number" class="form-control" id="waistline" name="waistline"
                    value="{{ old('waistline', $recorddata->waistline) }}" disabled>
            </div>

            <div class="form-group1">
                <label for="bmi" class="form-label">ดัชนีมวล BMI</label>
                <input type="number" class="form-control" id="bmi" name="bmi" value="{{ old('bmi', $recorddata->bmi) }}"
                    disabled>
            </div>

            <div class="form-group1">
                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $recorddata->phone) }}" disabled>
            </div>
            <div class="form-group1">
                <label for="idline" class="form-label">ID Line</label>
                <input type="text" class="form-control" id="idline" name="idline"
                    value="{{ old('idline', $recorddata->idline) }}" disabled>
            </div>

            @foreach($customFields as $field)
            <div class="form-group1">
                <label style="margin-bottom: 5px; text-align: left; color: #020364;">{{ $field->label }}</label>

                @php
                // ดึงค่าจาก customFieldValuesMap หรือ old() (กรณีมีการ submit แล้ว validation ไม่ผ่าน)
                $storedValue = $customFieldValuesMap[$field->id] ?? old($field->name, '');

                // ตรวจสอบว่าเป็น JSON string หรือไม่ ถ้าใช่ให้แปลงเป็น array
                if (is_string($storedValue) && str_starts_with($storedValue, '[')) {
                $storedValue = json_decode($storedValue, true);
                }
                @endphp

                @if($field->field_type == 'text')
                <input type="text" class="form-control" name="{{ $field->name }}" value="{{ $storedValue }}" disabled>

                @elseif($field->field_type == 'select')
                @php
                $options = json_decode($field->options, true) ?? [];
                $selectedValue = ($storedValue == '1') ? '1' : $storedValue;
                @endphp
                <select class="form-control" name="{{ $field->name }}" disabled>
                    @foreach($options as $option)
                    <option value="{{ $option }}" {{ $selectedValue == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                    @endforeach
                </select>

                @elseif($field->field_type == 'checkbox')
                @php
                $options = json_decode($field->options, true) ?? [];
                $checkedValues = is_array($storedValue) ? $storedValue : (is_string($storedValue) ? [$storedValue] :
                []);
                @endphp
                <div class="checkbox-group">
                    @foreach($options as $option)
                    <div class="form-check" style="display: inline-block; margin-right: 15px;">
                        <input class="form-check-input" type="checkbox" name="{{ $field->name }}[]"
                            value="{{ $option }}" {{ in_array($option, $checkedValues) ? 'checked' : '' }} disabled>
                        <label style="margin-bottom: 5px; text-align: left; color: #020364;">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>

                @elseif($field->field_type == 'radio')
                @php
                $options = json_decode($field->options, true) ?? [];
                $selectedRadio = ($storedValue == '1') ? '1' : $storedValue;
                @endphp
                <div class="radio-group">
                    @foreach($options as $option)
                    <div class="form-check" style="display: inline-block; margin-right: 15px;">
                        <input class="form-check-input" type="radio" name="{{ $field->name }}" value="{{ $option }}"
                            {{ $selectedRadio == $option ? 'checked' : '' }} disabled>
                        <label style="margin-bottom: 5px; text-align: left; color: #020364;">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach

            <div class="form-group3">
                <h4><strong>ข้อมูลทั่วไป</strong></h4>
            </div>

            <div class="accordion custom-accordion" id="accordionExample">
                @foreach($healthRecords as $index => $healthRecord)
                <div class="custom-accordion-item mb-3">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                            aria-controls="collapse{{ $index }}">
                            <span class="checkup-title">ตรวจครั้งที่ {{ count($healthRecords) - $index }}</span>
                            <span class="checkup-date">
                                {{ \Carbon\Carbon::parse($healthRecord->created_at)->translatedFormat('d F Y') }}
                            </span>
                        </button>
                    </h2>

                    <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $index }}">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="sys{{ $index }}">ความดัน SYS</label>
                                            <input type="text" class="form-control" id="sys{{ $index }}"
                                                name="sys[{{ $index }}]"
                                                value="{{ old('sys.' . $index, $healthRecord->sys ?? '') }}" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="dia{{ $index }}">ความดัน DIA</label>
                                            <input type="text" class="form-control" id="dia{{ $index }}"
                                                name="dia[{{ $index }}]"
                                                value="{{ old('dia.' . $index, $healthRecord->dia ?? '') }}" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="pul{{ $index }}">ชีพจร</label>
                                            <input type="text" class="form-control" id="pul{{ $index }}"
                                                name="pul[{{ $index }}]"
                                                value="{{ old('pul.' . $index, $healthRecord->pul ?? '') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="body_temp{{ $index }}">อุณหภูมิร่างกาย</label>
                                            <input type="text" class="form-control" id="body_temp{{ $index }}"
                                                name="body_temp[{{ $index }}]"
                                                value="{{ old('body_temp.' . $index, $healthRecord->body_temp ?? '') }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="blood_oxygen{{ $index }}">ออกซิเจนในเลือด</label>
                                            <input type="text" class="form-control" id="blood_oxygen{{ $index }}"
                                                name="blood_oxygen[{{ $index }}]"
                                                value="{{ old('blood_oxygen.' . $index, $healthRecord->blood_oxygen ?? '') }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="blood_level{{ $index }}">ระดับน้ำตาลในเลือด</label>
                                            <input type="text" class="form-control" id="blood_level{{ $index }}"
                                                name="blood_level[{{ $index }}]"
                                                value="{{ old('blood_level.' . $index, $healthRecord->blood_level ?? '') }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="health_zone_{{ $index }}">blood pressure zone</label>
                                            <input type="text" class="form-control" id="health_zone_{{ $index }}"
                                                name="health_zone_{{ $index }}"
                                                value="{{ isset($zones[$index]) ? implode(' ', $zones[$index]) : '' }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="health_zone2">blood pressure zone</label>
                                            <input type="text" class="form-control" id="health_zone2_{{ $index }}"
                                                name="health_zone2{{ $index }}"
                                                value="{{ isset($zones2[$index]) ? implode(' ', $zones2[$index]) : '' }}"
                                                readonly>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="diseaseNames_{{ $index }}">โรคประจำตัว</label>
                                            <input type="text" class="form-control" id="diseaseNames_{{ $index }}"
                                                name="diseaseNames[{{ $index }}]"
                                                value="{{ isset($diseaseNames[$index]) ? (isset($diseaseNames[$index]['other']) && $diseaseNames[$index]['other'] == 1 ? $diseaseNames[$index]['other_text'] : $diseaseNames[$index]['names']) : 'ไม่มีข้อมูล' }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        @if(isset($lifestylesHabit[$index]))
                                        <div class="col-12 mb-3">
                                            <label
                                                for="lifestyleshabit_{{ $lifestylesHabit[$index]['id'] }}">พฤติกรรม-สุขภาพจิต</label>
                                            <input type="text" class="form-control"
                                                id="lifestyleshabit_{{ $lifestylesHabit[$index]['id'] }}"
                                                name="lifestyleshabit[{{ $lifestylesHabit[$index]['id'] }}]"
                                                value="{{ $lifestylesHabit[$index]['lifestyleshabit'] ?? '' }}"
                                                readonly>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        @if(isset($elderlyInfo[$index]))
                                        <div class="col-12 mb-3">
                                            <label
                                                for="elderlyhabit_{{ $elderlyInfo[$index]['id'] }}">ข้อมูลผู้สูงอายุ</label>
                                            <input type="text" class="form-control"
                                                id="elderlyhabit_{{ $elderlyInfo[$index]['id'] }}"
                                                name="elderlyhabit[{{ $elderlyInfo[$index]['id'] }}]"
                                                value="{{ $elderlyInfo[$index]['lifestyleshabit'] }}" readonly>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        @foreach($customFieldsGeneral as $field)
                                        <div class="form-group1">
                                            <label
                                                style="margin-bottom: 5px; text-align: left; color: #020364;">{{ $field->label }}</label>

                                            @php
                                            $storedValue = $customFieldGeneralValuesMap[$field->id] ?? old($field->name,
                                            '');

                                            if (is_string($storedValue) && str_starts_with($storedValue, '[')) {
                                            $storedValue = json_decode($storedValue, true);
                                            }

                                            // Check if the value is '1', if not set to 'ไม่มีค่า'
                                            $displayValue = $storedValue;
                                            if ($storedValue == '' || (is_array($storedValue) && empty($storedValue))) {
                                            $displayValue = 'ไม่มีค่า';
                                            }
                                            @endphp

                                            @if($field->field_type == 'text')
                                            <input type="text" class="form-control" name="{{ $field->name }}"
                                                value="{{ $displayValue }}" readonly>

                                            @elseif($field->field_type == 'select')
                                            @php
                                            $options = json_decode($field->options, true) ?? [];
                                            $selectedValue = ($storedValue == '1') ? '1' : $displayValue;
                                            @endphp
                                            <input type="text" class="form-control" name="{{ $field->name }}"
                                                value="{{ $selectedValue }}" readonly>

                                            @elseif($field->field_type == 'checkbox')
                                            @php
                                            $options = json_decode($field->options, true) ?? [];
                                            $checkedValues = is_array($storedValue) ? $storedValue :
                                            (is_string($storedValue) ? [$storedValue] : []);

                                            // Check if any values are selected, otherwise set to 'ไม่มีค่า'
                                            if (empty($checkedValues)) {
                                            $displayValue = 'ไม่มีค่า';
                                            } else {
                                            // Join the selected checkbox values
                                            $displayValue = implode(', ', $checkedValues);
                                            }
                                            @endphp
                                            <input type="text" class="form-control" name="{{ $field->name }}"
                                                value="{{ $displayValue }}" readonly>

                                            @elseif($field->field_type == 'radio')
                                            @php
                                            $options = json_decode($field->options, true) ?? [];
                                            $selectedRadio = ($storedValue == '1') ? '1' : $displayValue;

                                            // If no value selected, set to 'ไม่มีค่า'
                                            if (empty($storedValue) || $storedValue == '0') {
                                            $displayValue = 'ไม่มีค่า';
                                            }
                                            @endphp
                                            <input type="text" class="form-control" name="{{ $field->name }}"
                                                value="{{ $displayValue }}" readonly>

                                            @endif
                                        </div>
                                        @endforeach
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="user_name">ผู้บันทึกข้อมูล</label>
                                            <input type="text" class="form-control" id="user_name" name="user_name"
                                                value="{{ old('user_name', $recorddata->user_name) }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </form>
    </div>
</div>
@endsection