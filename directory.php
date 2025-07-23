<?php
    include("includes/header.php");

    $user_type = $_SESSION['sess_user_type'];
?>
<main>
    <div class="container-fluid px-4">
        <h4 class="mt-4">Directory</h4>
        <!-- Dashboard Cards Row -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
            <div class="col">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Site with Server</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">0 / 0</div>
                            </div>
                            <i class="fas fa-server fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">DLRO</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                            </div>
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Proponents</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                            </div>
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-left-primary shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Licensing Center</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                            </div>
                            <i class="fas fa-id-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-4">
            <div class="col-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-2">
                                <div id="displayRegionFilter"></div>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="office_type" onchange="directory_site_name()" id="viewSiteDirectory" disabled>
                                    <option value="all_office" selected>All type of Office</option>
                                    <option value="District Office">District Office</option>
                                    <option value="Extension Office">Extension Office</option>
                                    <option value="DLRO">DLRO - Driver's License Regional Office</option>
                                    <option value="Regional Office">Regional Office</option>
                                    <option value="Operations Division">Operations Division</option>
                                    <option value="NRU"><strong>NRU</strong> - New Registration Unit</option>
                                    <option value="MAIDRS">MAIDRs - Manufacturers, Assemblers, Importers, Rebuilders, and Delears</option>
                                    <option value="Licensing Center">Licensing Center</option>
                                    <option value="E-Patrol">E-Patrol</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showDirectory" disabled>
                                    <i class="fas fa-search"></i> <span class="ms-1">Show</span>
                                </button>
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end justify-content-center" >
                                <button class="btn btn-success" id="btnAddOffice">
                                    <i class="fas fa-plus-circle"></i> Add Site
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Directory -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="directoryTable">
                                <thead class="table-dark">
                                <tr>
                                    <th>Region</th>
                                    <th>Office Type</th>
                                    <th>Site Code</th>
                                    <th>Site Name</th>
                                    <th>Address</th>
                                    <th>Ownership</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="directoryDisplay">
                                    <tr>
                                        <td colspan="7" class="text-muted text-center">
                                            <i>Please select region and click show.</i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- End of Table Responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Container -->
</main>

<!-- Add Site Modal -->
<div class="modal fade" id="addOfficeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserBtn" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addSiteForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSiteTitle">Add New LTO Office </h1>
                    <h1 class="modal-title fs-5" id="updateSiteTitle">Update LTO Office </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <h4>Site Information</h4>
                            <div id="addMessage"></div>
                            <div class="col-12 mb-3">
                                <input type="hidden" name="site_id_val" id="site_id_val">
                                <div id="displayModalRegion"></div>
                            </div>
                            <div class="col-12">
                                <input class="form-control mb-3" name="site_code" type="text" placeholder="Site Code" required>
                            </div>
                            <div class="col-12">
                                <input class="form-control mb-3" name="site_name" type="text" placeholder="Site Name" required>
                            </div>
                            <div class="col-12">
                                <select class="form-select mb-3" name="modal_office_type" onchange="selectAssignment()" required>
                                    <option value="" selected>All type of Office</option>
                                    <option value="District Office">District Office</option>
                                    <option value="Extension Office">Extension Office</option>
                                    <option value="DLRO">DLRO - Driver's License Regional Office</option>
                                    <option value="Regional Office">Regional Office</option>
                                    <option value="Operations Division">Operations Division</option>
                                    <option value="NRU"><strong>NRU</strong> - New Registration Unit</option>
                                    <option value="MAIDRS">MAIDRs - Manufacturers, Assemblers, Importers, Rebuilders, and Delears</option>
                                    <option value="Licensing Center">Licensing Center</option>
                                    <option value="E-Patrol">E-Patrol</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="multi-select-container mb-3">
                                    <div class="form-select d-flex justify-content-between align-items-center" onclick="toggleDropdown()" role="button" aria-expanded="false">
                                        <span id="selected-text" class="text-muted">Select transaction catered</span>
                                    </div>
                                    <div id="multi-select-dropdown" class="dropdown-menu w-100" style="display: none; max-height: 200px; overflow-y: auto;">
                                        <div class="dropdown-item d-flex align-items-center" onclick="toggleSelection('MV')" style="font-weight: 400; cursor: pointer;" data-value="MV">
                                            MV Registration
                                            <span class="checkmark text-primary ms-auto fa fa-check" style="display: none; font-weight: 400;"></span>
                                        </div>
                                        <div class="dropdown-item d-flex align-items-center" onclick="toggleSelection('DL')" style="font-weight: 400; cursor: pointer;" data-value="DL">
                                            Driver's License
                                            <span class="checkmark text-primary ms-auto fa fa-check" style="display: none; font-weight: 400;"></span>
                                        </div>
                                        <div class="dropdown-item d-flex align-items-center" onclick="toggleSelection('LETAS')" style="font-weight: 400; cursor: pointer;" data-value="LETAS">
                                            LETAS
                                            <span class="checkmark text-primary ms-auto fa fa-check" style="display: none; font-weight: 400;"></span>
                                        </div>
                                        <div class="dropdown-item d-flex align-items-center" onclick="toggleSelection('MAIDRS')" style="font-weight: 400; cursor: pointer;" data-value="MAIDRS">
                                            MAIDRS
                                            <span class="checkmark text-primary ms-auto fa fa-check" style="display: none; font-weight: 400;"></span>
                                        </div>
                                        <div class="dropdown-item d-flex align-items-center" onclick="toggleSelection('NRU')" style="font-weight: 400; cursor: pointer;" data-value="NRU">
                                            MV New Registration
                                            <span class="checkmark text-primary ms-auto fa fa-check" style="display: none; font-weight: 400;"></span>
                                        </div>
                                        <div class="dropdown-item d-flex align-items-center" onclick="toggleSelection('None')" style="font-weight: 400; cursor: pointer;" data-value="None">
                                            None
                                            <span class="checkmark text-primary ms-auto fa fa-check" style="display: none; font-weight: 400;"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <input class="form-control mb-3" name="site_address" type="text" placeholder="Address" required>
                            </div>
                            <div class="col-12">
                                <select class="form-select" name="site_partnership" id="">
                                    <option value="" selected disabled>Select Ownership</option>
                                    <option value="Government">Government</option>
                                    <option value="Proponent">Proponent</option>
                                    <option value="LGU">LGU - Local Government Unit</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addOfficeButton">Save</button>
                    <button class="btn btn-primary" type="button" id="addOfficeButtonDisabled" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <div id="displayValidation">
                        <button type="button" class="btn btn-warning" id="updateOfficeButton">Save Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<br>

<div class="modal" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Dual server set-up</h6>
                System found that the site name and office type already exist. By proceeding, you agree that this office has a dual server setup.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="confirmDecline">Decline</button>
                <button type="button" class="btn btn-primary" id="confirmProceed">Proceed</button>
            </div>
        </div>
    </div>
</div>

<div id="alertMessage" class="alert alert-success floating-alert" style="display: none;"></div>

<?php include 'includes/components.php'; ?>
<script src="js/directory.js?v=<?= time() ?>" type="text/javascript"></script>
<script src="js/inactivity.js.js?v=<?= time() ?>"></script>
<?php include 'includes/footer.php'; ?>
