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
    justify-content: space-between;
    width: 100%;
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
        align-items: flex-start;
    }

    .circle-group {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 20px;
        width: 100%;
    }

    .circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    label {
        margin-right: 10px;
        text-align: left;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-right: 10px;
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
        gap: 10px;
    }
}
</style>

<div class="card-container">
    <br>
    @if(session('success'))
    <div class="alert alert-success">
        {!! session('success') !!}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card-header">
        <h4><strong>แก้ไขข้อมูล</strong></h4>
        <a href="/admin/editrecord/{{ $recorddata_id }}" class="btn btn-secondary btn-back">กลับ</a>
    </div>

    <div class="card-body">
        <form id="Recorddata"
            action="{{ route('recorddata.update_form_general_information', ['recorddata_id' => $recorddata->id, 'checkup_id' => $checkup_index]) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="sys" style="margin-bottom: 5px; text-align: left; color: #020364;">SYS
                    (mmHg)</label>
                <input type="number" class="form-control" id="sys" name="sys"
                    value="{{ old('sys', $healthRecord->sys) }}" placeholder="กรอกค่าSYS" required>
            </div>

            <div class="form-group">
                <label for="dia" style="margin-bottom: 5px; text-align: left; color: #020364;">DIA (mmHg)
                </label>
                <input type="number" class="form-control" id="dia" name="dia"
                    value="{{ old('dia', $healthRecord->dia) }}" placeholder="กรอกDIA" required>
            </div>

            <div class="form-group">
                <label for="pul" style="margin-bottom: 5px; text-align: left; color: #020364;">PUL (min)</label>
                <input type="number" class="form-control" id="pul" name="pul"
                    value="{{ old('pul', $healthRecord->pul) }}" placeholder="กรอกPUL" required>
            </div>
            <div class="form-group">
                <label for="body_temp"
                    style="margin-bottom: 5px; text-align: left; color: #020364;">อุณหภูมิร่างกาย</label>
                <input type="number" class="form-control" id="body_temp" name="body_temp"
                    value="{{ old('body_temp', $healthRecord->body_temp) }}" placeholder="กรอกค่าอุณหภูมิร่างกาย"
                    required>
            </div>
            <div class="form-group">
                <label for="blood_oxygen"
                    style="margin-bottom: 5px; text-align: left; color: #020364;">ความเข้มข้นของออกซิเจนในเลือด
                </label>
                <input type="number" class="form-control" id="blood_oxygen" name="blood_oxygen"
                    value="{{ old('blood_oxygen', $healthRecord->blood_oxygen) }}"
                    placeholder="กรอกความเข้มข้นของออกซิเจนในเลือด" required>
            </div>
            <div class="form-group">
                <label for="blood_level"
                    style="margin-bottom: 5px; text-align: left; color: #020364;">ระดับน้ำตาลในเลือด</label>
                <input type="number" class="form-control" id="blood_level" name="blood_level"
                    value="{{ old('blood_level', $healthRecord->blood_level) }}" placeholder="กรอกระดับน้ำตาลในเลือด"
                    required>
            </div>

            <!-- Blood Pressure Zone 1 -->
            <div class="blood-pressure-zone">
                <h4>Blood Pressure Zone</h4>
                <div class="circle-container">
                    <div>
                        <!-- zone1_normal -->
                        <div class="circle" style="background-color: #fff;"></div>
                        <label>≤ 120/80 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_normal" name="zone1_normal" value="1"
                                {{ $zones['zone1_normal']['value'] ? 'checked' : '' }}>
                            <label for="zone1_normal">ปกติ</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #BEE5B6;"></div>
                        <label>120/80 - 139/89 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_risk_group" name="zone1_risk_group" value="1"
                                {{ $zones['zone1_risk_group']['value'] ? 'checked' : '' }}>
                            <label for="zone1_risk_group">กลุ่มเสี่ยง</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #558136;"></div>
                        <label>
                            < 139/89 mmHg</label>
                                <div class="form-check">
                                    <input type="checkbox" id="zone1_good_control" name="zone1_good_control" value="1"
                                        {{ $zones['zone1_good_control']['value'] ? 'checked' : '' }}>
                                    <label for="zone1_good_control">คุมได้ดี</label>
                                </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #FEFB18;"></div>
                        <label>140/90 - 159/99 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_watch_out" name="zone1_watch_out" value="1"
                                {{ $zones['zone1_watch_out']['value'] ? 'checked' : '' }}>
                            <label for="zone1_watch_out">เฝ้าระวัง</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #FF9600;"></div>
                        <label>160/100 - 179/109 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_danger" name="zone1_danger" value="1"
                                {{ $zones['zone1_danger']['value'] ? 'checked' : '' }}>
                            <label for="zone1_danger">อันตราย</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #FF0200;"></div>
                        <label>≥ 180/110 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_critical" name="zone1_critical" value="1"
                                {{ $zones['zone1_critical']['value'] ? 'checked' : '' }}>
                            <label for="zone1_critical">วิกฤต</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #090001;"></div>
                        <label>โรคแทรกซ้อน</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone1_complications" name="zone1_complications" value="1"
                                {{ $zones['zone1_complications']['value'] ? 'checked' : '' }}>
                            <label for="zone1_complications">โรคแทรกซ้อน</label>
                        </div>
                    </div>
                </div>

                <div class="zone-health">
                    <div class="form-check">
                        <input type="checkbox" id="zone1_heart" name="zone1_heart" value="1"
                            {{ $zones['zone1_heart']['value'] ? 'checked' : '' }}>
                        <label for="zone1_heart">หัวใจ</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="zone1_cerebrovascular" name="zone1_cerebrovascular" value="1"
                            {{ $zones['zone1_cerebrovascular']['value'] ? 'checked' : '' }}>
                        <label for="zone1_cerebrovascular">หลอดเลือดสมอง</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="zone1_kidney" name="zone1_kidney" value="1"
                            {{ $zones['zone1_kidney']['value'] ? 'checked' : '' }}>
                        <label for="zone1_kidney">ไต</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="zone1_eye" name="zone1_eye" value="1"
                            {{ $zones['zone1_eye']['value'] ? 'checked' : '' }}>
                        <label for="zone1_eye">ตา</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="zone1_foot" name="zone1_foot" value="1"
                            {{ $zones['zone1_foot']['value'] ? 'checked' : '' }}>
                        <label for="zone1_foot">เท้า</label>
                    </div>

                </div>
            </div>

            <!-- Blood Pressure Zone 2 -->
            <div class="blood-pressure-zone">
                <h4>Blood Pressure Zone</h4>
                <div class="circle-container">
                    <div>
                        <!-- zone2_normal -->
                        <div class="circle" style="background-color: #fff;"></div>
                        <label>≥ 180/110 mmHg</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_normal" name="zone2_normal" value="1"
                                {{ $zones2['zone2_normal']['value'] ? 'checked' : '' }}>
                            <label for="zone2_normal">ปกติ</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #BEE5B6;"></div>
                        <label>100-125 mg/dl</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_risk_group" name="zone2_risk_group" value="1"
                                {{ $zones2['zone2_risk_group']['value'] ? 'checked' : '' }}>
                            <label for="zone2_risk_group">กลุ่มเสี่ยง</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #558136;"></div>
                        <label>125 mg/dl</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_good_control" name="zone2_good_control" value="1"
                                {{ $zones2['zone2_good_control']['value'] ? 'checked' : '' }}>
                            <label for="zone2_good_control">คุมได้ดี</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #FEFB18;"></div>
                        <label>126-154 mg/dl HbA1c < 7</label>
                                <div class="form-check">
                                    <input type="checkbox" id="zone2_watch_out" name="zone2_watch_out" value="1"
                                        {{ $zones2['zone2_watch_out']['value'] ? 'checked' : '' }}>
                                    <label for="zone2_watch_out">เฝ้าระวัง</label>
                                </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #FF9600;"></div>
                        <label>155-182 mg/dl HbA1c 7-7.9</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_danger" name="zone2_danger" value="1"
                                {{ $zones2['zone2_danger']['value'] ? 'checked' : '' }}>
                            <label for="zone2_danger">อันตราย</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #FF0200;"></div>
                        <label>≥ 183 mg/dl HbA1c 8%</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_critical" name="zone2_critical" value="1"
                                {{ $zones2['zone2_critical']['value'] ? 'checked' : '' }}>
                            <label for="zone2_critical">วิกฤต</label>
                        </div>
                    </div>

                    <div>
                        <div class="circle" style="background-color: #090001;"></div>
                        <label>โรคแทรกซ้อน</label>
                        <div class="form-check">
                            <input type="checkbox" id="zone2_complications" name="zone2_complications" value="1"
                                {{ $zones2['zone2_complications']['value'] ? 'checked' : '' }}>
                            <label for="zone2_complications">โรคแทรกซ้อน</label>
                        </div>
                    </div>
                </div>

                <div class="zone-health">
                    <div class="form-check">
                        <input type="checkbox" id="zone2_heart" name="zone2_heart" value="1"
                            {{ $zones2['zone2_heart']['value'] ? 'checked' : '' }}>
                        <label for="zone2_heart">หัวใจ</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="zone2_eye" name="zone2_eye" value="1"
                            {{ $zones2['zone2_eye']['value'] ? 'checked' : '' }}>
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
                            {{ isset($diseases['diabetes']) && $diseases['diabetes'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="diabetes">เบาหวาน</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="cerebral_artery" value="0">
                        <input class="form-check-input" type="checkbox" name="cerebral_artery" id="cerebral_artery"
                            value="1"
                            {{ isset($diseases['cerebral_artery']) && $diseases['cerebral_artery'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="cerebral_artery">หลอดเลือดสมอง</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="kidney" value="0">
                        <input class="form-check-input" type="checkbox" name="kidney" id="kidney" value="1"
                            {{ isset($diseases['kidney']) && $diseases['kidney'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="kidney">ไต</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="blood_pressure" value="0">
                        <input class="form-check-input" type="checkbox" name="blood_pressure" id="blood_pressure"
                            value="1"
                            {{ isset($diseases['blood_pressure']) && $diseases['blood_pressure'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="blood_pressure">ความดันโลหิตสูง</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="heart" value="0">
                        <input class="form-check-input" type="checkbox" name="heart" id="heart" value="1"
                            {{ isset($diseases['heart']) && $diseases['heart'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="heart">หัวใจ</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="eye" value="0">
                        <input class="form-check-input" type="checkbox" name="eye" id="eye" value="1"
                            {{ isset($diseases['eye']) && $diseases['eye'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="eye">ตา</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="other" value="0">
                        <input class="form-check-input" type="checkbox" name="other" id="other" value="1"
                            {{ isset($diseases['other']) && $diseases['other'] == 1 ? 'checked' : '' }}
                            onchange="toggleOtherInput()">
                        <label class="form-check-label" for="other">อื่น ๆ</label>
                    </div>

                    <div id="other_input" style="display: none;">
                        <input type="text" class="form-control" name="other_text" placeholder="กรุณาระบุอื่น ๆ"
                            value="{{ isset($diseases['other_text']) ? $diseases['other_text'] : '' }}">
                    </div>

                    <script>
                    function toggleOtherInput() {
                        var checkbox = document.getElementById("other");
                        var otherInputDiv = document.getElementById("other_input");

                        if (checkbox.checked) {
                            otherInputDiv.style.display = "block"; 
                        } else {
                            otherInputDiv.style.display = "none";
                        }
                    }

                    window.onload = function() {
                        toggleOtherInput();
                    };
                    </script>

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
                        <input class="form-check-input" type="checkbox" name="drink" id="drink" value="1"
                            {{ isset($lifestyles['drink']) && $lifestyles['drink'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="drink">ดื่มแอลกอฮอล์</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="drink_sometimes" value="0">
                        <input class="form-check-input" type="checkbox" name="drink_sometimes" id="drink_sometimes"
                            value="1"
                            {{ isset($lifestyles['drink_sometimes']) && $lifestyles['drink_sometimes'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="drink_sometimes">ดื่มเป็นครั้งคราว</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="dont_drink" value="0">
                        <input class="form-check-input" type="checkbox" name="dont_drink" id="dont_drink" value="1"
                            {{ isset($lifestyles['dont_drink']) && $lifestyles['dont_drink'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="dont_drink">ไม่ดื่มแอลกอฮอล์</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="smoke" value="0">
                        <input class="form-check-input" type="checkbox" name="smoke" id="smoke" value="1"
                            {{ isset($lifestyles['smoke']) && $lifestyles['smoke'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="smoke">สูบบุหรี่</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="sometime_smoke" value="0">
                        <input class="form-check-input" type="checkbox" name="sometime_smoke" id="sometime_smoke"
                            value="1"
                            {{ isset($lifestyles['sometime_smoke']) && $lifestyles['sometime_smoke'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="sometime_smoke">สูบเป็นครั้งคราว</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="dont_smoke" value="0">
                        <input class="form-check-input" type="checkbox" name="dont_smoke" id="dont_smoke" value="1"
                            {{ isset($lifestyles['dont_smoke']) && $lifestyles['dont_smoke'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="dont_smoke">ไม่สูบบุหรี่</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="troubled" value="0">
                        <input class="form-check-input" type="checkbox" name="troubled" id="troubled" value="1"
                            {{ isset($lifestyles['troubled']) && $lifestyles['troubled'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="troubled">เครียด</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="dont_live" value="0">
                        <input class="form-check-input" type="checkbox" name="dont_live" id="dont_live" value="1"
                            {{ isset($lifestyles['dont_live']) && $lifestyles['dont_live'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="dont_live">ไม่ค่อยอยู่บ้าน</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="hidden" name="bored" value="0">
                        <input class="form-check-input" type="checkbox" name="bored" id="bored" value="1"
                            {{ isset($lifestyles['bored']) && $lifestyles['bored'] == 1 ? 'checked' : '' }}>
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
                                value="1"
                                {{ isset($elderlyInfos['help_yourself']) && $elderlyInfos['help_yourself'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="help_yourself">ช่วยเหลือตัวเองได้</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="can_help" value="0">
                            <input class="form-check-input" type="checkbox" name="can_help" id="can_help" value="1"
                                {{ isset($elderlyInfos['can_help']) && $elderlyInfos['can_help'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="can_help">ได้</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="cant_help" value="0">
                            <input class="form-check-input" type="checkbox" name="cant_help" id="cant_help" value="1"
                                {{ isset($elderlyInfos['cant_help']) && $elderlyInfos['cant_help'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="cant_help">ไม่ได้</label>
                        </div>
                    </div>

                    <!-- ผู้ดูแล -->
                    <div class="form-check-container">
                        <div class="form-check">
                            <input type="hidden" name="caregiver" value="0">
                            <input class="form-check-input" type="checkbox" name="caregiver" id="caregiver" value="1"
                                {{ isset($elderlyInfos['caregiver']) && $elderlyInfos['caregiver'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="caregiver">ผู้ดูแล</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="have_caregiver" value="0">
                            <input class="form-check-input" type="checkbox" name="have_caregiver" id="have_caregiver"
                                value="1"
                                {{ isset($elderlyInfos['have_caregiver']) && $elderlyInfos['have_caregiver'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="have_caregiver">มีผู้ดูแล</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="no_caregiver" value="0">
                            <input class="form-check-input" type="checkbox" name="no_caregiver" id="no_caregiver"
                                value="1"
                                {{ isset($elderlyInfos['no_caregiver']) && $elderlyInfos['no_caregiver'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_caregiver">ไม่มี</label>
                        </div>
                    </div>

                    <!-- กลุ่ม -->
                    <div class="form-check-container">
                        <div class="form-check">
                            <input type="hidden" name="group1" value="0">
                            <input class="form-check-input" type="checkbox" name="group1" id="group1" value="1"
                                {{ isset($elderlyInfos['group1']) && $elderlyInfos['group1'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="group1">กลุ่มที่ 1
                                ผู้สูงอายุช่วยตัวเองและผู้อื่นได้</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="group2" value="0">
                            <input class="form-check-input" type="checkbox" name="group2" id="group2" value="1"
                                {{ isset($elderlyInfos['group2']) && $elderlyInfos['group2'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="group2">กลุ่มที่ 2
                                ผู้สูงอายุช่วยตัวเองแต่มีโรคเรื้อรัง</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="group3" value="0">
                            <input class="form-check-input" type="checkbox" name="group3" id="group3" value="1"
                                {{ isset($elderlyInfos['group3']) && $elderlyInfos['group3'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="group3">กลุ่มที่ 3
                                ผู้สูงอายุ/ผู้ป่วยดูแลตัวเองไม่ได้</label>
                        </div>
                    </div>

                    <!-- สถานะ -->
                    <div class="form-check-container">
                        <div class="form-check">
                            <input type="hidden" name="house" value="0">
                            <input class="form-check-input" type="checkbox" name="house" id="house" value="1"
                                {{ isset($elderlyInfos['house']) && $elderlyInfos['house'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="house">ติดบ้าน</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="society" value="0">
                            <input class="form-check-input" type="checkbox" name="society" id="society" value="1"
                                {{ isset($elderlyInfos['society']) && $elderlyInfos['society'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="society">ติดสังคม</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="bed-ridden" value="0">
                            <input class="form-check-input" type="checkbox" name="bed-ridden" id="bed-ridden" value="1"
                                {{ isset($elderlyInfos['bed_ridden']) && $elderlyInfos['bed_ridden'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="bed-ridden">ติดเตียง</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group-name"
                style="display: flex; flex-direction: column; align-items: flex-end; width: 100%;">

                <label for="user_name"
                    style="margin-bottom: 5px; color: #020364; font-size:15px; font-weight: bold;">ผู้บันทึก</label>

                <div style="display: flex; justify-content: flex-end; width: 100%;">
                    <input type="text" class="form-control" id="user_name" name="user_name"
                        value="{{ old('user_name', $recorddata->user_name ?? '') }}" placeholder="ผู้บันทึก"
                        style="width: 50%; min-width: 200px; text-align: right;">
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
                        }
                    );
                </script>

                <!-- ปุ่มเปิด Modal -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#resetModal">ยกเลิก</button>

                <!-- Modal -->
                <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="resetModalLabel">ยืนยันการยกเลิก</h5>
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
        </form>

        <script>
        document.getElementById('confirmReset').addEventListener('click', function() {
            const form = document.getElementById('Recorddata');
            if (form) {
                form.reset(); // รีเซ็ตค่าทั้งหมดในฟอร์ม
            }

            // ปิด Modal
            const modalElement = document.getElementById('resetModal');
            const resetModal = bootstrap.Modal.getInstance(modalElement);
            if (resetModal) {
                resetModal.hide();
            }
        });
        </script>
        </form>
    </div>
</div>
@endsection