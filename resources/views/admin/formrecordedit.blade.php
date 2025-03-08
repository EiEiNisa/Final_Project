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

.custom-input {
    height: 38px;
    border-radius: 6px;
}

.removeField {
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-control.custom-input {
    flex: 1;
    font-size: 0.875rem;
    padding: 0.5rem;
    height: 38px;
}

.btn-danger {
    padding: 0.3rem 0.5rem;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fas.fa-trash-alt {
    font-size: 1.2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
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
        {{ session('error') }}
    </div>
    @endif

    <div class="card-header">
        <h4><strong>แก้ไขฟอร์มข้อมูลส่วนตัว</strong></h4>
        <a href="{{ url('admin/addrecord') }}" class="btn btn-secondary btn-back">กลับ</a>
    </div>

    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-4">
                        <h2 class="text-center text-primary mb-4">เพิ่ม Custom Field</h2>

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
                                <label for="options" class="font-weight-bold text-dark">ตัวเลือก (ใช้สำหรับ Select,
                                    Radio, Checkbox):</label>
                                <div id="option-container">
                                    <input type="text" class="form-control option-input rounded-pill" name="options[]"
                                        placeholder="เพิ่มค่าตัวเลือก">
                                </div>
                                <button type="button" class="btn btn-outline-secondary mt-2 rounded-pill"
                                    id="add-option">+ เพิ่มตัวเลือก</button>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill mt-3 w-100">บันทึก</button>
                        </form>
                    </div>
                </div>
            </div>
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