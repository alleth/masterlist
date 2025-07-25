<?php 
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h6 class="mt-2 display-6">CPU-PC Softwares</h6>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-2">
                                <select class="form-select" name="CpuPCRegionSelect" id="CpuPCRegionSelect">
                                    <option value="" disabled selected>Select region</option>
                                </select>
                            </div>               
                            <div class="col-md-2">
                                <select class="form-select" name="CpuPCSiteSelect" id="CpuPCSiteSelect" disabled>
                                    <option value="All Site" selected>All Site</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showCPUPCButton">
                                    <i class="fas fa-search"></i> <span class="ms-1">Show</span>
                                </button>
                            </div>
                            <!-- Added wrapper div to push button to the right -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="CPUPCPerSite" class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Region</th>
                                        <th scope="col">Site</th>
                                        <th scope="col">Asset/Serial</th>
                                        <th scope="col">Hostname</th>
                                        <th scope="col">Ip Address</th>
                                        <th scope="col">Mac Address</th>
                                        <th scope="col">Workstep</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="hardwareDisplay">
                                    <td id="rowdisplay" colspan="8" class="text-muted text-center fst-italic">Please select region and site...</td>
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
<?php include 'includes/components.php'; ?>
<script src="js/datepicker.min.js" type="text/javascript"></script>
<script src="js/hardware.js" type="text/javascript"></script>
<script src="js/cpu-pc-software.js" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>
