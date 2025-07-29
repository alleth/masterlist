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
});

// for binding edit hardware modal 2-----------------------------------
$('#EditHardwareModal').on('shown.bs.modal', function () {
    setupCascadingItemBrandModel('editItemSelect', 'editItemBrand', 'editItemModel');
});

/* /----------------- Load region select options ------------------------
   /**
     * Reusable loader for region dropdowns
     * @param {string} selectId - ID of the <select> element to populate
     *
    function loadRegionOptions(selectId) {
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
                console.error("AJAX Error loading region options:", {
                    status,
                    error,
                    response: xhr.responseText
                });
                alert("Error loading region options for #" + selectId);
            }
        });
    }
    */
   //----------------- Load region select options ------------------------
   /**
     * Reusable loader for region dropdowns
     * @param {string} selectId - ID of the <select> element to populate
     */
    function loadRegionOptions(selectId) {
        $.ajax({
            type: "POST",
            url: "hardware-region-modal.php",
            success: function(data) {
                const options = '<option value="" disabled selected>Select region</option>' + data;
                $("#" + selectId).html(options);
                console.log("Region options loaded for #" + selectId + " at %s", timestamp());
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error loading region options:", {
                    status,
                    error,
                    response: xhr.responseText
                });
                alert("Error loading region options for #" + selectId);
            }
        });
    }

    $(document).ready(function () {
        loadRegionOptions("RegionSelect");
        loadRegionOptions("editRegionSelect");
        loadRegionOptions("CpuPCRegionSelect");
    });

    //-Script for site select option-----------------------------------------------------------------------------------------
   /**
     * Reusable AJAX-based select population with prompt
     * @param {string} triggerSelectName - the <select name=""> that user changes (the parent)
     * @param {string} targetSelectId - the ID of the <select> to populate
     * @param {string} phpHandler - path to PHP file that returns the <option> list
     * @param {string} requestKey - key to send in POST (e.g., region_name, item_name)
     */
    function setupDependentSelect(triggerSelectName, targetSelectId, phpHandler, requestKey) {
        $(document).on("change", `select[name='${triggerSelectName}']`, function () {
            const selectedValue = $(this).val();
            const $targetSelect = $("#" + targetSelectId);

            if (!selectedValue) {
                $targetSelect.prop("disabled", true).html(`<option value="">Select ${triggerSelectName} first</option>`);
                return;
            }

            $targetSelect.prop("disabled", false).html(`<option disabled selected>Loading...</option>`);

            $.ajax({
                type: "POST",
                url: phpHandler,
                data: { [requestKey]: selectedValue },
                success: function (response) {
                    const defaultPrompt = `<option value="" disabled selected>Select Site</option>`;
                    $targetSelect.html(defaultPrompt + response);
                },
                error: function (xhr, status, error) {
                    console.error(`Error loading options for #${targetSelectId}`, { status, error });
                    $targetSelect.html(`<option disabled selected>Error loading options</option>`);
                }
            });
        });
    }

    $(document).ready(function () {
        // Setup all dependent selects here
        setupDependentSelect("RegionSelect", "hardwareSiteModal", "hardwares-site-modal.php", "region_name");
        setupDependentSelect("editRegionSelect", "editHardwareSiteModal", "hardwares-site-modal.php", "region_name");
        setupDependentSelect("CpuPCRegionSelect", "CpuPCSiteSelect", "hardwares-site-modal.php", "region_name");
    });

//-------------- select for item descriptions  --------------------------------------------------------------------------------
/**
 * Sets up cascading item → brand → model select dropdowns
 * @param {string} itemId - ID of the item <select>
 * @param {string} brandId - ID of the brand <select>
 * @param {string} modelId - ID of the model <select>
 */
function setupCascadingItemBrandModel(itemId, brandId, modelId) {
    const $item = $('#' + itemId);
    const $brand = $('#' + brandId);
    const $model = $('#' + modelId);

    // Load initial item options
    loadSelectOptions(itemId, 'item_description', 'item_desc', 'hardware-item-description-modal.php', 'Select Item');

    // Disable brand/model at start
    $brand.prop('disabled', true);
    $model.prop('disabled', true);

    // When item changes → fetch brands
    $item.on('change', function () {
        const selectedItem = $(this).val();

        resetSelect(brandId, 'Select Brand');
        resetSelect(modelId, 'Select Model', true);

        if (selectedItem) {
            fetchBrands(selectedItem, brandId);
        }
    });

    // When brand changes → fetch models
    $brand.on('change', function () {
        const selectedBrand = $(this).val();
        const selectedItem = $item.val();

        resetSelect(modelId, 'Select Model');

        if (selectedItem && selectedBrand) {
            fetchModels(selectedItem, selectedBrand, modelId);
        }
    });
}

function loadSelectOptions(selectId, table, column, url, placeholder = 'Select an option') {
    const $select = $('#' + selectId);

    $.ajax({
        url: url,
        method: 'GET',
        data: { table, column },
        dataType: 'json',
        success: function (options) {
            $select.empty().append(`<option value="" disabled selected>${placeholder}</option>`);
            options.forEach(opt => {
                $select.append(`<option value="${opt}">${opt}</option>`);
            });
            $select.prop("disabled", false);
        },
        error: function (xhr) {
            console.error(`Error loading #${selectId}:`, xhr.responseText);
            $select.html('<option disabled>Error loading data</option>');
        }
    });
}
//-- for reselecting the --//
function resetSelect(selectId, placeholder = 'Select an option', disable = false) {
    const $select = $('#' + selectId);
    $select.empty().append(`<option value="" disabled selected>${placeholder}</option>`);
    $select.prop('disabled', disable);
}

//-- for select brand -- //
function fetchBrands(item_desc, brandId) {
    const $brandSelect = $('#' + brandId);

    $.ajax({
        url: 'hardware-brand-modal.php',
        method: 'POST',
        data: { item_desc },
        dataType: 'json',
        success: function (brands) {
            resetSelect(brandId, 'Select Brand', false);

            brands.forEach(brand => {
                $brandSelect.append(`<option value="${brand}">${brand}</option>`);
            });

            $brandSelect.prop('disabled', false);
        },
        error: function (xhr) {
            console.error("Error loading brands:", xhr.responseText);
            $brandSelect.html('<option disabled>Error loading brands</option>');
        }
    });
}

//-- For Select Model --//
function fetchModels(item_desc, brand, modelId) {
    const $modelSelect = $('#' + modelId);

    $.ajax({
        url: 'hardware-model-modal.php',
        method: 'POST',
        data: { item_desc, brand },
        dataType: 'json',
        success: function (models) {
            resetSelect(modelId, 'Select Model', false);

            models.forEach(model => {
                $modelSelect.append(`<option value="${model}">${model}</option>`);
            });

            $modelSelect.prop('disabled', false);
        },
        error: function (xhr) {
            console.error("Error loading models:", xhr.responseText);
            $modelSelect.html('<option disabled>Error loading models</option>');
        }
    });
}

function setupSubTypeAutofill(itemSelectId, subTypeInputId) {
    $('#' + itemSelectId).on('change', function () {
        const selectedItem = $(this).val();

        if (selectedItem) {
            fetchSubType(selectedItem, subTypeInputId);
        } else {
            $('#' + subTypeInputId).val('');
        }
    });
}

function fetchSubType(item_desc, inputId) {
    $.ajax({
        url: 'hardware-subtype-modal.php',
        method: 'POST',
        data: { item_desc },
        dataType: 'json',
        success: function (response) {
            if (response && !response.error) {
                $('#' + inputId).val(response.sub_major_type || '');
            } else {
                console.warn("No subtype found or error:", response);
                $('#' + inputId).val('');
            }
        },
        error: function (xhr) {
            console.error("AJAX error:", xhr.responseText);
            $('#' + inputId).val('');
        }
    });
}


$(document).ready(function () {
    setupCascadingItemBrandModel('itemSelect', 'itemBrand', 'itemModel');
    setupCascadingItemBrandModel('editItemSelect', 'editItemBrand', 'editItemModel');

    setupSubTypeAutofill('itemSelect', 'SubType');
    setupSubTypeAutofill('editItemSelect', 'editSubType');
});
//end of codes for select options--------------------------------------------------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {
        const prefixTextEl = document.getElementById('prefixText');
        const assetNumInput = document.getElementById('asset_num');

        // === Update prefix text on radio selection ===
        document.querySelectorAll('input[name="assetType"]').forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.checked) {
                    prefixTextEl.textContent = radio.value;

                    // ✅ Disable #asset_num if prefix is 'Unreadable' or 'No Tag'
                    if (radio.value === "Unreadable" || radio.value === "No Tag") {
                        assetNumInput.value = '';
                        assetNumInput.disabled = true;
                    } else {
                        assetNumInput.disabled = false;
                    }
                }
            });
        });

       // === Modal open reset logic ===
        $('#AddHardwareModal').on('shown.bs.modal', function () {
            $('#hardwareForm')[0].reset();
            $('#prefixText').text("Type");
            $('#addHWMessage, #response').empty();
            $('#addNewHardwareBtn').prop('disabled', false);

            // ✅ Deselect all radio buttons
            $('input[name="assetType"], input[name="type"]').prop('checked', false);

            // ✅ Reset selects and disable fields
            $('#itemSelect').val('').trigger('change');
            $('#itemBrand, #itemModel, #hardwareSiteModal').val('').prop('disabled', true);
            $('#asset_num, #serial_num').val('').prop('disabled', false);

            // ✅ Remove is-invalid from inputs
            $('#RegionSelect, #hardwareSiteModal, #itemSelect, #itemBrand, #itemModel, #asset_num, #serial_num, #date')
                .removeClass('is-invalid');

            // ✅ Remove is-invalid from radio buttons
            $('input[name="assetType"]').removeClass('is-invalid');

            // ✅ Clear warning/validation messages
            $('#addHWMessage').html('');
        });


        // === Save button logic ===
        $('#addNewHardwareBtn').off('click').on('click', function () {

            const prefixText = prefixTextEl.textContent.trim();
            const isAssetTypeSelected = $('input[name="assetType"]:checked').length > 0;
            const RegionSelect = $('#RegionSelect').val();
            const hardwareSiteModal = $('#hardwareSiteModal').val();
            const itemSelect = $('#itemSelect').val();
            const SubType = $('#SubType').val();
            const itemBrand = $('#itemBrand').val();
            const itemModel = $('#itemModel').val();
            const asset_num = $('#asset_num').val();
            const serial_num = $('#serial_num').val();
            const date = $('#date').val();
            const acquired_value = $('#acquired_value').val();
            const hw_status = "On Site";
            const assetIdCombined = `${prefixText} ${asset_num}`;

            const wordObj = {
                RegionSelect,
                hardwareSiteModal,
                itemSelect,
                SubType,
                itemBrand,
                itemModel,
                asset_num,
                serial_num,
                prefixText,
                date,
                acquired_value,
                assetIdCombined,
                hw_status
            };

            // === Validate required fields ===
            let hasError = false;

            // Remove previous error states
            $('#RegionSelect, #hardwareSiteModal, #itemSelect, #itemBrand, #itemModel, #asset_num, #serial_num, #date')
                .removeClass('is-invalid');
            // Region
            if (!RegionSelect) {
                $('#RegionSelect').addClass('is-invalid');
                hasError = true;
            }
            // Site
            if (!hardwareSiteModal) {
                $('#hardwareSiteModal').addClass('is-invalid');
                hasError = true;
            }
            // Item
            if (!itemSelect || itemSelect === "Select item") {
                $('#itemSelect').addClass('is-invalid');
                hasError = true;
            }
            // Brand
            if (!itemBrand || itemBrand === "Select brand") {
                $('#itemBrand').addClass('is-invalid');
                hasError = true;
            }
            // Model
            if (!itemModel || itemModel === "Select model") {
                $('#itemModel').addClass('is-invalid');
                hasError = true;
            }
            // Asset type radio buttons
            if (!isAssetTypeSelected) {
                $("input[name='assetType']").addClass('is-invalid');
                hasError = true;
            } else {
                $("input[name='assetType']").removeClass('is-invalid');
            }

            // Asset number (only if not Unreadable/No Tag)
            if ((prefixText !== "Unreadable" && prefixText !== "No Tag") && !asset_num) {
                $('#asset_num').addClass('is-invalid');
                hasError = true;
            }

            // Serial number
            if (!serial_num) {
                $('#serial_num').addClass('is-invalid');
                hasError = true;
            }

            // Date
            if (!date) {
                $('#date').addClass('is-invalid');
                hasError = true;
            }

            if (hasError) {
                $('#addHWMessage').html(`
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        All fields are required!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
                return;
            }


            $(this).prop('disabled', true); // prevent double click

            $.ajax({
                type: 'POST',
                url: 'hardware-add-details.php',
                data: wordObj,
                success: function (saveResponse) {
                    if (saveResponse.includes('Already Exist')) {
                        $('#addHWMessage').html(`
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                ${saveResponse}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
                    } else {
                        $('#AddHardwareModal').modal('hide');
                        $('#response').html(saveResponse);
                        alertMessageSuccess(`<strong>Hardware successfully Added!</strong>`);

                        // Full manual reset
                        $('#hardwareForm')[0].reset();
                        $('#prefixText').text("Type");
                        $('input[name="assetType"], input[name="type"]').prop('checked', false);
                        $('#itemSelect').val('').trigger('change');
                        $('#itemBrand, #itemModel, #hardwareSiteModal').val('').prop('disabled', true);
                        $('#asset_num, #serial_num').val('').prop('disabled', false);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", { status, error, response: xhr.responseText });
                    $('#response').html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        An error occurred while saving the data.
                        </div>`);
                },
                complete: function () {
                    $('#addNewHardwareBtn').prop('disabled', false);
                }
            });
        });
    });
//------------------------------------------------------------------------------------------------------------------------------------------------


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

    //------ for Delete record by hw_id -------------------------
    let selectedHwIdToDelete = null;

    function hardwareDelete(hw_id) {
        selectedHwIdToDelete = hw_id;
        $('#delete_hw_id').val(hw_id);
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        const hw_id = $('#delete_hw_id').val();

        $.ajax({
            url: 'hardware-delete-details.php',
            type: 'POST',
            data: {
                hw_id: hw_id
            },
            success: function(response) {
                console.log("AJAX response:", response); // Add this
                if (response.trim() === "success") {
                $('#' + hw_id).remove();
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                modal.hide();
                } else {
                alert("Delete failed: " + response);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error); // Add this
                alert("AJAX error occurred while deleting.");
            }
        });
    });
}

    //---for edit modal------------------------------------------
        function hardwareUpdate2(hw_id) {
            console.log("hardwareUpdate2 called:", hw_id);

            $.ajax({
                type: "POST",
                url: "hardware-edit-details2.php",
                data: { hw_id },
                dataType: "json",
                error: function (xhr, status, error) {
                    console.error("Failed fetching hardware data:", status, error, xhr.responseText);
                    alert("Failed to fetch hardware data.");
                },
                success: function (data) {
                    console.log("Received data:", data);

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById("EditHardwareModal"));
                    modal.show();

                    // ID hidden
                    $("#edit_hw_id").val(data.hw_id);

                    // Region
                    $("#editPrefixRegion").text(data.region_id);
                    $("#editPrefixRegionName").text(data.region_name);
                    $("#editRegionSelect").val(data.region_id);

                    // Site
                    $("#editHardwareSiteModal").html(data.site_html);

                    // Item type (read-only)
                    const itemText = $(data.item_html).text().trim();
                    $("#editPrefixType").text(itemText);

                    // Sub Type
                    $('#editSubType').val(data.sub_major_type);

                    // Brand & model
                    $("#editItemBrand").html(data.brand_html);
                    $("#editItemModel").html(data.model_html);

                    // ✅ Extract prefix and number from asset number
                    const hwAsset = (data.hw_asset_num || "").trim();
                    let prefix = "";
                    let number = "";

                    // Special cases
                    if (hwAsset === "No Tag") {
                        prefix = "No Tag";
                        number = "";
                    } else if (hwAsset === "Unreadable") {
                        prefix = "Unreadable";
                        number = "";
                    } else {
                        const parts = hwAsset.split(/\s+/);

                        if (parts.length > 1) {
                            // e.g., "PE 12345"
                            prefix = parts.slice(0, -1).join(" ");
                            number = parts.slice(-1)[0];
                        } else {
                            // e.g., "PE12345" or just "12345"
                            const knownPrefixes = ["PE", "CI"];
                            const match = knownPrefixes.find(p => hwAsset.startsWith(p));

                            if (match && hwAsset.length > match.length) {
                                prefix = match;
                                number = hwAsset.slice(match.length).trim();
                            } else if (/^\d+$/.test(hwAsset)) {
                                // Pure number only
                                prefix = "";
                                number = hwAsset;
                            } else {
                                // Unknown format fallback
                                prefix = hwAsset;
                                number = "";
                            }
                        }
                    }

                    console.log("Prefix:", prefix, "| Asset Number:", number);

                    // Set radio button
                    const $radio = $(`input[name="assetType"][value="${prefix}"]`);
                    if ($radio.length) {
                        $radio.prop("checked", true).trigger("change");
                    } else {
                        console.warn("No matching radio found for:", prefix);
                    }

                    // Set display and input field values
                    $("#editPrefixText").text(prefix);
                    $("#editAssetNum").val(number);

                    // Disable or enable asset number input based on prefix
                    if (prefix === "Unreadable" || prefix === "No Tag") {
                        $("#editAssetNum").prop("disabled", true);
                    } else {
                        $("#editAssetNum").prop("disabled", false);
                    }

                    // Other fields
                    $("#editSerialNum").val(data.hw_serial_num);
                    $("#editDate").val(data.hw_date_acq);
                    $("#editAcquiredValue").val(data.hw_acq_val);
                }
            });
        } 

        $('#updateHardwareBtn2').on('click', function (e) {
            e.preventDefault();

            const data = {
                hw_id: $('#edit_hw_id').val(),
                itemSelect: $('#editPrefixType').text(),
                itemBrand: $('#editItemBrand').val(),
                itemModel: $('#editItemModel').val(),
                prefixText: $('#editPrefixText').text(),
                asset_num: $('#editAssetNum').val(),
                serial_num: $('#editSerialNum').val(),
                date: $('#editDate').val(),
                acquired_value: $('#editAcquiredValue').val(),
                subType: $('#editSubType').val(),
                regionName: $('#editPrefixRegion').text().trim(),
                siteCode: $('#editHardwareSiteModal').val()
            };

            // Define which fields are required (for validation)
            const requiredFields = [
                data.itemSelect,
                data.itemBrand,
                data.itemModel,
                data.prefixText,
                data.asset_num,
                data.serial_num,
                //data.date, //-- Remove the Comments to include in validation
                //data.acquired_value, //-- Remove the Comments to include in validation
                data.subType,
                data.regionName,
                data.siteCode
            ];

            // Field keys in order
            const keys = [
                'itemSelect', 'itemBrand', 'itemModel', 'prefixText',
                'asset_num', 'serial_num', //'date', //'acquired_value', //-- Remove the Comments to include in validation
                'subType', 'regionName', 'siteCode'
            ];

            // Mapping keys to selectors
            const fieldSelectors = {
                itemSelect: '#editItemSelect',
                itemBrand: '#editItemBrand',
                itemModel: '#editItemModel',
                asset_num: '#editAssetNum',
                serial_num: '#editSerialNum',
                //date: '#editDate', //-- Remove Comment to include validation
                //acquired_value: '#editAcquiredValue', //-- Remove Comment to include validation
                subType: '#editSubType',
                siteCode: '#editHardwareSiteModal'
            };

            // Special case: allow asset_num to be blank if prefixText is "Unreadable" or "No Tag"
            let isInvalid = false;

            requiredFields.forEach((value, index) => {
                const key = keys[index];
                const selector = fieldSelectors[key];
                const trimmedValue = (value || '').toString().trim();

                const allowBlankAsset = (
                    key === 'asset_num' &&
                    ['Unreadable', 'No Tag'].includes(data.prefixText)
                );

                const isFieldInvalid = (
                    trimmedValue === '' ||
                    trimmedValue === 'Select brand' ||
                    trimmedValue === 'Select model' ||
                    trimmedValue === 'Select region' ||
                    trimmedValue === 'Type' ||
                    trimmedValue === 'Select item'
                ) && !allowBlankAsset;

                if (isFieldInvalid && selector) {
                    $(selector).addClass('is-invalid');
                    isInvalid = true;
                }

                if (key === 'prefixText' && isFieldInvalid) {
                    // Apply Bootstrap red validation to each radio in the group
                    $("input[name='editAssetType']").addClass('is-invalid');
                    isInvalid = true;
                }


                // For non-inputs like regionName and prefixText (spans), you can optionally highlight their containers
                if (isFieldInvalid && !selector) {
                    // Optional: Add a red border to span wrappers if desired
                    // $('#editPrefixRegion').closest('.form-group').addClass('border border-danger');
                }
            });

            if (isInvalid) {
                $('#editHWMessage').html(`
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        All fields are required!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                return;
            }

            $.ajax({
                url: 'hardware-update-details2.php',
                type: 'POST',
                data: data,
                success: function (saveResponse) {
                    if (saveResponse.includes('Already Exist')) {
                        $('#editHWMessage').html(`
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                ${saveResponse}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
                    } else if (saveResponse.trim() === 'success') {
                        $('#EditHardwareModal').modal('hide');
                        $('#response').html(saveResponse);
                        alertMessageSuccess(`<strong>Hardware successfully Updated!</strong>`);

                        /*/ Optional: Reset edit form (if you want)
                        $('#editHardwareForm')[0].reset();
                        $('#editPrefixText').text("Type");
                        $('input[name="editAssetType"], input[name="type"]').prop('checked', false);
                        $('#editItemSelect').val('').trigger('change');
                        $('#editItemBrand, #editItemModel, #editHardwareSiteModal').val('').prop('disabled', true);
                        $('#editAssetNum, #editSerialNum').val('').prop('disabled', false);*/
                    } else {
                        $('#editHWMessage').html(`
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                ${saveResponse}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
                    }
                },
                /*success: function (saveResponse) {
                    if (saveResponse.trim() === 'success') {
                        $('#EditHardwareModal').modal('hide');
                        $('#response').html(saveResponse);
                        alertMessageSuccess(`<strong>Hardware successfully Updated!</strong>`);
                    } else {
                        alert('Update failed: ' + saveResponse);
                    }
                },*/
                error: function (xhr, status, error) {
                    console.error('AJAX error:', error);
                    alert('An error occurred while updating.');
                }
            });
        });

        $(document).on("change", "input[name='editAssetType']", function () {
            const selected = $(this).val();
            $("#editPrefixText").text(selected);

            // Optional logic to disable asset number field for special types
            if (selected === "Unreadable" || selected === "No Tag") {
                $("#editAssetNum").prop("disabled", true).val("");
            } else {
                $("#editAssetNum").prop("disabled", false);
            }
        });

        $(document).on('keydown', 'input[type=number]', function (e) {
            if (e.key === 'e' || e.key === 'E' || e.key === '+' || e.key === '-') {
                e.preventDefault();
            }
        });

        $(document).ready(function () {
            $('#EditHardwareModal').on('hidden.bs.modal', function () {
                // Reset the form fields
                $('#editHardwareForm')[0].reset();

                // Deselect all radio buttons
                $("input[name='editAssetType']").prop("checked", false);

                // Reset asset prefix label and re-enable input
                $('#editPrefixText').text('Type');
                $('#editAssetNum').prop("disabled", false);

                // Reset region fields
                $('#editPrefixRegion').addClass('d-none');
                $('#editPrefixRegionName').removeClass('d-none');
                $('#editRegionSelect').val('').addClass('d-none');
                $('#editHardwareSiteModal').val('').prop('disabled', true);

                // Reset item fields and trigger UI change
                $('#editItemSelect, #editItemBrand, #editItemModel')
                    .val('')
                    .trigger('change');

                // Reset subtype and result fields
                $('#editSubType').val('');
                $('#editResult').text('');

                // Reset the the radio
                $("input[name='editAssetType']").removeClass('is-invalid');

                // Optional: remove dynamically injected options if you add any
                $('#editItemSelect option.added-dynamically').remove();
                $('#editItemBrand option.added-dynamically').remove();
                $('#editItemModel option.added-dynamically').remove();

                $("input[name='editAssetType']").on('change', function () {
                    $("input[name='editAssetType']").removeClass('is-invalid');
                });

            });
        });

        $('#EditHardwareModal').on('show.bs.modal', function () {
            // Clear validation message when the modal is opened
            $('#editHWMessage').html('');
            // Clear any previous validation styles
            $('#editHardwareForm .form-control, #editHardwareForm .form-select').removeClass('is-invalid');
        });

        //--- for edit region prefix code to show or hide -----------------------------------
        $(document).ready(function () {
            // When the span is clicked
            $('#editPrefixRegionName').on('click', function () {
                $(this).addClass('d-none');                     // Hide span
                $('#editRegionSelect')
                    .removeClass('d-none')                      // Show select
                    .val('')                                    // Reset to default option
                    .focus();                                   // Focus the select
            });

            // When the user selects a region
            $('#editRegionSelect').on('change', function () {
                const selectedText = $(this).find('option:selected').text();

                $('#editPrefixRegionName').text(selectedText);  // Show selected name in span

                $(this).addClass('d-none');                     // Hide select
                $('#editPrefixRegionName').removeClass('d-none'); // Show span again
            });

            // Set initial region name if already selected
            const initialText = $('#editRegionSelect option:selected').text();
            if (initialText && initialText !== 'Select region') {
                $('#editPrefixRegionName').text(initialText);
            }
        });

        //----- for edit Item description to show or hide--------------------------------
        $(document).ready(function () {
            // When the span is clicked
            $('#editPrefixType').on('click', function () {
                $(this).addClass('d-none');                       // Hide span
                $('#editItemSelect')
                    .removeClass('d-none')                        // Show select
                    .val('')                                      // Reset to default option
                    .focus();                                     // Focus the select
            });

            // When the user selects an item
            $('#editItemSelect').on('change', function () {
                const selectedText = $(this).find('option:selected').text();

                $('#editPrefixType').text(selectedText);              // Show selected name in span

                $(this).addClass('d-none');                       // Hide select
                $('#editPrefixType').removeClass('d-none');           // Show span again
            });

            // Set initial item name if already selected
            const initialText = $('#editItemSelect option:selected').text();
            if (initialText && initialText !== 'Select item') {
                $('#editPrefixType').text(initialText);
            }
        });
    //----------------------------------------------------------------------------------------------------------------------------
    function alertMessageSuccess(messageHTML) {
        const alert = document.getElementById("alertMessage");

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