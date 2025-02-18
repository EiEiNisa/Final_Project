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
    /* ใช้ Flexbox สำหรับจัดการ layout */
    align-items: center;
    /* จัดตำแหน่งให้อยู่กลางแนวนอน */
    gap: 10px;
    /* เพิ่มช่องว่างระหว่าง input และปุ่ม */
}

.form-control.custom-input {
    flex: 1;
    /* ให้ input ขยายตัวจนเต็มช่อง */
    font-size: 0.875rem;
    /* ขนาดตัวอักษรใน input */
    padding: 0.5rem;
    /* เพิ่ม padding ให้กับ input */
    height: 38px;
    /* ความสูงของ input */
}

.btn-danger {
    padding: 0.3rem 0.5rem;
    /* ปรับขนาดปุ่มให้เล็กลง */
    font-size: 1rem;
    /* ขนาดตัวอักษรของปุ่ม */
    display: flex;
    /* ใช้ flex สำหรับจัดการ layout ของ icon */
    align-items: center;
    /* จัดให้อิคอนอยู่กลางปุ่ม */
    justify-content: center;
}

.fas.fa-trash-alt {
    font-size: 1.2rem;
    /* ขยายขนาดของไอคอนให้พอดี */
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
    @if(session('error'))
    <div class="alert alert-warning">{{ session('error') }}</div>
    @endif

    <div class="head">
        <h4 class="text-center fw-bold mb-4">แก้ไขฟอร์มข้อมูลส่วนตัว</h4>
        <a href="{{ url('admin/addrecord') }}" class="btn btn-secondary px-4">กลับ</a>
    </div>

    <div class="rectangle-box p-4">
        <form action="{{ route('update_record') }}" method="POST" class="container">
            @csrf
            @method('PUT')
            <div class="row g-3" id="fieldsContainer">
                <!-- ส่วนของคอลัมน์จาก recorddata -->
                @foreach($columns as $column)
                @if(in_array($column, array_keys($labels)))
                <!-- ตรวจสอบคอลัมน์ที่มี label ใน $labels -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group d-flex align-items-center">
                        @php
                        $label = $labels[$column] ?? ucfirst($column); // ใช้ label จาก $labels
                        $value = $recorddata->$column ?? ''; // ดึงค่าจาก recorddata
                        @endphp

                        <label for="{{ $column }}" class="form-label">{{ $label }}</label>

                        <!-- ใช้ old() หรือค่าเดิมจาก recorddata -->
                        <input type="text" class="form-control custom-input" id="{{ $column }}" name="{{ $column }}"
                            value="" placeholder="กรอก{{ $label }}" readonly>

                        <!-- ปุ่มลบ -->
                        <button type="button" class="btn btn-danger btn-sm ml-2" onclick="removeField('{{ $column }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                    </div>
                </div>
                @endif
                @endforeach

                <!-- ส่วนของ extra_fields -->
                @foreach($extra_fields as $field)
                @if(is_array($field) && isset($field['label']) && isset($field['value']))
                @php
                $label = $field['label']; // ค่า label จาก extra_fields
                $value = $field['value']; // ค่า value จาก extra_fields
                @endphp
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group d-flex align-items-center">
                        <!-- แสดง label จาก extra_fields -->
                        <label for="{{ $label }}" class="form-label">{{ $label }}</label>

                        <!-- ใช้ label เป็น placeholder และไม่แสดง value ใน input -->
                        <input type="text" class="form-control" id="{{ $label }}" name="extra_fields[{{ $label }}]"
                            value="" placeholder="กรอก{{ $label }}" readonly>

                        <!-- ปุ่มลบ -->
                        <button type="button" class="btn btn-danger btn-sm ml-2" onclick="showDeleteModal('{{ $label }}', '{{ $recorddata->id }}')">
    <i class="fas fa-trash-alt"></i>
</button>

                    </div>
                </div>
                @endif
                @endforeach
            </div>


            <!-- Extra fields container -->
            <div id="extraFieldsContainer" class="mt-4">
                <button type="button" id="addField" class="btn btn-primary btn-sm">เพิ่มรายการ</button>
            </div>

            <!-- Submit button -->
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-success px-4">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">ยืนยันการลบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                คุณต้องการลบฟิลด์นี้ใช่ไหม?
                <!-- Hidden input ที่เก็บ label ที่จะลบ -->
                <input type="hidden" id="labelToDelete">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-danger" onclick="deleteField()">ยืนยันการลบ</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="labelToDelete" name="labelToDelete" value="">

<script>
function deleteField() {
    var labelInput = document.getElementById('labelToDelete');
    if (!labelInput) {
        console.error('ไม่พบ input ที่มี id="labelToDelete"');
        return;
    }

    var labelToDelete = labelInput.value;
    if (!labelToDelete) {
        console.error("ไม่มีค่า label ที่จะลบ");
        return;
    }

    console.log('Deleting field with label: ', labelToDelete); 

    $.ajax({
        url: '{{ route('delete_extra_field') }}',
        method: 'DELETE',
        data: {
            label: labelToDelete,
            _token: '{{ csrf_token() }}' 
        },
        success: function(response) {
            $('#confirmDeleteModal').modal('hide');
            alert('ลบข้อมูลเรียบร้อย');
            location.reload();
        },
        error: function() {
            alert('ไม่สามารถลบข้อมูลได้');
        }
    });
}

function showDeleteModal(label) {
    var labelInput = document.getElementById('labelToDelete');
    if (labelInput) {
        labelInput.value = label;
    } else {
        console.error('ไม่พบ input ที่มี id="labelToDelete"');
    }
    $('#confirmDeleteModal').modal('show');
}

$(document).ready(function() {
    $('.delete-btn').on('click', function() {
        deleteField();
    });
});
</script>


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
                คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <form id="deleteForm" method="POST" action="{{ route('delete_extra_field') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="label" id="labelToDelete">
                    <button type="submit" class="btn btn-danger">ยืนยันการลบ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('addField').addEventListener('click', function() {
    var container = document.getElementById('extraFieldsContainer');
    var fieldCount = container.getElementsByClassName('extra-field').length;
    var newField = document.createElement('div');
    newField.className = 'extra-field mt-3';

    newField.innerHTML = `
        <label for="extra_fields[${fieldCount}][label]">ชื่อฟิลด์ (Label):</label>
        <input type="text" name="extra_fields[${fieldCount}][label]" required class="form-control mb-2" placeholder="ชื่อฟิลด์ที่ต้องการ" />

        <label for="extra_fields[${fieldCount}][value]">ค่าที่ต้องการเพิ่มในฟอร์ม:</label>
        <input type="text" name="extra_fields[${fieldCount}][value]" required class="form-control mb-2" placeholder="ค่าที่จะใช้" />

        <button type="button" class="removeField btn btn-danger btn-sm">ลบ</button>
    `;
    container.appendChild(newField);

    // เมื่อคลิกปุ่มลบ
    newField.querySelector('.removeField').addEventListener('click', function() {
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal2'));
        modal.show();

        // เมื่อคลิกปุ่มยืนยันใน Modal
        document.getElementById('confirmDeleteButton2').addEventListener('click', function() {
            // ลบฟิลด์จากหน้าฟอร์ม
            container.removeChild(newField);
            modal.hide();
        });
    });
});


document.querySelectorAll('.removeField').forEach(function(button) {
    button.addEventListener('click', function() {
        var column = button.getAttribute('data-column');
        var modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();

        // เมื่อกดยืนยันการลบ
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            // ลบฟิลด์จากหน้าฟอร์ม
            var field = button.closest('.extra-field');
            if (field) {
                field.remove(); // ลบฟิลด์จากหน้าฟอร์ม
            }

            // ส่งข้อมูลคอลัมน์ที่ต้องการลบไปยัง Controller
            var form = document.querySelector('form');
            var deletedFieldsInput = document.createElement('input');
            deletedFieldsInput.type = 'hidden';
            deletedFieldsInput.name = 'deleted_fields[]';
            deletedFieldsInput.value = column;
            form.appendChild(deletedFieldsInput);

            modal.hide();

            // ส่งฟอร์ม
            form.submit(); // ส่งฟอร์มไปยัง Controller
        });
    });
});
</script>

@endsection