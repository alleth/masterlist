    //- Enable the show button when the region is Selected
    $(document).ready(function () {
        $('#ServerRegionSelect').on('change', function () {
            const selectedRegion = $(this).val();

            if (selectedRegion) {
                // Enable the Show button
                $('#showServerButton').prop('disabled', false);
            } else {
                // Disable if no region is selected (optional fallback)
                $('#showServerButton').prop('disabled', true);
            }
        });
    });
    

    //--- Script For Show data on the table ------------------------------
    $(document).ready(function () {
    let cpuPcTable; // Store DataTable instance

        $("#showServerButton").on("click", function (e) {
            e.preventDefault();

            const selectedRegionId = $("#ServerRegionSelect").val();
            //const selectedSiteCode = $("#ServerSiteSelect").val();
            const tbody = $("#hardwareDisplay");

            if (!selectedRegionId) {
                tbody.html(`
                    <tr>
                        <td colspan="8" class="text-warning text-center fst-italic">Please select a region first.</td>
                    </tr>
                `);
                return;
            }

            // ✅ Destroy DataTable and clear table before making new AJAX call
            if ($.fn.DataTable.isDataTable('#CPUPCPerSite')) {
                $('#CPUPCPerSite').DataTable().destroy();
            }

            tbody.html(`
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2 text-muted fst-italic">Loading Servers records...</div>
                    </td>
                </tr>
            `);

            $.ajax({
                url: 'software-server-details.php',
                method: 'POST',
                data: {
                    region_id: selectedRegionId,
                },
                success: function (response) {
                    if ($.trim(response) === "") {
                        tbody.html(`
                            <tr>
                                <td colspan="8" class="text-muted text-center fst-italic">No CPU-PC records found.</td>
                            </tr>
                        `);
                    } else {
                        tbody.html(response);

                        // ✅ Reinitialize DataTable after replacing the table
                        $('#CPUPCPerSite').DataTable({
                            pageLength: 10,
                            searching: true,
                            ordering: false
                        });
                    }
                },
                error: function () {
                    tbody.html(`
                        <tr>
                            <td colspan="8" class="text-danger text-center">An error occurred while fetching data.</td>
                        </tr>
                    `);
                }
            });
        });
    });


    //-- Script for edit button to show data on modal-----------------------
    $(document).ready(function () {
        // When Edit button is clicked
        $(document).on("click", ".edit-hardware-btn", function (e) {
            e.preventDefault();

            // Get the row data (assuming the button is inside a table row)
            const row = $(this).closest("tr");

            // Extract data from table cells (adjust indexes based on your table)
            const region = row.find("td:eq(0)").text().trim();
            const site = row.find("td:eq(1)").text().trim();
            const assetSerial = row.find("td:eq(2)").text().trim().split(" / ");
            const hostname = row.find("td:eq(3)").text().trim();
            const ip = row.find("td:eq(4)").text().trim();
            const mac = row.find("td:eq(5)").text().trim();
            const workstep = row.find("td:eq(6)").text().trim();

            // Populate modal fields
            $("#editCpuPcRegion").val(region);
            $("#editCpuPcSite").val(site);
            $("#editCpuPcAssetNum").val(assetSerial[0] || "");
            $("#editCpuPcSerial").val(assetSerial[1] || "");
            $("#editCpuPcModel").val(workstep); // Optional: Adjust if needed
            $("#editCpuPcDate").val(""); // Date needs to come from DB or another column
            $("#editCpuPcStatus").val("On Site"); // Default or fetched later

            // Show modal
            $("#EditServerModal").modal("show");
        });
    });
    
    
    $(document).ready(function () {
        $(document).on("click", ".edit-hardware-btn", function (e) {
            e.preventDefault();

            // Get the hw_id from a data attribute (you must add this in the button)
            const hwId = $(this).data("id");

            $.ajax({
                url: "software-server-edit.php",
                type: "POST",
                data: { hw_id: hwId },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        // Populate modal fields
                        $("#editCpuPcId").val(data.hw.hw_id);
                        $("#editCpuPcRegion").val(data.hw.hw_host_name);
                        $("#editCpuPcAssetNum").val(data.hw.hw_primary_role);
                        $("#editCpuPcSite").val(data.hw.hw_ip_add);
                        $("#editCpuPcSerial").val(data.hw.hw_mac_add);
                        $("#editCpuPcItem").val(data.hw.os_type);

                        // Show modal
                        $("#EditServerModal").modal("show");
                    } else {
                        alert("Failed to load data: " + data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("Error fetching CPU-PC details.");
                }
            });
        });
    });

    //-- Script  to Update button to save updated data ----------------------------
    $(document).ready(function () {
    // Handle Update button click
        $("#updateCpuPcBtn").on("click", function (e) {
            e.preventDefault();

            // Collect form data
            const hw_id = $("#editCpuPcId").val();
            const region = $("#editCpuPcRegion");
            const site = $("#editCpuPcSite");
            const item_desc = $("#editCpuPcItem");
            const asset_num = $("#editCpuPcAssetNum");
            const serial_num = $("#editCpuPcSerial");

            let isValid = true;

            // Reset all previous validation
            $("#editCpuPcForm input, #editCpuPcForm select").removeClass("is-invalid");

            // Validate each field
            if (!region.val()) {
                region.addClass("is-invalid");
                isValid = false;
            }
            if (!site.val()) {
                site.addClass("is-invalid");
                isValid = false;
            }
            if (!item_desc.val()) {
                item_desc.addClass("is-invalid");
                isValid = false;
            }
            if (!asset_num.val()) {
                asset_num.addClass("is-invalid");
                isValid = false;
            }
            if (!serial_num.val()) {
                serial_num.addClass("is-invalid");
                isValid = false;
            }

            // If any field is invalid, show alert and stop
            if (!isValid) {
                $("#editCpuPcMessage").html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        All fields are required! Please fill in the highlighted inputs.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                return;
            }

            // Proceed with AJAX if all fields are valid
            $.ajax({
                url: "software-server-update.php",
                type: "POST",
                data: {
                    hw_id: hw_id,
                    hw_host_name: region.val(),
                    hw_ip_add: site.val(),
                    os_type: item_desc.val(),
                    hw_primary_role: asset_num.val(),
                    hw_mac_add: serial_num.val()
                },
                success: function (response) {
                    $("#editCpuPcMessage").html(response);

                    // After success, hide modal and refresh table
                    setTimeout(() => {
                        $("#EditServerModal").modal("hide");
                        $("#showServerButton").click(); // Refresh the table
                    }, 1500);
                },
                error: function (xhr, status, error) {
                    $("#editCpuPcMessage").html(`
                        <div class="alert alert-danger" role="alert">
                            An error occurred: ${error}
                        </div>
                    `);
                }
            });
        });

        // Clear messages and validation when modal is closed
        $('#EditServerModal').on('hidden.bs.modal', function () {
            $("#editCpuPcMessage").html(""); // Clear alert message
            $("#editCpuPcForm")[0].reset();  // Reset form
            $("#editCpuPcForm input, #editCpuPcForm select").removeClass("is-invalid"); // Remove red borders
        });
    });










