<?php
include("includes/header.php");

$user_type = $_SESSION['sess_user_type'];

if ($user_type == "ADM" || $user_type == "SPV") {
    $user_id = $_SESSION['sess_id'];
} else {
    echo "<div class='container mt-5'>
                  <div class='alert alert-danger' role='alert' style='max-width: 600px; margin: auto;'>
                      <h4 class='alert-heading text-center'>Access Denied</h4>
                      <p class='mt-3'>You do not have permission to access this page. If you believe this is a mistake, please contact the system administrator for assistance.</p>
                      <hr>
                      <p class='mb-0'>Need help? Visit the <a href='#' class='alert-link'>support page</a> or reach out to the help desk.</p>
                  </div>
              </div>";
    exit;
}
?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 display-4">User Management</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">List and Enroll Users</li>
            </ol>
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" id="addUserBtn">
                        Enroll User &nbsp;<i class="fas fa-plus-circle"></i>
                    </button>
                </div>
                <div class="container mt-5">
                    <div class="table-responsive">
                        <table id="tblUser" class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Cluster</th>
                                <th scope="col">Region Assigned</th>
                                <th scope="col">User Type</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col" colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody id="userList">
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="spinner-grow text-primary" role="status">
                                        <xspan class="sr-only">Loading...</xspan>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                                    <select class="form-select mb-3" name="user_type" onchange="selectAssignment()" required>
                                        <option value="" disabled selected>Select User Type:</option>
                                        <option value="FSE">FSE</option>
                                        <option value="SPV">Supervisor</option>
                                        <option value="ADM">Administrator</option>
                                    </select>
                                    <div id="viewAssignment">
                                        <select class="form-select form-control mb-3" name="assignmentName" id="assignmentSelect" disabled>
                                            <option value="N/A" disabled selected>Please Select Cluster</option>
                                        </select>
                                    </div>
                                    <div id="viewRegionAssignment">
                                        <select class="form-select form-control mb-3" name="regionAssignmentName" id="regionAssignmentSelect" disabled>
                                            <option value="N/A" disabled selected>Select cluster / region assignment</option>
                                        </select>
                                    </div>
                                    <input class="form-control mb-3" name="user_name" type="text" placeholder="Username" required>
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
    <div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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