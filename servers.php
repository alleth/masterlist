<?php 
    include("includes/header.php"); 
    
?>
    <main>
        <div class="container-fluid px-4">
            <h6 class="mt-2 display-6">Servers Software</h6>
            <!--
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                <div class="col">
                    <div class="card border-left-primary shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <i class="fas fa-database fa-2x text-gray-300"></i> Database icon for total
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-left-primary shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Virtual Machine</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <i class="fas fa-cloud fa-2x text-gray-300"></i> Cloud icon for Virtual Machine
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-left-primary shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Physical Server</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <i class="fas fa-server fa-2x text-gray-300"></i> Server icon for Physical Server
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-left-primary shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Down Server</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i> Warning icon for Down Server
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-2">
                                    <div id="displayRegionServer"></div>
                                </div>
                                <div class="col-md-2 col-6">
                                    <select class="form-select" name="server_type" onchange="directory_site_name()" id="viewTypeServer" disabled>
                                        <option value="all_server" selected>All server type</option>
                                        <option value="VM">VM - Virtual Machine</option>
                                        <option value="XITRIX">XITRIX</option>
                                        <option value="IBM">IBM</option>
                                        <option value="HP">HP</option>
                                        <option value="Dell">Dell</option>
                                        <option value="Lenovo">Lenovo</option>
                                    </select>
                                </div>
                                <div class="col-md-1 col-6">
                                    <button class="btn btn-primary w-100" id="showServerType" disabled>
                                        <i class="fas fa-search"></i> Show
                                    </button>
                                </div>
                                
                                <div class="col-md-7 col-12 d-flex justify-content-md-end justify-content-center mt-2 mt-md-0">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#serverModalInput" id="addServerBtn"><i class="fas fa-plus-circle"></i> Add Server</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="serverTable" class="table table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Region</th>
                                            <th scope="col">Site Code</th>
                                            <th scope="col">Site Name</th>
                                            <th scope="col">Asset</th>
                                            <th scope="col">Serial</th>
                                            <th scope="col">OS</th>
                                            <th scope="col">Hostname</th>
                                            <th scope="col">Ip</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="serverDisplay">
                                        <td id ="rowdisplay" colspan="10" class="text-muted text-center fst-italic">Please select region or site...</td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container mt-5">

            </div>
        </div>
    </main>

    <!-- Modal Add CPU-PC -->
    <div class="modal modal-lg fade" id="serverModalInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCPUHardwareLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">

                        </h1>
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
                                            <input name="server_id" type="hidden" disabled>
                                            <div class="sr-only">Region</div>
                                            <div id="regionRegionModal"></div>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Site Name</div>
                                            <input class="form-control" name="site_name_input" id="viewSiteSelect" disabled>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Brand</div>
                                            <select class="form-select" name="brand_name" id="brand_option" required>
                                                <option value="" selected disabled>Select brand name </option>
                                                <option value="XITRIX">XITRIX</option>
                                                <option value="IBM">IBM</option>
                                                <option value="HP">HP</option>
                                                <option value="Dell">Dell</option>
                                                <option value="Lenovo">Lenovo</option>
                                            </select>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Model</div>
                                            <select class="form-select" name="model_name" id="model_option" disabled></select>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="sr-only">Acquired Value</div>
                                            <input class="form-control" type="text" name="acquired_value" placeholder="Acquired Value">
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
                                        <dt class="sr-only">Date Acquired:</dt>
                                        <dd class="d-flex col-sm-12">
                                            <input type="text" id="datepicker" class="form-control datepicker-input" name="date_acquired" placeholder="Date Acquired" readonly required>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <select class="form-select" name="status_option" required>
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="Onsite">On site</option>
                                                <option value="Pulled out">Pulled out</option>
                                                <option value="Idle">Idle</option>
                                            </select>
                                        </dd>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Information Section -->
                            <div class="container">
                                <hr>
                                <div class="row">
                                    <h4>Other Information</h4>
                                    <div class="col-12">
                                        <div class="card border-dashed p-4 text-center">
                                            <button type="button" class="btn btn-outline-primary col-5 center-align" disabled><i class="fas fa-plus-circle"></i> Add Other Information</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Other Information Section -->

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveServerBtn">Save</button>
                        <button type="button" class="btn btn-warning" id="updateServerBtn">Update</button>
                        <button type="submit" class="btn btn-primary disabled" id="addDetailsCPULoading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Saving...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--this is a comment-->
    <!-- this is my comment--->
    <!-- this is another comment-->
<?php include("includes/footer.php"); ?>