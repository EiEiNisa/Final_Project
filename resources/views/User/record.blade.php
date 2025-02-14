@extends('layoutuser')

@section('content')
<style>
.title {
    color: #020364;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.table {

    margin-top: 10px;
    margin-bottom: 50px;
}

.table th {
    background-color: #020364;
    color: #fff;
}

.table td {
    background-color: #7DA7D8;
    color: #fff;
}

.rectangle-box {
    margin-bottom: 20px;
    width: 100%;
    height: 100px;
    border: none;
    border-radius: 10px;
    background-color: #6D91C9;
    /*box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);*/
    display: flex;
    justify-content: center;
    align-items: center;
}

form {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.form-group {
    display: flex;
    flex-direction: column;
    width: calc((100% - (4 * 10px)) / 5);
    color: #020364;
}

.button {
    display: inline-block;
    padding: 5px 20px;
    background-color: #020364;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 17px;
    margin-top: 85px;
    margin-bottom: 60px;
    text-decoration: none;
}

.button:hover {
    background-color: #000145;
}
</style>
<div class="container py-2">
    <div class="title">
        <h4><strong>บันทึกข้อมูล</strong></h4>
    </div>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">เลขบัตรประจำตัวประชาชน</th>
                <th scope="col">ชื่อ-นามสกุล</th>
                <th scope="col">บ้านเลขที่</th>
                <th scope="col">วัน/เดือน/ปีเกิด</th>
                <th scope="col">อายุ</th>
                <th scope="col">เบอร์โทรศัพท์</th>
                <th scope="col">โรคประจำตัว</th>
                <th scope="col">การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recorddata as $key => $data)
            <tr>
                <td scope="row"><strong>{{ $recorddata->firstItem() + $loop->iteration - 1 }}</strong></td>
                <td><strong>{{ $data['id_card'] }}</strong></td>
                <td><strong>{{ $data['name'] }} {{ $data['surname'] }}</strong></td>
                <td style="text-align: center;"><strong>{{ $data['housenumber'] }}</strong></td>
                <td style="text-align: center;">
                    <strong>{{ Carbon::parse($data['birthdate'])->format('d/m/Y') }}</strong>
                </td>
                <td style="text-align: center;"><strong>{{ $data['age'] }}</strong></td>
                <td style="text-align: center;"><strong>{{ $data['phone'] }}</strong></td>
                <td><strong>
                        @if($data->diseases)
                        @php
                        $diseaseLabels = [
                        'diabetes' => 'เบาหวาน',
                        'cerebral_artery' => 'โรคหลอดเลือดสมอง',
                        'kidney' => 'โรคไต',
                        'blood_pressure' => 'ความดันโลหิตสูง',
                        'heart' => 'โรคหัวใจ',
                        'eye' => 'โรคตา',
                        'other' => 'โรคอื่นๆ'
                        ];

                        $selectedDiseases = collect($data->diseases->toArray())
                        ->filter(fn($value, $key) => $value == 1 && isset($diseaseLabels[$key]))
                        ->keys()
                        ->map(fn($key) => $diseaseLabels[$key])
                        ->implode("\n");
                        @endphp

                        {!! nl2br(e($selectedDiseases) ?: 'ไม่มีโรคประจำตัว') !!}
                        @else
                        -
                        @endif
                    </strong></td>

                <td>
                    <a href="{{ route('recorddata.show', $data->id) }}" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>

                    <a href="{{ route('recorddata.edit', $data->id) }}" class="btn btn-primary"><i
                            class="fa-solid fa-pen"></i></a>

                    <form id="deleteForm{{ $data->id }}" action="{{ route('recorddata.destroy', ['id' => $data->id]) }}"
                        method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                            data-bs-target="#deleteModal{{ $data->id }}" data-id="{{ $data->id }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>

                    <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1"
                        aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $data->id }}" style="color:#000;">
                                        ยืนยันการลบ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="color:#000;">
                                    คุณต้องการลบข้อมูลนี้ใช่หรือไม่?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ไม่</button>
                                    <button type="button" class="btn btn-danger confirmDelete"
                                        data-form-id="deleteForm{{ $data->id }}">ยืนยันการลบ</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.confirmDelete').forEach(button => {
                            button.addEventListener('click', function() {
                                const formId = this.getAttribute('data-form-id');
                                document.getElementById(formId).submit();
                            });
                        });
                    });
                    </script>

                    <button class="btn btn-warning"><i class="fa-solid fa-print"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $recorddata->links() }}
</div>
@endsection