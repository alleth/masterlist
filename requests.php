<?php
include("includes/header.php");

$user_type = $_SESSION['sess_user_type'];
?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 display-6">Requests</h1>
            <ol class="breadcrumb mb-4">

            </ol>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card border border-dark-subtle shadow-sm">
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
            </div>
            <div class="container mt-5"></div>
        </div>
    </main>

    <!--Delete Modal-->
    <div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="trackingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Confirm Deletion</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="containter">
                        <input type="hidden" name="idDelete">
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

    <!---View modal---->
    <div class="modal fade" id="viewDetailsRequest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCPUHardwareLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel">
                            <i class="fa fa-info-circle"></i> View Request
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="">
                            <div class="container">
                                <div id=""></div>
                                <div class="row">
                                    <input type="hidden" name="item_id">
                                    <input type='hidden' name='statMess'>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <tbody id="viewFullDetailsRequest">

                                            </tbody>
                                        </table>
                                        <?php
                                            if($user_type == "SPV" || $user_type == "ADM") {
                                                echo "<p class='fw-light'>Note: Approval is subject to confirmation of hardware receipt.***</p>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="viewButtons">
                            <?php
                            if($user_type == "SPV" || $user_type == "ADM"){
                                echo "<button title='Decline' class='btn btn-outline-danger' id='declineItem'><span class='fas fa-minus-circle'></span> Decline</button>
                                        <button title='Approve' class='btn btn-outline-success' id='approveRequest'><strong><span class='fa fa-check'></span></strong> Receive</button>";
                            }else{
                                echo "<button title='Delete' class='btn btn-outline-danger' id='deleteItem'><span class='fas fa-trash-alt'></span> Delete</button>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <!----Decline modal--->
    <div class="modal" id="declineModal" tabindex="-1" aria-labelledby="trackingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Decline request</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="containter">
                        <input type="hidden" name="idDecline">
                        <div class="row">
                            <div class="mb-3">
                                <label for="leaveRemarks" class="form-label">Leave a remarks:</label>
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

    <div class="modal" id="receiveModal" tabindex="-1" aria-labelledby="receiveModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Decline request</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="containter">
                        <input type="hidden" name="idDecline">
                        <div class="row">
                            <div class="mb-3">
                                <label for="leaveRemarks" class="form-label">Leave a remarks:</label>
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


<?php include("includes/footer.php"); ?>