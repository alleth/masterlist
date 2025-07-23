function timestamp() {
    return new Date().toLocaleString("en-US", { timeZone: "UTC" });
}

$(function(){
    console.log("=== hardware.js loaded successfully at %s ===", timestamp());

    $("#updateHardwareBtn").hide();
    $("#displayHardwareValidation").hide();

    $(".datepicker-input").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showAnim: "fadeIn",
        autoclose: true,
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    position: "absolute",
                    top: $(input).offset().top + $(input).outerHeight(),
                    left: $(input).offset().left,
                    zIndex: 99999
                });
            }, 100);
        }
    });

    $(document).on("focus", ".datepicker-input", function () {
        $(".ui-datepicker").css("z-index", 99999);
    });

    $(".modal").on("shown.bs.modal", function () {
        $(".ui-datepicker").css("z-index", parseInt($(this).css("z-index")) + 1);
    });

    // Bind brand dropdown change event
    $(document).on("change", "#edit_brandSelect", function() {
        console.log("Brand dropdown changed to: %s at %s", $(this).val(), timestamp());
        showHardwareModel();
    });

    // Load region dropdown
    $.ajax({
        type: "POST",
        url: "hardwares-view-region.php",
        success: function(data) {
            $("#displayRegionHW").html(data);
            $("select[name='hw_region_name']").on("change", hardware_site_option);
            console.log("Region dropdown loaded at %s", timestamp());
            hardware_site_option(); // Initialize site dropdown
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading regions:", { status, error, response: xhr.responseText });
            alert("Error loading regions.");
        }
    });

    // Load region modal
    $.ajax({
        type: "POST",
        url: "hardware-region-modal.php",
        success: function(data) {
            $("#hardwareRegionModal").html(data);
            console.log("Region modal loaded at %s", timestamp());
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", { status, error, response: xhr.responseText });
            alert("Error loading region modal.");
        }
    });

    // Load item description modal
    $.ajax({
        type: "POST",
        url: "hardware-item-description-modal.php",
        success: function(data) {
            $("#itemDescription").html(data);
            console.log("Item description modal loaded at %s", timestamp());
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", { status, error, response: xhr.responseText });
            alert("Error loading item description.");
        }
    });

    // Show button click
    $("#showHwButton").on("click", function() {
        console.log("Show HW button clicked at %s", timestamp());
        updateHardwareTable();
    });

    // Bind edit hardware buttons
    $(document).on("click", ".edit-hardware-btn", function() {
        var id = $(this).data("hw-id");
        console.log("Edit button clicked for hardware_id: %s at %s", id, timestamp());
        hardwareUpdate(id);
    });

    $("#addNewHardwareBtn").click(function() {
        var RegionSelect = $('#RegionSelect').val();
        var hardwareSiteModal = $('#hardwareSiteModal').val();
        var itemSelect = $('#itemSelect').val();
        var itemBrand = $('#itemBrand').val();
        var itemModel = $('#itemModel').val();
        var asset_num = $('#asset_num').val();
        var serial_num = $('#serial_num').val();
        var date = $('#date').val();
        var acquired_value = $('#acquired_value').val();
        var hw_status = "On Site";

        console.log("Add hardware attempt at %s", timestamp());

        var wordObj = {
            RegionSelect,
            hardwareSiteModal,
            itemSelect,
            itemBrand,
            itemModel,
            asset_num,
            serial_num,
            date,
            acquired_value,
            hw_status
        };

        if (!RegionSelect || !hardwareSiteModal || !itemSelect || !itemBrand || !itemModel || !asset_num || !serial_num || !date) {
            $("#addHWMessage").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'>All fields are required!</div>");
            console.log("Add hardware failed: missing fields at %s", timestamp());
            return;
        }

        $.ajax({
            type: "POST",
            url: "hardware-add-details.php",
            data: wordObj,
            success: function(saveResponse) {
                if (saveResponse.includes("Asset Number Already Exist") ||
                    saveResponse.includes("Serial Number Already Exist on site") ||
                    saveResponse.includes("Asset Number and Serial Number Already Exist on site")) {
                    $("#addHWMessage").html(`
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>${saveResponse}</strong><br>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                } else {
                    $("#AddHardwareModal").modal('hide');
                    $('#response').html(saveResponse);
                    alertMessageSuccess(`<strong>Hardware successfully save!</strong>`);
                    $('select, input').val('');
                    updateHardwareTable(); // Refresh table
                    console.log("Hardware added successfully at %s", timestamp());
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error adding hardware:", { status, error, response: xhr.responseText });
                $('#response').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred while saving the data.</div>');
            }
        });
    });

    $(document).on("click", "#updateHardwareBtn", function() {
        $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num'], select[name='edit_sub_major_type'], select[name='edit_item_desc']").removeClass('is-invalid');
        $("input[name='tracking_num']").val("").removeClass("is-invalid");
        $("#tracking_required").text("");
        $("input[name='edit_date_pullout']").val("").removeClass("is-invalid");
        $("#date_required").text("");

        var hw_id = $("input[name='edit_hw_id']").val();
        var sub_major_type = $("select[name='edit_sub_major_type']").val();
        var item_desc = $("select[name='edit_item_desc']").val();
        var brand_name = $("select[name='edit_brand_name']").val();
        var model_name = $("select[name='edit_model_name']").val();
        var acquired_value = $("input[name='edit_acquired_value']").val();
        var asset_num = $("input[name='edit_asset_num']").val();
        var serial_num = $("input[name='edit_serial_num']").val();
        var date_acquired = $("input[name='edit_date_acquired']").val();
        var hardwareStatus = $("select[name='hardware_status_option']").val();

        var hasEmptyFields = false;
        if (hw_id === "") {
            $("input[name='edit_hw_id']").addClass('is-invalid');
            hasEmptyFields = true;
        }
        if (sub_major_type === "" || sub_major_type === null) {
            $("select[name='edit_sub_major_type']").addClass('is-invalid');
            hasEmptyFields = true;
        }
        if (item_desc === "" || item_desc === null) {
            $("select[name='edit_item_desc']").addClass('is-invalid');
            hasEmptyFields = true;
        }
        if (brand_name === "" || brand_name === null) {
            $("select[name='edit_brand_name']").addClass('is-invalid');
            hasEmptyFields = true;
        }
        if (model_name === "" || model_name === null) {
            $("select[name='edit_model_name']").addClass('is-invalid');
            hasEmptyFields = true;
        }
        if (asset_num === "") {
            $("input[name='edit_asset_num']").addClass('is-invalid');
            hasEmptyFields = true;
        }
        if (serial_num === "") {
            $("input[name='edit_serial_num']").addClass('is-invalid');
            hasEmptyFields = true;
        }

        if (hasEmptyFields) {
            $("#addMessage").html(`
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Warning!</strong> Please check the fields below.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
            console.log("Update failed: missing fields at %s", timestamp());
        } else {
            $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num'], select[name='edit_sub_major_type'], select[name='edit_item_desc']").removeClass('is-invalid');
            $("#addMessage").html("");
            if (hardwareStatus === "Pull Out") {
                $("#warning-pullout").html(`<i class='fas fa-exclamation-triangle'></i> You're about to pull out this hardware with Asset No. <b>${asset_num}</b>`);
                $("#hardwareModalInput").modal('hide');
                $("#trackingModal").modal('show');
                console.log("Pull out initiated for asset_num: %s at %s", asset_num, timestamp());
            } else {
                var wordObj = {
                    hw_id,
                    sub_major_type,
                    item_desc,
                    brand_name,
                    model_name,
                    acquired_value,
                    asset_num,
                    serial_num,
                    date_acquired,
                    hardware_status: hardwareStatus
                };

                $.ajax({
                    type: "POST",
                    url: "hardwares-save-details.php",
                    data: wordObj,
                    beforeSend: function () {
                        $("#displayHardwareValidation").removeClass('disabled').show();
                        console.log("Updating hardware ID: %s at %s", hw_id, timestamp());
                    },
                    success: function(data) {
                        $("#hardwareModalInput").modal('hide');
                        $("#displayHardwareValidation").addClass('disabled').hide();
                        // Initialize and show Bootstrap Toast
                        var toastElement = document.getElementById('successToast');
                        var toastBody = toastElement.querySelector('.toast-body');
                        toastBody.textContent = 'Hardware information updated successfully!';
                        var toast = new bootstrap.Toast(toastElement, { delay: 3000 });
                        toast.show();

                        $("input[name='edit_hw_id']").val("");
                        $("input[name='edit_hw_region_name']").val("");
                        $("input[name='edit_site_name_input']").val("");
                        $("select[name='edit_sub_major_type']").val("");
                        $("select[name='edit_item_desc']").val("");
                        $("select[name='edit_brand_name']").val("");
                        $("select[name='edit_model_name']").val("");
                        $("input[name='edit_acquired_value']").val("");
                        $("input[name='edit_asset_num']").val("");
                        $("input[name='edit_serial_num']").val("");
                        $("input[name='edit_date_acquired']").val("");
                        $("select[name='hardware_status_option']").val("");
                        updateHardwareTable(); // Refresh table
                        console.log("Hardware ID %s updated at %s", hw_id, timestamp());
                    },
                    error: function(xhr, status, error) {
                        $("#displayHardwareValidation").addClass('disabled').hide();
                        console.error("AJAX Error updating hardware:", { status, error, response: xhr.responseText });
                        $("#addMessage").html(`
                        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> Failed to update hardware. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                    }
                });
            }
        }
    });


    $("#pullout-button").on("click", function() {
        const tracking_num = $("input[name='tracking_num']").val().trim();
        const track_required = $("#tracking_required");
        const validPattern = /^[0-9]{12}$/;
        const datePullout = $("input[name='edit_date_pullout']").val();
        const date_required = $("#date_required");

        var hw_id = $("input[name='edit_hw_id']").val();
        var brand_name = $("select[name='edit_brand_name']").val();
        var model_name = $("select[name='edit_model_name']").val();
        var acquired_value = $("input[name='edit_acquired_value']").val();
        var asset_num = $("input[name='edit_asset_num']").val();
        var serial_num = $("input[name='edit_serial_num']").val();
        var date_acquired = $("input[name='edit_date_acquired']").val();
        var hardwareStatus = $("select[name='hardware_status_option']").val();

        $("input[name='tracking_num']").removeClass("is-invalid");
        track_required.text("").removeClass("text-danger");

        if (!tracking_num) {
            track_required.text("Tracking number is required.").addClass("text-danger");
            $("input[name='tracking_num']").addClass("is-invalid");
            console.log("Pull out failed: missing tracking number at %s", timestamp());
        } else if (!validPattern.test(tracking_num)) {
            track_required.text("Tracking number must be exactly 12 digits and contain only numbers.").addClass("text-danger");
            $("input[name='tracking_num']").addClass("is-invalid");
            console.log("Pull out failed: invalid tracking number at %s", timestamp());
        } else if (datePullout == "") {
            $("input[name='edit_date_pullout']").addClass("is-invalid");
            date_required.text("Date pulled out is required.").addClass("text-danger");
            console.log("Pull out failed: missing date at %s", timestamp());
        } else {
            var wordObj = {
                tracking_num,
                hw_id_pullout: hw_id,
                datePullout
            };

            $.ajax({
                type: "POST",
                url: "tracking-number-add.php",
                data: wordObj,
                success: function(data) {
                    $("#trackingModal").modal("hide");
                    window.location.href = "requests.php";
                    console.log("Pull out successful for hardware_id: %s at %s", hw_id, timestamp());
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error adding tracking number:", { status, error, response: xhr.responseText });
                    alert("Error adding tracking number.");
                }
            });

            $("input[name='tracking_num']").val("").removeClass("is-invalid");
            track_required.text("");
        }
    });

    $("#addHardwareButton").click(function (){
        $(".addHardwareForm").val("");
        $("#addHWMessage").html("");
    });

});

function updateHardwareTable() {
    // Check if table exists in DOM
    if (!$("#hardwarePerSite").length) {
        console.error("Table #hardwarePerSite not found in DOM at %s", timestamp());
        $("#hardwareDisplay").html(`
            <tr>
                <td colspan='8' class='text-center text-danger'>
                    Table not found in page. Please check HTML structure.
                </td>
            </tr>
        `);
        return;
    }

    // Safely destroy DataTable if initialized
    try {
        if ($.fn.DataTable.isDataTable('#hardwarePerSite')) {
            $('#hardwarePerSite').DataTable().destroy();
            console.log("DataTable destroyed at %s", timestamp());
        }
    } catch (e) {
        console.warn("Error destroying DataTable: %s at %s", e.message, timestamp());
    }

    document.getElementById('viewHwType').disabled = false;

    var region_name = $("select[name='hw_region_name']").val() || 'all_region';
    var site_name = $("select[name='site_name']").val() || 'all_sites';
    var hw_type = $("select[name='hw_type']").val() || 'all_hw';

    console.log("Updating hardware table: region_name=%s, site_name=%s, hw_type=%s at %s", region_name, site_name, hw_type, timestamp());

    var url = "hardwares-view-details.php"; // Always use hardwares-view-details.php
    var data = { region_name, site_name, hw_type };

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        beforeSend: function() {
            console.log("beforeSend triggered for URL: %s at %s", url, timestamp());
            // Disable showHwButton if it exists
            var showHwButton = document.getElementById('showHwButton');
            if (showHwButton) {
                showHwButton.disabled = true;
            }
            // Disable addHardwareButton if it exists, without interrupting flow
            var addHardwareButton = document.getElementById('addHardwareButton');
            if (addHardwareButton) {
                addHardwareButton.disabled = true;
            }
            $("#hardwareDisplay").empty(); // Clear existing content
            $("#hardwareDisplay").html(`
                <tr>
                    <td colspan='8' class='text-center'>
                        <div class='spinner-grow spinner-grow-sm text-primary' role='status'>
                            <span class='sr-only'>Loading...</span>
                        </div>
                        <div class='spinner-grow spinner-grow-sm text-primary'></div>
                        <div class='spinner-grow spinner-grow-sm text-primary'></div>
                    </td>
                </tr>
            `);
        },
        success: function(data) {
            // Disable showHwButton if it exists
            var showHwButton = document.getElementById('showHwButton');
            if (showHwButton) {
                showHwButton.disabled = false;
            }
            // Disable addHardwareButton if it exists, without interrupting flow
            var addHardwareButton = document.getElementById('addHardwareButton');
            if (addHardwareButton) {
                addHardwareButton.disabled = false;
            }
            console.log("AJAX response received: %s at %s", data, timestamp());
            // Validate response
            if (!data.trim() || !data.includes('<tr')) {
                console.error("Invalid or empty AJAX response at %s", timestamp());
                $("#hardwareDisplay").html(`
                    <tr>
                        <td colspan='8' class='text-center text-danger'>
                            No hardware found for the selected filters.
                        </td>
                    </tr>
                `);
                return;
            }
            $("#hardwareDisplay").html(data);
            // Validate table structure
            var $tbody = $("#hardwarePerSite tbody");
            var rowCount = $tbody.find("tr").length;
            var headerCount = $("#hardwarePerSite thead th").length;
            var isValid = true;
            var isErrorResponse = false;
            $tbody.find("tr").each(function(index) {
                var cellCount = $(this).find("td").length;
                var colspan = parseInt($(this).find("td:first").attr("colspan") || 1);
                if (cellCount !== headerCount && !(cellCount === 1 && colspan === headerCount)) {
                    console.error(`Invalid row ${index + 1}: cells=${cellCount}, colspan=${colspan}, expected=${headerCount} at %s`, timestamp());
                    isValid = false;
                }
                if (cellCount === 1 && colspan === headerCount) {
                    isErrorResponse = true;
                }
            });
            console.log("Validation: rows=%s, headers=%s, valid=%s, errorResponse=%s at %s", rowCount, headerCount, isValid, isErrorResponse, timestamp());
            // Skip DataTables for error responses
            if (isErrorResponse) {
                console.log("Skipping DataTables initialization due to error response at %s", timestamp());
                $("#hardwareDisplay").html(data);
                return;
            }
            if (rowCount > 0 && isValid) {
                try {
                    $('#hardwarePerSite').DataTable({
                        "paging": true,
                        "ordering": false,
                        "searching": true
                    });
                    console.log("Hardware table loaded successfully at %s", timestamp());
                } catch (e) {
                    console.error("DataTables initialization error: %s at %s", e.message, timestamp());
                    $("#hardwareDisplay").html(`
                        <tr>
                            <td colspan='8' class='text-center text-danger'>
                                Error initializing table. Invalid data structure.
                            </td>
                        </tr>
                    `);
                }
            } else {
                console.error("Invalid table structure: rows=%s, headers=%s, valid=%s at %s", rowCount, headerCount, isValid, timestamp());
                $("#hardwareDisplay").html(`
                    <tr>
                        <td colspan='8' class='text-center text-danger'>
                            Invalid table structure. Check server response for errors.
                        </td>
                    </tr>
                `);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading hardware table:", { status, error, response: xhr.responseText }, "at %s", timestamp());
            $("#hardwareDisplay").html(`
                <tr>
                    <td colspan='8' class='text-center text-danger'>
                    Error loading hardware data. Please try again.
                    </td>
                </tr>
            `);
            alert("Error loading hardware data.");
        }
    });
}

function hardware_site_option() {
    var region_name = $("select[name='hw_region_name']").val() || 'all_region';

    if (region_name === 'all_region'){
        $("select[name='site_name']").val("all_sites");
        document.getElementById('viewSiteOption').disabled = true;
    }else{
        document.getElementById('viewSiteOption').disabled = false;
        document.getElementById('showHwButton').disabled = false;
        console.log("hardware_site_option called with region_name: %s at %s", region_name, timestamp());
        $.ajax({
            type: "POST",
            url: "hardwares-view-site.php",
            data: { region_name },
            success: function(data) {
                $("#viewSiteOption").html(data);
                $("select[name='site_name']").val('all_sites');
                console.log("Site dropdown options: %s at %s", data, timestamp());
                console.log("Site dropdown populated at %s", timestamp());
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error loading sites:", { status, error, response: xhr.responseText });
                $("#viewSiteOption").html('<option value="all_sites">All Sites</option>');
                alert("Error loading sites.");
            }
        });
    }
}
function hardwareUpdate(id) {
    $("#addMessage").html("");
    $("#saveHardwareBtn").hide();
    $("#updateHardwareBtn").show();
    $("#hardwareModalInput").modal('show');
    $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num'], select[name='edit_sub_major_type'], select[name='edit_item_desc']").removeClass('is-invalid');

    console.log("hardwareUpdate called with id: %s at %s", id, timestamp());

    $.ajax({
        type: "POST",
        url: "hardware-update-details.php",
        data: { hw_id: id, action: 'fetch_hardware' },
        dataType: "json",
        success: function(data) {
            if (data.error) {
                console.error("Error from server: %s", data.error);
                $("#addMessage").html(`<div class="alert alert-danger">${data.error}</div>`);
                return;
            }

            console.log("Hardware details loaded for id: %s at %s", id, timestamp());
            $("input[name='edit_hw_id']").val(data.hw_id || '');
            $("input[name='edit_hw_region_name']").val(data.region_name || '');
            $("input[name='edit_site_name_input']").val(data.site_code && data.site_name ? `${data.site_code} - ${data.site_name}` : '');

            var itemDescDropdown = $("#edit_item_desc");
            itemDescDropdown.empty();
            itemDescDropdown.append('<option value="" disabled>Select Item Description</option>');
            if (data.item_descriptions && Array.isArray(data.item_descriptions)) {
                $.each(data.item_descriptions, function(index, desc) {
                    itemDescDropdown.append(`<option value="${desc}">${desc}</option>`);
                });
                itemDescDropdown.val(data.item_desc || '');
            } else {
                itemDescDropdown.append('<option value="" disabled>No item descriptions available</option>');
            }

            var brandDropdown = $("#edit_brandSelect");
            brandDropdown.empty();
            brandDropdown.append('<option value="" disabled>Select Brand</option>');
            if (data.brands && Array.isArray(data.brands)) {
                $.each(data.brands, function(index, brand) {
                    brandDropdown.append(`<option value="${brand}">${brand}</option>`);
                });
                brandDropdown.val(data.selected_brand || '');
            } else {
                brandDropdown.append('<option value="" disabled>No brands available</option>');
            }

            var modelDropdown = $("#edit_model_option");
            modelDropdown.empty();
            modelDropdown.append('<option value="" disabled>Select model</option>');
            if (data.hw_model && Array.isArray(data.hw_model)) {
                $.each(data.hw_model, function(index, model) {
                    modelDropdown.append(`<option value="${model.model_name}">${model.model_name}</option>`);
                });
                modelDropdown.val(data.selected_model || '');
            } else {
                modelDropdown.append('<option value="" disabled>No models available</option>');
            }

            $("select[name='edit_sub_major_type']").val(data.sub_major_type || '');
            $("input[name='edit_acquired_value']").val(data.acq_val || '');
            $("input[name='edit_asset_num']").val(data.asset_num || '');
            $("input[name='edit_serial_num']").val(data.serial_num || '');
            $("input[name='edit_date_acquired']").val(data.date_acq || '');
            $("select[name='hardware_status_option']").val(data.hw_status || '');

            // Event listener for item_desc change
            $("#edit_item_desc").off('change').on('change', function() {
                var selectedItemDesc = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "hardware-update-details.php",
                    data: { item_desc: selectedItemDesc, action: 'fetch_brands' },
                    dataType: "json",
                    success: function(data) {
                        brandDropdown.empty();
                        brandDropdown.append('<option value="" disabled selected>Select Brand</option>');
                        if (data.brands && Array.isArray(data.brands)) {
                            $.each(data.brands, function(index, brand) {
                                brandDropdown.append(`<option value="${brand}">${brand}</option>`);
                            });
                        } else {
                            brandDropdown.append('<option value="" disabled>No brands available</option>');
                        }
                        modelDropdown.empty();
                        modelDropdown.append('<option value="" disabled selected>Select model</option>');
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error loading brands:", { status, error, response: xhr.responseText });
                        $("#addMessage").html('<div class="alert alert-danger">Error loading brands. Please try again.</div>');
                    }
                });
            });

            // Event listener for brand change
            $("#edit_brandSelect").off('change').on('change', function() {
                var selectedItemDesc = $("#edit_item_desc").val();
                var selectedBrand = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "hardware-update-details.php",
                    data: { item_desc: selectedItemDesc, brand: selectedBrand, action: 'fetch_models' },
                    dataType: "json",
                    success: function(data) {
                        modelDropdown.empty();
                        modelDropdown.append('<option value="" disabled selected>Select model</option>');
                        if (data.models && Array.isArray(data.models)) {
                            $.each(data.models, function(index, model) {
                                modelDropdown.append(`<option value="${model.model_name}">${model.model_name}</option>`);
                            });
                        } else {
                            modelDropdown.append('<option value="" disabled>No models available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error loading models:", { status, error, response: xhr.responseText });
                        $("#addMessage").html('<div class="alert alert-danger">Error loading models. Please try again.</div>');
                    }
                });
            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading hardware details:", { status, error, response: xhr.responseText });
            $("#addMessage").html('<div class="alert alert-danger">Error loading hardware details. Please try again.</div>');
        }
    });
}
function showHardwareModel() {
    var hw_id = $("input[name='edit_hw_id']").val();
    var brand_name = $("select[name='edit_brand_name']").val();

    console.log("showHardwareModel called with hw_id: %s, brand_name: %s at %s", hw_id, brand_name, timestamp());

    if (!hw_id || !brand_name) {
        console.error("Missing hw_id or brand_name:", { hw_id, brand_name, time: timestamp() });
        $("#edit_model_option").html('<option value="" disabled>Select model</option>');
        return;
    }

    $.ajax({
        type: "POST",
        url: "hardwares-change-model.php",
        data: { hw_id, brand_name },
        dataType: "json",
        beforeSend: function() {
            $("#edit_model_option").html('<option value="" disabled>Loading models...</option>');
            console.log("Loading models for brand: %s at %s", brand_name, timestamp());
        },
        success: function(data) {
            console.log("Model data received at %s", timestamp());
            var modelDropdown = $("#edit_model_option");
            modelDropdown.empty();
            modelDropdown.append('<option value="" disabled>Select model</option>');

            if (data.hw_model && Array.isArray(data.hw_model)) {
                $.each(data.hw_model, function(index, model) {
                    modelDropdown.append(`<option value="${model.model_name}">${model.model_name}</option>`);
                });
                console.log("Models loaded for brand: %s at %s", brand_name, timestamp());
            } else {
                console.warn("No models returned for brand: %s at %s", brand_name, timestamp());
                modelDropdown.append('<option value="" disabled>No models available</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading models:", { status, error, response: xhr.responseText });
            $("#edit_model_option").html('<option value="" disabled>Error loading models</option>');
            alert("Error loading models.");
        }
    });
}

function hardware_site_select() {
    var region_name = $("select[name='RegionSelect']").val();
    document.getElementById('hardwareSiteModal').disabled = false;

    console.log("hardware_site_select called with site_name: %s at %s", region_name, timestamp());

    $.ajax({
        type: "POST",
        url: "hardwares-site-modal.php",
        data: { region_name },
        success: function(data) {
            $("#hardwareSiteModal").html(data);
            console.log("Site modal populated at %s", timestamp());
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading site modal:", { status, error, response: xhr.responseText });
            alert("Error loading site modal data.");
        }
    });
}

function hardware_brand_option() {
    var item_name = $("select[name='itemSelect']").val();
    document.getElementById('itemBrand').disabled = false;
    document.getElementById('itemModel').disabled = false;

    console.log("hardware_brand_option called with item_name: %s at %s", item_name, timestamp());

    $.ajax({
        type: "POST",
        url: "hardware-brand-modal.php",
        data: { item_name },
        success: function(data) {
            $("#itemBrand").html(data);
            console.log("Brands loaded at %s", timestamp());
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading brands:", { status, error, response: xhr.responseText });
            alert("Error loading brands.");
        }
    });
}

function hardware_model_option() {
    var model_item_name = $("select[name='itemSelect']").val();

    console.log("hardware_model_option called with model_item_name: %s at %s", model_item_name, timestamp());

    $.ajax({
        type: "POST",
        url: "hardware-model-modal.php",
        data: { model_item_name },
        success: function(data) {
            $("#itemModel").html(data);
            console.log("Models loaded at %s", timestamp());
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading models:", { status, error, response: xhr.responseText });
            alert("Error loading models.");
        }
    });
}

function alertMessageSuccess(messageHTML) {
    const alert = document.getElementById("alertMessage");

    // Set message
    alert.innerHTML = messageHTML;

    // Reset display and classes
    alert.style.display = "block";
    alert.classList.remove("fade-out");
    void alert.offsetWidth; // Force reflow

    // Fade in
    alert.classList.add("fade-in");

    // Fade out after 3 seconds
    setTimeout(() => {
        alert.classList.remove("fade-in");
        alert.classList.add("fade-out");

        setTimeout(() => {
            alert.style.display = "none";
        }, 500); // Match transition duration
    }, 3000);
}