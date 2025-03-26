<?php include("includes/header.php"); ?>
<main>
    <div class="container-fluid px-4">
        <h6 class="mt-2 display-6">Hardwares</h6>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border border-dark-subtle shadow-sm">
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-2">
                                <div id="displayRegionHW"></div>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="site_name" onchange="directory_site_name()" id="viewSiteOption" disabled>
                                    <option value="all_site" selected>Select Site</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="hw_type" onchange="directory_site_name()" id="viewHwType" disabled>
                                    <option value="all_hw" selected>All hardware</option>
                                    <option value="Server" >Server</option>
                                    <option value="UPS-Server" >UPS-Server</option>
                                    <option value="CPU-PC" >CPU-PC</option>
                                    <option value="Monitor" >Monitor</option>
                                    <option value="UPS-PC" >UPS-PC</option>
                                    <option value="Keyboard" >Keyboard</option>
                                    <option value="Mouse" >Mouse</option>
                                    <option value="Printer" >Printer</option>
                                    <option value="Laserjet" >Laserjet</option>
                                    <option value="Webcam" >Webcam</option>
                                    <option value="Sigpad" >Sigpad</option>
                                    <option value="Router" >Router</option>
                                    <option value="Switch" >Switch</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showHwButton" disabled>
                                    <i class="fas fa-search"></i> <span class="ms-1">Show</span>
                                </button>
                            </div>
                            <!-- Added wrapper div to push button to the right -->
                            <div class="col-md-4 d-flex justify-content-md-end justify-content-center">
                                <button class="btn btn-success justify-content-center align-items-center" data-toggle="modal" data-target="#serverModalInput" id="addServerBtn">
                                    <i class="fas fa-plus-circle"></i>&nbsp;Add Hardware
                                </button>
                            </div>
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
                            <table id="hardwarePerSite" class="table table-striped">
                                <thead class="table-dark">
                                <tr>
                                    <th scope="col">Region</th>
                                    <th scope="col">Site</th>
                                    <th scope="col">Item Description</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Asset No.</th>
                                    <th scope="col">Serial No.</th>
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
<?php include("includes/footer.php"); ?>
