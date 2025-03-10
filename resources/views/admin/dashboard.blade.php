@extends('layoutadmin')

@section('content')
<div class="container py-4">
    <h2 class="text-white text-center mb-4">Dashboard</h2>
    
    <div class="row text-center my-4">
        <!-- Card 1: Total Members -->
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card text-white shadow" style="background-color: #00695c;">
                <div class="card-body">
                    <h5 class="card-title">สมาชิกทั้งหมดในชุมชน</h5>
                    <h3 id="total-members" class="card-text display-4 member-count">XXX คน</h3>
                </div>
            </div>
        </div>

        <!-- Card 2: Female Members -->
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card text-white shadow" style="background-color: #ffb300;">
                <div class="card-body">
                    <h5 class="card-title">สมาชิกที่ลงทะเบียนเป็นหญิง</h5>
                    <h3 id="female-members" class="card-text display-4 member-count">XXX คน</h3>
                </div>
            </div>
        </div>

        <!-- Card 3: Male Members -->
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card text-white shadow" style="background-color: #d32f2f;">
                <div class="card-body">
                    <h5 class="card-title">สมาชิกที่ลงทะเบียนเป็นชาย</h5>
                    <h3 id="male-members" class="card-text display-4 member-count">XXX คน</h3>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ช่วงเวลา -->
    <div class="text-center mb-4">
        <select id="time-period" class="form-select w-25 mx-auto my-3 rounded-pill">
            <option value="daily">รายวัน</option>
            <option value="monthly">รายเดือน</option>
            <option value="yearly">รายปี</option>
            <option value="custom">ช่วงเวลา</option>
        </select>
        <!-- ตัวเลือกวันเริ่มต้นและวันสิ้นสุด (เฉพาะช่วงเวลา) -->
        <div id="custom-date-range" class="d-none">
            <input type="date" id="start-date" class="form-control my-2" />
            <input type="date" id="end-date" class="form-control my-2" />
        </div>
    </div>

    <!-- Age Chart Section -->
    <div class="card p-3 bg-white text-dark">
        <h5 class="text-center">สมาชิกในชุมชนแยกตามอายุทั้งหมด</h5>
        <canvas id="ageChart" class="mt-3"></canvas>
    </div>

    <!-- Disease Filter and Chart Section -->
    <div class="card p-3 bg-white text-dark">
        <h5 class="text-center">โรคประจำตัว</h5>
        <select id="disease-filter" class="form-select w-25 mx-auto my-3 rounded-pill">
            <option value="all">ทั้งหมด</option>
            <option value="diabetes">เบาหวาน</option>
            <option value="cerebral_artery">หลอดเลือดในสมอง</option>
            <option value="kidney">ไต</option>
            <option value="blood_pressure">ความดันโลหิตสูง</option>
            <option value="heart">หัวใจ</option>
            <option value="eye">ตา</option>
            <option value="other">อื่นๆ</option>
        </select>
        <canvas id="diseaseChart" class="mt-3"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let dashboardData = null;
    let ageChart = null;
    let diseaseChart = null;

    // ฟังก์ชันดึงข้อมูลจาก API ตามช่วงเวลา
    async function fetchDashboardData(timePeriod = 'monthly', startDate = null, endDate = null) {
        let url = `https://thungsetthivhv.pcnone.com/dashboard/data?time_period=${timePeriod}`;
        
        if (timePeriod === 'custom' && startDate && endDate) {
            url += `&start_date=${startDate}&end_date=${endDate}`;
        }

        let response = await fetch(url);

        if (!response.ok) {
            alert("ไม่สามารถดึงข้อมูลได้");
            return;
        }
        let data = await response.json();
        dashboardData = data;

        // อัปเดตข้อมูลในกราฟและการแสดงผล
        updateDashboard(data);
    }

    // อัปเดตข้อมูลใน Dashboard
    function updateDashboard(data) {
        document.getElementById("total-members").innerText = data.total + " คน";
        document.getElementById("female-members").innerText = data.female + " คน";
        document.getElementById("male-members").innerText = data.male + " คน";
        
        updateAgeChart(data);
        updateDiseaseChart("all", data);
    }

    // อัปเดตกราฟอายุ
    function updateAgeChart(data) {
        if (!ageChart) {
            const ctx = document.getElementById("ageChart").getContext("2d");
            ageChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: data.age_labels,
                    datasets: [{
                        label: "จำนวนสมาชิก",
                        data: data.age_data,
                        backgroundColor: "rgba(0, 150, 136, 0.7)",
                        borderColor: "rgba(0, 0, 0, 0.1)",
                        borderWidth: 1,
                        hoverBorderColor: "rgba(0, 0, 0, 0.5)",
                        hoverBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    legend: { position: "bottom" },
                    scales: {
                        x: {
                            ticks: { font: { size: 12 } }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            ageChart.data.labels = data.age_labels;
            ageChart.data.datasets[0].data = data.age_data;
            ageChart.update();
        }
    }

    // อัปเดตกราฟโรค
    function updateDiseaseChart(filter, data) {
        let dataset = [];

        if (filter === "all") {
            dataset = [
                {
                    label: 'เบาหวาน',
                    data: data.diseases['diabetes'],
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                },
                {
                    label: 'หลอดเลือดในสมอง',
                    data: data.diseases['cerebral_artery'],
                    backgroundColor: 'rgba(255, 82, 82, 0.7)',
                    borderColor: 'rgba(255, 82, 82, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ไต',
                    data: data.diseases['kidney'],
                    backgroundColor: 'rgba(33, 150, 243, 0.7)',
                    borderColor: 'rgba(33, 150, 243, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ความดันโลหิตสูง',
                    data: data.diseases['blood_pressure'],
                    backgroundColor: 'rgba(76, 175, 80, 0.7)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                },
                {
                    label: 'หัวใจ',
                    data: data.diseases['heart'],
                    backgroundColor: 'rgba(156, 39, 176, 0.7)',
                    borderColor: 'rgba(156, 39, 176, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ตา',
                    data: data.diseases['eye'],
                    backgroundColor: 'rgba(255, 87, 34, 0.7)',
                    borderColor: 'rgba(255, 87, 34, 1)',
                    borderWidth: 1
                },
                {
                    label: 'อื่นๆ',
                    data: data.diseases['other'],
                    backgroundColor: 'rgba(233, 30, 99, 0.7)',
                    borderColor: 'rgba(233, 30, 99, 1)',
                    borderWidth: 1
                }
            ];
        } else {
            if (data.diseases[filter]) {
                dataset = [
                    {
                        label: data.disease_labels[filter],
                        data: data.diseases[filter],
                        backgroundColor: 'rgba(255, 193, 7, 0.7)',
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1
                    }
                ];
            }
        }

        if (!diseaseChart) {
            diseaseChart = new Chart(document.getElementById("diseaseChart"), {
                type: "bar",
                data: {
                    labels: data.months,
                    datasets: dataset
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    legend: { position: "bottom" },
                    scales: {
                        x: {
                            ticks: { font: { size: 12 } }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            diseaseChart.data.labels = data.months;
            diseaseChart.data.datasets = dataset;
            diseaseChart.update();
        }
    }

    // ฟังก์ชันสำหรับเลือกช่วงเวลา
    document.getElementById("time-period").addEventListener("change", function() {
        let selectedPeriod = this.value;

        if (selectedPeriod === 'custom') {
            document.getElementById('custom-date-range').classList.remove('d-none');
        } else {
            document.getElementById('custom-date-range').classList.add('d-none');
        }

        let startDate = document.getElementById('start-date').value;
        let endDate = document.getElementById('end-date').value;

        fetchDashboardData(selectedPeriod, startDate, endDate);
    });

    fetchDashboardData();  // ดึงข้อมูลเริ่มต้น
</script>
<style>
    /* ซ่อนตัวเลือกช่วงเวลา */
    .d-none {
        display: none;
    }
</style>

@endsection
