@extends('layoutadmin')

@section('content')
<form action="{{ route('customfields.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="label">Label (ชื่อที่แสดง):</label>
        <input type="text" class="form-control" name="label" required>
    </div>

    <div class="form-group">
        <label for="name">Field Name (ชื่อฟิลด์):</label>
        <input type="text" class="form-control" name="name" required>
    </div>

    <div class="form-group">
        <label for="field_type">Field Type:</label>
        <select class="form-control" name="field_type" id="field_type" required>
            <option value="text">Text</option>
            <option value="select">Select</option>
            <option value="checkbox">Checkbox</option>
            <option value="radio">Radio</option>
        </select>
    </div>

    <!-- ส่วนสำหรับการเพิ่มตัวเลือกของ Select, Radio, Checkbox -->
    <div class="form-group" id="options-group" style="display: none;">
        <label for="options">ตัวเลือก (ใช้สำหรับ Select, Radio, Checkbox):</label>
        <div id="option-container">
            <input type="text" class="form-control option-input" name="options[]" placeholder="เพิ่มค่าตัวเลือก">
        </div>
        <button type="button" class="btn btn-secondary mt-2" id="add-option">+ เพิ่มตัวเลือก</button>
    </div>

    <button type="submit" class="btn btn-primary mt-3">บันทึก</button>
</form>

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
            newOption.className = "form-control option-input mt-2";
            newOption.name = "options[]";
            newOption.placeholder = "เพิ่มค่าตัวเลือก";
            optionContainer.appendChild(newOption);
        });

        toggleOptionsField();
    });
</script>
@endsection
