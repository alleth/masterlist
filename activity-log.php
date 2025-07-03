<?php
include("includes/header.php");
?>

<main>
    <div class="container-fluid px-4">
        
        <div class="row">
            <div class="container mt-4">
                <h4 class="mb-3">Activity Log</h4>
                <div class="table-responsive">
                    <table id="activity_tbl" class="table table-striped">
                        <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Activity</th>
                            <th>User</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody id="viewLogs">
                        <tr>
                            <td colspan="5" class="text-center text-muted">You do not have any activity yet.</td>
                        </tr>
                        <!--<tr>
                            <td>2025-01-10</td>
                            <td>Device Added</td>
                            <td>John Doe</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2025-01-11</td>
                            <td>Device Removed</td>
                            <td>Jane Smith</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>2025-01-12</td>
                            <td>Warranty Expired</td>
                            <td>System</td>
                            <td><span class="badge bg-danger">Failed</span></td>
                        </tr>
                        <tr>
                            <td>2025-01-13</td>
                            <td>Device Repaired</td>
                            <td>Michael Brown</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</main>


<?php include("includes/footer.php"); ?>
