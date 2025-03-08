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
        <select class="form-control" name="field_type" required>
            <option value="text">Text</option>
            <option value="select">Select</option>
            <option value="checkbox">Checkbox</option>
            <option value="radio">Radio</option>
        </select>
    </div>
    <div class="form-group" id="options-group" style="display: none;">
        <label for="options">Options (เลือกสำหรับ Select หรือ Radio):</label>
        <input type="text" class="form-control" name="options" placeholder="ค่าที่แยกด้วยเครื่องหมายคอมม่า">
    </div>
    <button type="submit" class="btn btn-primary">บันทึก</button>
</form>

<script>
    // เพิ่มการแสดง/ซ่อนฟิลด์ตัวเลือกตามประเภทของฟิลด์
    document.querySelector('[name="field_type"]').addEventListener('change', function() {
        if (this.value === 'select' || this.value === 'radio') {
            document.getElementById('options-group').style.display = 'block';
        } else {
            document.getElementById('options-group').style.display = 'none';
        }
    });
</script>

@endsection
