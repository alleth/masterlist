<?php
include("includes/header.php");

$user_type = $_SESSION['sess_user_type'];
?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 display-4">Server</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Hardwares</li>
            </ol>
            <div class="row">

            </div>
        </div>
    </main>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserBtn" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addUserForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Enroll User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div id="addMessage"></div>
                            <div class="row">
                                <h4>User Information</h4>
                                <div class="col-12">
                                    <input class="form-control mb-3" name="f_name" type="text" placeholder="First Name" required>
                                    <input class="form-control mb-3" name="l_name" type="text" placeholder="Last Name" required>
                                    <select class="form-select mb-3" name="user_type" required>
                                        <option value="" disabled selected>Select User Type:</option>
                                        <option value="FSE">FSE</option>
                                        <option value="SPV">Supervisor</option>
                                        <option value="ADM">Administrator</option>
                                    </select>
                                    <input class="form-control mb-3" name="user_name" type="text" placeholder="Username" required>
                                    <label for="regionSelect" class="form-label">Region Assigned:</label>
                                    <div id="viewRegionSelect"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addDetailsUser">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id">
                    <p class="text-black">Are you sure you want to delete this user? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

<?php include("includes/footer.php"); ?>