document.addEventListener("DOMContentLoaded", function () {
  const downloadButton = document.getElementById("downloadButton");

  downloadButton.addEventListener("click", function () {
    const siteCode = document.getElementById("downloadSiteSelect").value;
    const regionName = document.getElementById("downloadRegionSelect").value;

    if (!siteCode) {
      alert("Please select a site before downloading.");
      return;
    }

    // Build query string
    let queryParams = `site_code=${encodeURIComponent(siteCode)}`;
    if (siteCode === "All Site") {
      if (!regionName) {
        alert("Please select a region for All Site download.");
        return;
      }
      queryParams += `&region_name=${encodeURIComponent(regionName)}`;
    }

    const downloadUrl = `hardware-download-csv-data.php?${queryParams}`;

    // Trigger download
    const tempLink = document.createElement("a");
    tempLink.href = downloadUrl;
    tempLink.style.display = "none";
    tempLink.download = "hardware_inventory.csv";
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);

    // Hide filter modal
    const filterModalEl = document.getElementById("filterModal");
    const filterModal = bootstrap.Modal.getInstance(filterModalEl);
    if (filterModal) {
      filterModal.hide();
    }

    // Show success modal after filter modal hides
    filterModalEl.addEventListener("hidden.bs.modal", function onHidden() {
      filterModalEl.removeEventListener("hidden.bs.modal", onHidden);

      const successModalEl = document.getElementById("successModal");
      const successModal = new bootstrap.Modal(successModalEl);
      successModal.show();

      // Auto-hide after 2 seconds
      setTimeout(() => {
        const instance = bootstrap.Modal.getInstance(successModalEl);
        if (instance) instance.hide();
      }, 2000);
    });
  });
});