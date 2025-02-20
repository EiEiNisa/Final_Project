@extends('layoutuser')

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
    margin-bottom: 20px;
    width: 100%;
    padding: 20px;
    border-radius: 5px;
    background-color: #6D91C9;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

#accordionExample {
    width: 100%;
    max-width: 1000px;
    margin: 20px auto;
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: min-height 0.4s ease-out;
}

.accordion-item {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 100%;
    margin: 0 auto;
}

.accordion-header {
    background-color: #4a90e2;
    color: white;
    padding: 10px 10px;
    cursor: pointer;
    font-weight: bold;
    border-bottom: 1px solid #ddd;
    transition: background-color 0.3s ease;
}

.accordion-button {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #4a90e2;
    color: white;
    border: none;
    width: 100%;
}

.checkup-title {
    font-weight: bold;
    font-size: 16px;
}

.checkup-date {
    font-size: 14px;
    color: #ddd;
    margin-left: 10px;
}


.accordion-collapse {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.1s ease-out;
}

.accordion-collapse.show {
    max-height: 1000px;
}

.accordion-body {
    background-color: #f1f9ff;
    padding: 15px;
    border-top: 1px solid #ddd;
    border-radius: 0 0 8px 8px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
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

    .form-group, .form-group1 {
        flex-direction: column; /* ถ้าหน้าจอเล็กลง จะจัดเรียงในแนวตั้ง */
        align-items: flex-start;
    }

    .form-group label, .form-group1 label {
        margin-right: 0;
        margin-bottom: 5px; /* ระยะห่างระหว่าง label และ input/select */
    }

    .form-group .form-control, .form-group1 .form-control {
        width: 100%; /* ทำให้ input/select ขยายเต็มความกว้าง */
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

<div class="container">

    <div class="title">
        <h4><strong>แก้ไขข้อมูล</strong></h4>
        <a href="/User/record" class="btn btn-success">กลับไปยังหน้าบันทึกข้อมูล</a>
    </div>

    <div class="rectangle-box">
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
                    value="{{ old('name', $recorddata->name) }}" readonly>
            </div>

            <div class="form-group1">
                <label for="surname" class="form-label">นามสกุล</label>
                <input type="text" class="form-control" id="surname" name="surname"
                    value="{{ old('surname', $recorddata->surname) }}" readonly>
            </div>

            <div class="form-group1">
                <label for="housenumber" class="form-label">บ้านเลขที่</label>
                <input type="text" class="form-control" id="housenumber" name="housenumber"
                    value="{{ old('housenumber', $recorddata->housenumber) }}" readonly>
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
                    value="{{ old('weight', $recorddata->weight) }}" readonly>
            </div>

            <div class="form-group1">
                <label for="height" class="form-label">ส่วนสูง</label>
                <input type="number" class="form-control" id="height" name="height"
                    value="{{ old('height', $recorddata->height) }}" readonly>
            </div>

            <div class="form-group1">
                <label for="waistline" class="form-label">รอบเอว</label>
                <input type="number" class="form-control" id="waistline" name="waistline"
                    value="{{ old('waistline', $recorddata->waistline) }}" readonly>
            </div>

            <div class="form-group1">
                <label for="bmi" class="form-label">ดัชนีมวล BMI</label>
                <input type="number" class="form-control" id="bmi" name="bmi" value="{{ old('bmi', $recorddata->bmi) }}"
                    readonly>
            </div>

            <div class="form-group1">
                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $recorddata->phone) }}" readonly>
            </div>
            <div class="form-group1">
                <label for="idline" class="form-label">ID Line</label>
                <input type="text" class="form-control" id="idline" name="idline"
                    value="{{ old('idline', $recorddata->idline) }}" readonly>
            </div>

            <div class="form-group3">
                <h4><strong>ข้อมูลทั่วไป</strong></h4>
            </div>

            @if(session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
            @endif

            <div class="accordion" id="accordionExample">
                @foreach($healthRecords as $index => $healthRecord)
                <div class="accordion-item" style="margin-bottom: 10px;">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}" aria-expanded="true"
                            aria-controls="collapse{{ $index }}">
                            <span class="checkup-title">ตรวจครั้งที่ {{ count($healthRecords) - $index }}</span>
                            <span
                                class="checkup-date">{{ \Carbon\Carbon::parse($healthRecord->created_at)->format('d-m-Y') }}</span>
                        </button>
                    </h2>

                    <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
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

                            <!-- blood pressure zone -->
                            <div class="form-group3">
                                <label for="health_zone">blood pressure zone</label>
                                @if (isset($zones[$index]) && is_array($zones[$index]))
                                <input type="text" class="form-control" id="health_zone_{{ $index }}"
                                    name="health_zone{{ $index }}" value="{{ implode(' ', $zones[$index]) }}" readonly>
                                @else
                                <input type="text" class="form-control" id="health_zone_{{ $index }}"
                                    name="health_zone{{ $index }}" value="{{ $zones[$index] ?? '' }}" readonly>
                                @endif
                            </div>

                            <!-- blood pressure zone 2 -->
                            <div class="form-group3">
                                <label for="health_zone2">blood pressure zone 2</label>
                                @if (isset($zones2[$index]) && is_array($zones2[$index]))
                                <input type="text" class="form-control" id="health_zone2_{{ $index }}"
                                    name="health_zone2[]" value="{{ implode(' ', $zones2[$index]) }}" readonly>
                                @else
                                <input type="text" class="form-control" id="health_zone2_{{ $index }}"
                                    name="health_zone2[]" value="{{ $zones2[$index] ?? '' }}" readonly>
                                @endif
                            </div>

                            @foreach ($diseaseNames as $disease)
                            <div class="form-group1">
                                <label for="disease_{{ $disease['id'] }}">โรคประจำตัว</label>
                                <input type="text" class="form-control" id="disease_{{ $disease['id'] }}"
                                    name="diseaseNames[]" value="{{ $disease['names'] }}" readonly>
                            </div>
                            @endforeach


                            @foreach ($lifestylesHabit as $lifestyle)
                            <div class="form-group1">
                                <label for="lifestyleshabit_{{ $lifestyle['id'] }}">พฤติกรรม-สุขภาพจิต</label>
                                <input type="text" class="form-control" id="lifestyleshabit_{{ $lifestyle['id'] }}"
                                    name="lifestyleshabit[{{ $lifestyle['id'] }}]"
                                    value="{{ $lifestyle['lifestyleshabit'] ?? '' }}" readonly>
                            </div>
                            @endforeach

                            @foreach ($elderlyInfo as $info)
                            <div class="form-group1">
                                <label for="elderlyhabit_{{ $info['id'] }}">ข้อมูลผู้สูงอายุ</label>
                                <input type="text" class="form-control" id="elderlyhabit_{{ $info['id'] }}"
                                    name="elderlyhabit[{{ $info['id'] }}]" value="{{ $info['lifestyleshabit'] }}"
                                    readonly>
                            </div>
                            @endforeach

                            <div class="form-group">
                                <label for="user_id">ผู้บันทึกข้อมูล</label>
                                <input type="text" class="form-control" id="user_id" name="user_id"
                                    value="{{ $user->name }} {{ $user->surname }}" readonly>
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