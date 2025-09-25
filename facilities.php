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
                                    <th>Node Available</th>
                                    <th>Outlet Count</th>
                                    <th>Outlet Available</th>
                                    <th>Port Count</th>
                                    <th>Port Available</th>
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

        <!-- Edit Modal -->
        <div class="modal fade" id="EditFacilitiesModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                
                    <div class="modal-header"> 
                        <h5 class="modal-title">Edit Site Facilities</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editFacilitiesForm">
                            <input type="hidden" id="editSiteId" name="site_id">

                            <div class="row g-3">
                                <!-- Node -->
                                <div class="col-md-3">
                                    <label for="editNodeCount" class="form-label">Node Count</label>
                                    <input type="text" class="form-control" id="editNodeCount" name="node_count">
                                </div>
                                <div class="col-md-3">
                                    <label for="editNodeWorking" class="form-label">Node Working</label>
                                    <input type="text" class="form-control" id="editNodeWorking" name="node_working">
                                </div>
                                <div class="col-md-3">
                                    <label for="editNodeDefective" class="form-label">Node Defective</label>
                                    <input type="text" class="form-control" id="editNodeDefective" name="node_defective">
                                </div>
                                <div class="col-md-3">
                                    <label for="editNodeAvailable" class="form-label">Node Available</label>
                                    <input type="text" class="form-control" id="editNodeAvailable" name="node_available">
                                </div>

                                <!-- Outlet -->
                                <div class="col-md-3">
                                    <label for="editOutletCount" class="form-label">Outlet Count</label>
                                    <input type="text" class="form-control" id="editOutletCount" name="outlet_count">
                                </div>
                                <div class="col-md-3">
                                    <label for="editOutletWorking" class="form-label">Outlet Working</label>
                                    <input type="text" class="form-control" id="editOutletWorking" name="outlet_working">
                                </div>
                                <div class="col-md-3">
                                    <label for="editOutletDefective" class="form-label">Outlet Defective</label>
                                    <input type="text" class="form-control" id="editOutletDefective" name="outlet_defective">
                                </div>
                                <div class="col-md-3">
                                    <label for="editOutletAvailable" class="form-label">Outlet Available</label>
                                    <input type="text" class="form-control" id="editOutletAvailable" name="outlet_available">
                                </div>

                                 <!-- Port -->
                                <div class="col-md-3">
                                    <label for="editPortCount" class="form-label">Port Count</label>
                                    <input type="text" class="form-control" id="editPortCount" name="port_count">
                                </div>
                                <div class="col-md-3">
                                    <label for="editPortWorking" class="form-label">Port Working</label>
                                    <input type="text" class="form-control" id="editPortWorking" name="port_working">
                                </div>
                                <div class="col-md-3">
                                    <label for="editPortDefective" class="form-label">Port Defective</label>
                                    <input type="text" class="form-control" id="editPortDefective" name="port_defective">
                                </div>
                                <div class="col-md-3">
                                    <label for="editPortAvailable" class="form-label">Port Available</label>
                                    <input type="text" class="form-control" id="editPortAvailable" name="port_available">
                                </div>

                                <!-- Electrical -->
                                    <div class="col-md-6">
                                        <label for="editTypeElectricalCon" class="form-label">Electrical Connection Type</label>
                                        <select class="form-select" id="editTypeElectricalCon" name="type_electrical_con">
                                            <option value="">-- Select Connection Type --</option>
                                            <option value="Separate Meter">Separate Meter</option>
                                            <option value="Sub-meter">Sub-meter</option>
                                            <option value="Fixed Sharing">Fixed Sharing</option>
                                            <option value="No Cost">No Cost</option>
                                        </select>
                                    </div>
                               
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveFacilitiesBtn" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Update Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content bg-success text-white text-center">
                <div class="modal-body">
                    <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                    Facilities Updated...
                </div>
                </div>
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
<?php include 'includes/components.php'; ?>
<script src="js/facilities.js?v=<?= time() ?>"></script>
<script src="js/inactivity.js?v=<?= time() ?>"></script>
<?php include 'includes/footer.php'; ?>
