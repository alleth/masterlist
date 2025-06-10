<?php 
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h6 class="mt-2 display-6">CPU-PC Softwares</h6>

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
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showHwButton" disabled>
                                    <i class="fas fa-search"></i> <span class="ms-1">Show</span>
                                </button>
                            </div>
                            <!-- Added wrapper div to push button to the right -->
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
                                        <th scope="col">Asset/Serial</th>
                                        <th scope="col">Hostname</th>
                                        <th scope="col">Ip Address</th>
                                        <th scope="col">Mac Address</th>
                                        <th scope="col">Workstep</th>
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
                                        <div class="">Region</div>
                                        <input type="text" class="form-control" name="edit_hw_region_name" disabled>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="">Site Name</div>
                                        <input class="form-control" name="edit_site_name_input" id="viewSiteSelect" disabled>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="">Brand</div>
                                        <select class="form-select" name="edit_brand_name" onchange="showHardwareModel()" id="edit_brandSelect"></select>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="">Model</div>
                                        <select class="form-select" name="edit_model_name" id="edit_model_option"></select>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="">Acquired Value</div>
                                        <input class="form-control" type="text" name="edit_acquired_value" placeholder="Acquired Value">
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="">Asset No.:</div>
                                        <input type="text" class="form-control" name="edit_asset_num" placeholder="Asset Number" required>
                                    </dd>
                                    <dd class="col-sm-12">
                                        <div class="">Serial No.</div>
                                        <input type="text" class="form-control" name="edit_serial_num" placeholder="Serial Number" required>
                                    </dd>
                                    <dt class="">Date Acquired:</dt>
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


<?php include 'includes/components.php'; ?>
<script src="js/datepicker.min.js" type="text/javascript"></script>
<script src="js/hardware.js" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>
