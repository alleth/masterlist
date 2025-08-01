
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

function loadSelectOptions(selectId, table, column, url, placeholder = 'Select an option') {
    const $select = $('#' + selectId);
      const currentValue = $select.val(); // Save current selection (may be injected manually)

      $.ajax({
          url: url,
          method: 'GET',
          data: { table, column },
          dataType: 'json',
          success: function (options) {
              const existingOptions = new Set();

              // Remove previously added dynamic options only
              $select.find('option[data-dynamic="true"]').remove();

              // Preserve static/manual options like "All Hardware"
              $select.find('option').each(function () {
                  const val = $(this).val();
                  if (val !== "") {
                      existingOptions.add(val);
                  }
              });

              const selectedExists = currentValue && existingOptions.has(currentValue);

              // If placeholder does not already exist, add it
              if ($select.find('option[value=""]').length === 0) {
                  $select.prepend(`<option value="" disabled ${!currentValue ? 'selected' : ''}>${placeholder}</option>`);
              }

              // If current value is manually inserted and not in the DB, preserve it
              if (currentValue && !options.includes(currentValue)) {
                  if ($select.find(`option[value="${currentValue}"]`).length === 0) {
                      $select.append(`<option value="${currentValue}" selected disabled>${currentValue} (Invalid)</option>`);
                  }
              }

              // Add new options from DB
              options.forEach(opt => {
                  const isSelected = opt === currentValue && !selectedExists;
                  const optionEl = $('<option>')
                      .val(opt)
                      .text(opt)
                      .attr('data-dynamic', true);

                  if (isSelected) optionEl.prop('selected', true);

                  $select.append(optionEl);
              });

              $select.prop("disabled", false);
          },
          error: function (xhr) {
              console.error(`Error loading #${selectId}:`, xhr.responseText);
              $select.html('<option disabled>Error loading data</option>');
          }
      });
  }

