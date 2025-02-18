<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
    @media print {
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        width: 210mm;
        height: 297mm;
        overflow: hidden;
        line-height: 1.2;
    }

    @page {
        margin: 10mm;
    }

    .container {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 10mm;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .info-box {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        padding: 8px;
        font-size: 14px;
        page-break-inside: avoid;
    }

    .info-box .row-1 .col,
    .info-box .row-2 .col {
        width: 50%;
    }

    .divider {
        margin: 20px 0;
        border-top: 1px solid #000;
    }

    .info-box-container {
        padding: 10px;
    }

    .info-box:last-child {
        page-break-after: auto;
    }
    }

    </style>
</head>


<body>
    <div class="container mt-5">
        <h2 class="text-center">ข้อมูลบุคคล</h2>

        <div class="info-box row-1">
            <div class="col">
                <strong>เลขบัตรประชาชน:</strong> {{ $recorddata->id_card }}
            </div>
            <div class="col">
                <strong>ชื่อ:</strong> {{ $recorddata->prefix }} {{ $recorddata->name }} {{ $recorddata->surname }}
            </div>
            <div class="col">
                <strong>วันเกิด:</strong> {{ \Carbon\Carbon::parse($recorddata->birthdate)->format('d/m/Y') }}
            </div>
        </div>

        <div class="info-box row-2">
            <div class="col">
                <strong>อายุ:</strong> {{ $recorddata->age }}
            </div>
            <div class="col">
                <strong>บ้านเลขที่:</strong> {{ $recorddata->housenumber }}
            </div>
            <div class="col">
                <strong>กรุ๊ปเลือด:</strong> {{ $recorddata->blood_group }}
            </div>
            <div class="col">
                <strong>น้ำหนัก:</strong> {{ $recorddata->weight }}
            </div>
            <div class="col">
                <strong>ส่วนสูง:</strong> {{ $recorddata->height }}
            </div>
            <div class="col">
                <strong>รอบเอว:</strong> {{ $recorddata->waistline }}
            </div>
            <div class="col">
                <strong>BMI:</strong> {{ $recorddata->bmi }}
            </div>
        </div>

        <div class="info-box">
            <div class="col">
                <strong>เบอร์โทร:</strong> {{ $recorddata->phone }}
            </div>
            <div class="col">
                <strong>LINE ID:</strong> {{ $recorddata->idline }}
            </div>
        </div>


        <div class="divider"></div>

        <h3 class="inspection-title">ประวัติการตรวจ</h3>
        <br>
        @foreach($inspections as $inspection)
        <div class="info-box-container">
            <!-- แสดงหมายเลขการตรวจ -->
            <div class="info-box">
                <h5><strong>ตรวจครั้งที่ {{ $inspection['inspection_number'] }}</strong></h5>
                <div><strong>วันที่ตรวจ:</strong> {{ $inspection['date'] }}</div>
                <div><strong>ผู้บันทึกข้อมูล:</strong> {{ $inspection['user_id'] }}</div>
                </div>

            <!-- Health Record -->
            <div class="info-box">
                @if(isset($inspection['health_record']))
                <div><strong>ความดัน (SYS): </strong>{{ $inspection['health_record']['sys'] ?? 'ไม่มีข้อมูล' }}</div>
                <div><strong>ความดัน (DIA): </strong>{{ $inspection['health_record']['dia'] ?? 'ไม่มีข้อมูล' }}</div>
                <div><strong>ชีพจร: </strong>{{ $inspection['health_record']['pul'] ?? 'ไม่มีข้อมูล' }}</div>
                <div><strong>อุณหภูมิร่างกาย: </strong>{{ $inspection['health_record']['body_temp'] ?? 'ไม่มีข้อมูล' }}
                </div>
                <div><strong>ออกซิเจนในเลือด:
                    </strong>{{ $inspection['health_record']['blood_oxygen'] ?? 'ไม่มีข้อมูล' }}</div>
                <div><strong>ระดับน้ำตาลในเลือด:
                    </strong>{{ $inspection['health_record']['blood_level'] ?? 'ไม่มีข้อมูล' }}</div>
                @endif
            </div>

            <!-- Blood Pressure Zone -->
            <div class="info-box">
                <p><strong>Blood Pressure Zone:</strong></p>
                @if(is_array($inspection['health_zone']))
                @foreach($inspection['health_zone'] as $zone)
                <div><strong></strong>{{ $zone }}</div>
                @endforeach
                @else
                <div><strong></strong>{{ $inspection['health_zone'] }}</div>
                @endif
            </div>

            <!-- Blood Pressure Zone2 -->
            <div class="info-box">
                <p><strong>Blood Pressure Zone2:</strong></p>
                @if(is_array($inspection['health_zone2']))
                @foreach($inspection['health_zone2'] as $zone2)
                <div><strong></strong>{{ $zone2 }}</div>
                @endforeach
                @else
                <div><strong></strong>{{ $inspection['health_zone2'] }}</div>
                @endif
            </div>

            <!-- โรคประจำตัว -->
            <div class="info-box">
                <p><strong>โรคประจำตัว:</strong></p>
                @if (is_array($inspection['disease']) || is_object($inspection['disease']))
                <ul>
                    @foreach ($inspection['disease'] as $disease)
                    <li>{{ $disease }}</li>
                    @endforeach
                </ul>
                @else
                <p>{{ $inspection['disease'] ?? 'ไม่มีข้อมูล' }}</p>
                @endif
            </div>

            <!-- พฤติกรรม-สุขภาพจิต -->
            <div class="info-box">
                <p><strong>พฤติกรรม-สุขภาพจิต:</strong></p>
                @if (is_array($inspection['lifestyle_habits']))
                <ul>
                    @foreach ($inspection['lifestyle_habits'] as $habit)
                    <li>{{ $habit  }}</li>
                    @endforeach
                </ul>
                @else
                <p>{{ $inspection['lifestyle_habits'] ?? 'ไม่มีข้อมูล' }}</p>
                @endif
            </div>

            <!-- ข้อมูลผู้สูงอายุ -->
            <div class="info-box">
                <p><strong>ข้อมูลผู้สูงอายุ:</strong></p>
                @if (is_array($inspection['elderly_information']))
                <ul>
                    @foreach ($inspection['elderly_information'] as $elderlyHabits)
                    <li>{{ $elderlyHabits  }}</li>
                    @endforeach
                </ul>
                @else
                <p>{{ $inspection['elderly_information'] ?? 'ไม่มีข้อมูล' }}</p>
                @endif
            </div>
        </div>

        <div class="divider"></div>
        @endforeach


    </div>
</body>

</html>