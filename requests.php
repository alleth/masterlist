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
                                        <button class='btn btn-primary me-md-2' type='button'>
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

<?php include 'includes/components.php'; ?>
<script src="js/request-hw.js?v=<?= time()?>" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>