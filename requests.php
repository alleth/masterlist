<?php
include("includes/header.php");

$user_type = $_SESSION['sess_user_type'];
?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 display-6">Requests</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Impending Hardwares</li>
            </ol>
            <div class="row">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="activity_tbl" class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Requested By</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="requestList">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">You do not have a request...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include("includes/footer.php"); ?>