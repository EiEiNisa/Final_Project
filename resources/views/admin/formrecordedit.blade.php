@extends('layoutadmin')

@section('content')
<style>
/* การตั้งค่าพื้นฐานของฟอร์ม */
.card-container {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    padding: 30px 35px;
    margin-bottom: 30px;
    transition: all 0.3s ease-in-out;
    max-width: 900px;
    margin: 40px auto;
}

/* เอฟเฟกต์ hover */
.card-container:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* การตั้งค่าส่วนหัว */
.card-header {
    color: #1d3557;
    font-weight: bold;
    font-size: 28px;
    text-align: center;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f1f1;
}

.card-header h4 {
    margin: 0;
    font-size: 28px;
}

.card-header .btn-back {
    background: #f0f4f8;
    color: #1d3557;
    padding: 8px 16px;
    border-radius: 30px;
    text-decoration: none;
    transition: background 0.3s ease;
    font-size: 16px;
}

.card-header .btn-back:hover {
    background: #a8dadc;
}

.card-body {
    padding: 20px;
}

/* ปรับแต่ง Input Fields */
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
                <label for="options" class="font-weight-bold text-dark">ตัวเลือก (ใช้สำหรับ Select, Radio, Checkbox):</label>
                <div id="option-container">
                    <input type="text" class="form-control option-input rounded-pill" name="options[]"
                        placeholder="เพิ่มค่าตัวเลือก">
                </div>
                <button type="button" class="btn btn-outline-secondary mt-2 rounded-pill" id="add-option">+ เพิ่มตัวเลือก</button>
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
