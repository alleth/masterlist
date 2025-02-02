<?php include("includes/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 display-4">Servers</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Hardwares</li>
                    </ol>
                    <div class="row">
                        <div class="col-auto">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addServerHardware" id="addServerBtn">Add Server &nbsp;<i class="fas fa-plus-circle"></i></button>
                        </div>
                        <div id="alertMessage" class="alert alert-top" role="alert"></div>
                        <div class="col-sm-2">
                            <label class="visually-hidden" for="specificSizeSelect">Select Region</label>
                            <select class="form-select" id="specificSizeSelect">
                                <option>Select Region</option>
                                <option value="NCR">NCR</option>
                                <option value="Region 2">Region 2</option>
                                <option value="Region 3">Region 3</option>
                                <option value="Region 4-A">Region 4-A</option>
                                <option value="Region 4-B">Region 4-B</option>
                                <option value="Region 5">Region 5</option>
                                <option value="Region 6">Region 6</option>
                                <option value="Region 7">Region 7</option>
                                <option value="Region 8">Region 8</option>
                                <option value="Region 9">Region 9</option>f
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
                                <tbody id="tableDisplay2"></tbody>
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
                    <button type="button" class="btn-close button-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="srvr_info">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div id="hw_displayEdit">
                        <div class="row">
                            <div id="updateMessage"></div>
                            <h4>Primary Information</h4>
                            <div class="col-6">
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Region</div>
                                    <input type="hidden" class="form-control" name="hw_idEdit" disabled required>
                                    <select id="regionEdit" type="text" class="form-select" name="region_nameEdit" placeholder="Region" disabled required>
                                        <option value="" selected>Select Region</option>
                                    </select>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Site Name</div>
                                    <input type="hidden" class="form-control-plaintext" name="site_nameEdit" placeholder="Site Name" disabled required>
                                    <select name="site_nameEdit" id="siteNameEdit" class="form-select" disabled>
                                        <option value="" selected>Select Site Name</option>
                                    </select>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Site Code</div>
                                    <input type="hidden" class="form-control-plaintext" name="site_codeEdit" placeholder="Site Code" disabled required>
                                    <select name="site_codeEdit" id="siteCodeEdit" class="form-select" disabled>
                                        <option value="" selected>Select Site Code</option>
                                    </select>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Select Brand</div>
                                    <input type="hidden" class="form-control" name="brand_nameEdit" placeholder="Select Brand" required>
                                    <div class="sr-only">Brand</div>
                                    <select class="form-select" name="brand_name" onchange="" id="brand_optionUpdate"></select>

                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Select Model</div>
                                    <input type="hidden" class="form-control" name="model_nameEdit" placeholder="Select Model" required>
                                    <select class="form-select" name="model_name" onchange="" id="brand_modelUpdate"></select>
                                </dd>
                            </div>
                            <div class="col-6">
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Asset Number</div>
                                    <input type="text" class="form-control" name="asset_numEdit" placeholder="Asset Number" required>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Serial Number</div>
                                    <input type="text" class="form-control" name="serial_numEdit" placeholder="Serial Number" required>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Date Acquired</div>
                                    <input type="text" class="form-control" name="date_acqEdit" placeholder="Date Acquired" required>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Select Status</div>
                                    <input type="text" class="form-control" name="status_nameEdit" placeholder="Select Status" disabled>
                                </dd>
                            </div>
                            <hr>
                            <h4>Other Information</h4>
                            <div class="col-6">
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Hostname</div>
                                    <input type="text" class="form-control" name="host_nameEdit" placeholder="Hostname" required>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">IP Address</div>
                                    <input type="text" class="form-control" name="ip_addEdit" placeholder="IP Address" required>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">MAC Address</div>
                                    <input type="text" class="form-control" name="mac_addEdit" placeholder="MAC Address" required>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">User name</div>
                                    <input type="text" class="form-control" name="user_nameEdit" placeholder="User Name" required>
                                </dd>
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Primary Role</div>
                                    <input type="text" class="form-control" name="primary_roleEdit" placeholder="Primary Role" required>
                                </dd>
                            </div>
                            <div class="col-6">
                                <dd class='col-sm-12'>
                                    <div class="sr-only">Hostname</div>
                                    <input type="text" class="form-control" name="acq_valEdit" placeholder="Acquired Value" required>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary button-close" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editBtn">Edit Details</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveEditBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add CPU-PC-->
    <div class="modal modal-lg fade" id="addServerHardware" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCPUHardwareLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fas fa-info-circle"></i> Add Server</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="hw_add">
                            <div class="container">
                                <div id="addMessage"></div>
                                <div class="row">
                                    <h4>Primary Information</h4>
                                    <div class="col-6">
                                        <dd class='col-sm-12'>
                                            <div class="sr-only">Region</div>
                                            <div id="viewRegionSelect"></div>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Site Name</div>
                                            <div>
                                                <select class="form-select" name="site_name" id="viewSiteSelect" onchange="site_name_option()" disabled>
                                                    <option value="" selected disabled>Select Site Name</option>
                                                </select>
                                            </div>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Site Code</div>
                                            <input type="text" class="form-control" name="site_code" id="viewSiteCode" placeholder="Site Code" disabled>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Brand</div>
                                            <select class="form-select" name="brand_name" onchange="brandName()" id="brand_option" required></select>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Model</div>
                                            <select class="form-select" name="model_name" id="model_option" disabled></select>
                                        </dd>
                                    </div>
                                    <div class="col-6">
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Asset No.:</div>
                                            <input type="text" class="form-control" name="asset_num" placeholder="Asset Number" required>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Serial No.</div>
                                            <input type="text" class="form-control" name="serial_num" placeholder="Serial Number" required>
                                        </dd>
                                        <br>
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
                                            <select class="form-select" name="status_option" required>
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="ON SITE">ON SITE</option>
                                                <option value="ON SITE">DEFECTIVE</option>
                                                <option value="ON SITE">PULLED OUT</option>
                                            </select>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <hr>
                                <div class="row">
                                    <h4>Other Information</h4>
                                    <div class="col-6">
                                        <dd class='col-sm-12'>
                                            <div class="sr-only">Hostname</div>
                                            <div id="">
                                                <input class="form-control" name="host_name" type="text" placeholder="Hostname">
                                            </div>
                                        </dd>
                                        <dd class='col-sm-12'>
                                            <div class="sr-only">IP Address</div>
                                            <div id="">
                                                <input class="form-control" name="ip_address" type="text" placeholder="IP Address">
                                            </div>
                                        </dd>
                                        <dd class='col-sm-12'>
                                            <div class="sr-only">MAC Address</div>
                                            <div id="">
                                                <input class="form-control" name="mac_address" type="text" placeholder="MAC Address">
                                            </div>
                                        </dd>
                                        <dd class='col-sm-12'>
                                            <div class="sr-only">User Name</div>
                                            <div id="">
                                                <input class="form-control" name="user_name" type="text" placeholder="User Name">
                                            </div>
                                        </dd>
                                        <dd class='col-sm-12'>
                                            <div class="sr-only">Primary Role</div>
                                            <div id="">
                                                <select class="form-select" name="primary_role">
                                                    <option value="" selected disabled>Select Primary Role</option>
                                                    <option value="Evaluator">Evaluator</option>
                                                    <option value="Approving">Approving</option>
                                                    <option value="Input Clerk">Input Clerk</option>
                                                    <option value="Cashier">Cashier</option>
                                                    <option value="Releasing">Releasing</option>
                                                    <option value="Site Support">Site Support</option>
                                                </select>
                                            </div>
                                        </dd>
                                    </div>
                                    <div class='col-6'>
                                        <dd class='col-sm-12'>
                                            <div class="sr-only">Acquired Value</div>
                                            <div id="">
                                                <input class="form-control" type="text" name="acquired_value" placeholder="Acquired Value">
                                            </div>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addDetailsServer">Add Server</button>
                        <button type="submit" class="btn btn-primary disabled" id="addDetailsServerLoading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Adding...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--this is a comment-->
    <!-- this is my comment--->
    <!-- this is another comment-->
    
<?php include("includes/serverfooter.php"); ?>