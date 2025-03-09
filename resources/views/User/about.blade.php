@extends('layoutuser')

@section('content')
<style>
body, html {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fb;
}

.header-banner {
    background-color: #090A77;
    color: #fff;
    text-align: center;
    padding: 50px 20px;
    width: 100%;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.header-banner h3 {
    font-size: 2.5rem;
    font-weight: bold;
    letter-spacing: 1px;
}

.header-banner h5 {
    font-size: 1.5rem;
    font-weight: 400;
}

.info-section {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.info-section h4 {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 50px;
}

.table, th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    border-radius: 6px;
}

.table th {
    background-color: #F7F7F7;
    font-weight: bold;
    color: #555;
}

.table td {
    background-color: #f9f9f9;
    color: #444;
}

.table td strong {
    color: #090A77;
}

.table tr:nth-child(even) td {
    background-color: #f1f1f1;
}

.table tr:hover td {
    background-color: #e0e0e0;
}

.form-container {
    margin: 20px 0;
}

@media (max-width: 768px) {
    .header-banner h3 {
        font-size: 2rem;
    }

    .header-banner h5 {
        font-size: 1.2rem;
    }

    .info-section {
        padding: 20px;
    }

    table {
        font-size: 0.9rem;
    }
}
</style>

<div class="header-banner">
    <h3><strong>ข้อมูลพื้นฐาน</strong></h3>
    <h5>ชุมชนทุ่งเศรษฐี</h5>
</div>

<div style="color:#333; display:flex; flex-direction:column; align-items: center;">
    <main>
        <section class="info-section">
            <h4>ข้อมูลพื้นฐาน</h4>

            <!-- ตารางข้อมูล -->
            <table>
                <tr>
                    <td><strong>จำนวนประชากรทั้งหมด</strong></td>
                    <td><strong>{{ $populationCount }} คน</strong></td>
                </tr> 
                <tr>
                    <td>จำนวนผู้ชาย</td>
                    <td>{{ $maleCount }} คน</td>
                </tr>
                <tr>
                    <td>จำนวนผู้หญิง</td>
                    <td>{{ $femaleCount }} คน</td>
                </tr>
                <tr>
                    <td>เด็กแรกเกิดถึงอายุ 6 ปี</td>
                    <td>{{ $age_0_6 }} คน</td>
                </tr>
                <tr>
                    <td>อายุ 7 ปีขึ้นไป</td>
                    <td>{{ $age_7_14 }} คน</td>
                </tr>
                <tr>
                    <td>อายุ 15 ปีขึ้นไป</td>
                    <td>{{ $age_15_34 }} คน</td>
                </tr>
                <tr>
                    <td>อายุ 35 ปีขึ้นไป</td>
                    <td>{{ $age_35_59 }} คน</td>
                </tr>
                <tr>
                    <td>ผู้สูงอายุ (60 ปีขึ้นไป)</td>
                    <td>{{ $age_60_plus }} คน</td>
                </tr>
                <tr>
                    <td>ผู้สูงอายุติดสังคม</td>
                    <td>{{ $society }} คน</td>
                </tr>
                <tr>
                    <td>ผู้สูงอายุติดบ้าน</td>
                    <td>{{ $house }} คน</td>
                </tr>
                <tr>
                    <td>ผู้สูงอายุติดเตียง</td>
                    <td>{{ $bed_ridden }} คน</td>
                </tr>
                <tr>
                    <td>ผู้ป่วยเบาหวาน</td>
                    <td>{{ $diabetesCount }} คน</td>
                </tr>
                <tr>
                    <td>ผู้ป่วยความดันโลหิตสูง</td>
                    <td>{{ $hypertensionCount }} คน</td>
                </tr>
                <tr>
                    <td>ภาวะไตเสื่อมจากโรคเรื้อรัง</td>
                    <td>{{ $kidneyDiseaseCount }} คน</td>
                </tr>
                <tr>
                    <td>เส้นรอบเอวเกิน 90 ซม. (ชาย)</td>
                    <td>{{ $waist_male_90_plus }} คน</td>
                </tr>
                <tr>
                    <td>เส้นรอบเอวเกิน 80 ซม. (หญิง)</td>
                    <td>{{ $waist_female_80_plus }} คน</td>
                </tr>               
            </table>
        </section>
    </main>
</div>

@endsection
