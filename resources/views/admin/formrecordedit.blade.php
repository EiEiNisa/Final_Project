@extends('layoutadmin')

@section('content')
<style>
.card-container {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    padding: 30px 35px;
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
    padding: 12px 20px;
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

.form-group1 {
    display: flex;
    justify-content: space-between;
    gap: 5px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.form-group1 .form-control {
    flex: 1;
    margin-bottom: 0;
}

.form-group1 .form-control,
.form-group1 label {
    width: 100%;
}

.form-group1 label {
    margin-bottom: 5px;
    color: #020364;
    text-align: left;
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
            <div class="input-container">
                <label>เลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="form-control" placeholder="กรอกเลขบัตรประจำตัวประชาชน" disabled>
            </div>
            <div class="input-container">
                <label>คำนำหน้าชื่อ</label>
                <select class="form-control" disabled>
                    <option value="" disabled {{ old('prefix') == '' ? 'selected' : '' }}>กรุณาเลือกคำนำหน้าชื่อ
                    </option>
                    <option value="ด.ช.">ด.ช.</option>
                    <option value="ด.ญ.">ด.ญ.</option>
                    <option value="นาย">นาย</option>
                    <option value="นาง">นาง</option>
                    <option value="นางสาว">นางสาว</option>
                </select>
            </div>
            <div class="input-container">
                <label>ชื่อ</label>
                <input type="text" class="form-control" placeholder="กรอกชื่อ" disabled>
            </div>
        </div>

        <div class="form-group1">
            <div class="input-container">
                <label>นามสกุล</label>
                <input type="text" class="form-control" placeholder="กรอกนามสกุล" disabled>
            </div>
            <div class="input-container">
                <label>บ้านเลขที่</label>
                <input type="text" class="form-control" value="{{ old('housenumber') }}" placeholder="กรอกบ้านเลขที่"
                    disabled>
            </div>
            <div class="input-container">
                <label>วัน / เดือน / ปีเกิด</label>
                <input type="date" class="form-control" placeholder="วัน/เดือน/ปีเกิด" disabled>
            </div>
        </div>

        <div class="form-group1">
            <div class="input-container">
                <label>อายุ</label>
                <input type="number" class="form-control" placeholder="กรอกอายุ" disabled>
            </div>
            <div class="input-container">
                <label>กรุ๊ปเลือด </label>
                <select class="form-control" disabled>
                    <option value="" disabled {{ old('blood_group') == '' ? 'selected' : '' }}>
                        กรุณาเลือกกรุ๊ปเลือด
                    </option>
                    <option value="A" {{ old('blood_group') == 'A' ? 'selected' : '' }}>
                        A</option>
                    <option value="B" {{ old('blood_group') == 'B' ? 'selected' : '' }}>
                        B</option>
                    <option value="AB" {{ old('blood_group') == 'AB' ? 'selected' : '' }}>AB
                    </option>
                    <option value="O" {{ old('blood_group') == 'O' ? 'selected' : '' }}>
                        O</option>
                </select>
            </div>
            <div class="input-container">
                <label style="margin-bottom: 5px; text-align: left; color: #020364;">น้ำหนัก
                </label>
                <input type="number" class="form-control" placeholder="กรอกน้ำหนัก" step="0.1" disabled>
            </div>
        </div>

        <div class="form-group1">
            <div class="input-container">
                <label style="margin-bottom: 5px; text-align: left; color: #020364;">ส่วนสูง
                </label>
                <input type="number" class="form-control" placeholder="กรอกส่วนสูง" step="0.1" disabled>
            </div>
            <div class="input-container">
                <label style="margin-bottom: 5px; text-align: left; color: #020364;">รอบเอว
                    (ซม.)</label>
                <input type="number" class="form-control" placeholder="กรอกรอบเอว" step="0.1" disabled>
            </div>
            <div class="input-container">
                <label style="margin-bottom: 5px; text-align: left; color: #020364;">ดัชนีมวล
                    BMI </label>
                <input type="number" class="form-control" placeholder="กรอกดัชนีมวล BMI" step="0.1" disabled>
            </div>
        </div>

        <div class="form-group1">
            <label style="margin-bottom: 5px; text-align: left; color: #020364;">เบอร์โทรศัพท์</label>
            <input type="tel" class="form-control" placeholder="กรอกหมายเลขโทรศัพท์" disabled>
            <label style="margin-bottom: 5px; text-align: left; color: #020364;">ID Line</label>
            <input type="text" class="form-control" placeholder="กรอกไอดีไลน์" disabled>
        </div>

        <button type="button" class="btn btn-primary rounded-pill mb-3" id="show-form-btn">เพิ่ม Custom
            Field</button>

        <div id="custom-field-form" style="display: none;">
            <form action="{{ route('customfields.store') }}" method="POST">
                @csrf
                <div id="field-container">
                </div>

                <button type="button" class="btn btn-outline-secondary mt-3" id="add-field-btn">+ เพิ่ม
                    Custom
                    Field</button>

                <button type="submit" class="btn btn-primary rounded-pill mt-3 w-100">บันทึก</button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let showFormBtn = document.getElementById("show-form-btn");
        let customFieldForm = document.getElementById("custom-field-form");
        let addFieldBtn = document.getElementById("add-field-btn");
        let fieldContainer = document.getElementById("field-container");

        // ฟังก์ชันสำหรับแสดงฟอร์มเพิ่ม Custom Field
        showFormBtn.addEventListener("click", function() {
            customFieldForm.style.display = customFieldForm.style.display === "none" ? "block" : "none";
        });

        // ฟังก์ชันสำหรับเพิ่มฟิลด์ใหม่ในฟอร์ม
        addFieldBtn.addEventListener("click", function() {
            let fieldHTML = `
            <div class="form-group custom-field-group">
                <label>Label:</label>
                <input type="text" class="form-control" name="label[]" required>

                <label>Field Name:</label>
                <input type="text" class="form-control" name="name[]" required>

                <label>Field Type:</label>
                <select class="form-control field-type" name="field_type[]" required>
                    <option value="text">Text</option>
                    <option value="select">Select</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                </select>

                <div class="form-group options-group" style="display: none;">
                    <label>Options:</label>
                    <div class="option-container">
                        <input type="text" class="form-control option-input" name="options[${fieldContainer.children.length}][]" placeholder="เพิ่มค่าตัวเลือก">
                    </div>
                    <button type="button" class="btn btn-secondary add-option-btn">+ เพิ่มตัวเลือก</button>
                </div>

                <button type="button" class="btn btn-danger delete-field-btn">ลบฟิลด์</button>
                <hr>
            </div>
            `;
            fieldContainer.insertAdjacentHTML('beforeend', fieldHTML);
        });


        // ฟังก์ชันสำหรับเพิ่มตัวเลือกของ Select, Checkbox, Radio
        fieldContainer.addEventListener("click", function(event) {
            if (event.target && event.target.classList.contains("add-option-btn")) {
                let optionContainer = event.target.closest('.form-group').querySelector(
                    '.option-container');
                let newOption = document.createElement("input");
                newOption.type = "text";
                newOption.className = "form-control option-input rounded-pill mt-2";
                newOption.name = "options[]";
                newOption.placeholder = "เพิ่มค่าตัวเลือก";
                optionContainer.appendChild(newOption);
            }

            // ฟังก์ชันลบฟิลด์
            if (event.target && event.target.classList.contains("delete-field-btn")) {
                let fieldGroup = event.target.closest('.custom-field-group');
                fieldGroup.remove();
            }
        });

        // ฟังก์ชันเพื่อแสดง/ซ่อนตัวเลือกเมื่อเลือก field type
        fieldContainer.addEventListener("change", function(event) {
            if (event.target && event.target.name === "field_type[]") {
                // หาตำแหน่งของ options-group ในฟอร์มที่เลือก
                let optionsGroup = event.target.closest('.custom-field-group').querySelector(
                    '.options-group');
                if (event.target.value === "select" || event.target.value === "radio" || event.target
                    .value === "checkbox") {
                    optionsGroup.style.display = "block"; // แสดงตัวเลือก
                } else {
                    optionsGroup.style.display = "none"; // ซ่อนตัวเลือก
                }
            }
        });
    });
    </script>
    @endsection