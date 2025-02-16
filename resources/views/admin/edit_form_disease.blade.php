@extends('layoutadmin')

@section('content')
<style>
.head {
    color: #020364;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.head {
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
}

.rectangle-box {
    background: #6D91C9;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 50px;
    width: 100%;
    padding: 20px;
    border-radius: 5px;
    background-color: #6D91C9;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ปรับขนาด input */
.custom-input {
    height: 38px;
    border-radius: 6px;
}

/* ปรับปุ่มลบให้สวย */
.removeField {
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ปรับให้ label อยู่ข้างบน input */
.form-group {
    display: flex;
    flex-direction: column;
}

/* Responsive */
@media (max-width: 768px) {
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}
</style>

<div class="container py-3">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <div class="head">
        <h4 class="text-center fw-bold mb-4">แก้ไขฟอร์มโรคประจำตัว</h4>
        <a href="{{ url('admin/addrecord') }}" class="btn btn-secondary px-4">กลับ</a>
    </div>

    <div class="rectangle-box p-4">
        <form action="{{ route('update_disease') }}" method="POST" class="container">
            @csrf
            @method('PUT')

            <div class="row g-3" id="fieldsContainer">
                @foreach($filteredDiseaseColumns as $column)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        @php
                        $labels = [
                        'diabetes' => 'โรคเบาหวาน',
                        'cerebral_artery' => 'โรคหลอดเลือดสมอง',
                        'kidney' => 'โรคไต',
                        'blood_pressure' => 'โรคความดันโลหิต',
                        'heart' => 'โรคหัวใจ',
                        'eye' => 'โรคตา',
                        'other' => 'โรคอื่นๆ',
                        ];
                        $label = $labels[$column] ?? ucfirst($column);
                        @endphp

                        <div class="input-group">
                            <!-- แสดง checkbox สำหรับแต่ละคอลัมน์ -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="diseases[]" value="{{ $column }}"
                                    id="disease_{{ $column }}" @if(in_array($column, old('diseases', []))) checked
                                    @endif disabled>
                                <label class="form-check-label" for="disease_{{ $column }}">
                                    {{ ucfirst(str_replace('_', ' ', $label)) }}
                                    <!-- ใช้ชื่อคอลัมน์แทน -->
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="extraFieldsContainer" class="mt-4">
                <label class="fw-bold">เพิ่มฟิลด์ใหม่</label>
                <button type="button" id="addField2" class="btn btn-primary btn-sm">เพิ่ม Input</button>
            </div>

            <!-- ปุ่มส่งข้อมูล -->
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-success px-4">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Confirmation -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">ยืนยันการลบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                คุณแน่ใจหรือไม่ว่าต้องการลบฟิลด์นี้?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">ลบ</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for confirmation -->
<div class="modal fade" id="confirmDeleteModal2" tabindex="-1" aria-labelledby="confirmDeleteModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel2">ยืนยันการลบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                คุณแน่ใจหรือไม่ว่าต้องการลบฟิลด์นี้?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton2">ยืนยันการลบ</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    var container = document.getElementById("extraFieldsContainer");

    // ฟังก์ชันเพิ่มฟิลด์ใหม่
    document.getElementById("addField2").addEventListener("click", function() {
        var fieldCount = container.getElementsByClassName("extra-field").length;
        var newField = document.createElement("div");
        newField.className = "extra-field mt-3";

        newField.innerHTML = `
            <label for="extra_fields[${fieldCount}][value]">ค่าที่ต้องการเพิ่มในฟอร์ม:</label>
            <input type="text" name="extra_fields[${fieldCount}][value]" required class="form-control mb-2" placeholder="ค่าที่จะใช้">
            <button type="button" class="removeField btn btn-danger btn-sm">ลบ</button>
        `;
        container.appendChild(newField);
    });

    // ใช้ Event Delegation สำหรับปุ่มลบ
    container.addEventListener("click", function(event) {
        if (event.target.classList.contains("removeField")) {
            event.target.closest(".extra-field").remove();
        }
    });

    // กำหนดการลบฟิลด์ที่มาจากฐานข้อมูล
    document.querySelectorAll(".removeField").forEach(function(button) {
        button.addEventListener("click", function() {
            var column = button.getAttribute("data-column");
            var modal = new bootstrap.Modal(document.getElementById("confirmDeleteModal"));
            modal.show();

            document.getElementById("confirmDeleteButton").addEventListener(
                "click",
                function() {
                    var field = button.closest(".form-group");
                    if (field) {
                        field.remove();
                    }
                    
                    var form = document.querySelector("form");
                    var deletedFieldsInput = document.createElement("input");
                    deletedFieldsInput.type = "hidden";
                    deletedFieldsInput.name = "deleted_fields[]";
                    deletedFieldsInput.value = column;
                    form.appendChild(deletedFieldsInput);
                    
                    modal.hide();
                }, 
                { once: true }
            );
        });
    });
});

</script>
@endsection