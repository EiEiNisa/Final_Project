@extends('layoutadmin')

@section('content')
<style>
body,
html {
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
}
</style>

<!-- แบรนเนอร์กว้างเต็มหน้าจอ -->
<div class="header-banner">
    <h3><strong>เกี่ยวกับเรา</strong></h3>
    <h5>ชุมชนทุ่งเศรษฐี</h5>
</div>

<!-- เนื้อหาข้อมูล -->
<div style="color:#fff; display:flex; flex-direction:column;align-items: center;">
    <main>
        <section class="info-section">
            <h4>ข้อมูลพื้นฐาน</h4>

            <!-- ตารางข้อมูล -->
            <table>
                <tr style="color: #ffff00">
                    <td> จำนวนหลังคาเรือน </td>
                    <td> 334 หลัง</td>
                </tr>
                <tr>
                    <td> ประชากรทั้งหมด </td>
                    <td> 866 คน</td>
                </tr>
                <tr>
                    <td> ชาย </td>
                    <td> 407 คน</td>
                </tr>
                <tr>
                    <td> หญิง </td>
                    <td> 459 คน</td>
                </tr>
                <tr>
                    <td> เด็กแรกเกิดถึงอายุ 6 ปี </td>
                    <td> 7 คน</td>
                </tr>
                <tr>
                    <td> อายุ 35 ปีขึ้นไป </td>
                    <td> 705 คน</td>
                </tr>
                <tr>
                    <td> ผู้สูงอายุ 60 ปีขึ้นไป </td>
                    <td> 135 คน</td>
                </tr>
                <tr>
                    <td> ผู้สูงอายุ กลุ่มที่ 1 ติดสังคม </td>
                    <td> 123 คน</td>
                </tr>
                <tr>
                    <td> ผู้สูงอายุ กลุ่มที่ 2 ติดบ้าน </td>
                    <td> 12 คน</td>
                </tr>
                <tr>
                    <td> ผู้สูงอายุ กลุ่มที่ 3 ติดเตียง </td>
                    <td> 2 คน</td>
                </tr>
                <tr>
                    <td> เบาหวาน </td>
                    <td> 13 คน</td>
                </tr>
                <tr>
                    <td> ความดันโลหิตสูง </td>
                    <td> 36 คน</td>
                </tr>
                <tr>
                    <td> เบาหวานและความดันโลหิตสูง </td>
                    <td> 9 คน</td>
                </tr>
                <tr>
                    <td> ผู้พิการ </td>
                    <td> 7 คน</td>
                </tr>
                <tr>
                    <td> ร้อยละขอพื้นที่พบลูกน้ำยุงลาย </td>
                    <td> 0 %</td>
                </tr>
                <tr>
                    <td> เส้นรอบเอวเกิน 90 ซม. (ชาย) </td>
                    <td> 30 คน</td>
                </tr>
                <tr>
                    <td> เส้นรอบเอวเกิน 90 ซม. (หญิง) </td>
                    <td> 40 คน</td>
                </tr>
                <tr>
                    <td> จำนวนคนเกิดในปี 2567 </td>
                    <td> 2 คน</td>
                </tr>
                <tr>
                    <td> จำนวนคนตายในปี 2567 </td>
                    <td> 2 คน</td>
                </tr>
                <tr>
                    <td> ภาวะไตเสื่อมจากโรคเรื้อรัง </td>
                    <td> 13 คน</td>
                </tr>
            </table>
        </section>
    </main>
</div>
</div>

@endsection