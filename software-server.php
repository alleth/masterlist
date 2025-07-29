<?php 
include("includes/header.php");
?>
<main>
    <div class="container-fluid px-4">
        <h6 class="mt-2 display-6">Server Softwares</h6>

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
                                        <th scope="col">Operating System</th>
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

    <!-- Utilitites Edit Modal ------------------->
     <!-- Edit CPU-PC Modal -->
<div class="modal modal-lg fade" id="EditCpuPcModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditCpuPcModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="row g-3 needs-validation" id="editCpuPcForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EditCpuPcModalLabel">Update CPU-PC Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editCpuPcId" name="hw_id">

                    <div id="cpuPc_edit">
                        <div class="container">
                            <div class="row">
                                <div id="editCpuPcMessage"></div>

                                <div class="col-6">
                                    <dd class="col-sm-12">
                                        <div>Hostname</div>
                                        <input type="text" class="form-control" id="editCpuPcRegion" name="region">
                                    </dd>

                                    <dd class="col-sm-12">
                                        <div>IP Address</div>
                                        <input type="text" class="form-control" id="editCpuPcSite" name="site">
                                    </dd>

                                    <dd class="col-sm-12">
                                        <div>Operating System</div>
                                        <!-- <input type="text" class="form-control" id="editCpuPcItem" name="item_desc"> -->
                                        <select class="form-select" name="item_desc" id="editCpuPcItem">
                                            <option value="" selected>Select Operating System</option>
                                            <option value="Windows XP">Windows XP</option>
                                            <option value="Windows 10 32Bit">Windows 10 32Bit</option>
                                            <option value="Windows 10 64Bit">Windows 10 64Bit</option>
                                            <option value="Windows 11 64Bit">Windows 11 64Bit</option>
                                        </select>
                                    </dd>
                                    <!--
                                    <dd class="col-sm-12">
                                        <div>Title</div>
                                        <input type="text" class="form-control" id="" name="">
                                    </dd>

                                    <dd class="col-sm-12">
                                        <div>Title</div>
                                        <input type="text" class="form-control" id="" name="">
                                    </dd>
                                    -->
                                </div>

                                <div class="col-6">
                                    <dd class="col-sm-12">
                                        <div>WorkStep</div>
                                        <input type="text" class="form-control" id="editCpuPcAssetNum" name="asset_num">
                                    </dd>

                                    <dd class="col-sm-12">
                                        <div>Mac Address</div>
                                        <input type="text" class="form-control" id="editCpuPcSerial" name="serial_num">
                                    </dd>
                                    <!--
                                    <dd class="col-sm-12">
                                        <div></div>
                                        <input class="form-control" type="date" id="editCpuPcDate" name="date">
                                    </dd>

                                    <dd class="col-sm-12">
                                        <div>title</div>
                                        <input type="text" class="form-control" id="editCpuPcStatus" name="hardware_status">
                                    </dd>

                                    <dd class="col-sm-12">
                                        <div hidden>Title</div>
                                        <input class="form-control" type="text" id="editCpuPcAcquiredValue" name="acquired_value">
                                    </dd>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning w-400" id="updateCpuPcBtn">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

</main>
<?php include 'includes/components.php'; ?>
    <script src="js/hardware.js?v=<?= time() ?>" type="text/javascript"></script>
    <script src="js/cpu-pc-software.js?v=<?= time() ?>" type="text/javascript"></script>
    <script src="js/datepicker.min.js?v=<?= time() ?>" type="text/javascript"></script>
    <script src="js/inactivity.js.js?v=<?= time() ?>"></script>
<?php include 'includes/footer.php'; ?>
