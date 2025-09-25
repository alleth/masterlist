// Load regions into dropdown when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    loadRegionOptions();
});

function loadRegionOptions() {
    fetch('facilities-select-region.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("regionSelect");
            select.innerHTML = '<option value="all">All Region</option>';
            data.forEach(region => {
                const option = document.createElement("option");
                option.value = region.region_id;
                option.textContent = region.region_name;
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error loading regions:", error));
}

$(document).ready(function () {
    $("#showFacButton").on("click", function () {
        let region = $("#regionSelect").val();

        $.ajax({
            url: "facilities-show.php",
            method: "POST",
            data: { region: region },
            success: function (response) {
                $("#facilitiesDisplay").html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
                alert("Failed to load data.");
            }
        });
    });
});

// for debugging
$(document).ready(function () {
    $("#showFacButton").on("click", function () {
        let region = $("#regionSelect").val();
        console.log("Selected region:", region); // debug log

        $.ajax({
            url: "facilities-show.php",
            method: "POST",
            data: { region: region },
            success: function (response) {
                console.log("AJAX success. Response:", response); // debug log
                $("#facilitiesDisplay").html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
                alert("Failed to load data.");
            }
        });
    });
});

$(document).on("click", ".edit-facilities-btn", function () {
    let siteId = $(this).data("site-id");

    $.ajax({
        url: "facilities-edit.php",
        method: "POST",
        data: { site_id: siteId },
        dataType: "json",
        success: function (data) {
            if (data.success) {
                // Fill modal inputs
                $("#editSiteId").val(data.site.site_id);
                $("#editNodeCount").val(data.site.node_count);
                $("#editNodeWorking").val(data.site.node_working);
                $("#editNodeDefective").val(data.site.node_defective);
                $("#editNodeAvailable").val(data.site.node_available);
                $("#editOutletCount").val(data.site.outlet_count);
                $("#editOutletWorking").val(data.site.outlet_working);
                $("#editOutletDefective").val(data.site.outlet_defective);
                $("#editOutletAvailable").val(data.site.outlet_available);
                $("#editPortCount").val(data.site.port_count);
                $("#editPortWorking").val(data.site.port_working);
                $("#editPortDefective").val(data.site.port_defective);
                $("#editPortAvailable").val(data.site.port_available);
                $("#editTypeElectricalCon").val(data.site.type_electrical_con);

                // Show modal
                $("#EditFacilitiesModal").modal("show");
            } else {
                alert("No site data found.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching site:", error, xhr.responseText);
            alert("Failed to fetch site details.");
        }
    });
});

$(document).on("click", "#saveFacilitiesBtn", function () {
    const formData = $("#editFacilitiesForm").serialize();

    $.ajax({
        url: "facilities_update.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                // Hide the edit modal first
                $("#EditFacilitiesModal").modal("hide");

                // Once hidden, show the success modal
                const editModalEl = document.getElementById("EditFacilitiesModal");
                editModalEl.addEventListener("hidden.bs.modal", function onHidden() {
                    editModalEl.removeEventListener("hidden.bs.modal", onHidden);

                    const successModalEl = document.getElementById("successModal");
                    const successModal = new bootstrap.Modal(successModalEl);
                    successModal.show();

                    // Auto-hide after 1 second
                    setTimeout(() => {
                        const instance = bootstrap.Modal.getInstance(successModalEl);
                        if (instance) instance.hide();
                    }, 500);

                    // ✅ Refresh only the table body
                    $("#facilitiesDisplay").load("facilities-show.php", {
                        region: $("#regionSelect").val()
                    });
                });
            } else {
                alert("Update failed: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred while updating facilities.");
        }
    });
});





