<?php
include("includes/header.php");
include("hardware-download-modals.php");
?>
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4">Hardware</h4>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-2">
                                    <div id="displayRegionHW"></div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="site_name" onchange="" id="viewSiteOption" disabled>
                                        <option value="all_sites" selected>All Sites</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="hw_type" id="viewHwType">
                                        <option value="all_hw" selected>All hardware</option>
                                        <option value="CPU-Server" >Server</option>
                                        <option value="UPS-Server" >UPS-Server</option>
                                        <option value="CPU-PC" >CPU-PC</option>
                                        <option value="Monitor" >Monitor</option>
                                        <option value="UPS-PC" >UPS-PC</option>
                                        <option value="Keyboard" >Keyboard</option>
                                        <option value="Mouse" >Mouse</option>
                                        <option value="Sigpad" >Signature Pad</option>
                                        <option value="Webcam" >Webcam</option>
                                        <option class="text-muted" disabled>*** Printers ***</option>
                                        <option value="Laserjet">Laserjet</option>
                                        <option value="Inkjet">Inkjet</option>
                                        <option value="Dot Matrix">Dotmatrix</option>
                                        <option value="Deskjet">Deskjet</option>
                                        <option class="text-muted" disabled>*** Network Equipment ***</option>
                                        <option value="Router">Router</option>
                                        <option value="SDWAN">SDWAN</option>
                                        <option value="Switch">Switch</option>
                                        <option value="Modem">Modem</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showHwButton">
                                        <i class="fas fa-search"></i> <span class="ms-1">Show</span>
                                    </button>
                                </div>
                                <div class="col-md-4 d-flex justify-content-md-end justify-content-center">
                                    <?php
                                    $user_type = $_SESSION['sess_user_type'];
                                    if($user_type == "ADM" || $user_type == "SPV"){
                                        echo "";
                                    }else{
                                        echo "
                                            <div class='d-flex gap-2'>
                                                <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#filterModal'>
                                                <i class='fas fa-download'></i> Download
                                            </button>
                                            <button class='btn btn-success justify-content-center align-items-center' data-bs-toggle='modal' data-bs-target='#AddHardwareModal' id='addHardwareButton'>
                                                <i class='fas fa-plus-circle'></i> Add Hardware
                                            </button>
                                            </div>";
                                    }
                                    ?>
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

        <!-- Add Hardware Modal-->
        <div class="modal modal-lg fade" id="AddHardwareModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AddHardwareModal" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" class="row g-3 needs-validation" id="hardwareForm">
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
                                        <div id="addHWMessage"></div>
                                        <div class="col-6">
                                            <dd class="col-sm-12">
                                                <div class="">Region</div>
                                                <select class="form-select addHardwareForm" name="RegionSelect" id="RegionSelect">
                                                    <option value="" disabled selected>Select region</option>
                                                </select>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="">Site Name</div>
                                                <select class="form-select addHardwareForm" name="hardwareSiteModal" id="hardwareSiteModal" disabled>
                                                    <option value="" selected>Select Site</option>
                                                </select>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="">Item Description</div>
                                                <select class="form-select addHardwareForm" name="itemSelect" id="itemSelect">
                                                    <option value="" selected>Select Item</option>
                                                </select>
                                            </dd>
                                            <dd class="col-sm-12 d-none">
                                                <div class="">Sub Type</div>
                                                    <input type="text" class="form-control" id="SubType" name="sub_major_type" readonly>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="">Brand</div>
                                                <select class="form-select addHardwareForm" name="itemBrand" id="itemBrand">
                                                    <option value="" selected>Select Brand</option>
                                                </select>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="">Model</div>
                                                <select class="form-select addHardwareForm" name="itemModel" id="itemModel">
                                                    <option value="" selected></option>
                                                </select>
                                            </dd>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <div class="form-label">Choose Asset Type:</div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="assetType" id="radioPE" value="PE" required>
                                                    <label class="form-check-label" for="typeA">PE</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"  name="assetType" id="radioCI" value="CI">
                                                    <label class="form-check-label" for="typeB">CI</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"  name="assetType" id="radioCI" value="Unreadable">
                                                    <label class="form-check-label" for="typeB">Unreadable</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"  name="assetType" id="radioCI" value="No Tag">
                                                    <label class="form-check-label" for="typeB">No Tag</label>
                                                </div>
                                                </div>
                                            <dd class="col-sm-12">
                                                <div class="">Asset No.: <span id="result" class="text-primary"></span></div>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="prefixText">Type</span>
                                                    <input type="number" class="form-control addHardwareForm" name="asset_num" id="asset_num" required>
                                                </div>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="">Serial No.</div>
                                                <input type="text" class="form-control addHardwareForm" name="serial_num" id="serial_num" required>
                                            </dd>
                                            <dd class="">Date Deployed:</dd>
                                            <dd class="d-flex col-sm-12">
                                                <input class="form-control addHardwareForm" type="date" id="date" name="date" required>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="" hidden>Acquired Value</div>
                                                <input class="form-control addHardwareForm" type="text" name="acquired_value" id="acquired_value" placeholder="" value="-" hidden>
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-success" id="addNewHardwareBtn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        

        <!-- Edit Hardware Modal -->
        <div class="modal modal-lg fade" id="EditHardwareModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditHardwareModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" class="row g-3 needs-validation" id="editHardwareForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="EditHardwareModalLabel">Update Hardware</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="edit_hw_id" name="hw_id">

                            <div id="hw_edit">
                                <div class="container">
                                    <div class="row">
                                        <div id="editHWMessage"></div>

                                        <div class="col-6">
                                            <dd class="col-sm-12">
                                                <div>Region</div>
                                                <span class="input-group-text d-none" id="editPrefixRegion" style="cursor: pointer;">Click to edit</span>
                                                <span class="input-group-text" id="editPrefixRegionName" style="cursor: pointer;">Click to edit</span>
                                                <select class="form-select d-none" name="editRegionSelect" id="editRegionSelect">
                                                    <option value="" disabled selected>Select region</option>
                                                </select>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div>Site Name</div>
                                                <select class="form-select" name="hardwareSiteModal" id="editHardwareSiteModal" disabled>
                                                    <option value="" selected>Select Site</option>
                                                </select>
                                            </dd>

                                            <dd class="col-sm-12">
                                                <div>Item Description</div>
                                                    <span class="input-group-text" id="editPrefixType" style="cursor: pointer;">Click to edit</span>
                                                    <select class="form-select d-none" name="itemSelect" id="editItemSelect" required>
                                                        <option value="" selected>Select Item</option>
                                                    </select>
                                            </dd>

                                            <dd class="col-sm-12 d-none">
                                                <div class="">Sub Type</div>
                                                    <input type="text" class="form-control" id="editSubType" name="sub_major_type" readonly>
                                            </dd>

                                            <dd class="col-sm-12">
                                                <div>Brand</div>
                                                <select class="form-select" name="itemBrand" id="editItemBrand" required>
                                                    <option value="" selected>Select Brand</option>
                                                </select>
                                            </dd>

                                            <dd class="col-sm-12">
                                                <div>Model</div>
                                                <select class="form-select" name="itemModel" id="editItemModel" required>
                                                    <option value="" selected></option>
                                                </select>
                                            </dd>
                                        </div>

                                        <div class="col-6">
                                            <dd class="col-sm-12">
                                                <div class="mb-3" id="editAssetTypeGroup">
                                                    <div class="form-label">Choose Asset Type:</div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="editAssetType" id="editRadioPE" value="PE" required>
                                                        <label class="form-check-label" for="editRadioPE">PE</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="editAssetType" id="editRadioCI" value="CI">
                                                        <label class="form-check-label" for="editRadioCI">CI</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="editAssetType" id="editRadioUnreadable" value="Unreadable">
                                                        <label class="form-check-label" for="editRadioUnreadable">Unreadable</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="editAssetType" id="editRadioNoTag" value="No Tag">
                                                        <label class="form-check-label" for="editRadioNoTag">No Tag</label>
                                                    </div>
                                                </div>
                                            </dd>
                                    
                                            <dd class="col-sm-12">
                                                <div>Asset No.: <span id="editResult" class="text-primary"></span></div>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="editPrefixText">Type</span>
                                                    <input type="number" class="form-control" name="asset_num" id="editAssetNum" required>
                                                </div>
                                            </dd>
                                            
                                            <dd class="col-sm-12">
                                                <div>Serial No.</div>
                                                <input type="text" class="form-control" name="serial_num" id="editSerialNum" required>
                                            </dd>

                                            <dd class="">Date Deployed:</dd>
                                            <dd class="d-flex col-sm-12">
                                                <input class="form-control" type="date" id="editDate" name="date" required>
                                            </dd>
                                            <dd>
                                                <div>Hardware Status</div>
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
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div hidden>Acquired Value</div>
                                                <input class="form-control" type="text" name="acquired_value" id="editAcquiredValue" placeholder="" value="-" hidden>
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                            <button type="submit" class="btn btn-warning w-400" id="updateHardwareBtn2">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal --->
        <div class="modal fade custom-modal-slide" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-0">Are you sure you want to delete this hardware?</p>
                    <input type="hidden" id="delete_hw_id">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
                </div>
            </div>
        </div>

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
                                                <div class="">Sub Major Type</div>
                                                <select class="form-select" name="edit_sub_major_type" id="edit_sub_major_type">
                                                    <option value="" selected disabled>Select Sub Major Type</option>
                                                    <option value="Server">Server</option>
                                                    <option value="CPUC-PC">CPUC-PC</option>
                                                    <option value="Printers">Printers</option>
                                                    <option value="Network Equipment">Network Equipment</option>
                                                    <option value="UPS">UPS</option>
                                                    <option value="Peripherals">Peripherals</option>
                                                </select>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="">Item Description</div>
                                                <select class="form-select" name="edit_item_desc" id="edit_item_desc"></select>
                                            </dd>
                                            <dd class="col-sm-12">
                                                <div class="">Brand</div>
                                                <select class="form-select" name="edit_brand_name" id="edit_brandSelect"></select>
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


    </main>


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


    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Hardware information updated successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php include 'includes/components.php'; ?>
    <script src="js/hardware.js?v=<?= time() ?>" type="text/javascript"></script>
    <script src="js/hardware-downloadExcelData.js?v=<?= time() ?>" type="text/javascript"></script>
    <script src="js/datepicker.min.js?v=<?= time() ?>" type="text/javascript"></script>
    <script src="js/inactivity.js.js?v=<?= time() ?>"></script>
<?php include 'includes/footer.php'; ?>