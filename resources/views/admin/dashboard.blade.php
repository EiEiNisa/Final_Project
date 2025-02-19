@extends('layoutadmin')

@section('content')
<div class="container py-4">
    <h2 class="text-white text-center mb-4">Dashboard</h2>
    
    <div class="row text-center my-4">
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card text-white shadow" style="background-color: #00A86B;">
                <div class="card-body">
                    <h5 class="card-title">สมาชิกทั้งหมดในชุมชน</h5>
                    <h3 id="total-members" class="card-text display-4 member-count">XXX คน</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card text-white shadow" style="background-color: #f8ba1c;">
                <div class="card-body">
                    <h5 class="card-title">สมาชิกที่ลงทะเบียนเป็นหญิง</h5>
                    <h3 id="female-members" class="card-text display-4 member-count">XXX คน</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card text-white shadow" style="background-color: #FF5733;">
                <div class="card-body">
                    <h5 class="card-title">สมาชิกที่ลงทะเบียนเป็นชาย</h5>
                    <h3 id="male-members" class="card-text display-4 member-count">XXX คน</h3>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart Section -->
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
    let dashboardData = null; // ตัวแปรเก็บข้อมูลที่ดึงมาจาก server
    let ageChart = null; // ตัวแปรเก็บกราฟอายุ
    let diseaseChart = null; // ตัวแปรเก็บกราฟโรค

    async function fetchDashboardData() {
        let response = await fetch("https://thungsetthivhv.pcnone.com/dashboard/data");

        if (!response.ok) {
            alert("ไม่สามารถดึงข้อมูลได้");
            return;
        }
        let data = await response.json();
        
        console.log(data);  // ดูข้อมูลที่ได้จาก API
        dashboardData = data;

        // แสดงผลข้อมูลจำนวนสมาชิก
        document.getElementById("total-members").innerText = data.total + " คน";
        document.getElementById("female-members").innerText = data.female + " คน";
        document.getElementById("male-members").innerText = data.male + " คน";
        
        // แสดงกราฟอายุ
        if (!ageChart) {
            ageChart = new Chart(document.getElementById("ageChart"), {
                type: "bar",
                data: {
                    labels: data.age_labels,
                    datasets: [{
                        label: "จำนวนสมาชิก",
                        data: data.age_data,
                        backgroundColor: "#36a2eb"
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    legend: {
                        position: "bottom"
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
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

        // เริ่มต้นกราฟโรค
        updateDiseaseChart("all", data);
    }

    function updateDiseaseChart(filter, data) {
        console.log("Disease data:", data.diseases);  // ตรวจสอบข้อมูลโรค
        let dataset = [];

        if (filter === "all") {
            dataset = [
                {
                    label: 'เบาหวาน',
                    data: data.diseases['diabetes'],  
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                },
                {
                    label: 'หลอดเลือดในสมอง',
                    data: data.diseases['cerebral_artery'],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                },
                {
                    label: 'ไต',
                    data: data.diseases['kidney'],
                    backgroundColor: 'rgba(153, 102, 255, 0.7)'
                },
                {
                    label: 'ความดันโลหิตสูง',
                    data: data.diseases['blood_pressure'],
                    backgroundColor: 'rgba(181, 234, 239, 0.7)'
                },
                {
                    label: 'หัวใจ',
                    data: data.diseases['heart'],
                    backgroundColor: 'rgba(126, 237, 92, 0.7)'
                },
                {
                    label: 'ตา',
                    data: data.diseases['eye'],
                    backgroundColor: 'rgba(255, 159, 64, 0.7)'
                },
                {
                    label: 'อื่นๆ',
                    data: data.diseases['other'],
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                }
            ];
        } else {
            // ตรวจสอบว่า filter ที่เลือกมีอยู่ใน data.diseases หรือไม่
            if (data.diseases[filter]) {
                dataset = [
                    {
                        label: data.disease_labels[filter],
                        data: data.diseases[filter],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    }
                ];
            } else {
                console.log("Error: No data found for", filter);  // กรณีที่ไม่มีข้อมูลสำหรับ filter ที่เลือก
            }
        }

        // อัปเดตกราฟ
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
                    legend: {
                        position: "bottom"
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
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

    document.getElementById("disease-filter").addEventListener("change", function() {
        let selectedFilter = this.value; // รับค่าจาก select
        console.log("Selected filter:", selectedFilter);  // ตรวจสอบค่าที่ถูกเลือก
        if (dashboardData) {
            updateDiseaseChart(selectedFilter, dashboardData); // อัปเดตกราฟโรคตาม filter ที่เลือก
        }
    });

    // เรียกใช้ฟังก์ชันเมื่อโหลดหน้า
    fetchDashboardData();
</script>

<style>
    /* ให้การ์ดดูมีระยะห่างในแต่ละอุปกรณ์ */
    .card {
        margin-bottom: 1.5rem;
    }

    /* ปรับขนาดข้อความของจำนวนสมาชิกให้เล็กลงในหน้าจอที่เล็ก */
    .member-count {
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .member-count {
            font-size: 1.2rem; /* ลดขนาดของจำนวนสมาชิก */
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