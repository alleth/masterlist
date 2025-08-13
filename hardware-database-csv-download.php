<?php 
include("includes/header.php");
?>

<div class="container my-5">
    <main class="card border-0 shadow-lg text-center p-5 mx-auto" style="max-width: 450px; border-radius: 1rem;">
        <div class="mb-4">
            <i class="fas fa-database fa-3x text-primary"></i>
        </div>
        <h3 class="fw-bold mb-3">Database Backup</h3>
        <p class="text-muted mb-4">
            Download a full backup of your hardware database for safekeeping.
        </p>
        <!-- Trigger modal -->
        <button type="button" id="downloadBackupBtn" class="btn btn-primary btn-lg px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#backupConfirmModal">
            <i class="fas fa-download me-2"></i> Download Backup
        </button>
    </main>
</div>

<!-- Download Confirmation Modal -->
<div class="modal fade" id="backupConfirmModal" tabindex="-1" aria-labelledby="backupConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg text-center p-5" style="border-radius: 1rem;">
      <div class="modal-body">
        <div class="mb-4">
          <i class="fas fa-database fa-3x text-primary"></i>
        </div>
        <h4 class="fw-bold mb-3" id="backupConfirmLabel">Confirm Download</h4>
        <p class="text-muted mb-4">Do you want to download the backup now?</p>
        <button type="button" id="confirmDownloadBtn" class="btn btn-primary btn-lg px-4 py-2 shadow-sm me-2">
          <i class="fas fa-download me-2"></i> Download
        </button>
        <button type="button" class="btn btn-secondary btn-lg px-4 py-2 shadow-sm" data-bs-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Masterfile | Hardware Inventory System &copy; 2024 &dash; <?php echo date("Y"); ?> </div>
        </div>
    </div>
</footer>

<!-- JS Scripts -->
<script src="js/jquery.main.js" type="text/javascript"></script>
<script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
<script src="js/cdn.jsdelivr.js" type="text/javascript"></script>
<script src="js/chart.min.js"></script>
<script src="js/user-tab.js" type="text/javascript"></script>

<script>
$(document).ready(function () {

    $("#confirmDownloadBtn").on("click", function (e) {
        e.preventDefault();

        let modalBtn = $(this);
        let mainBtn = $("#downloadBackupBtn"); // Main page button

        // Disable both buttons and show "Preparing download..."
        modalBtn.prop("disabled", true).html('<i class="fas fa-hourglass-start me-2"></i> Preparing download...');
        mainBtn.prop("disabled", true).html('<i class="fas fa-hourglass-start me-2"></i> Preparing download...');

        setTimeout(function () {
            // Trigger CSV download
            window.location.href = "download-backup-handler.php";

            // Restore buttons after 2s
            setTimeout(function () {
                modalBtn.prop("disabled", false).html('<i class="fas fa-download me-2"></i> Download');
                mainBtn.prop("disabled", false).html('<i class="fas fa-download me-2"></i> Download Backup');
            }, 2000);
        }, 500);

        // Hide modal after clicking download
        $('#backupConfirmModal').modal('hide');
    });

});
</script>
</body>
</html>
