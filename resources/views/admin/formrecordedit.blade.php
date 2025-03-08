@extends('layoutadmin')

@section('content')
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

<div class="container my-5">
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
                            <label for="options" class="font-weight-bold text-dark">ตัวเลือก (ใช้สำหรับ Select, Radio, Checkbox):</label>
                            <div id="option-container">
                                <input type="text" class="form-control option-input rounded-pill" name="options[]" placeholder="เพิ่มค่าตัวเลือก">
                            </div>
                            <button type="button" class="btn btn-outline-secondary mt-2 rounded-pill" id="add-option">+ เพิ่มตัวเลือก</button>
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
