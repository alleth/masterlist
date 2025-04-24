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
    <link href="css/datepicker-min.css" rel="stylesheet">
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
                <li><a class="dropdown-item" href="#!"><i class="fa fa-cog"></i> Settings</a></li>
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
                        Hardwares
                    </a>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Other Inventory
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="servers.php">Server Software</a>
                            <a class="nav-link" href="cpu-pc-softwares.php">CPU-PC Software</a>
                            <a class="nav-link" href="hardware-switch.php">Network Equipment</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                        Activities
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
                                    <div class='sb-nav-link-icon'><i class='fa fa-users'></i></div>
                                    Reference
                                    </a>";
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