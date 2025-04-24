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
                                    <option value="Peripherals" >Peripherals</option>
                                    <option value="Network Equipment" >Network Equipment</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showHwButton" disabled>
                                    <i class="fas fa-search"></i> <span class="ms-1">Show</span>
                                </button>
                            </div>
                            <!-- Added wrapper div to push button to the right -->
                            <div class="col-md-4 d-flex justify-content-md-end justify-content-center">
                                <button class="btn btn-success justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#AddHardwareModal" id="">
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
                <form method="POST" class="row g-3 needs-validation">
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
                                <div class="row">
                                    <h4>Primary Information</h4>
                                    <div id="addHWMessage"></div>
                                    <div class="col-6">
                                        <dd class='col-sm-12'>
                                            <div class="">Region</div>
                                            <div>
                                                <div id="hardwareRegionModal"></div>
                                            </div>
                                        <dd class="col-sm-12">
                                            <div class="">Site Name</div>
                                            <select class="form-select" name="hardwareSiteModal" id="hardwareSiteModal" disabled>
                                                <option value="" selected></option>
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
                                                <option value="" selected></option>
                                            </select>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Model</div>
                                            <select class="form-select" name="itemModel" id="itemModel" disabled>
                                                <option value="" selected></option>
                                            </select>
                                        </dd>
                                    </div>
                                    <div class="col-6">
                                        <dd class="col-sm-12">
                                            <div class="">Asset No.:</div>
                                            <input type="text" class="form-control" name="asset_num" id="asset_num" required>
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="">Serial No.</div>
                                            <input type="text" class="form-control" name="serial_num" id="serial_num" required>
                                        </dd>
                                        <dt class="">Date Deployed:</dt>
                                        <dd class="d-flex col-sm-12">
                                            <input class="form-control" type="date" id="date" name="date" required>
                                            <!-- <input type="date" class="form-control datepicker-input" name="date_acquired" id="datepicker" placeholder="" readonly required> -->
                                        </dd>
                                        <dd class="col-sm-12">
                                            <div class="" hidden>Acquired Value</div>
                                            <input class="form-control" type="text" name="acquired_value" id="acquired_value" placeholder="" value="-" hidden>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addNewHardwareBtn">Save</button>
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


<!---Edit Modal---->

<div class="modal fade" id="hardwareModalInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCPUHardwareLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">
                        <i class="fa fa-info-circle"></i> Update Details
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="">
                        <div class="container">
                            <div id="addMessage"></div>
                            <div class="row">
                                <div class="col-12">
                                    <dd class='col-sm-12'>
                                        <input name="edit_hw_id" type="hidden" disabled>
                                        <div class="sr-only">Region</div>
                                        <input type="text" class="form-control" name="edit_hw_region_name" disabled>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="sr-only">Site Name</div>
                                        <input class="form-control" name="edit_site_name_input" id="viewSiteSelect" disabled>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="sr-only">Brand</div>
                                        <select class="form-select" name="edit_brand_name" onchange="showHardwareModel()" id="edit_brandSelect"></select>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="sr-only">Model</div>
                                        <select class="form-select" name="edit_model_name" id="edit_model_option"></select>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="sr-only">Acquired Value</div>
                                        <input class="form-control" type="text" name="edit_acquired_value" placeholder="Acquired Value">
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="sr-only">Asset No.:</div>
                                        <input type="text" class="form-control" name="edit_asset_num" placeholder="Asset Number" required>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="sr-only">Serial No.</div>
                                        <input type="text" class="form-control" name="edit_serial_num" placeholder="Serial Number" required>
                                    </dd>
                                    <dt class="sr-only">Date Acquired:</dt>
                                    <dd class="d-flex col-sm-12">
                                        <input type="text" id="datepicker" class="form-control datepicker-input" name="edit_date_acquired" placeholder="Date Acquired" readonly required>
                                    </dd>
                                    <?php
                                        $user_type = $_SESSION['sess_user_type'];
                                        if($user_type == "ADM" || $user_type == "SPV"){
                                            echo "";
                                        }else{
                                            echo "<dd class='col-sm-12'>
                                                        <select class='form-select' name='hardware_status_option'>
                                                            <option value='' selected disabled>Select Status</option>
                                                            <option value='On Site'>On Site</option>
                                                            <option value='Pull Out'>Pull out</option>
                                                        </select>
                                                    </dd>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="updateHardwareBtn">Save Update</button>
                    <button type="submit" class="btn btn-warning disabled" id="displayHardwareValidation">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Saving...
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!--Tracking Modal-->
<div class="modal" id="trackingModal" tabindex="-1" aria-labelledby="trackingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Action Required</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="containter">
                    <div class="row">
                        <dd class="col-sm-12">
                            <div class='alert alert-warning alert-dismissible fade show' role='alert' id='warning-pullout'></div>
                        </dd>
                        <dd class="col-sm-12">

                            <div class="sr-only">Date pulled out:</div>
                            <input type="text" id="datepicker" class="form-control datepicker-input" name="edit_date_pullout" placeholder="Date pulled out" readonly required>
                            <div id="date_required" class="text-danger"></div>
                        </dd>
                        <dd class="col-sm-12">
                            <div class="sr-only">Tracking number:</div>
                            <input type="hidden" class="form-control" name="hw_id_pullout" disabled required>
                            <input type="text" class="form-control" name="tracking_num" placeholder="Add tracking number here..." required>
                            <div id="tracking_required" class="text-danger"></div>
                        </dd>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="pullout-button">Proceed</button>
            </div>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>
