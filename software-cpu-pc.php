<?php
include("includes/header.php");

// Maintenance mode flag (set to true when under maintenance)
$maintenance_mode = false; // Change to false to disable maintenance mode

if ($maintenance_mode) {
    // Include the coming-soon.php file for maintenance page
    include("coming-soon.php");
    exit; // Stop further execution
}

// Proceed with normal page if not in maintenance mode
$user_type = $_SESSION['sess_user_type'];
?>
    <!-- Bootstrap Icons via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 Bootstrap-5 theme for better integration -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        .accordion-footer {
            padding: .45rem 1.25rem;
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            font-size: 0.8rem;
        }

        /* Make Select2 look like a single-select dropdown */
        .select2-container .select2-selection--multiple {
            min-height: 1.8rem;
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0;
            padding: 0 0.5rem;
            white-space: nowrap;
            background-color: transparent;
            display: flex;
            align-items: center;
            height: auto;
        }
        .select2-container--focus .select2-selection--multiple {
            border-color: #0d6efd;
            box-shadow: 0 1px 0 0 #0d6efd;
        }

        /* Selected tags (chips) */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd;
            opacity: 1;
            border: none;
            color: #fff;
            padding: 0 3px;
            margin: 1px 2px;
            border-radius: .1rem;
            display: inline-flex;
            align-items: center;
            gap: 2px;
            font-size: 0.7rem;
            line-height: 1.2;
        }

        /* Horizontal chip layout */
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            display: flex;
            flex-wrap: nowrap;
            gap: 1px;
            padding: 2px 0;
            white-space: nowrap;
        }

        /* Smaller dropdown options */
        .select2-results__option {
            font-size: 0.8rem;
            padding: 4px 8px;
            line-height: 1.2;
        }

        /* Dropdown checkmark */
        .select2-results__option[aria-selected="true"]::before,
        .select2-results__option.select2-results__option--selected::before {
            content: "✓";
            display: inline-block;
            margin-right: 6px;
            font-weight: 700;
        }
        .select2-results__option::before {
            content: "";
            display: inline-block;
            width: 1em;
            margin-right: 6px;
        }

        /* Cleaner, smaller inputs with bottom border only */
        .accordion-body .form-control,
        .accordion-body .form-select {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0;
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
            height: 1.8rem;
            background-color: transparent;
            box-shadow: none;
        }
        .accordion-body .form-control:focus,
        .accordion-body .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 1px 0 0 #0d6efd;
        }
        .accordion-body .form-label {
            font-size: 0.8rem;
            margin-bottom: 0.2rem;
            color: #495057;
        }
        .accordion-body .row.mb-3 {
            margin-bottom: 0.4rem !important;
        }

        /* Style Select2's default remove button */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
            margin-right: 4px;
            font-size: 0.7rem;
        }

        /* Warning styles for incomplete accordion items: apply to icon and active shadow */
        .accordion-item.has-warning .accordion-button .bi {
            color: #ffc107; /* Bootstrap warning color for the warning icon */
        }
        .accordion-item.has-warning .accordion-button:not(.collapsed) .bi {
            color: #ffc107; /* Maintain warning color for icon when active */
        }
        .accordion-item.has-warning .accordion-button:not(.collapsed) {
            background-color: #fff3cd; /* Light warning background for active state */
            box-shadow: inset 0 -2px 0 #ffc107; /* Warning-colored shadow for active state */
        }
        .accordion-item.has-warning .accordion-body {
            border: 1px solid #ffc107; /* Warning border for body */
            border-radius: 0.25rem;
        }

        /* Success styles for complete accordion items: apply to icon only */
        .accordion-item:not(.has-warning) .accordion-button .bi {
            color: #198754; /* Bootstrap success color for the icon */
        }
        .accordion-item:not(.has-warning) .accordion-button:not(.collapsed) .bi {
            color: #198754; /* Maintain success color for icon when active */
        }

        /* Default accordion styles */
        .accordion-item .accordion-button {
            color: #000; /* Black text for default state */
        }
        .accordion-item .accordion-button:not(.collapsed) {
            color: #000; /* Black text when active */
            background-color: #f8f9fa; /* Default Bootstrap background */
            box-shadow: inset 0 -2px 0 #0d6efd; /* Default blue shadow for active state */
        }
        .accordion-item .accordion-body {
            border: none; /* No border unless has-warning */
        }

        /* Warning styles for empty/invalid inputs */
        .accordion-item.has-warning .form-control.input-warning,
        .accordion-item.has-warning .form-select.input-warning,
        .accordion-item.has-warning .select2-container.input-warning .select2-selection--multiple {
            border-color: #ffc107; /* Yellow bottom border for warning */
            box-shadow: 0 1px 0 0 #ffc107; /* Yellow shadow to match */
        }

        /* Error styles for invalid inputs in accordion footer */
        .accordion-footer .status.error {
            color: #dc3545; /* Bootstrap danger color for errors */
            font-weight: 500;
        }
    </style>

    <main>
        <div class="container-fluid px-4">
            <h5 class="mt-3">CPU-PC Configuration</h5>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border border-dark-subtle shadow-sm">
                        <div class="card-body">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-2">
                                    <select class="form-select" name="region_name" id="CpuPCRegionSelect">
                                        <option value="" selected>Select Region</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select" name="site_name" id="CpuPCSiteSelect" disabled>
                                        <option value="" selected disabled>Please select site</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary d-flex justify-content-center align-items-center" id="showCPUPCButton">
                                        <i class="bi bi-search"></i> <span class="ms-1">Show</span>
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
                            <div class="accordion" id="accordionExample">
                                <p class="text-center text-muted fst-italic">Please select region and site...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5"></div>
        </div>

        <!-- Toast Container for Region/Site Validation -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
            <div id="toastValidation" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <span class="bi bi-exclamation-triangle"></span>&nbsp; Please select both region and site
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <!-- Toast for Invalid MAC/IP Address -->
            <div id="toastInvalidInput" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <span class="bi bi-exclamation-triangle"></span>&nbsp; <span id="invalidInputMessage">Invalid input</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </main>
<?php include 'includes/components.php'; ?>
    <script src="js/select2-design.js" type="text/javascript"></script>
    <script src="js/software-cpu-pc.js?v=<?= time() ?>" type="text/javascript"></script>
    <script src="js/inactivity.js?v=<?= time() ?>" type="text/javascript"></script>
<?php include 'includes/footer.php'; ?>