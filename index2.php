<?php
require_once "auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Masterfile | Hardware Inventory System</title>
    <!--<link href="css/spinner/bootstrap.min.css" rel="stylesheet" />-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="css/alert-style.css" rel="stylesheet" />
    <link href="icons/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="icons/cube.png" type="image/x-icon">
    <link href="css/datepicker-min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboardv3.css">
    <script src="js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3" href="index.php">Masterfile</a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Content -->
    <ul class="navbar-nav ms-auto align-items-center">
        <!-- Greeting for Wide Screens -->
        <li class="nav-item d-none d-lg-block me-1">
            <span class="navbar-text text-muted small">
                Hello,
                <strong>
                    <?php
                    if (isset($_SESSION['sess_fname'])) {
                        echo htmlspecialchars($_SESSION['sess_fname']); // Escape output for safety
                    } else {
                        echo "Guest"; // Fallback message
                    }
                    ?>
                </strong>!
            </span>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle fa-lg"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <!-- Greeting for Small Screens -->
                <li class="dropdown-item d-lg-none">
                    Hello,
                    <strong>
                        <?php
                        if (isset($_SESSION['sess_fname'])) {
                            echo htmlspecialchars($_SESSION['sess_fname']); // Escape output for safety
                        } else {
                            echo "Guest"; // Fallback message
                        }
                        ?>
                    </strong>!
                </li>
                <li><hr class="dropdown-divider" /></li>
                <!-- Dropdown Links -->
                <li><a class="dropdown-item" href="settings.php"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a class="dropdown-item" href="activity-log.php"><i class="fa fa-history"></i> Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion custom-shadow sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">ANALYTICS</div>
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">ASSET</div>
                    <a class="nav-link" href="hardwares.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-desktop"></i></div>
                        Hardware
                    </a>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseNetwork" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-tag"></i></div>
                        System Tagging
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseNetwork" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="software-server.php"><div class="sb-nav-link-icon"><i class="fas fa-database"></i></div> Server</a>
                            <a class="nav-link" href="software-cpu-pc.php"><div class="sb-nav-link-icon"><i class="fas fa-desktop"></i></div> CPU-PC</a>
                            <a class="nav-link" href="#"><div class="sb-nav-link-icon"><i class="fas fa-network-wired"></i></div> Network Switch</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                        Hardware Status
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="requests.php">Requests</a>
                            <a class="nav-link" href="pullout-hw.php">Pulled Out</a>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Set-up</div>

                    <?php
                        $user_type = $_SESSION['sess_user_type'];
                        if($user_type == "ADM" || $user_type == "SPV"){

                            echo "<a class='nav-link' href='user.php'>
                                        <div class='sb-nav-link-icon'><i class='fa fa-users'></i></div>
                                        Users
                                    </a>";
                            echo "<a class='nav-link' href='hardware-management.php'>
                                    <div class='sb-nav-link-icon'><i class='fas fa-archive'></i></div>
                                    Reference
                                    </a>";
                            if($user_type == "ADM"){
                                echo "<a class='nav-link' href='hardware-database-csv-download.php'>
                                    <div class='sb-nav-link-icon'><i class='fas fa-database'></i></div>
                                    Database Backup
                                    </a>";
                            }
                        }else{
                            echo "";
                        }
                    ?>

                    <a class="nav-link" href="directory.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-store-alt"></i></div>
                        Directory
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php
                    $user_type = $_SESSION['sess_user_type'];
                    if ($user_type == "ADM"){
                        echo "Administrator";
                    }else if($user_type == "SPV"){
                        echo "Supervisor";
                    }else{
                        echo "FSE";
                    }
                ?>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
<main>
<div class="container-fluid mt-0">
    <!-- Header -->
    <div class="row align-items-center page-header">
        <div class="col-md-4">
            <h1 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
            <div class="text-muted small">Directory & Hardware overview</div>
        </div>

        <div class="col-md-8 text-md-end mt-3 mt-md-0">
            <div class="row g-2 justify-content-end">
                <div class="col-md-5">
                    <select id="dbregionSelect" class="form-select">
                        <option value="">All Regions</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select id="dbsiteSelect" class="form-select">
                        <option value="">All Sites</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="scrollable-content">

    <!-- Transactions Catered (shown per-site) -->
    <div id="allSiteCard2" class="card mb-4 d-none">
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
                        <div class="stat-label">New Registrationn</div>
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
                        <div class="stat-icon"><!--<i class="bi bi-hdd-network"></i>--></div>
                        <div class="large-number" data-target="18">
                            <p class="card-text" id="actualSiteCount">0</p>
                        </div>
                        <div class="stat-label">Total Sites</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box2 text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="20">
                            <p class="card-text" id="siteCount">0</p>
                        </div>
                        <div class="stat-label">Total Office</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box3 text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="20">
                            <p class="card-text" id="serverCount">0</p>
                        </div>
                        <div class="stat-label">Total Server</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box4 text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="2">
                            <p class="card-text" id="dualServerCount">0</p>
                        </div>
                        <div class="stat-label">Dual Server Site</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box5 text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="3">
                            <p class="card-text" id="governmentCount">0</p>
                        </div>
                        <div class="stat-label">Government</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-6">
                    <div class="stat-box color-box6 text-center">
                        <div class="stat-icon"></div>
                        <div class="large-number" data-target="0">
                            <p class="card-text" id="proponentCount">0</p>
                        </div>
                        <div class="stat-label">Proponent</div>
                    </div>
                </div>
            </div>

            <!-- nested two columns for Office Type & Transactions -->
            <div class="row g-3 mt-4">
                <!-- Office Type -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="bi bi-briefcase-fill me-2"></i> Office Type
                        </div>
                        <div class="card-body p-0">
                            <canvas id="officeBarChart" style="height: 400px;"></canvas>
                        </div>
                        <!--
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center mb-0">
                                    <tbody>
                                        <tr><td>Regional Office</td><td><p class="card-text" id="roCount">0</p></td></tr>
                                        <tr><td>District Office</td><td><p class="card-text" id="doCount">0</p></td></tr>
                                        <tr><td>Licensing Center</td><td><p class="card-text" id="lcCount">0</p></td></tr>
                                        <tr><td>Extension Office</td><td><p class="card-text" id="eoCount">0</p></td></tr>
                                        <tr><td>New Registration Unit</td><td><p class="card-text" id="nruCount">0</p></td></tr>
                                        <tr><td>MAIDRS</td><td><p class="card-text" id="maidrsCount">0</p></td></tr>
                                        <tr><td>EPATROL</td><td><p class="card-text" id="epatCount">0</p></td></tr>
                                        <tr><td>DLRO</td><td><p class="card-text" id="dlroCount">0</p></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        -->
                    </div>
                </div>

                <!-- Transactions Catered -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="bi bi-graph-up-arrow me-2"></i> Transactions Catered
                        </div>
                        <div class="card-body p-0">
                            <canvas id="transactionBarChart" style="height: 400px;"></canvas>
                        </div>
                        <!--
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped text-center mb-0">
                                    <tbody>
                                        <tr><td>MV Transactions</td><td><p class="card-text" id="mvCount">0</p></td></tr>
                                        <tr><td>MV New</td><td><p class="card-text" id="mvnewCount">0</p></td></tr>
                                        <tr><td>DL Transaction</td><td><p class="card-text" id="dlCount">0</p></td></tr>
                                        <tr><td>DL New</td><td><p class="card-text" id="dlnewCount">0</p></td></tr>
                                        <tr><td>LETAS</td><td><p class="card-text" id="letasCount">0</p></td></tr>
                                        <tr><td>MAIDRS</td><td><p class="card-text" id="maidrstxCount">0</p></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
            </div>

        </div> <!-- end card-body Directory -->
    </div> <!-- end Directory card -->

    <!-- end Directory card -->

    <!-- Hardware Section (keeps order of your original layout) -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">

                <!-- Left column: Servers / Others / Peripherals -->
                <div class="col-md-3">
                    <div class="card stats-card mb-3">
                        <div class="card-header color-box1 py-2 px-3">
                            <i class="bi bi-server me-1"></i> Servers
                        </div>
                        <div class="stats-item">
                            <div class="stats-label"><strong>Total</strong></div>
                            <div> <strong><p class="card-text" id="serverCount2">0</p></strong></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">HP</div>
                            <div><p class="card-text" id="serverHpCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">IBM</div>
                            <div><p class="card-text" id="serverIbmCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Xitrix</div>
                            <div><p class="card-text" id="serverXitrixCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">DELL</div>
                            <div><p class="card-text" id="serverDellCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Lenovo</div>
                            <div><p class="card-text" id="serverLenovoCount">0</p></div>
                        </div>
                    </div>

                    <div class="card stats-card mb-3">
                        <div class="card-header color-box2 py-2 px-3">
                            <i class="bi bi-box-seam me-1"></i> Others
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Monitor</div>
                            <div><p class="card-text" id="monitorCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Keyboard</div>
                            <div><p class="card-text" id="keyboardCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Mouse</div>
                            <div><p class="card-text" id="mouseCount">0</p></div>
                        </div>
                    </div>

                    <div class="card stats-card">
                        <div class="card-header color-box3 py-2 px-3">
                            <i class="bi bi-usb-plug me-1"></i> Peripherals
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Webcam</div>
                            <div><p class="card-text" id="webcamCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Sigpad</div>
                            <div><p class="card-text" id="sigpadCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">POS</div>
                            <div><p class="card-text" id="posCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">LCD Display</div>
                            <div><p class="card-text" id="LCDDisplayCount">0</p></div>
                        </div>
                        <div class="stats-item">
                            <div class="stats-label">Cash Drawer</div>
                            <div><p class="card-text" id="cashDrawerCount">0</p></div>
                        </div>
                    </div>
                </div>

                <!-- Middle column: Workstations / Utilities / Network -->
                <div class="col-md-3">
                    <div class="card stats-card mb-3">
                        <div class="card-header color-box4 py-2 px-3">
                            <i class="bi bi-pc-display-horizontal me-1"></i> Workstations
                        </div>
                        <div class="stats-item">
                            <div class="stats-label"><strong>Total</strong></div>
                            <div><strong><p class="card-text" id="cpuPcCount">0</p></strong></div>
                        </div>
                        <div class="stats-item"><div class="stats-label">Windows XP</div><div><p class="card-text" id="xpCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Windows 10 32Bit</div><div><p class="card-text" id="w1032bitCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Windows 10 64Bit</div><div><p class="card-text" id="w1064bitCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Windows 11</div><div><p class="card-text" id="w11Count">0</p></div></div>
                    </div>

                    <div class="card stats-card mb-3">
                        <div class="card-header color-box5 py-2 px-3"><i class="bi bi-tools me-1"></i> Utilities</div>
                        <div class="stats-item"><div class="stats-label">RSU Facility</div><div><p class="card-text" id="rsuCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">MV Data Take-On</div><div><p class="card-text" id="mvdtoCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">MV Maintenance</div><div><p class="card-text" id="mvmaintCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">IMS/AIU</div><div><p class="card-text" id="imsaiuCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">DL Data Take-On</div><div><p class="card-text" id="dldtoCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">DL Maintenance</div><div><p class="card-text" id="dlmaintCount">0</p></div></div>
                    </div>

                    <div class="card stats-card">
                        <div class="card-header color-box6 py-2 px-3"><i class="bi bi-ethernet me-1"></i> Network Equipment</div>
                        <div class="stats-item"><div class="stats-label">Switch</div><div><p class="card-text" id="switchCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">SDWAN</div><div><p class="card-text" id="sdwanCount">0</p></div></div>
                        <div class="stats-item"><div class="stats-label">Router</div><div><p class="card-text" id="routerCount">0</p></div></div>
                    </div>
                </div>

                <!-- Right column: Printers & Facilities (with charts + tables) -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header color-box7">
                            <i class="bi bi-printer-fill me-1"></i> Printers
                        </div>
                        <div class="card-body p-0">
                            <div class="small-box m-0 p-0">
                                <table class="table table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <td colspan="2">Laserjet <br><p class="card-text" id="laserjetCount">0</p></td>
                                            <td>Dotmatrix <br><p class="card-text" id="dotmatrixCount">0</p></td>
                                            <td>Inkjet <br><p class="card-text" id="inkjetCount">0</p></td>
                                            <td>Deskjet <br><p class="card-text" id="deskjetCount">0</p></td>
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

                    <div class="card">
                        <div class="card-header color-box8">
                            <i class="bi bi-building-check me-1"></i> Facilities
                        </div>
                        <div class="card-body p-0">
                            <div class="small-box m-0 p-0">
                                <table class="table table-bordered text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <td></tD>
                                            <td>Node</td>
                                            <td>Electrical</td>
                                            <td>Switch Port</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><th scope="row">Total</th><td>0</td><td>0</td><td>0</td></tr>
                                        <tr><th scope="row">Working</th><td>0</td><td>0</td><td>0</td></tr>
                                        <tr><th scope="row">Available</th><td>0</td><td>0</td><td>0</td></tr>
                                        <tr><th scope="row">Defective</th><td>0</td><td>0</td><td>0</td></tr>
                                    </tbody>
                                </table>
                                <div class="card-footer text-center border-0 bg-transparent pt-3">
                                    <span class="badge bg-primary me-1 badge-compact">Fixed Sharing: 99</span>
                                    <span class="badge bg-warning text-dark me-1 badge-compact">Separate Meter: 89</span>
                                    <span class="badge bg-success badge-compact">No Cost: 217</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div> <!-- end right col -->
            </div> <!-- end hardware row -->
        </div> <!-- end hardware body -->
    
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Masterfile | Hardware Inventory System &copy; 2024 &dash; <?php echo date("Y");?> </div>
        </div>
    </div>
</footer>
</div>
</div>

<script src="js/jquery.main.js" type="text/javascript"></script>
<script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
<script src="js/dashboardv3.js"></script>
<script src="js/cdn.jsdelivr.js" type="text/javascript"></script>
<script src="js/chart.min.js"></script>
</body>
</html>