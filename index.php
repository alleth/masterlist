<?php
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4 display-6">Dashboard</h1>
        <div class="row">
            <div class="col-xl-3 col-md-6"><h3> </h3></div>
        </div>
        <!-- Main Dashboard -->
        <div class="container-fluid mt-4">
            <!-- Graphs and Summaries -->
            <div class="row">
                <!-- Device Categories Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Hardware by Category <span class='badge bg-success'>On Site</span></h6>
                            <canvas id="categoryChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Age of Hardware Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Age of Hardware <span class='badge bg-success'>On Site</span></h6>
                            <canvas id="ageChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hardware Details -->
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Other Hardwares</h5>
                            <table class="table table-striped" id="hardwareTable">
                                <thead class="table-dark">
                                <tr>
                                    <th>Hardwares</th>
                                    <th>Item Description</th>
                                    <th>Total Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Data will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<?php include("includes/footer.php"); ?>
