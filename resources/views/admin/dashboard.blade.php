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
    
    <!-- Age Chart Section -->
    <div class="card p-3 bg-dark text-white">
        <h5 class="text-center">สมาชิกในชุมชนแยกตามอายุทั้งหมด</h5>
        <canvas id="ageChart" class="mt-3"></canvas>
    </div>
    
    <!-- Disease Filter and Chart Section -->
    <div class="card p-3 bg-dark text-white mt-3">
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

    async function fetchDashboardData() {
        let response = await fetch("https://thungsetthivhv.pcnone.com/dashboard/data");

        if (!response.ok) {
            alert("ไม่สามารถดึงข้อมูลได้");
            return;
        }
        let data = await response.json();
        
        dashboardData = data;

        // Update total, female, and male member counts
        document.getElementById("total-members").innerText = data.total + " คน";
        document.getElementById("female-members").innerText = data.female + " คน";
        document.getElementById("male-members").innerText = data.male + " คน";
        
        // Create or update age chart
        if (!ageChart) {
            ageChart = new Chart(document.getElementById("ageChart"), {
                type: "bar",
                data: {
                    labels: data.age_labels,
                    datasets: [{
                        label: "จำนวนสมาชิก",
                        data: data.age_data,
                        backgroundColor: "#ffffff"
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        x: {
                            grid: {
                                color: "rgba(255, 255, 255, 0.2)"
                            },
                            ticks: {
                                color: "#ffffff"
                            }
                        },
                        y: {
                            grid: {
                                color: "rgba(255, 255, 255, 0.2)"
                            },
                            ticks: {
                                color: "#ffffff"
                            }
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

    fetchDashboardData();
</script>

<style>
    .card {
        margin-bottom: 1.5rem;
    }

    .member-count {
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .member-count {
            font-size: 1.2rem;
        }

        #ageChart, #diseaseChart {
            max-height: 400px;
        }

        .form-select {
            width: 80%;
        }
    }
</style>

@endsection
