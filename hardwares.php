<?php 
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h6 class="mt-2 display-6">Hardwares</h6>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-2">
                                <div id="displayRegionHW"></div>
                            </div>               
                            <div class="col-md-2">
                                <select class="form-select" name="site_name" onchange="directory_site_name()" id="viewSiteOption" disabled>
                                    <option value="all_site" selected>Select Site</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="hw_type" onchange="directory_site_name()" id="viewHwType" disabled>
                                    <option value="all_hw" selected>All hardware</option>
                                    <option value="Server" >Server</option>
                                    <option value="UPS-Server" >UPS-Server</option>
                                    <option value="CPU-PC" >CPU-PC</option>
                                    <option value="Monitor" >Monitor</option>
                                    <option value="UPS-PC" >UPS-PC</option>
                                    <option value="Keyboard" >Keyboard</option>
                                    <option value="Mouse" >Mouse</option>
                                    <option value="Printer" >Printer</option>
                                    <option value="LaserJet" >LaserJet</option>
                                    <option value="Webcam" >Webcam</option>
                                    <option value="Sigpad" >Sigpad</option>
                                    <option value="Router" >Router</option>
                                    <option value="Switch" >Switch</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showHwButton" disabled>
                                    <i class="fas fa-search"></i> <span class="ms-1">Show</span>
                                </button>
                            </div>
                            <!-- Added wrapper div to push button to the right -->
                            <div class="col-md-4 d-flex justify-content-md-end justify-content-center">
                                <button class="btn btn-success justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#AddHardwareModal" id="addHardwareBtn">
                                    <i class="fas fa-plus-circle"></i>&nbsp;Add Hardware
                                </button>
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
                            <table id="hardwarePerSite" class="table table-striped">
                                <thead class="table-dark">
                                <tr>
                                    <th scope="col">Region</th>
                                    <th scope="col">Site</th>
                                    <th scope="col">Item Description</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Asset No.</th>
                                    <th scope="col">Serial No.</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody id="hardwareDisplay">
                                <td id="rowdisplay" colspan="8" class="text-muted text-center fst-italic">Please select region and site...</td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5"></div>
    </div>

    <!--- Add Hardware Modal ------------->
    <div class="modal modal-lg fade" id="AddHardwareModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AddHardwareModal" aria-hidden="true">
        <div class="modal-dialog">
                <form action="addHardware.php" method="POST" class="row g-3 needs-validation">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                            Add Hardware
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
                                            <div class="">Region</div>
                                            <div>
                                                <div id="hardwareRegionModal"></div>
                                            </div>
                                        <dd class="col-sm-12">
                                            <div class="">Site Code</div>
                                            <select class="form-select" name="SelectCode" id="SelectCode" required>
                                                <option value="" selected> </option>
                                            </select>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Site Name</div>
                                            <select class="form-select" name="SelectSite" id="SelectSite" required>
                                                <option value="" selected> </option>
                                            </select>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Item Description</div>
                                            <div>
                                                <div id="itemDescription"></div>
                                            </div>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Brand</div>
                                            <select class="form-select" name="itemBrand" id="itemBrand" disabled>
                                                <option value="" selected>Select Brand</option>
                                            </select>
                                            <!--
                                            <div>
                                                <div id="itemBrand"></div>
                                            </div>
                                            -->
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Model</div>
                                            <div>
                                                <div id="itemModel"></div>
                                            </div>
                                        </dd>
                                    </div>
                                    <div class="col-6">
                                        <dd class="col-sm-12">
                                            <div class="">Asset No.:</div>
                                            <input type="text" class="form-control" name="asset_num" placeholder="" required>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Serial No.</div>
                                            <input type="text" class="form-control" name="serial_num" placeholder="" required>
                                        </dd>
                                        <dt class="">Date Deployed:</dt>
                                        <dd class="d-flex col-sm-12">
                                            <input type="text" id="datepicker" class="form-control datepicker-input" name="date_acquired" placeholder="" readonly required>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Acquired Value</div>
                                            <input class="form-control" type="text" name="acquired_value" placeholder="">
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
                        <!--<button type="button" class="btn btn-warning" id="updateServerBtn">Update</button>-->
                        <!--<button type="submit" class="btn btn-primary disabled" id="addDetailsCPULoading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Saving...
                        </button>-->
                    </div>
                </div>
            </form>
        </div>
    </div>

</main>


<?php include("includes/footer.php"); ?>
