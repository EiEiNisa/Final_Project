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
            const customBackgroundPlugin = {
                id: "customCanvasBackgroundColor",
                beforeDraw: (chart) => {
                    const ctx = chart.canvas.getContext("2d");
                    ctx.save();
                    ctx.fillStyle = "#FFFFFF"; 
                    ctx.fillRect(0, 0, chart.width, chart.height);
                    ctx.restore();
                }
            };

            const ctx = document.getElementById("ageChart").getContext("2d");
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, "rgba(255, 165, 0, 0.7)");  // ส้ม
            gradient.addColorStop(1, "rgba(0, 150, 136, 0.7)");  // เขียวมรกต

            ageChart = new Chart(document.getElementById("ageChart"), {
                type: "bar",
                data: {
                    labels: data.age_labels,
                    datasets: [{
                        label: "จำนวนสมาชิก",
                        data: data.age_data,
                        backgroundColor: gradient,
                        borderColor: "rgba(0, 0, 0, 0.1)",
                        borderWidth: 1,
                        hoverBorderColor: "rgba(0, 0, 0, 0.5)",
                        hoverBorderWidth: 2
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
                },
                plugins: [customBackgroundPlugin]
            });
        } else {
            ageChart.data.labels = data.age_labels;
            ageChart.data.datasets[0].data = data.age_data;
            ageChart.update();
        }

        // Update disease chart
        updateDiseaseChart("all", data);
    }

    function updateDiseaseChart(filter, data) {
        let dataset = [];

        if (filter === "all") {
            dataset = [
                {
                    label: 'เบาหวาน',
                    data: data.diseases['diabetes'],
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',  // สีทอง
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                },
                {
                    label: 'หลอดเลือดในสมอง',
                    data: data.diseases['cerebral_artery'],
                    backgroundColor: 'rgba(255, 82, 82, 0.7)',  // สีแดงอ่อน
                    borderColor: 'rgba(255, 82, 82, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ไต',
                    data: data.diseases['kidney'],
                    backgroundColor: 'rgba(33, 150, 243, 0.7)',  // สีน้ำเงิน
                    borderColor: 'rgba(33, 150, 243, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ความดันโลหิตสูง',
                    data: data.diseases['blood_pressure'],
                    backgroundColor: 'rgba(76, 175, 80, 0.7)',  // สีเขียว
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                },
                {
                    label: 'หัวใจ',
                    data: data.diseases['heart'],
                    backgroundColor: 'rgba(156, 39, 176, 0.7)',  // สีม่วง
                    borderColor: 'rgba(156, 39, 176, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ตา',
                    data: data.diseases['eye'],
                    backgroundColor: 'rgba(255, 87, 34, 0.7)',  // สีส้ม
                    borderColor: 'rgba(255, 87, 34, 1)',
                    borderWidth: 1
                },
                {
                    label: 'อื่นๆ',
                    data: data.diseases['other'],
                    backgroundColor: 'rgba(233, 30, 99, 0.7)',  // สีชมพู
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
                        backgroundColor: 'rgba(255, 193, 7, 0.7)',  // สีทอง
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1
                    }
                ];
            }
        }

        // Create or update disease chart
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
        let selectedFilter = this.value;
        if (dashboardData) {
            updateDiseaseChart(selectedFilter, dashboardData);
        }
    });

    fetchDashboardData();
</script>

<style>
    /* Card Margin */
    .card {
        margin-bottom: 1.5rem;
    }

    /* Adjust the font size for smaller screens */
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
