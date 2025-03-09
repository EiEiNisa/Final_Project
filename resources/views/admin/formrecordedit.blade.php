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

.btn-primary {
    background-color: #1d3557;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #457b9d;
}

#options-group {
    margin-top: 20px;
}

#option-container input {
    margin-bottom: 10px;
    padding: 10px 20px;
    font-size: 15px;
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

.input-field {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
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

.personal-info-group,
.contact-info-group {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.personal-info-group .input-container,
.contact-info-group .input-container {
    flex: 1 1 calc(33.33% - 20px);
}

.contact-info-group .input-container {
    flex: 1 1 calc(50% - 20px);
}

.personal-info-group .input-container {
    max-width: calc(33.33% - 20px);
}

.contact-info-group .input-container {
    max-width: calc(50% - 20px);
}

.form-check {
    margin-bottom: 10px;
}

.checkbox-input,
.radio-input {
    margin-right: 5px;
}

label {
    font-size: 15px;
    margin-bottom: 5px;
    text-align: left;
    color: #020364;
    font-weight: bold;
}

#existing-fields {
    margin-top: 20px;
}

.custom-field-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.custom-field-group .left-column,
.custom-field-group .right-column {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

label {
    font-weight: bold;
    font-size: 14px;
    color: #333;
}

input[type="text"],
select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.field-label,
.field-name {
    background-color: #fff;
}

.field-type {
    background-color: #fff;
}

.options-group {
    grid-column: 1 / -1;
    margin-top: 15px;
}

.option-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.option-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.button-group {
    display: flex;
    justify-content: flex-start;
    gap: 15px;
    margin-top: 10px;
}

.add-option-btn {
    background-color: #6c757d;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.add-option-btn:hover {
    background-color: #5a6268;
}

.delete-field-btn {
    grid-column: 1 / -1;
    background-color: #dc3545;
    color: white;
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.delete-field-btn:hover {
    background-color: #c82333;
}

.field-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.field-container:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.field-label {
    font-weight: bold;
    font-size: 14px;
    color: #333;
    display: flex;
    align-items: center;
}

.placeholder {
    font-size: 12px;
    color: #777;
    margin-left: 5px;
}

.input-box {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.input-box:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

.option-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-top: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f8f9fa;
}

.option-list {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.option-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn {
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
}

.button-group {
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    margin-top: 10px;
}

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

    .custom-field-group {
        grid-template-columns: 1fr;
        /* ให้แสดงเป็น 1 คอลัมน์เมื่อหน้าจอเล็ก */
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
                <label class="input-label">เลขบัตรประจำตัวประชาชน</label>
                <input type="number" class="form-control" placeholder="กรอกเลขบัตรประจำตัวประชาชน" disabled>
            </div>
            <div class="input-container">
                <label class="input-label">คำนำหน้าชื่อ</label>
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
                <label class="input-label">ชื่อ</label>
                <input type="text" class="form-control" placeholder="กรอกชื่อ" disabled>
            </div>
        </div>

        <div class="personal-info-group">
            <div class="input-container">
                <label class="input-label">นามสกุล</label>
                <input type="text" class="form-control" placeholder="กรอกนามสกุล" disabled>
            </div>
            <div class="input-container">
                <label class="input-label">บ้านเลขที่</label>
                <input type="text" class="form-control" value="{{ old('housenumber') }}" placeholder="กรอกบ้านเลขที่"
                    disabled>
            </div>
            <div class="input-container">
                <label class="input-label">วัน / เดือน / ปีเกิด</label>
                <input type="date" class="form-control" placeholder="วัน/เดือน/ปีเกิด" disabled>
            </div>
        </div>

        <div class="personal-info-group">
            <div class="input-container">
                <label class="input-label">อายุ</label>
                <input type="number" class="form-control" placeholder="กรอกอายุ" disabled>
            </div>
            <div class="input-container">
                <label class="input-label">กรุ๊ปเลือด</label>
                <select class="form-control" disabled>
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
                <input type="number" class="form-control" placeholder="กรอกน้ำหนัก" step="0.1" disabled>
            </div>
        </div>

        <div class="contact-info-group">
            <div class="input-container">
                <label class="input-label">เบอร์โทรศัพท์</label>
                <input type="tel" class="form-control" placeholder="กรอกหมายเลขโทรศัพท์" disabled>
            </div>
            <div class="input-container">
                <label class="input-label">ID Line</label>
                <input type="text" class="form-control" placeholder="กรอกไอดีไลน์" disabled>
            </div>
        </div>

        <div id="existing-fields">
            @foreach($customFields as $field)
            <div class="form-group custom-field-group" data-id="{{ $field->id }}">
                <div class="left-column">
                    <label class="input-label">ชื่อหัวข้อ</label>
                    <input type="text" class="form-control field-label" name="label[]" value="{{ $field->label }}"
                        required>
                    <label class="input-label">ชื่อตัวแปร</label>
                    <input type="text" class="form-control field-name" name="name[]" value="{{ $field->name }}"
                        required>
                </div>

                <div class="right-column">
                    <label class="input-label">รูปแบบข้อมูล</label>
                    <select class="form-control field-type" name="field_type[]" required>
                        <option value="text" {{ $field->field_type == 'text' ? 'selected' : '' }}>ช่องกรอกข้อความ
                        </option>
                        <option value="select" {{ $field->field_type == 'select' ? 'selected' : '' }}>เลือกจากรายการ
                        </option>
                        <option value="checkbox" {{ $field->field_type == 'checkbox' ? 'selected' : '' }}>
                            ช่องทำเครื่องหมาย (เลือกได้หลายรายการ)</option>
                        <option value="radio" {{ $field->field_type == 'radio' ? 'selected' : '' }}>ช่องทำเครื่องหมาย
                            (เลือกได้รายการเดียว)</option>
                    </select>

                    <div class="form-group options-group"
                        style="{{ in_array($field->field_type, ['select', 'radio', 'checkbox']) ? 'display: block;' : 'display: none;' }}">
                        <label class="input-label">ตัวเลือก</label>
                        <div class="option-container">
                            @foreach(json_decode($field->options) ?? [] as $option)
                            <input type="text" class="form-control option-input" name="options[{{ $field->id }}][]"
                                value="{{ $option }}" placeholder="เพิ่มค่าตัวเลือก">
                            @endforeach
                        </div>
                        <div class="button-group">
                            <button type="button" class="btn btn-secondary add-option-btn">+ เพิ่มตัวเลือก</button>
                        </div>
                    </div>
                </div>

                <br>
                <div class="button-group">
                    <button type="button" class="btn btn-success update-field-btn"
                        data-id="{{ $field->id }}">บันทึกแก้ไขรายการ</button>
                    <button type="button" class="btn btn-danger delete-field-btn"
                        data-id="{{ $field->id }}">ลบรายการ</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Modal ยืนยันการบันทึก -->
        <div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-labelledby="confirmSaveLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmSaveLabel">ยืนยันการบันทึก</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal-error-message" class="alert alert-danger d-none"></div>
                        คุณต้องการบันทึกการแก้ไขรายการนี้หรือไม่?
                    </div>
                    <div class="modal-footer d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-success" id="confirmSaveBtn">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Delete Confirmation -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1"
            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">ยืนยันการลบ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        คุณต้องการลบฟิลด์นี้หรือไม่?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">ลบ</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Error -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">เกิดข้อผิดพลาด</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ไม่สามารถลบฟิลด์ได้ กรุณาลองใหม่อีกครั้ง
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <button type="button" class="btn btn-primary rounded-pill mb-3" id="show-form-btn">เพิ่มรายการ</button>

        <div id="custom-field-form" style="display: none;">
            <form action="{{ route('customfields.store') }}" method="POST">
                @csrf
                <div id="field-container">
                </div>

                <button type="button" class="btn btn-outline-secondary mt-3" id="add-field-btn">+ เพิ่มรายการ</button>

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
    let selectedFieldId = null;
    let selectedFieldData = {};

    // ฟังก์ชันสำหรับแสดงฟอร์มเพิ่ม Custom Field
    showFormBtn.addEventListener("click", function() {
        customFieldForm.style.display = customFieldForm.style.display === "none" ? "block" : "none";
    });

    addFieldBtn.addEventListener("click", function() {
        let fieldIndex = fieldContainer.children.length;
        let fieldHTML = `
            <div class="form-group custom-field-group">
                <label class="input-label">ชื่อหัวข้อ (เช่น ชื่อ)</label>
                <input type="text" class="form-control" name="label[]" required>

                <label class="input-label">ชื่อตัวแปร (เช่น name)</label>
                <input type="text" class="form-control" name="name[]" required>

                <label class="input-label">รูปแบบข้อมูล</label>
                <select class="form-control" name="field_type[]" required>
                    <option value="text">ช่องกรอกข้อความ</option>
                    <option value="select">เลือกจากรายการ</option>
                    <option value="checkbox">ช่องทำเครื่องหมาย (เลือกได้หลายรายการ)</option>
                    <option value="radio">ช่องทำเครื่องหมาย (เลือกได้รายการเดียว)</option>
                </select>

                <div class="form-group options-group" style="display: none;">
                    <label class="input-label">ตัวเลือก</label>
                    <div class="option-container">
                        <input type="text" class="form-control" name="options[${fieldIndex}][]" placeholder="เพิ่มค่าตัวเลือก">
                    </div>
                    <div class="button-group">
                        <button type="button" class="btn btn-secondary add-option-btn">+ เพิ่มตัวเลือก</button>
                    </div>
                </div>
                <br>
                <button type="button" class="btn btn-danger delete-field-btn">ลบฟิลด์</button>
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
            newOption.name = `options[${fieldIndex}][]`;
            newOption.placeholder = "เพิ่มค่าตัวเลือก";

            optionContainer.appendChild(newOption);
        }

        if (event.target && event.target.classList.contains("delete-field-btn")) {
            event.target.closest('.custom-field-group').remove();
        }
    });

    fieldContainer.addEventListener("change", function(event) {
        if (event.target && event.target.name === "field_type[]") {
            let optionsGroup = event.target.closest('.custom-field-group').querySelector(
                '.options-group');
            if (event.target.value === "select" || event.target.value === "radio" || event.target
                .value === "checkbox") {
                optionsGroup.style.display = "block";
            } else {
                optionsGroup.style.display = "none";
            }
        }
    });

    document.querySelector("#existing-fields").addEventListener("click", function(event) {
        if (event.target && event.target.classList.contains("add-option-btn")) {
            let optionContainer = event.target.closest('.form-group').querySelector(
                '.option-container');
            let fieldId = event.target.closest('.custom-field-group').getAttribute('data-id');

            let newOption = document.createElement("input");
            newOption.type = "text";
            newOption.className = "form-control option-input rounded-pill mt-2";
            newOption.name = `options[${fieldId}][]`;
            newOption.placeholder = "เพิ่มค่าตัวเลือก";

            optionContainer.appendChild(newOption);
        }
    });
    
    document.querySelector("#existing-fields").addEventListener("click", function(event) {
        if (event.target && event.target.classList.contains("delete-field-btn")) {
            let fieldId = event.target.getAttribute("data-id");

            // แสดง Modal ยืนยันการลบ
            let deleteConfirmationModal = new bootstrap.Modal(document.getElementById(
                'deleteConfirmationModal'));
            deleteConfirmationModal.show();

            // เมื่อกดปุ่ม "ลบ" ใน Modal ยืนยันการลบ
            document.getElementById("confirmDeleteBtn").addEventListener("click", async function() {
                try {
                    // ส่งคำขอลบไปยัง Controller
                    const response = await fetch(`/delete-custom-field/${fieldId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // แสดงข้อความ success บนหน้า
                        let successAlert = document.createElement('div');
                        successAlert.classList.add('alert', 'alert-success');
                        successAlert.innerText = result.message || 'ลบฟิลด์สำเร็จ';

                        // เพิ่มข้อความ success ไว้ที่ท้าย #existing-fields หรือท้าย body
                        let existingFields = document.querySelector('#existing-fields');
                        if (existingFields) {
                            existingFields.appendChild(successAlert);
                        } else {
                            document.body.appendChild(successAlert);
                        }

                        // ปิด Modal ยืนยันการลบ
                        deleteConfirmationModal.hide();

                        // รีเฟรชหน้าทันที
                        window.location.replace("{{ route('customfields.edit') }}");

                        // ทำให้ข้อความ success หายไปทันที (ถ้าต้องการ)
                        successAlert.remove();
                    } else {
                        throw new Error(result.message ||
                            "ไม่สามารถลบฟิลด์ได้ กรุณาลองใหม่อีกครั้ง");
                    }
                } catch (error) {
                    console.error('Error:', error); // log for debugging
                    let errorModal = new bootstrap.Modal(document.getElementById(
                        'errorModal'));
                    document.querySelector("#errorModal .modal-body").innerHTML = error
                        .message ||
                        "ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง";
                    errorModal.show();
                }
            });

            document.querySelector(".btn-secondary").addEventListener("click", function() {
                deleteConfirmationModal.hide();
            });
        }
    });

    // กดปุ่ม "บันทึกแก้ไขรายการ" → แสดง Modal
    document.querySelectorAll(".update-field-btn").forEach((button) => {
        button.addEventListener("click", function() {
            let fieldGroup = this.closest(".custom-field-group");
            selectedFieldId = this.getAttribute("data-id");

            selectedFieldData = {
                label: fieldGroup.querySelector(".field-label").value,
                name: fieldGroup.querySelector(".field-name").value,
                field_type: fieldGroup.querySelector(".field-type").value,
                options: []
            };

            if (["select", "radio", "checkbox"].includes(selectedFieldData.field_type)) {
                fieldGroup.querySelectorAll(".option-input").forEach((input) => {
                    if (input.value.trim() !== "") {
                        selectedFieldData.options.push(input.value.trim());
                    }
                });
            }

            // ซ่อนข้อความ error (ถ้ามี)
            document.getElementById("modal-error-message").classList.add("d-none");

            // แสดง Modal
            let confirmModal = new bootstrap.Modal(document.getElementById("confirmSaveModal"));
            confirmModal.show();
        });
    });

    // เมื่อกด "ยืนยัน" ใน Modal ให้ส่งข้อมูลไปยังเซิร์ฟเวอร์
    document.getElementById("confirmSaveBtn").addEventListener("click", function() {
        if (!selectedFieldId || !selectedFieldData) return;

        fetch(`/custom-fields/update/${selectedFieldId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                        "content"),
                },
                body: JSON.stringify(selectedFieldData),
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("HTTP status " + response.status);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    window.location.href = "/custom-fields/edit?success=1";
                } else {
                    let errorBox = document.getElementById("modal-error-message");
                    errorBox.innerHTML = data.message;
                    errorBox.classList.remove("d-none");
                }
            })
            .catch((error) => {
                let errorBox = document.getElementById("modal-error-message");
                errorBox.innerHTML = "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง!";
                errorBox.classList.remove("d-none");
            });
    });
});
</script>
@endsection