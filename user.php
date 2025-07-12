<?php
include ("check_restriction.php");
include("includes/header.php");

?>
<main>
    <div class="container-fluid px-4">
        <h5 class="mt-4"> <i class="fa fa-users"></i> User Management</h5>
        <ol class="breadcrumb mb-4">

        </ol>
        <div class="row mt-3">
            <div class="col-lg-12">
                    <div class="card p-4 shadow-sm">
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="fa fa-user-plus"></i> Add User</button>
                        </div>

                        <table class="table table-bordered mb-0" id="userTable">
                            <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Region</th>
                                <th>Cluster</th>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center text-muted fst-italic">No user display.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                <!-- Modal -->
                <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content border-0 shadow-sm rounded-3">
                            <div class="modal-header bg-primary text-white rounded-top-3">
                                <h5 class="modal-title" id="userModalLabel">Add New User</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body px-4 py-3">
                                <form id="userForm">
                                    <input type="hidden" name="id" id="userId">

                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label for="fname" class="form-label">First Name</label>
                                            <input type="text" class="form-control form-control-sm" id="fname" name="fname" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control form-control-sm" id="lname" name="lname" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="user_type" class="form-label">User Type</label>
                                            <select class="form-select form-select-sm" id="user_type" name="user_type" required>
                                                <option value="" selected disabled>Select User Type</option>
                                                <?php
                                                $user_type = $_SESSION['sess_user_type'];
                                                if($user_type != "FSE" || $user_type != "SPV"){
                                                    echo `<option value="ADM">Administrator</option>`;
                                                }else{
                                                    echo "";
                                                }
                                                ?>
                                                <option value="SPV">Supervisor</option>
                                                <option value="FSE">FSE</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cluster" class="form-label">Assign Cluster</label>
                                            <select class="form-select form-select-sm" id="cluster" name="cluster_name" required>
                                                <option value="" selected disabled>Select Cluster</option>
                                                <option value="NCR">NCR</option>
                                                <option value="Luzon">Luzon</option>
                                                <option value="VisMin">Vismin</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="region" class="form-label">Region Assigned</label>
                                            <select class="form-select form-select-sm" id="region" name="region_assigned" required>
                                                <option value="" selected disabled>Select Region</option>
                                                <option value="1">NCR</option>
                                                <option value="2">Region 1</option>
                                                <option value="3">Region 2</option>
                                                <option value="4">Region 3</option>
                                                <option value="5">Region 4-A</option>
                                                <option value="6">Region 4-B</option>
                                                <option value="7">Region 5</option>
                                                <option value="8">Region 6</option>
                                                <option value="9">Region 7</option>
                                                <option value="10">Region 8</option>
                                                <option value="11">Region 9</option>
                                                <option value="12">Region 10</option>
                                                <option value="13">Region 11</option>
                                                <option value="14">Region 12</option>
                                                <option value="15">BARMM</option>
                                                <option value="16">CAR</option>
                                                <option value="17">CARAGA</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control form-control-sm" id="username" name="user_name" required>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control form-control-sm" id="password" name="user_pass" required>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer bg-light border-top-0 px-4 py-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm px-3" id="saveUser">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </div>
</main>

<?php include 'includes/components.php'; ?>
    <script src="js/user-tab.js" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>