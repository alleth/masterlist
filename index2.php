<?php
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4 display-4">Dashboard</h1>
        <div class="row">
            <div class="col-xl-3 col-md-6"><h3> </h3></div>
        </div>
        <!-- Main Dashboard -->
        <div class="container-fluid mt-4">
            <!-- KPIs Section -->
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">Total Devices</h5>
                            <h3 class="text-primary fw-bold">120</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">Under Warranty</h5>
                            <h3 class="text-success fw-bold">90</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">Needing Repair</h5>
                            <h3 class="text-danger fw-bold">5</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">Unallocated Devices</h5>
                            <h3 class="text-warning fw-bold">25</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphs and Summaries -->
            <div class="row">
                <!-- Device Categories Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Devices by Category</h5>
                            <canvas id="categoryChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Age of Hardware Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Age of Hardware</h5>
                            <canvas id="ageChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts and Notifications -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Alerts & Notifications</h5>
                            <ul class="list-group">
                                <li class="list-group-item text-danger">5 devices have expiring warranties this month.</li>
                                <li class="list-group-item text-warning">2 devices are pending repair approval.</li>
                                <li class="list-group-item text-success">All servers are operational.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</main>
<script src="js/chart.min.js"></script>
<script>
    // Sample data for the "Devices by Category" chart
    const data = {
        labels: ['Servers', 'CPU-PC', 'Printers', 'UPS', 'Monitors'],
        datasets: [{
            label: 'Devices',
            data: [313, 3980, 2210, 3885, 4273],
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar', // Change to 'pie' or 'doughnut' for different styles
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Devices by Category'
                }
            }
        }
    };

    const categoryChart = new Chart(
        document.getElementById('categoryChart'),
        config
    );

    // Sample data for the "Age of Hardware" chart
    const ageData = {
        labels: ['< 1 Year', '1-3 Years', '3-5 Years', '> 5 Years'],
        datasets: [{
            label: 'Age of Hardware',
            data: [50, 40, 20, 10],
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(255, 99, 132, 0.6)'

            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };

    const ageConfig = {
        type: 'doughnut', // You can change this to 'bar', 'line', etc., as desired
        data: ageData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Age of Hardware'
                }
            }
        }
    };

    const ageChart = new Chart(
        document.getElementById('ageChart'),
        ageConfig
    );
</script>

<?php include("includes/footer.php"); ?>
