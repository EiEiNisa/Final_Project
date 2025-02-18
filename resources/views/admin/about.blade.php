@extends('layoutadmin')

@section('content')
<style>
body, html {
    margin: 0;
    padding: 0;
}

.header-banner {
    background-color: #090A77;
    margin-bottom: 20px;
    color: #fff;
    text-align: center;
    padding: 20px;
    width: 100%;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

table {
    margin-bottom: 50px;
    width: 100%;
}

.table, th, td {
    border: 1px solid #ddd;
    border-collapse: collapse;
    padding: 8px 12px;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
}

.form-container {
    margin: 20px 0;
}
</style>

<div class="header-banner">
    <h3><strong>เกี่ยวกับเรา</strong></h3>
    <h5>ชุมชนทุ่งเศรษฐี</h5>
</div>

<div style="color:#fff; display:flex; flex-direction:column;align-items: center;">
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
                    <td>{{ $age_15_34  }} คน</td>
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