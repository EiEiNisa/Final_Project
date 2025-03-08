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

/* General Styles */
.input-field {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.input-container {
    margin-bottom: 15px;
}

.input-label {
    margin-bottom: 5px;
    text-align: left;
    color: #020364;
}

/* Group Styles */
.personal-info-group,
.contact-info-group {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    /* Adds space between inputs */
}

.personal-info-group .input-container,
.contact-info-group .input-container {
    flex: 1 1 calc(33.33% - 20px);
    /* 3 inputs per row for personal-info-group */
}

.contact-info-group .input-container {
    flex: 1 1 calc(50% - 20px);
    /* 2 inputs per row for contact-info-group */
}

/* Additional Styles */
.personal-info-group .input-container {
    max-width: calc(33.33% - 20px);
}

.contact-info-group .input-container {
    max-width: calc(50% - 20px);
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
        <div class="personal-info-group">
            <div class="input-container">
                <label>เลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="input-field" placeholder="กรอกเลขบัตรประจำตัวประชาชน" disabled>
            </div>
            <div class="input-container">
                <label>คำนำหน้าชื่อ</label>
                <select class="input-field" disabled>
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
                <input type="text" class="input-field" placeholder="กรอกชื่อ" disabled>
            </div>
        </div>

        <div class="personal-info-group">
            <div class="input-container">
                <label>นามสกุล</label>
                <input type="text" class="input-field" placeholder="กรอกนามสกุล" disabled>
            </div>
            <div class="input-container">
                <label>บ้านเลขที่</label>
                <input type="text" class="input-field" value="{{ old('housenumber') }}" placeholder="กรอกบ้านเลขที่"
                    disabled>
            </div>
            <div class="input-container">
                <label>วัน / เดือน / ปีเกิด</label>
                <input type="date" class="input-field" placeholder="วัน/เดือน/ปีเกิด" disabled>
            </div>
        </div>

        <div class="personal-info-group">
            <div class="input-container">
                <label>อายุ</label>
                <input type="number" class="input-field" placeholder="กรอกอายุ" disabled>
            </div>
            <div class="input-container">
                <label>กรุ๊ปเลือด</label>
                <select class="input-field" disabled>
                    <option value="" disabled {{ old('blood_group') == '' ? 'selected' : '' }}>กรุณาเลือกกรุ๊ปเลือด
                    </option>
                    <option value="A" {{ old('blood_group') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('blood_group') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="AB" {{ old('blood_group') == 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O" {{ old('blood_group') == 'O' ? 'selected' : '' }}>O</option>
                </select>
            </div>
            <div class="input-container">
                <label class="input-label">น้ำหนัก</label>
                <input type="number" class="input-field" placeholder="กรอกน้ำหนัก" step="0.1" disabled>
            </div>
        </div>

        <div class="contact-info-group">
            <div class="input-container">
                <label class="input-label">เบอร์โทรศัพท์</label>
                <input type="tel" class="input-field" placeholder="กรอกหมายเลขโทรศัพท์" disabled>
            </div>
            <div class="input-container">
                <label class="input-label">ID Line</label>
                <input type="text" class="input-field" placeholder="กรอกไอดีไลน์" disabled>
            </div>
        </div>

        @foreach($customFields as $field)
        <div class="custom-form-group">
            <label>{{ $field->label }}</label>

            @if($field->field_type == 'text')
            <input type="text" class="input-field" name="{{ $field->name }}">

            @elseif($field->field_type == 'select')
            @php $options = json_decode($field->options, true) ?? []; @endphp
            <select class="input-field" name="{{ $field->name }}">
                @foreach($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>

            @elseif($field->field_type == 'checkbox')
            @php $options = json_decode($field->options, true) ?? []; @endphp
            <div class="checkbox-group">
                @foreach($options as $option)
                <div class="form-check">
                    <input class="checkbox-input" type="checkbox" name="{{ $field->name }}[]" value="{{ $option }}">
                    <label class="form-check-label">{{ $option }}</label>
                </div>
                @endforeach
            </div>

            @elseif($field->field_type == 'radio')
            @php $options = json_decode($field->options, true) ?? []; @endphp
            <div class="radio-group">
                @foreach($options as $option)
                <div class="form-check">
                    <input class="radio-input" type="radio" name="{{ $field->name }}" value="{{ $option }}">
                    <label class="form-check-label">{{ $option }}</label>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach

        <br>
        <button type="button" class="btn btn-primary rounded-pill mb-3" id="show-form-btn">เพิ่ม Custom Field</button>

        <div id="custom-field-form" style="display: none;">
            <form action="{{ route('customfields.store') }}" method="POST">
                @csrf
                <div id="field-container">
                </div>

                <button type="button" class="btn btn-outline-secondary mt-3" id="add-field-btn">+ เพิ่ม Custom
                    Field</button>

                <button type="submit" class="btn btn-primary rounded-pill mt-3 w-100">บันทึก</button>
            </form>
        </div>
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

    addFieldBtn.addEventListener("click", function() {
        let fieldIndex = fieldContainer.children.length; // กำหนด fieldIndex
        let fieldHTML = `
                <div class="form-group custom-field-group">
                    <label>ชื่อหัวข้อ (เช่น ชื่อ)</label>
                    <input type="text" class="form-control" name="label[]" required>

                    <label>ชื่อตัวแปร (เช่น name)</label>
                    <input type="text" class="form-control" name="name[]" required>

                    <label>รูปแบบข้อมูล</label>
                    <select class="form-control field-type" name="field_type[]" required>
                        <option value="text">ช่องกรอกข้อความ</option>
                        <option value="select">เลือกจากรายการ</option>
                        <option value="checkbox">ช่องทำเครื่องหมาย (เลือกได้หลายรายการ)</option>
                        <option value="radio">ช่องทำเครื่องหมาย (เลือกได้รายการเดียว)</option>
                    </select>

                    <div class="form-group options-group" style="display: none;">
                        <label>ตัวเลือก</label>
                        <div class="option-container">
                            <input type="text" class="form-control option-input" name="options[${fieldIndex}][]" placeholder="เพิ่มค่าตัวเลือก">
                        </div>
                        <div class="button-group">
                            <button type="button" class="btn btn-secondary add-option-btn">+ เพิ่มตัวเลือก</button>
                        </div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-danger delete-field-btn">ลบฟิลด์</button>
                    <hr>
                </div>
            `;
        fieldContainer.insertAdjacentHTML('beforeend', fieldHTML);
    });

    fieldContainer.addEventListener("click", function(event) {
        if (event.target && event.target.classList.contains("add-option-btn")) {
            let optionContainer = event.target.closest('.form-group').querySelector(
                '.option-container');
            let fieldIndex = [...fieldContainer.children].indexOf(event.target.closest(
                '.custom-field-group'));

            let newOption = document.createElement("input");
            newOption.type = "text";
            newOption.className = "form-control option-input rounded-pill mt-2";
            newOption.name = `options[${fieldIndex}][]`; // แก้ไข name ให้ถูกต้อง
            newOption.placeholder = "เพิ่มค่าตัวเลือก";

            optionContainer.appendChild(newOption);
        }

        if (event.target && event.target.classList.contains("delete-field-btn")) {
            event.target.closest('.custom-field-group').remove(); // ลบฟิลด์
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