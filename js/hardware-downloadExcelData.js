document.addEventListener("DOMContentLoaded", function () {
  const downloadButton = document.getElementById("downloadButton");

  downloadButton.addEventListener("click", function () {
    const siteCode = document.getElementById("downloadSiteSelect").value;

    if (!siteCode) {
      alert("Please select a site before downloading.");
      return;
    }

    // Prepare download URL
    const downloadUrl = `hardware-download-csv-data.php?site_code=${encodeURIComponent(siteCode)}`;

    // Trigger download
    const tempLink = document.createElement("a");
    tempLink.href = downloadUrl;
    tempLink.style.display = "none";
    tempLink.download = "hardware_inventory.csv";
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);

    // Hide filter modal immediately
    const filterModalEl = document.getElementById("filterModal");
    const filterModal = bootstrap.Modal.getInstance(filterModalEl);
    if (filterModal) {
      filterModal.hide();
    }

    // Wait for modal to fully close before showing success
    filterModalEl.addEventListener("hidden.bs.modal", function onHidden() {
      filterModalEl.removeEventListener("hidden.bs.modal", onHidden);

      const successModalEl = document.getElementById("successModal");
      const successModal = new bootstrap.Modal(successModalEl);
      successModal.show();

      // Auto-close success modal after 2 seconds
      setTimeout(() => {
        const instance = bootstrap.Modal.getInstance(successModalEl);
        if (instance) instance.hide();
      }, 2000);
    });
  });
});


