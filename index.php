<?php
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col">        
                <h1 class="mt-4 display-6">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Analytics</li>
                </ol>
            </div>
            <div class="col-lg-4 mb-6">
                <br>
                <br>
                <select class="form-select form-select-padding-y-lg" name="" id="regionFilter">
                    <option value="all">All Region</option>
                    <option value="1">NCR</option>
                    <option value="2">Region 1</option>
                    <option value="3">Region 2</option>
                    <option value="4">Region 3</option>
                    <option value="5">Region 4-A</option>
                    <option value="6">Region 4-B</option>
                    <option value="7">Region 5</option>
                    <option value="8">Region 6</option>
                    <option value="9">Region 7</option>
                    <option value="10">Region 8</option>
                    <option value="11">Region 9</option>
                    <option value="12">Region 10</option>
                    <option value="13">Region 11</option>
                    <option value="14">Region 12</option>
                    <option value="15">BARMM</option>
                    <option value="16">CAR</option>
                    <option value="17">CARAGA</option>
                </select>
            </div>
        </div>


        <!-- Main Dashboard -->
        <div class="container-fluid mt-4">
            <!-- Graphs and Summaries -->
            <div class="row">
                <!-- Device Categories Chart -->
                <div class="col-lg-6 mb-lg-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-header">
                            <h6 class="card-title">Hardware by Category <span class='badge bg-success'>On Site</span></h6>
                        </div>
                        <div class="card-body">
                            <canvas id="categoryChart" style="height: 300px;"></canvas>
                        </div>
                        <div class="card-footer text-muted"></div>
                    </div>
                </div>
                <!-- Age of Hardware Chart -->
                <div class="col-lg-6 mb-4">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-header">
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
                                        <option value="UPS-PC">UPS-PC</option>
                                        <option value="UPS-SERVER">UPS-SERVER</option>
                                        <option value="Monitor">Monitor</option>
                                        <option value="Network Equipment">Network Equipment</option>
                                        <option value="Peripherals">Peripherals</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="ageChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card border border-dark-subtle shadow-sm fixed-card">
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
                    <div class="card border border-dark-subtle shadow-sm fixed-card">
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
                    <div class="card border border-dark-subtle shadow-sm fixed-card">
                        <div class="card-body">
                            <h6 class="card-title">Workstation <span class='badge bg-success'>On Site</span></h6>
                            <div class="table-responsive">
                                <table id="osTypeTable" class="table">
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
