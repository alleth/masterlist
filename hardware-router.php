<?php
include("includes/header.php");

$user_type = $_SESSION['sess_user_type'];
?>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 display-4">Routers</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Hardwares</li>
            </ol>
            <div class="row">
                <div class="alert alert-warning text-center" role="alert">
                    <h4 class="alert-heading">Page Unavailable</h4>
                    <p>We're sorry, but this page is currently under development.</p>
                    <hr>
                    <p class="mb-0">Please check back later or contact the administrator if you have any questions.</p>
                </div>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-primary">Go Back to Dashboard</a>
                </div>
            </div>
        </div>
    </main>

<?php include("includes/footer.php"); ?>