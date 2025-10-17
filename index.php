<?php
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/dashboardv3.css">
</head>
<body class="sb-nav-fixed">
<main class="flex-grow-1">
<div class="container-fluid">
    <!-- Header -->
    <div class="row align-items-center page-header sticky-header">
        <div class="col-md-4">
            <h3>Dashboard</h3>
            <div class="text-muted small">Directory & Hardware overview</div>
        </div>

        <div class="col-md-8 text-md-end">
            <div class="row g-2 justify-content-end">
                <div class="col-md-5">
                    <select id="dbregionSelect" class="form-select">
                    </select>
                </div>
                
                <div class="col-md-5">
                    <select id="dbsiteSelect" class="form-select">
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Catered (shown per-site) -->
    <div id="allSiteCard2" class="card mb-4 d-none" hidden>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="18">
                            <p class="card-text" id="mvtxCount" hidden>0</p>
                        </div>
                        <div class="stat-label">Mv Transaction</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="20">
                            <p class="card-text" id="mvnewtxCount" hidden>0</p>
                        </div>
                        <div class="stat-label">New Registration</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="20">
                            <p class="card-text" id="dltxCount" hidden>0</p>
                        </div>
                        <div class="stat-label">Drivers License Transaction</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="2">
                            <p class="card-text" id="dlnewtxCount" hidden>0</p>
                        </div>
                        <div class="stat-label">New Drivers License</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="3">
                            <p class="card-text" id="letastxCount" hidden>0</p>
                        </div>
                        <div class="stat-label">LETAS</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="0">
                            <p class="card-text" id="maidrstxtxCount" hidden>0</p>
                        </div>
                        <div class="stat-label">MAIDRS</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Directory Summary -->
    <div id="allSiteCard" class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box1 text-center">
                        <div class="large-number" data-target="18">
                            <p class="card-text" id="actualSiteCount">0</p>
                        </div>
                        <div class="">Total Sites</div>
                    </div>
                </div>
                 <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box2 text-center">
                        <div class="large-number" data-target="2">
                            <p class="card-text" id="dualServerCount">0</p>
                        </div>
                        <div class="">Dual Server Site</div>
                    </div>
                </div>
                <!--
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box2 text-center">
                        <div class="large-number" data-target="20">
                            <p class="card-text" id="siteCount">0</p>
                        </div>
                        <div class="stat-label">Total Office</div>
                    </div>
                </div>
                -->
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box3 text-center">
                        <div class="large-number" data-target="20">
                            <p class="card-text" id="serverCount">0</p>
                        </div>
                        <div class="">Total Server</div>
                    </div>
                </div>
                <!--

                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box5 text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="3">
                            <p class="card-text" id="governmentCount">0</p>
                        </div>
                        <div class="stat-label">Government</div>
                    </div>
                </div>
                -->
                <!--
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box6 text-center">

                        <div class="large-number" data-target="0">
                            <p class="card-text" id="proponentCount">0</p>
                        </div>
                        <div class="stat-label">Proponent Sites</div>
                    </div>
                </div>
                -->
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box5 text-center">
                        <div class="large-number" data-target="3">
                            <p class="card-text" id="totalCount">0</p>
                        </div>
                        <div class="">Total Hardware</div>
                    </div>
                </div>
            </div>
            <!--Office Type & Transactions -->
            <div class="row g-3 mt-4">
                <!-- Office Type 
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="bi bi-briefcase-fill me-2"></i> Office Type
                        </div>
                        <div class="card-body p-0">
                            <canvas id="officeBarChart" style="height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

            
                
                Transactions Catered
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="bi bi-graph-up-arrow me-2"></i> Transactions Catered
                        </div>
                        <div class="card-body p-0">
                            <canvas id="transactionBarChart" style="height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
                -->
            </div>

        </div> <!-- end card-body Directory -->
    </div> <!-- end Directory card -->

    <!-- Hardware Section (keeps order of your original layout) -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">

                <!-- Left column: Servers / Others / Peripherals -->
                <div class="col-md-3">
                    <div class="card stats-card mb-3">
                        <div class="card-header color-box1 py-2 px-3 d-flex justify-content-between align-items-center">
                            <div><i class="bi bi-server me-1"></i><strong>Servers</strong></div>
                            <strong><p class="card-text mb-0" id="serverCount2"> 0</p></strong> <!-- Header count only -->
                        </div>
                        <div class="stats-item"><div class="stats-label">HP</div><div><p class="card-text" id="serverHpCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">IBM</div><div><p class="card-text" id="serverIbmCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Xitrix</div><div><p class="card-text" id="serverXitrixCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">DELL</div><div><p class="card-text" id="serverDellCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Lenovo</div><div><p class="card-text" id="serverLenovoCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">VM-Server</div><div><p class="card-text" id="VMServerCount">0</p></div></div>
                    </div>

                    <div class="card stats-card mb-3">
                        <div class="card-header color-box2 py-2 px-3">
                            <i class="bi bi-box-seam me-1"></i><strong>Peripherals</strong>
                        </div>
                        <div class="stats-item"><div class="stats-label">Monitor</div><div><p class="card-text" id="monitorCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Keyboard</div><div><p class="card-text" id="keyboardCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Mouse</div><div><p class="card-text" id="mouseCount">0</p></div></div>
                    </div>

                    <div class="card stats-card">
                        <div class="card-header color-box3 py-2 px-3">
                            <i class="bi bi-usb-plug me-1"></i><strong>Peripherals</strong>
                        </div>
                        <div class="stats-item"><div class="stats-label">Webcam</div><div><p class="card-text" id="webcamCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Sigpad</div><div><p class="card-text" id="sigpadCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Scanner</div><div><p class="card-text" id="scannerCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">POS</div><div><p class="card-text" id="posCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">LCD Display</div><div><p class="card-text" id="LCDDisplayCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Cash Drawer</div><div><p class="card-text" id="cashDrawerCount">0</p></div></div>
                    </div>
                </div>

                <!-- Middle column: Workstations / Utilities / Network -->
                <div class="col-md-3">
                    <div class="card stats-card mb-3">
                        <div class="card-header color-box4 py-2 px-3 d-flex justify-content-between align-items-center">
                            <div><i class="bi bi-server me-1"></i><strong>Workstations</strong></div>
                            <strong><p class="card-text mb-0" id="cpuPcCount"> 0</p></strong> <!-- Header count only -->
                        </div>
                        <div class="stats-item"><div class="stats-label">Windows XP</div><div><p class="card-text" id="xpCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Windows 10 32Bit</div><div><p class="card-text" id="w1032bitCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Windows 10 64Bit</div><div><p class="card-text" id="w1064bitCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Windows 11</div><div><p class="card-text" id="w11Count">0</p></div></div>
                    </div>

                    <div class="card stats-card mb-3">
                        <div class="card-header color-box5 py-2 px-3"><i class="bi bi-tools me-1"></i><strong>Utilities</strong></div>
                        <div class="stats-item"><div class="stats-label">RSU Facility</div><div><p class="card-text" id="rsuCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">MV Data Take-On</div><div><p class="card-text" id="mvdtoCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">MV Maintenance</div><div><p class="card-text" id="mvmaintCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">IMS/AIU</div><div><p class="card-text" id="imsaiuCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">DL Data Take-On</div><div><p class="card-text" id="dldtoCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">DL Maintenance</div><div><p class="card-text" id="dlmaintCount">0</p></div></div>
                    </div>

                    <div class="card stats-card">
                        <div class="card-header color-box6 py-2 px-3"><i class="bi bi-ethernet me-1"></i><strong>Network Equipment</strong></div>
                        <div class="stats-item"><div class="stats-label">Switch</div><div><p class="card-text" id="switchCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">SDWAN</div><div><p class="card-text" id="sdwanCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Router</div><div><p class="card-text" id="routerCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Modem</div><div><p class="card-text" id="modemCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Data Cabinet</div><div><p class="card-text" id="dataCabCount">0</p></div></div>
                    </div>
                </div>

                <!-- Right column: Printers & Facilities (with charts + tables) -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header color-box7 py-2 px-3 d-flex justify-content-between align-items-center">
                            <div><i class="bi bi-server me-1"></i><strong>Printers</strong></div>
                            <strong><p class="card-text mb-0" id="printerCount"> 0</p></strong> <!-- Header count only -->
                        </div>

                        <div class="card-body p-0">
                            <div class="small-box m-0 p-0">
                                <table class="table table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <td colspan="2"><strong>LaserJet</strong><br><p class="card-text" id="laserjetCount">0</p></td>
                                            <td><strong>Dot Matrix</strong><br><p class="card-text" id="dotmatrixCount">0</p></td>
                                            <td><strong>InkJet</strong><br><p class="card-text" id="inkjetCount">0</p></td>
                                            <td><strong>DeskJet</strong><br><p class="card-text" id="deskjetCount">0</p></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td >HP 4100 <br><p class="card-text" id="4100Count">0</p></td>
                                            <td>HP 507 <br><p class="card-text" id="507Count">0</p></td>
                                            <td>LX 300 <br><p class="card-text" id="lx300Count">0</p></td>
                                            <td>L310 <br><p class="card-text" id="l310Count">0</p></td>
                                            <td>1280<br><p class="card-text" id="hp1280Count">0</p></td>
                                        </tr>
                                        <tr>
                                            <td>HP 4250 <br><p class="card-text" id="4250Count">0</p></td>
                                            <td>HP 2015 <br><p class="card-text" id="2015Count">0</p></td>
                                            <td>LX310 <br><p class="card-text" id="lx310Count">0</p></td>
                                            <td>L360 <br><p class="card-text" id="l360Count">0</p></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>HP M401 <br><p class="card-text" id="m401Count">0</p></td>
                                            <td>HP 402n <br><p class="card-text" id="402nCount">0</p></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>HP 4003dn <br><p class="card-text" id="4003dnCount">0</p></td>
                                            <td>Others <br><p class="card-text" id="otherprintersCount">0</p></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                            <div class="card-header color-box8">
                                <i class="bi bi-building-check me-1"></i><strong>Facilities</strong>
                            </div>
                            <div class="card-body p-0">
                                <div class="small-box m-0 p-0">
                                    <table class="table table-bordered text-center mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <td></td>
                                                <td>Node</td>
                                                <td>Electrical</td>
                                                <td>Switch Port</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><th scope="row">Total</th><td><p class="card-text" id="nodeCount">0</p></td><td><p class="card-text" id="outlet">0</p></td><td><p class="card-text" id="portCount">0</p></td></tr>
                                            <tr><th scope="row">Working</th><td><p class="card-text" id="ndWorking">0</p></td><td><p class="card-text" id="outletWorking">0</p></td><td><p class="card-text" id="portWorking">0</p></td></tr>
                                            <tr><th scope="row">Available</th><td><p class="card-text" id="ndAvailable">0</p></td><td><p class="card-text" id="outletAvailable">0</p></td><td><p class="card-text" id="portAvailable">0</p></td></tr>
                                            <tr><th scope="row">Defective</th><td><p class="card-text" id="ndDefective">0</p></td><td><p class="card-text" id="outletDefective">0</p></td><td><p class="card-text" id="portDefective">0</p></td></tr>
                                        </tbody>
                                    </table>
                                    <div class="card-footer text-center border-0 bg-transparent p-0 m-0">
                                        <table class="table table-bordered text-center mb-0 mt-3">
                                            <tbody>
                                            <tr>
                                                <td class="p-1" style="background-color: #daecffff;">
                                                    <span class="d-flex justify-content-center align-items-center gap-2" style="font-size: 1rem;">
                                                        Fixed Sharing:
                                                        <span id="fxdSharing" class="card-text">0</span>
                                                    </span>
                                                </td>
                                                <td class="p-1" style="background-color: #fcf0f2ff;">
                                                    <span class="d-flex justify-content-center align-items-center gap-2" style="font-size: 1rem;">
                                                        Separate Meter:
                                                        <span id="seprateMeter" class="card-text">0</span>
                                                    </span>
                                                </td>
                                                <td class="p-1" style="background-color: #eaffe7ff;">
                                                    <span class="d-flex justify-content-center align-items-center gap-2" style="font-size: 1rem;">
                                                        No Cost:
                                                        <span id="noCost" class="card-text">0</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="card">
                        <div class="card-header color-box1">
                            <i class="bi bi-building-check me-1"></i><Strong>Furnitures</Strong>
                        </div>
                        <div class="card-body p-0">
                            <div class="small-box m-0 p-0">
                                <table class="table table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                        <td>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span>Free Standing Table</span>
                                            <span><p class="card-text" id="tableCount">0</p></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span>Office Chair</span>
                                            <span><p class="card-text" id="chairCount">0</p></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <span>Mobile Pedestal Drawer</span>
                                            <span><p class="card-text" id="drawerCount">0</p></span>
                                            </div>
                                        </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div> <!-- end right col -->
            </div> <!-- end hardware row -->
        </div> <!-- end hardware body -->
    </div>
</div>
<?php include 'includes/components.php'; ?>
    <script src="js/dashboardv3.js?v=<?= time() ?>"></script>
    <script src="js/inactivity.js?v=<?= time() ?>"></script>
<?php include 'includes/footer.php'; ?>