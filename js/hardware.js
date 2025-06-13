
function timestamp() {
    return new Date().toLocaleString("en-US", { timeZone: "UTC" });
}
$(function(){
    console.log("=== hardware.js loaded successfully at %s ===", timestamp());

    $("#updateHardwareBtn").hide();
    $("#displayHardwareValidation").hide();

    // Helper function for timestamp
    function timestamp() {
        return new Date().toLocaleString("en-US", { timeZone: "UTC" });
    }

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
            $("select[name='hw_region_name']").removeAttr("onchange");
            $("select[name='hw_region_name']").off("change").on("change", hardware_site_option);
            console.log("Region dropdown bound to hardware_site_option at %s", timestamp());
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
                if (saveResponse.includes("Asset Number Already Exist")) {
                    $("#addHWMessage").html(`
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>${saveResponse}</strong><br>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                } else if (saveResponse.includes("Serial Number Already Exist on site")) {
                    $("#addHWMessage").html(`
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>${saveResponse}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                } else if (saveResponse.includes("Asset Number and Serial Number Already Exist on site")) {
                    $("#addHWMessage").html(`
                        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>${saveResponse}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                } else {
                    $("#AddHardwareModal").modal('hide');
                    $('#response').html(saveResponse);
                    alertMessageSuccess(`<strong>Hardware successfully save!</strong>`);
                    $('select, input').val('');
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
        $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num']").removeClass('is-invalid');
        $("input[name='tracking_num']").val("").removeClass("is-invalid");
        $("#tracking_required").text("");
        $("input[name='edit_date_pullout']").val("").removeClass("is-invalid");
        $("#date_required").text("");

        var hw_id = $("input[name='edit_hw_id']").val();
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
        if (brand_name === "") {
            $("select[name='edit_brand_name']").addClass('is-invalid');
            hasEmptyFields = true;
        }
        if (model_name === "") {
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
            $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num']").removeClass('is-invalid');
            $("#addMessage").html("");
            if (hardwareStatus === "Pull Out") {
                $("#warning-pullout").html(`<i class='fas fa-exclamation-triangle'></i> You're about to pull out this hardware with Asset No. <b>${asset_num}</b>`);
                $("#hardwareModalInput").modal('hide');
                $("#trackingModal").modal('show');
                console.log("Pull out initiated for asset_num: %s at %s", asset_num, timestamp());
            } else {
                var wordObj = {
                    hw_id,
                    brand_name,
                    model_name,
                    acquired_value,
                    asset_num,
                    serial_num,
                    date_acquired
                };

                $.ajax({
                    type: "POST",
                    url: "hardwares-save-details.php",
                    data: wordObj,
                    beforeSend: function () {
                        $("#displayHardwareValidation").show();
                        console.log("Updating hardware ID: %s at %s", hw_id, timestamp());
                    },
                    success: function(data) {
                        $(document.getElementById(wordObj.hw_id)).html(data);
                        $("#addMessage").html(`
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Updated Successfully!</strong> You updated hardware information.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        $("input[name='edit_hw_id']").val("");
                        $("input[name='edit_hw_region_name']").val("");
                        $("input[name='edit_site_name_input']").val("");
                        $("select[name='edit_brand_name']").val("");
                        $("select[name='edit_model_name']").val("");
                        $("input[name='edit_acquired_value']").val("");
                        $("input[name='edit_asset_num']").val("");
                        $("input[name='edit_serial_num']").val("");
                        $("input[name='edit_date_acquired']").val("");
                        $("#displayHardwareValidation").hide();
                        $("#updateHardwareBtn").show();
                        console.log("Hardware ID %s updated at %s", hw_id, timestamp());
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error updating hardware:", { status, error, response: xhr.responseText });
                        alert("Error updating hardware.");
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
    if ($.fn.DataTable.isDataTable('#hardwarePerSite')) {
        $('#hardwarePerSite').DataTable().destroy();
        console.log("DataTable destroyed at %s", timestamp());
    }
    document.getElementById('viewHwType').disabled = false;

    var site_name = $("select[name='site_name']").val();
    var hw_type = $("select[name='hw_type']").val();

    console.log("Updating hardware table: site_name=%s, hw_type=%s at %s", site_name, hw_type, timestamp());

    var url = hw_type !== 'all_hw' ? "hardwares-view-specific-details.php" : "hardwares-view-details.php";
    var data = hw_type !== 'all_hw' ? { site_name, hw_type } : { site_name };

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        beforeSend: function() {
            $("#rowdisplay").html(`
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow spinner-grow-sm text-primary"></div>
                            <div class="spinner-grow spinner-grow-sm text-primary"></div>
                        </td>
                    </tr>
                `);
            console.log("Loading hardware table at %s", timestamp());
        },
        success: function(data) {
            $("#hardwareDisplay").html(data);
            $('#hardwarePerSite').DataTable({
                "paging": true,
                "ordering": false,
                "searching": true
            });
            console.log("Hardware table loaded at %s", timestamp());
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error loading hardware table:", { status, error, response: xhr.responseText });
            alert("Error loading hardware data.");
        }
    });
}

    function hardware_site_option() {
        var region_name = $("select[name='hw_region_name']").val();
        document.getElementById('viewSiteOption').disabled = false;
        document.getElementById('showHwButton').disabled = false;

        console.log("hardware_site_option called with region_name: %s at %s", region_name, timestamp());

        var wordObj = { region_name };

        $.ajax({
            type: "POST",
            url: "hardwares-view-site.php",
            data: wordObj,
            success: function(data) {
                $("#viewSiteOption").html(data);
                console.log("Site dropdown populated at %s", timestamp());
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error loading sites:", { status, error, response: xhr.responseText });
                alert("Error loading sites.");
            }
        });
    }

    function hardwareUpdate(id) {
        $("#addMessage").html("");
        $("#saveHardwareBtn").hide();
        $("#updateHardwareBtn").show();
        $("#hardwareModalInput").modal('show');
        $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num']").removeClass('is-invalid');

        console.log("hardwareUpdate called with id: %s at %s", id, timestamp());

        var wordObj = { hw_id: id };
        $.ajax({
            type: "POST",
            url: "hardware-update-details.php",
            data: wordObj,
            dataType: "json",
            success: function(data) {
                console.log("Hardware details loaded for id: %s at %s", id, timestamp());
                $("input[name='edit_hw_id']").val(data.hw_id);
                $("input[name='edit_hw_region_name']").val(data.region_name);
                $("input[name='edit_site_name_input']").val(data.site_code + " - " + data.site_name);

                var brandDropdown = $("#edit_brandSelect");
                brandDropdown.empty();
                brandDropdown.append('<option value="" disabled>Select Brand</option>');
                $.each(data.brands, function(index, brand) {
                    brandDropdown.append(`<option value="${brand}">${brand}</option>`);
                });
                if (data.selected_brand) {
                    brandDropdown.val(data.selected_brand);
                }

                var modelDropdown = $("#edit_model_option");
                modelDropdown.empty();
                modelDropdown.append('<option value="" disabled>Select model</option>');
                $.each(data.hw_model, function(index, model) {
                    modelDropdown.append(`<option value="${model.model_name}">${model.model_name}</option>`);
                });
                if (data.selected_model) {
                    modelDropdown.val(data.selected_model);
                }
                $("input[name='edit_acquired_value']").val(data.acq_val);
                $("input[name='edit_asset_num']").val(data.asset_num);
                $("input[name='edit_serial_num']").val(data.serial_num);
                $("input[name='edit_date_acquired']").val(data.date_acq);
                $("select[name='hardware_status_option']").val(data.hw_status);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error loading hardware details:", { status, error, response: xhr.responseText });
                alert("Error loading hardware details.");
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

        var wordObj = { hw_id, brand_name };

        $.ajax({
            type: "POST",
            url: "hardwares-change-model.php",
            data: wordObj,
            dataType: "json",
            beforeSend: function() {
                $("#edit_model_option").html('<option value="" disabled>Loading models...</option>');
                console.log("Loading models for brand: %s at %s", brand_name, timestamp());
            },
            success: function(data) {
                console.log("Model data received:", data, "at %s", timestamp());
                var modelDropdown = $("#edit_model_option");
                modelDropdown.empty();
                modelDropdown.append('<option value="" disabled>Select model</option>');

                if (data.hw_model && data.hw_model.length > 0) {
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
                alert("Error loading models: " + (xhr.responseText || "Unknown error. Check console for details."));
            }
        });
    }

    function hardware_site_select() {
        var region_name = $("select[name='RegionSelect']").val();
        document.getElementById('hardwareSiteModal').disabled = false;

        console.log("hardware_site_select called with site_name: %s at %s", region_name, timestamp());

        var wordObj = { region_name };

        $.ajax({
            type: "POST",
            url: "hardwares-site-modal.php",
            data: wordObj,
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

        var wordObj = { item_name };

        $.ajax({
            type: "POST",
            url: "hardware-brand-modal.php",
            data: wordObj,
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

        var wordObj = { model_item_name };

        $.ajax({
            type: "POST",
            url: "hardware-model-modal.php",
            data: wordObj,
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
