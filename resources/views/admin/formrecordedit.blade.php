@extends('layoutadmin')

@section('content')
<div id="custom-fields">
    <div class="custom-field">
        <input type="text" name="custom_fields[0][label]" placeholder="ชื่อฟิลด์">
        <input type="text" name="custom_fields[0][value]" placeholder="ค่า">
        <button type="button" onclick="removeField(this)">ลบ</button>
    </div>
</div>
<button type="button" onclick="addField()">เพิ่มฟิลด์</button>

<script>
let fieldIndex = 1;

function addField() {
    let container = document.getElementById('custom-fields');
    let div = document.createElement('div');
    div.classList.add('custom-field');
    div.innerHTML = `
        <input type="text" name="custom_fields[${fieldIndex}][label]" placeholder="ชื่อฟิลด์">
        <input type="text" name="custom_fields[${fieldIndex}][value]" placeholder="ค่า">
        <button type="button" onclick="removeField(this)">ลบ</button>
    `;
    container.appendChild(div);
    fieldIndex++;
}

function removeField(button) {
    button.parentElement.remove();
}
</script>

@endsection
