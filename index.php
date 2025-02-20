<?php
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4 display-6">Dashboard</h1>
        <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Analytics</li>
            </ol>

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
                            <div class="row">
                                <div class="col-sm">
                                    <h6 class="card-title">Age of Hardware <span class='badge bg-success'>On Site</span></h6>
                                </div>
                                <div class="col-sm">
                                    <select id="hardwareFilter" name="hardwareFilter" class="form-select form-select-sm mb-3">
                                        <option value="all">All</option>
                                        <option value="Server">Server</option>
                                        <option value="CPU-PC">CPU</option>
                                        <option value="Printer">Printer</option>
                                        <option value="UPS">UPS</option>
                                        <option value="Monitor">Monitor</option>
                                        <option value="Switch">Switch</option>
                                        <option value="Router">Router</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                            <canvas id="ageChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                        <h6 class="card-title">Server <span class='badge bg-success'>On Site</span></h6>
                            <div class="table-responsive">
                                <table id="serverModelTable" class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <!-- Data will be populated dynamically via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Printer <span class='badge bg-success'>On Site</span></h6>
                            <div class="table-responsive">
                                <table id="printerModelTable" class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <!-- Data will be populated dynamically via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">Workstation <span class='badge bg-success'>On Site</span></h6>
                            <div class="table-responsive">
                                <table id="" class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>OS Type</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <!-- Data will be populated dynamically via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row">
                
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
