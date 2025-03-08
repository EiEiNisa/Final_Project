@extends('layoutadmin')

@section('content')
<style>
.card-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    padding: 25px 30px;
    margin-bottom: 30px;
    transition: all 0.3s ease-in-out;
}

.card-container:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.card-header {
    color: #020364;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.card-header h4 {
    font-size: 24px;
    font-weight: bold;
    margin: 0;
}

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

.card-header::after {
    content: "";
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 4px;
    background-color: #020364;
}

.card-body {
    padding: 20px;
}

.form-control {
    border-radius: 30px;
    padding: 10px 20px;
    font-size: 16px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
}

.form-control:focus {
    border-color: #1d3557;
    box-shadow: 0 0 5px rgba(29, 53, 87, 0.3);
}

/* ปุ่ม */
.btn-primary {
    background-color: #1d3557;
    border: none;
    padding: 12px 20px;
    border-radius: 30px;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #457b9d;
}

/* การปรับแต่งกล่องตัวเลือก */
#options-group {
    margin-top: 20px;
}

#option-container input {
    border-radius: 30px;
    margin-bottom: 10px;
    padding: 10px 20px;
    font-size: 16px;
    border: 1px solid #ddd;
    width: 100%;
}

#option-container button {
    background-color: #a8dadc;
    border-radius: 30px;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    width: 100%;
}

#option-container button:hover {
    background-color: #457b9d;
}

/* Mobile Friendly */
@media (max-width: 768px) {
    .card-container {
        padding: 20px;
    }

    .form-control {
        padding: 12px;
    }

    .btn-primary {
        padding: 10px;
    }
}
</style>

<div class="card-container">

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

    @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
    @endif

    <div class="card-header">
        <h4><strong>แก้ไขฟอร์มข้อมูลส่วนตัว</strong></h4>
        <a href="{{ url('admin/addrecord') }}" class="btn btn-secondary btn-back">กลับ</a>
    </div>

    <div class="card-body">
        <div class="form-group1">
            <label for="id_card">เลขบัตรประจำตัวประชาชน <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="id_card" name="id_card" pattern="^[1-9]\d{12}$" maxlength="13"
                placeholder="กรอกเลขบัตรประจำตัวประชาชน" required>
        </div>

        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">ข้อมูลในระบบ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ข้อมูลนี้มีอยู่ในระบบ
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group1">
            <label for="prefix">คำนำหน้าชื่อ <span style="color: red;">*</span></label>
            <select class="form-control" id="prefix" name="prefix" required>
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
            <label for="name">ชื่อ <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                placeholder="กรอกชื่อ" required>
        </div>

        <div class="form-group1">
            <label for="surname">นามสกุล <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname') }}"
                placeholder="กรอกนามสกุล" required>
        </div>

        <div class="form-group1">
            <label for="housenumber">บ้านเลขที่ <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="housenumber" name="housenumber" value="{{ old('housenumber') }}"
                placeholder="กรอกบ้านเลขที่" required>
        </div>

        <div class="form-group1">
            <label for="birthdate">วัน / เดือน / ปีเกิด <span style="color: red;">*</span></label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"
                placeholder="วัน/เดือน/ปีเกิด" required>
        </div>

        <div class="form-group1">
            <label for="age">อายุ <span style="color: red;">*</span></label>
            <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}"
                placeholder="กรอกอายุ" readonly>
        </div>

        <div class="form-group1">
            <label for="blood_group">กรุ๊ปเลือด <span style="color: red;">*</span></label>
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
            <label for="weight" style="margin-bottom: 5px; text-align: left; color: #020364;">น้ำหนัก <span
                    style="color: red;">*</span></label>
            <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight') }}"
                placeholder="กรอกน้ำหนัก" step="0.1" required>
        </div>

        <div class="form-group1">
            <label for="height" style="margin-bottom: 5px; text-align: left; color: #020364;">ส่วนสูง <span
                    style="color: red;">*</span></label>
            <input type="number" class="form-control" id="height" name="height" value="{{ old('height') }}"
                placeholder="กรอกส่วนสูง" step="0.1" required>
        </div>

        <div class="form-group1">
            <label for="waistline" style="margin-bottom: 5px; text-align: left; color: #020364;">รอบเอว
                (ซม.) <span style="color: red;">*</span></label>
            <input type="number" class="form-control" id="waistline" name="waistline" value="{{ old('waistline') }}"
                placeholder="กรอกรอบเอว" step="0.1" required>
        </div>

        <div class="form-group1">
            <label for="bmi" style="margin-bottom: 5px; text-align: left; color: #020364;">ดัชนีมวล BMI <span
                    style="color: red;">*</span></label>
            <input type="number" class="form-control" id="bmi" name="bmi" value="{{ old('bmi') }}"
                placeholder="กรอกดัชนีมวล BMI" step="0.1" readonly>
        </div>

        <div class="form-group1">
            <label for="phone" style="margin-bottom: 5px; text-align: left; color: #020364;">เบอร์โทรศัพท์ <span
                    style="color: red;">*</span></label>
            <input type="tel" class="form-control" id="phone" name="phone" maxlength="10" value="{{ old('phone') }}"
                placeholder="กรอกหมายเลขโทรศัพท์" required>
        </div>

        <h2 class="text-primary mb-4">เพิ่ม Custom Field</h2>

        <form action="{{ route('customfields.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="label" class="font-weight-bold text-dark">Label (ชื่อที่แสดง):</label>
                <input type="text" class="form-control rounded-pill" name="label" required>
            </div>

            <div class="form-group">
                <label for="name" class="font-weight-bold text-dark">Field Name (ชื่อฟิลด์):</label>
                <input type="text" class="form-control rounded-pill" name="name" required>
            </div>

            <div class="form-group">
                <label for="field_type" class="font-weight-bold text-dark">Field Type:</label>
                <select class="form-control rounded-pill" name="field_type" id="field_type" required>
                    <option value="text">Text</option>
                    <option value="select">Select</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                </select>
            </div>

            <!-- ส่วนสำหรับการเพิ่มตัวเลือกของ Select, Radio, Checkbox -->
            <div class="form-group" id="options-group" style="display: none;">
                <label for="options" class="font-weight-bold text-dark">ตัวเลือก (ใช้สำหรับ Select, Radio,
                    Checkbox):</label>
                <div id="option-container">
                    <input type="text" class="form-control option-input rounded-pill" name="options[]"
                        placeholder="เพิ่มค่าตัวเลือก">
                </div>
                <button type="button" class="btn btn-outline-secondary mt-2 rounded-pill" id="add-option">+
                    เพิ่มตัวเลือก</button>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill mt-3 w-100">บันทึก</button>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let fieldType = document.getElementById("field_type");
    let optionsGroup = document.getElementById("options-group");
    let optionContainer = document.getElementById("option-container");
    let addOptionBtn = document.getElementById("add-option");

    function toggleOptionsField() {
        if (fieldType.value === "select" || fieldType.value === "radio" || fieldType.value === "checkbox") {
            optionsGroup.style.display = "block";
        } else {
            optionsGroup.style.display = "none";
        }
    }

    fieldType.addEventListener("change", toggleOptionsField);

    addOptionBtn.addEventListener("click", function() {
        let newOption = document.createElement("input");
        newOption.type = "text";
        newOption.className = "form-control option-input rounded-pill mt-2";
        newOption.name = "options[]";
        newOption.placeholder = "เพิ่มค่าตัวเลือก";
        optionContainer.appendChild(newOption);
    });

    toggleOptionsField();
});
</script>

@endsection