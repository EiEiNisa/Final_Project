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

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-top: 10px;
        margin-bottom: 50px;
        border-collapse: collapse;
        font-size: 14px; /* ลดขนาดตัวอักษรในตาราง */
    }

    .table th, .table td {
        padding: 8px; /* ลด padding ของเซลล์ */
        text-align: left;
        font-size: 13px; /* ลดขนาดตัวอักษรในตาราง */
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

    /* Responsive Styles */
    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 12px;
            padding: 6px; /* ลดขนาด padding ให้เล็กลง */
        }

        .form-group {
            width: calc(50% - 10px);
        }

        .button {
            font-size: 15px;
            margin-top: 20px;
        }

        .title {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .table th, .table td {
            font-size: 11px;
            padding: 5px; /* ลดขนาด padding ให้เล็กลง */
        }

        .form-group {
            width: 100%;
        }

        .button {
            font-size: 14px;
            margin-top: 20px;
        }

        .title {
            flex-direction: column;
            align-items: flex-start;
        }

        .rectangle-box {
            height: auto;
            padding: 15px;
        }
    }
</style>

<div class="container py-2">
    <div class="title">
        <h4><strong>บันทึกข้อมูล</strong></h4>
        <div>
            <!-- Add any buttons or links here, similar to the admin layout -->
        </div>
    </div>

    <div class="rectangle-box">
        <form method="GET" action="{{ route('User.record') }}">
            <div class="form-group">
                <label for="name">ชื่อ-นามสกุล</label>
                <input id="name" class="form-control" type="search" name="name" placeholder="ค้นหาชื่อ-นามสกุล" aria-label="Search">
            </div>
            <div class="form-group">
                <label for="house-number">บ้านเลขที่</label>
                <input id="house-number" class="form-control" type="search" name="housenumber" placeholder="ค้นหาบ้านเลขที่" aria-label="Search">
            </div>
            <div class="form-group">
                <label for="disease">โรคประจำตัว</label>
                <input id="disease" class="form-control" type="search" name="disease" placeholder="ค้นหาโรคประจำตัว" aria-label="Search">
            </div>
            <button class="button" type="submit">ค้นหา</button>
        </form>
    </div>

    @php
    use Carbon\Carbon;
    @endphp

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col">บ้านเลขที่</th>
                    <th scope="col">วัน/เดือน/ปีเกิด</th>
                    <th scope="col">อายุ</th>
                    <th scope="col">เบอร์โทรศัพท์</th>
                    <th scope="col">โรคประจำตัว</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recorddata as $key => $data)
                    <tr>
                        <td scope="row"><strong>{{ $recorddata->firstItem() + $loop->iteration - 1 }}</strong></td>
                        <td><strong>{{ $data['name'] }} {{ $data['surname'] }}</strong></td>
                        <td><strong>{{ $data['housenumber'] }}</strong></td>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Show Pagination -->
    <div class="pagination">
        {{ $recorddata->links() }}
    </div>

</div>
@endsection