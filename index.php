<?php include 'includes/header.php'; ?>

<style>
    body {
        background-color: #faf9f9;
        font-family: system-ui, -apple-system, sans-serif;
        margin: 0; /* Ensure no default margin interferes */
    }
    .spinner-container {
        min-height: 60px;
    }
    .accordion-button {
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.75rem 1.25rem;
        background-color: #e9ecef;
        color: #343a40;
    }
    .accordion-button:not(.collapsed) {
        background-color: #dee2e6;
        color: #343a40;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    .accordion-item {
        border: none;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        background-color: #fff;
    }
    .accordion-body {
        padding: 1rem 1.25rem;
    }
    .table {
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }
    .table th, .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-color: #dee2e6;
    }
    .table thead th {
        background-color: #343a40;
        color: #fff;
        border: none;
    }
    .table tbody tr:hover {
        background-color: #f1f3f5;
    }
    .count-column {
        width: 150px;
        text-align: center;
    }
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .form-select, .form-label {
        display: block;
        font-size: 0.875rem;
    }
    h4 {
        font-size: 1.25rem;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 1.5rem;
    }
    h5 {
        font-size: 1rem;
        font-weight: bold;
        color: #343a40;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    /* Fixed Filter Section */
    .filter-fixed {
        position: fixed;
        top: 8rem;
        right: calc(1rem + 15px); /* Align with container padding + half gutter */
        width: calc(33.3333% - 30px); /* Matches col-md-3 minus full gutter */
        max-width: 300px; /* Prevent overly wide filter */
        z-index: 1000;
    }
    /* Ensure container supports scrolling */
    .dashboard-container {
        min-height: 100vh;
        overflow-y: auto; /* Allow vertical scrolling */
        position: relative; /* Context for positioning */
    }
    /* Prevent overlap with fixed filter */
    .main-content {
        margin-right: 0; /* Default for mobile */
        box-sizing: border-box;
    }
    /* Media query for medium and larger screens */
    @media (min-width: 768px) {
        .main-content {
            margin-right: calc(33.3333% + 2rem); /* Initial margin for filter */
            max-width: calc(100% - 330px); /* Account for filter width (300px + 30px gutter) */
        }
    }
    /* Media query for mobile view */
    @media (max-width: 767.98px) {
        .filter-fixed {
            position: static; /* Disable fixed positioning on mobile */
            width: 100%; /* Full width on mobile */
            max-width: none; /* Remove max-width constraint */
            top: auto; /* Reset top */
            right: auto; /* Reset right */
        }
        .main-content {
            margin-right: 0; /* No margin needed on mobile */
            max-width: 100%; /* Full width on mobile */
        }
        .filter-card {
            margin-top: 1rem; /* Add spacing between sections on mobile */
        }
        .dashboard-container {
            padding-top: 0; /* Ensure no extra padding pushes content */
        }
    }
    /* Fine-tune for 1000–1175px to prevent overlap */
    @media (min-width: 1000px) and (max-width: 1175px) {
        .filter-fixed {
            width: 300px; /* Match max-width for consistency */
            right: calc(1rem + 15px); /* Align with container edge */
        }
        .main-content {
            margin-right: 330px; /* Match filter width (300px + 30px gutter) */
            max-width: calc(100% - 330px); /* Prevent overlap */
        }
    }
    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        display: none; /* Hidden by default */
        padding: 0.75rem 1rem;
        background-color: #343a40;
        color: #fff;
        border: none;
        border-radius: 0.25rem;
        cursor: pointer;
        z-index: 1000;
        font-size: 0.875rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: opacity 0.3s ease;
    }
    .back-to-top:hover {
        background-color: #495057;
    }
    .back-to-top.visible {
        display: block;
        opacity: 1;
    }
    /* Hide button on mobile */
    @media (max-width: 767.98px) {
        .back-to-top {
            display: none !important; /* Always hidden on mobile */
        }
    }
</style>

<div class="container-fluid px-4 my-4 dashboard-container">
    <div class="row">
        <div class="col-12">
            <h4>Dashboard</h4>

            <div class="row">
                <!-- Main Content (Hardware Accordion) -->
                <div class="col-12 col-md-12 order-1 main-content">
                    <!-- Hardware Accordion -->
                    <div class="card mb-4" id="hardware-section">
                        <div class="card-body">
                            <div class="accordion" id="hardwareAccordion">
                                <div class="spinner-container d-flex justify-content-center align-items-center text-center">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section (Fixed on Medium+, Below on Mobile) -->
                <div class="col-12 col-md-3 order-2 filter-fixed">
                    <div class="card mb-4 filter-card">
                        <div class="card-body">
                            <form id="deviceForm">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="regionFilter" class="form-label">Region</label>
                                        <select class="form-select" id="regionSelect">
                                            <option value="">All Region</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="siteFilter" class="form-label">Site</label>
                                        <select class="form-select" id="siteSelect" disabled>
                                            <option value="0">All Site</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4 counts-card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-muted">Total Number of Sites</label>
                                    <p class="text-dark">Loading...</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">Total Number of Proponent-Owned</label>
                                    <p class="text-dark">Loading...</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted">Total Number of Government-Owned</label>
                                    <p class="text-dark">Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button title="Back To Top" class="back-to-top" id="backToTop"><span class="fas fa-angle-up"></span></button>

<script>
    // Back to Top Button Functionality
    document.addEventListener('DOMContentLoaded', () => {
        const backToTopButton = document.getElementById('backToTop');

        // Show/hide button based on scroll position
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        // Smooth scroll to top on click
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>

<?php include 'includes/components.php'; ?>
    <script src="js/dashboardv2.js"></script>
<?php include 'includes/footer.php'; ?>