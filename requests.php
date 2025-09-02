<?php
include("includes/header.php");

// Maintenance mode flag (set to true when under maintenance)
$maintenance_mode = false; // Change to false to disable maintenance mode

if ($maintenance_mode) {
    // Include the coming-soon.php file for maintenance page
    include("coming-soon.php");
    exit; // Stop further execution
}

// Proceed with normal page if not in maintenance mode
$user_type = $_SESSION['sess_user_type'];
?>
    <style>
        .carousel-inner {
            min-height: 200px;
        }

        .carousel-item {
            padding-right: 30px;
            padding-left: 30px;
            padding-bottom: 30px;
        }

        /* Progress Line + Dots */
        .progress-guide {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin-bottom: 20px;
        }

        .progress-guide::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 15px;
            right: 15px;
            height: 4px;
            background: #dee2e6;
            z-index: 0;
            transform: translateY(-50%);
        }

        .progress-dot {
            position: relative;
            width: 20px;
            height: 20px;
            background: #dee2e6;
            border-radius: 50%;
            z-index: 1;
            transition: background-color 0.3s ease;
        }

        .progress-dot.active {
            background: #14B8A6;
        }

        .progress-line-fill {
            position: absolute;
            top: 50%;
            left: 15px;
            height: 4px;
            background: #14B8A6;
            z-index: 0;
            transform: translateY(-50%);
            transition: width 0.3s ease;
            width: 0;
        }
        .toast {
            transition: opacity 0.5s ease-in-out;
        }
        #leaveReason{
            resize: none;
        }
    </style>


<main>
    <div class="container-fluid px-4">
        <h4 class="mt-4">Requests</h4>
        <div class="row mt-3">
            <div class="col-lg-12">
                <!-- Bootstrap Nav Tabs -->
                <ul class="nav nav-tabs" id="requestTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pullout-tab" data-bs-toggle="tab" data-bs-target="#pullout" type="button" role="tab" aria-controls="pullout" aria-selected="true">Pullout</button>
                    </li>

                    <?php
                        if ($user_type == "SPV" || $user_type == "ADM") {
                            echo "<li class='nav-item' role='presentation'>
                                    <button class='nav-link' id='deploy-tab' data-bs-toggle='tab' data-bs-target='#deploy' type='button' role='tab' aria-controls='deploy' aria-selected='false'>Deploy</button>
                                </li>";
                        }
                    ?>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="relocation-tab" data-bs-toggle="tab" data-bs-target="#relocation" type="button" role="tab" aria-controls="relocation" aria-selected="false">Relocation</button>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content" id="requestTabsContent">
                    <!-- Pullout Tab -->
                    <div class="tab-pane fade show active" id="pullout" role="tabpanel" aria-labelledby="pullout-tab">
                        <?php
                            if ($user_type == "SPV" || $user_type == "ADM") {
                                echo "";
                            }else{
                                echo"
                                    <div class='d-grid gap-2 d-md-flex mt-3'>
                                        <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#slidePulloutModal'>
                                            <i class='fa fa-plus'></i> Create
                                        </button>
                                    </div>
                                ";
                            }
                        ?>

                        <div class="card border border-dark-subtle shadow-sm mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="requestDisplay" class="table table-sm">
                                        <thead class="text-muted">
                                        <tr>
                                            <th>No.</th>
                                            <th>Date Requested</th>
                                            <th>Requested By</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="requestList">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted fst-italic">You do not have a request...</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Deploy Tab -->
                    <div class="tab-pane fade" id="deploy" role="tabpanel" aria-labelledby="deploy-tab">
                        <div class="card border border-dark-subtle shadow-sm mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="deployDisplay" class="table table-sm">
                                        <thead class="text-muted">
                                        <tr>
                                            <th>No.</th>
                                            <th>Date Requested</th>
                                            <th>Requested By</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="deployList">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted fst-italic">You do not have a deploy request...</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Relocation Tab -->
                    <div class="tab-pane fade" id="relocation" role="tabpanel" aria-labelledby="relocation-tab">
                        <div class="card border border-dark-subtle shadow-sm mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="relocationDisplay" class="table table-sm">
                                        <thead class="text-muted">
                                        <tr>
                                            <th>No.</th>
                                            <th>Date Requested</th>
                                            <th>Requested By</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="relocationList">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted fst-italic">You do not have a relocation request...</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5"></div>
    </div>
</main>

<!--Delete Modal (Shared for all tabs)-->
<div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Confirm Deletion</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <input type="hidden" name="idDelete">
                    <input type="hidden" name="requestType">
                    <div class="row">
                        <p>This request will be deleted permanently. Proceed?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteButton">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<!--View Modal (Shared for all tabs)-->
<div class="modal fade" id="viewDetailsRequest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewDetailsRequestLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="viewDetailsRequestLabel">
                    <i class="fa fa-info-circle"></i> View Request
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="item_id">
                        <input type="hidden" name="statMess">
                        <input type="hidden" name="requestType">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tbody id="viewFullDetailsRequest">
                                </tbody>
                            </table>
                            <?php
                            if ($user_type == "SPV" || $user_type == "ADM") {
                                echo "<p class='fw-light'>Note: Approval is subject to confirmation of hardware receipt.***</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div id="viewButtons">
                    <?php
                    if ($user_type == "SPV" || $user_type == "ADM") {
                        echo "<button title='Decline' class='btn btn-outline-danger' id='declineItem'><span class='fas fa-minus-circle'></span> Decline</button>
                                  <button title='Approve' class='btn btn-outline-success' id='approveRequest'><strong><span class='fa fa-check'></span></strong> Receive</button>";
                    } else {
                        echo "<button title='Delete' class='btn btn-outline-danger' id='deleteItem'><span class='fas fa-trash-alt'></span> Delete</button>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Decline Modal (Shared for all tabs)-->
<div class="modal" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Decline Request</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <input type="hidden" name="idDecline">
                    <input type="hidden" name="requestType">
                    <div class="row">
                        <div class="mb-3">
                            <label for="leaveRemarks" class="form-label">Leave a remark:</label>
                            <textarea class="form-control" id="leaveRemarks" name="remarks" rows="3" maxlength="60"></textarea>
                            <div class="form-text"><span id="charCount">60</span> characters remaining</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="declineRequest">Proceed</button>
            </div>
        </div>
    </div>
</div>

<!--Receive Modal (Shared for all tabs, corrected title)-->
<div class="modal" id="receiveModal" tabindex="-1" aria-labelledby="receiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Receive Request</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <input type="hidden" name="idReceive">
                    <input type="hidden" name="requestType">
                    <div class="row">
                        <div class="mb-3">
                            <label for="receiveRemarks" class="form-label">Leave a remark (optional):</label>
                            <textarea class="form-control" id="receiveRemarks" name="remarks" rows="3" maxlength="60"></textarea>
                            <div class="form-text"><span id="receiveCharCount">60</span> characters remaining</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="receiveRequest">Proceed</button>
            </div>
        </div>
    </div>
</div>

    <!-- Pullout Modal -->
    <div class="modal fade" id="slidePulloutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Request Pullout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Slide Guide -->
                    <div class="progress-guide px-2 mt-2">
                        <div class="progress-line-fill"></div>
                        <div class="progress-dot" data-step="0"></div>
                        <div class="progress-dot" data-step="1"></div>
                        <div class="progress-dot" data-step="2"></div>
                        <div class="progress-dot" data-step="3"></div>
                    </div>
                    <!-- Slides -->
                    <div id="carouselSlides" class="carousel slide" data-bs-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active mt-1">
                                <h5>1. Select hardware to pullout</h5>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <select class="form-select" name="hw_type" id="">
                                                    <option value="" selected disabled>Select type of hardware</option>
                                                    <option value="CPU-Server" >Server</option>
                                                    <option value="UPS-SERVER" >UPS-Server</option>
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
                                            <div class="col-auto">
                                                <select class="form-select" name="site_list" id="site_list">
                                                    <option value="" selected disabled>Select a site</option>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-primary" id="show-hardware">
                                                    <i class='fa fa-search'></i> Show
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <table id="hardwareToPullout" class="table table-striped table-sm">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Model</th>
                                                <th scope="col">Asset No.</th>
                                                <th scope="col">Serial No.</th>
                                                <th scope="col" style="text-align: center;">
                                                    <label for="">Select All</label> <input type="checkbox" id="selectAllHardware" class="form-check-input">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="hardwareToPulloutDisplay">
                                        <td id="rowdisplay" colspan="5" class="text-muted text-center fst-italic">Please select hardware type and site...</td>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="carousel-item">
                                <h5>2. Add details</h5>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-label">SR no.:</label>
                                                <input type="text" class="form-control" id="srNumber" placeholder="Enter your SR No.">
                                            </div>
                                            <div class="col">
                                                <label class="form-label">Date of pull out:</label>
                                                <input class="form-control" type="date" id="date" name="date" required>
                                            </div>
                                            <div class="mt-3">
                                                <label for="receiveRemarks" class="form-label">Reason of pull out:</label>
                                                <textarea class="form-control" resize="none" id="leaveReason" name="reasonPullout" rows="3" maxlength="60"></textarea>
                                                <div class="form-text"><span id="reasonCharCount">60</span> characters remaining</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <h5>3. Select delivery option</h5>
                                <p>This is the third slide.</p>
                            </div>
                            <div class="carousel-item">
                                <h4>Slide 4</h4>
                                <p>This is the final slide.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button id="prevBtn" class="btn btn-primary" disabled>Previous</button>
                    <button id="nextBtn" class="btn btn-primary">Next</button>
                </div>

            </div>
        </div>
    </div>

    <!--Toast-->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Saved successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>


<?php include 'includes/components.php'; ?>
<script src="js/request-hw.js?v=<?= time()?>" type="text/javascript"></script>
<script src="js/request-pulloutform-hw.js?v=<?= time()?>" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>