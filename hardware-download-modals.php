<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Download Hardware Inventory List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row justify-content-end">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="downloadRegionSelect" class="form-label">Select Region</label>
              <select class="form-select addHardwareForm" name="downloadRegionSelect" id="downloadRegionSelect">
              </select>
            </div>

            <div class="mb-3">
              <label for="downloadSiteSelect" class="form-label">Select Site</label>
              <select class="form-select addHardwareForm" name="downloadSiteSelect" id="downloadSiteSelect" disabled>
                <option value="" selected>Select Site</option>
              </select>
            </div>

            <!-- Optional Hardware Type -->
            <!--
            <div class="mb-3">
              <label for="downloadHwType" class="form-label">Select Hardware Type</label>
              <select class="form-select" name="downloadHwType" id="downloadHwType">
                <option value="All Hardware">All Hardware</option>
              </select>
            </div>
            -->
          </div>
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
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content bg-success text-white text-center">
      <div class="modal-body">
        <i class="fas fa-check-circle fa-2x mb-2"></i><br>
        Downloading Inventory List...
      </div>
    </div>
  </div>
</div>