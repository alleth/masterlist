<?php
include "navigation.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Masterfile | Hardware Inventory System</title>
    <link href="css/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <script src="js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 display-4">Servers</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Hardwares</li>
                </ol>
                <div class="row">
                    <div class="col-auto">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addCPUHardware" id="addCPUBtn">Add Server &nbsp;<i class="fas fa-plus-circle"></i></button>
                    </div>
                    <div class="col-sm-2">
                        <label class="visually-hidden" for="specificSizeSelect">Select Region</label>
                        <select class="form-select" id="specificSizeSelect">
                            <option selected>Select Region</option>
                            <option value="NCR">NCR</option>
                            <option value="Region 2">Region 2</option>
                            <option value="Region 3">Region 3</option>
                            <option value="Region 4-A">Region 4-A</option>
                            <option value="Region 4-B">Region 4-B</option>
                            <option value="Region 5">Region 5</option>
                            <option value="Region 6">Region 6</option>
                            <option value="Region 7">Region 7</option>
                            <option value="Region 8">Region 8</option>
                            <option value="Region 9">Region 9</option>
                            <option value="Region 10">Region 10</option>
                            <option value="Region 11">Region 11</option>
                            <option value="Region 12">Region 12</option>
                            <option value="BARMM">BARMM</option>
                            <option value="CAR">CAR</option>
                        </select>
                    </div>
                </div>
                <div class="container mt-5">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Region</th>
                                <th scope="col">Site Code</th>
                                <th scope="col">Site Name</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Model</th>
                                <th scope="col">PE No.</th>
                                <th scope="col">Serial No.</th>
                                <th scope="col">Age</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody id="tableDisplay"></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Masterfile | Hardware Inventory System &copy; <?php echo date("Y");?> </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Modal Hardware Info-->
<div class="modal modal-lg fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-info-circle"></i> &nbsp;Hardware Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="hw_display">Loading...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Edit Details</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Add CPU-PC-->
<div class="modal modal-lg fade" id="addCPUHardware" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCPUHardwareLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-info-circle"></i> Add CPU-PC</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="hw_add">
                    <div class="container">
                        <div class="row">
                            <h4>Primary Information</h4>
                            <div class="col-6">
                                <dd class='col-sm-12'>
                                    <label class="sr-only">Region</label>
                                    <input type="text" class="form-control" name="Region" placeholder="Region">
                                </dd>
                                <dd class="col-sm-12">
                                    <label class="sr-only">Site Code</label>
                                    <input type="text" class="form-control" name="Region" placeholder="Site Code">
                                </dd>
                                <dd class="col-sm-12">
                                    <label class="sr-only">Site Name</label>
                                    <input type="text" class="form-control" name="Region" placeholder="Site Name">
                                </dd>
                                <dd class="col-sm-12">
                                    <label class="sr-only">Brand</label>
                                    <input type="text" class="form-control" name="Region" placeholder="Brand">
                                </dd>
                                <dd class="col-sm-12">
                                    <label class="sr-only">Model</label>
                                    <input type="text" class="form-control" name="Region" placeholder="Model">
                                </dd>

                            </div>
                            <div class="col-6">
                                <dd class="col-sm-12">
                                    <label class="sr-only">Asset No.:</label>
                                    <input type="text" class="form-control" name="Region" placeholder="Asset Number">
                                </dd>
                                <dd class="col-sm-12">
                                    <label class="sr-only">Serial No.</label>
                                    <input type="text" class="form-control" name="Region" placeholder="Serial Number">
                                </dd>
                                <dt class="col-sm-4">Date Acquired:</dt>
                                <dd class="d-flex col-sm-12">
                                    <select class="form-select" name="hw_month">
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    &nbsp;
                                        <select class="form-select" name="hw_day">
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    &nbsp;
                                    <select class="form-select" name="hw_year">
                                        <option value="1999">1999</option>
                                        <option value="2000">2000</option>
                                        <option value="2001">2001</option>
                                        <option value="2002">2002</option>
                                        <option value="2003">2003</option>
                                        <option value="2004">2004</option>
                                        <option value="2005">2005</option>
                                        <option value="2006">2006</option>
                                        <option value="2007">2007</option>
                                        <option value="2008">2008</option>
                                        <option value="2009">2009</option>
                                        <option value="2010">2010</option>
                                        <option value="2011">2011</option>
                                        <option value="2012">2012</option>
                                        <option value="2013">2013</option>
                                        <option value="2014">2014</option>
                                        <option value="2015">2015</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                    </select>
                                </dd>
                                <dd class="col-sm-12">
                                    <select class="form-select">
                                        <option value="ON SITE">ON SITE</option>
                                        <option value="ON SITE">DEFECTIVE</option>
                                        <option value="ON SITE">PULLED OUT</option>
                                    </select>
                                </dd>
                            </div>
                        </div>
                        <hr>
                        <h4>Other Information</h4>
                        <div class="row" style="background-color: #bcbebf;">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add Server</button>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.main.js" type="text/javascript"></script>
<script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="js/chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="js/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
<script src="js/cpu-pc-script.js" type="text/javascript"></script>
</body>
</html>