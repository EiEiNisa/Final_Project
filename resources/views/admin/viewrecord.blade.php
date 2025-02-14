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

.accordion {
    width: 100%;
    height: 100vh;
    overflow-y: auto;
}
</style>

<div class="container">
    <br><br>
    <div class="rectangle-box">
        <form action="{{ route('recorddata.edit', $recorddata->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group3">
                <h4><strong>ข้อมูลประจำตัว</strong></h4>
            </div>

            <div class="form-group1">
                <label for="id_card" class="form-label">เลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="form-control" id="id_card" name="id_card"
                    value="{{ old('id_card', $recorddata->id_card) }}" readonly>
            </div>

            <div class="form-group1">
                <label for="prefix" class="form-label">คำนำหน้าชื่อ</label>
                <select class="form-control" id="prefix" name="prefix" disabled>
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

            <div class="form-group1">
                <label for="blood_group" class="form-label">กรุ๊ปเลือด</label>
                <select name="blood_group" id="blood_group" class="form-control" disabled>
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

            <div class="accordion" id="accordionExample">
                @foreach($healthRecords as $index => $healthRecord)
                <div class="accordion-item" style="margin-bottom: 10px;">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $index }}" aria-expanded="true"
                            aria-controls="collapse{{ $index }}">
                            ตรวจครั้งที่ {{ $index + 1 }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <fieldset class="form-group">
                                <div class="form-group">
                                    <label for="sys{{ $index }}">ความดัน SYS</label>
                                    <input type="text" class="form-control" id="sys{{ $index }}"
                                        name="sys[{{ $index }}]"
                                        value="{{ old('sys.' . $index, $healthRecord->sys ?? '') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="dia{{ $index }}">ความดัน DIA</label>
                                    <input type="text" class="form-control" id="dia{{ $index }}"
                                        name="dia[{{ $index }}]"
                                        value="{{ old('dia.' . $index, $healthRecord->dia ?? '') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="pul{{ $index }}">ชีพจร</label>
                                    <input type="text" class="form-control" id="pul{{ $index }}"
                                        name="pul[{{ $index }}]"
                                        value="{{ old('pul.' . $index, $healthRecord->pul ?? '') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="body_temp{{ $index }}">อุณหภูมิร่างกาย</label>
                                    <input type="text" class="form-control" id="body_temp{{ $index }}"
                                        name="body_temp[{{ $index }}]"
                                        value="{{ old('body_temp.' . $index, $healthRecord->body_temp ?? '') }}"
                                        readonly>
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

                            </fieldset>

                            <div class="form-group1">
                                <label for="health_zone">blood pressure zone</label>
                                <input type="text" class="form-control" id="health_zone" name="health_zone"
                                    value="{{ implode(' ' , $zones) }}" readonly>
                            </div>

                            <div class="form-group1">
                                <label for="health_zone2">blood pressure zone</label>
                                <input type="text" class="form-control" id="health_zone2" name="health_zone2"
                                    value="{{ implode(' ' , $zones2) }}" readonly>
                            </div>

                            <div class="form-group1">
                                <label for="diseaseNames">โรคประจำตัว</label>
                                <input type="text" class="form-control" id="diseaseNames" name="diseaseNames"
                                    value="{{ implode(' ' , $diseaseNames) }}" readonly>
                            </div>

                            <div class="form-group1">
                                <label for="lifestyleshabit">พฤติกรรม-สุขภาพจิต</label>
                                <input type="text" class="form-control" id="lifestyleshabit" name="lifestyleshabit"
                                    value="{{ implode(' ' , $lifestyleshabit) }}" readonly>
                            </div>
                            <div class="form-group1">
                                <label for="hlderly">ข้อมูลผู้สูงอายุ</label>
                                <input type="text" class="form-control" id="hlderly" name="hlderly"
                                    value="{{ implode(' ' , $hlderly) }}" readonly>
                            </div>
                            
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
    @endsection