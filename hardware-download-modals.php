<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Download Hardware Inventory List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label for="downloadRegionSelect" class="form-label">Select Site</label>
          <select class="form-select addHardwareForm" name="downloadRegionSelect" id="downloadRegionSelect">
              <option value="" disabled selected>Select region</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="downloadSiteSelect" class="form-label">Select Site</label>
          <select class="form-select addHardwareForm" name="downloadSiteSelect" id="downloadSiteSelect" disabled>
            <option value="" selected>Select Site</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button id="downloadButton" type="button" class="btn btn-success">
          <i class="fas fa-download"></i> Download
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-success text-white text-center">
      <div class="modal-body">
        <p class="mb-0"><i class="fas fa-check-circle me-2"></i>Download starting...</p>
      </div>
    </div>
  </div>
</div>

<script src="hardware-downloadExcelData.js?v=<?= time() ?>" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
