<?php
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h4 class="mt-4">Facilities</h4>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <select class="form-select" id="regionSelect">
                                    <option value="all">All Region</option>
                                    <!-- You can populate regions dynamically via JS or PHP -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" id="showFacButton">
                                    <i class="fas fa-search"></i> Show
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="hardwarePerSite" class="table table-striped table-bordered">
                                <thead class="table-dark">
                                <tr>
                                    <th>Site Name</th>
                                    <th>Node Count</th>
                                    <th>Node Working</th>
                                    <th>Node Defective</th>
                                    <th>Node Available</th>
                                    <th>Outlet Count</th>
                                    <th>Outlet Working</th>
                                    <th>Outlet Defective</th>
                                    <th>Outlet Available</th>
                                    <th>Connection Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="facilitiesDisplay">
                                    <tr>
                                        <td colspan="12" class="text-center text-muted fst-italic">Please select region and click "Show"</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Site Modal -->
        <div class="modal fade" id="EditHardwareModal" tabindex="-1" aria-labelledby="EditHardwareModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="editHardwareForm" class="needs-validation" novalidate>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditHardwareModalLabel">Edit Site Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="site_id" id="editSiteId">

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="editRegionId" class="form-label">Region ID</label>
                                    <input type="text" class="form-control" id="editRegionId" name="region_id" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="editPhysicalSiteCount" class="form-label">Physical Site Count</label>
                                    <input type="number" class="form-control" id="editPhysicalSiteCount" name="physical_site_count" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="editNodeCount" class="form-label">Node Count</label>
                                    <input type="number" class="form-control" id="editNodeCount" name="node_count" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="editNodeWorking" class="form-label">Node Working</label>
                                    <input type="number" class="form-control" id="editNodeWorking" name="node_working" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="editNodeDefective" class="form-label">Node Defective</label>
                                    <input type="number" class="form-control" id="editNodeDefective" name="node_defective" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="editNodeAvailable" class="form-label">Node Available</label>
                                    <input type="number" class="form-control" id="editNodeAvailable" name="node_available" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="editOutletCount" class="form-label">Outlet Count</label>
                                    <input type="number" class="form-control" id="editOutletCount" name="outlet_count" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="editOutletWorking" class="form-label">Outlet Working</label>
                                    <input type="number" class="form-control" id="editOutletWorking" name="outlet_working" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="editOutletDefective" class="form-label">Outlet Defective</label>
                                    <input type="number" class="form-control" id="editOutletDefective" name="outlet_defective" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="editOutletAvailable" class="form-label">Outlet Available</label>
                                    <input type="number" class="form-control" id="editOutletAvailable" name="outlet_available" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Toast for success -->
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="successToast" class="toast text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">Site information updated successfully!</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (optional, if you use modals/toasts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your custom JS -->
<script src="js/site_list.js?v=<?= time() ?>"></script>


<?php include 'includes/footer.php'; ?>
