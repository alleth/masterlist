$(function () {
    $("#updateSiteTitle").hide();
    $("#updateOfficeButton").hide();
    $("#addOfficeButtonDisabled").hide();

    // Bind onchange events to replace inline attributes
    $("#region_directory").on("change", directory_site_option);
    $("#viewSiteDirectory").on("change", directory_site_name);

    $.ajax({
        type: "POST",
        url: "directory-region.php",
        success: function(data){
            $("#displayRegionFilter").html(data);
        },
        error: function(){
            alert("Failed to load region filter");
        }
    });

    $.ajax({
        type: "POST",
        url: "directory-modal-region.php",
        success: function(data){
            $("#displayModalRegion").html(data);
        },
        error: function(){
            alert("Failed to load modal region");
        }
    });

    $("#showDirectory").click(function(){
        if ($.fn.DataTable.isDataTable('#directoryTable')) {
            $('#directoryTable').DataTable().destroy();
        }

        var region_name = $("#region_directory").val();
        var officeType = $("#viewSiteDirectory").val();

        if ((region_name != 'all') || (officeType != 'all_office')) {
            if (officeType != 'all_office') {
                var wordObj = {
                    "region_name": region_name,
                    "officeType": officeType
                };
                $.ajax({
                    type: "POST",
                    url: "directory-specific-officeType.php",
                    data: wordObj,
                    beforeSend: function () {
                        $("#directoryDisplay").html(`
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        `);
                    },
                    success: function (data) {
                        $("#directoryDisplay").html(data);
                        $('#directoryTable').DataTable({
                            "paging": true,
                            "ordering": false,
                            "searching": true
                        });
                    },
                    error: function () {
                        alert("Failed to load directory data");
                    }
                });
            } else {
                var wordObj = {
                    "region_name": region_name
                };
                $.ajax({
                    type: "POST",
                    url: "directory-specific-region.php",
                    data: wordObj,
                    beforeSend: function () {
                        $("#directoryDisplay").html(`
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        `);
                    },
                    success: function(data){
                        $("#directoryDisplay").html(data);
                        $('#directoryTable').DataTable({
                            "paging": true,
                            "ordering": false,
                            "searching": true
                        });
                    },
                    error: function(){
                        alert("Failed to load directory data");
                    }
                });
            }
        } else {
            $.ajax({
                type: "POST",
                url: "directory-details-site.php",
                beforeSend: function () {
                    $("#directoryDisplay").html(`
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    `);
                },
                success: function(data){
                    $("#directoryDisplay").html(data);
                    $('#directoryTable').DataTable({
                        "paging": true,
                        "ordering": false,
                        "searching": true
                    });
                },
                error: function(){
                    alert("Failed to load directory data");
                }
            });
        }
    });

    $("#btnAddOffice").click(function(){
        $("#updateSiteTitle").hide();
        $("#updateOfficeButton").hide();
        $("#addOfficeButton").show();
        $("#addSiteTitle").show();
        $("#site_id_val").val("");
        $("#addMessage").html("");
        $("select[name='region_modal']").val("");
        $("input[name='site_code']").val("");
        $("input[name='site_name']").val("");
        $("select[name='modal_office_type']").val("");
        $("input[name='site_address']").val("");
        $("select[name='site_partnership']").val("");
        selectedValues.length = 0;
        updateCheckmarks();
        updateSelected();
        $("input[name='trxn_catered']").val("");
        $("#multi-select-dropdown").css("display", "none");
        $("#addOfficeModal").modal('show');
    });

    $("#addOfficeButton").click(function() {
        var region_name = $("select[name='region_modal']").val();
        var site_code = $("input[name='site_code']").val();
        var site_name = $("input[name='site_name']").val();
        var office_type = $("select[name='modal_office_type']").val();
        var site_address = $("input[name='site_address']").val();
        var site_partnership = $("select[name='site_partnership']").val();
        var trxn_catered = $("input[name='trxn_catered']").val() || '';

        if (region_name === "" || site_code === "" || site_name === "" || office_type === "" || site_address === "" || site_partnership === "") {
            $("#addMessage").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Warning!</strong> You should check in on some of those fields below</div>");
            return;
        }

        var checkObj = {
            "site_name": site_name,
            "office_type": office_type,
            "site_code": site_code,
            "validate": true
        };

        $.ajax({
            type: "POST",
            url: "directory-add-site-details.php",
            data: checkObj,
            dataType: "json",
            beforeSend: function() {
                $("#addOfficeButtonDisabled").show();
                $("#addOfficeButton").hide();
            },
            success: function(data) {
                $("#addOfficeButtonDisabled").hide();
                $("#addOfficeButton").show();
                if (data.exactMatch) {
                    $("#addMessage").html(`
                        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> A site with the same name, office type, and code already exists.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                    return;
                }
                if (data.nameTypeMatch) {
                    $("#confirmationModal").modal('show');
                    $("#confirmProceed").off('click').on('click', function() {
                        $("#confirmationModal").modal('hide');
                        submitAddSite(region_name, site_code, site_name, office_type, site_address, site_partnership, trxn_catered);
                    });
                    $("#confirmDecline").off('click').on('click', function() {
                        $("#confirmationModal").modal('hide');
                        $("#addMessage").html(`
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>Cancelled!</strong> Site addition cancelled due to existing name and office type.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    });
                } else {
                    submitAddSite(region_name, site_code, site_name, office_type, site_address, site_partnership, trxn_catered);
                }
            },
            error: function(jqXHR, textStatus) {
                $("#addOfficeButtonDisabled").hide();
                $("#addOfficeButton").show();
                $("#addMessage").html(`
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Failed to validate site details: ${textStatus}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        });
    });

    function submitAddSite(region_name, site_code, site_name, office_type, site_address, site_partnership, trxn_catered) {
        var wordObj = {
            "region_name": region_name,
            "site_code": site_code,
            "site_name": site_name,
            "office_type": office_type,
            "site_address": site_address,
            "site_partnership": site_partnership,
            "trxn_catered": trxn_catered,
            "force": true
        };
        $.ajax({
            type: "POST",
            url: "directory-add-site-details.php",
            data: wordObj,
            dataType: "json",
            beforeSend: function() {
                $("#addOfficeButtonDisabled").show();
                $("#addOfficeButton").hide();
            },
            success: function(data) {
                $("#addOfficeButtonDisabled").hide();
                $("#addOfficeButton").show();
                if (data.success) {
                    $("#addOfficeModal").modal('hide');
                    $("input[name='site_id_val']").val("");
                    $("select[name='region_modal']").val("");
                    $("input[name='site_code']").val("");
                    $("input[name='site_name']").val("");
                    $("select[name='modal_office_type']").val("");
                    $("input[name='site_address']").val("");
                    $("select[name='site_partnership']").val("");
                    selectedValues.length = 0;
                    updateCheckmarks();
                    updateSelected();
                    $("input[name='trxn_catered']").val("");
                    $("#multi-select-dropdown").css("display", "none");
                    $("#addMessage").html("");
                    alertMessageSuccess(`<strong>${data.message}</strong>`);
                    $("#showDirectory").click();
                } else {
                    $("#addMessage").html(`
                        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            },
            error: function(jqXHR, textStatus) {
                $("#addOfficeButtonDisabled").hide();
                $("#addOfficeButton").show();
                $("#addMessage").html(`
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> An error occurred while saving the data: ${textStatus}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        });
    }

    $(document).on("click", "#updateOfficeButton", function(){
        var site_id = $("input[name='site_id_val']").val();
        var region_name = $("select[name='region_modal']").val();
        var site_code = $("input[name='site_code']").val();
        var site_name = $("input[name='site_name']").val();
        var office_type = $("select[name='modal_office_type']").val();
        var site_address = $("input[name='site_address']").val();
        var site_partnership = $("select[name='site_partnership']").val();
        var trxn_catered = $("input[name='trxn_catered']").val() || '';

        if(site_id === "" || region_name === "" || site_code === "" || site_name === "" || office_type === "" || site_address === "" || site_partnership === "") {
            $("#addMessage").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Warning!</strong> You should check in on some of those fields below</div>");
        } else {
            var wordObj = {
                "site_id": site_id,
                "region_name": region_name,
                "site_code": site_code,
                "site_name": site_name,
                "office_type": office_type,
                "site_address": site_address,
                "site_partnership": site_partnership,
                "trxn_catered": trxn_catered
            };

            $.ajax({
                type: "POST",
                url: "directory-save-site-details.php",
                data: wordObj,
                dataType: "json",
                beforeSend: function () {
                    $("#displayValidation").html(`
                        <button class="btn btn-warning" type="button" disabled>
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                          Loading...
                        </button>
                    `);
                },
                success: function(data) {
                    $("#displayValidation").html(`
                        <button type="button" class="btn btn-warning" id="updateOfficeButton">Save Update</button>
                    `);

                    if (data.dualConflict) {
                        $("#addOfficeModal").modal('hide'); // Temporarily hide the main modal
                        setTimeout(() => {
                            $("#confirmationModal").modal('show');
                        }, 500);
                        $("#confirmProceed").off('click').on('click', function () {
                            $("#confirmationModal").modal('hide');

                            // Add the `force` flag to allow bypass in PHP
                            wordObj.force = true;

                            $.ajax({
                                type: "POST",
                                url: "directory-save-site-details.php",
                                data: wordObj,
                                dataType: "json",
                                success: function (data) {
                                    if (data.success) {
                                        alertMessageSuccess(`<strong>${data.message}</strong>`);
                                        $("#addOfficeModal").modal('hide');

                                        // Delay slightly to allow modal transition
                                        setTimeout(() => {
                                            // Destroy existing DataTable before reloading
                                            if ($.fn.DataTable.isDataTable('#directoryTable')) {
                                                $('#directoryTable').DataTable().destroy();
                                            }
                                            $("#showDirectory").click();
                                        }, 300);
                                    } else {
                                        $("#addMessage").html(`
                                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                                <strong>Error!</strong> ${data.message}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        `);
                                        $("#addOfficeModal").modal('show'); // Return to modal for retry
                                    }
                                },
                                error: function () {
                                    $("#addMessage").html(`
                                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                        <strong>Error!</strong> Failed to update after confirmation.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `);
                                    $("#addOfficeModal").modal('show');
                                }
                            });
                        });

                        $("#confirmDecline").off('click').on('click', function () {
                            $("#confirmationModal").modal('hide');
                            setTimeout(() => {
                                $("#addOfficeModal").modal('show');
                            }, 300);
                            $("#addMessage").html(`
                                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                    <strong>Cancelled!</strong> Update cancelled due to name/office type conflict.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                        });
                        return;
                    }

                    if (data.success) {
                        $("#addOfficeModal").modal('hide');
                        alertMessageSuccess(`<strong>${data.message}</strong>`);
                        $("#showDirectory").click();
                    } else {
                        $("#addMessage").html(`
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Error!</strong> ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    $("#displayValidation").html(`
                        <button type="button" class="btn btn-warning" id="updateOfficeButton">Save Update</button>
                    `);
                    $("#addMessage").html(`
                        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> Failed to update site details: ${textStatus}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            });
        }
    });
});

function directory_site_option() {
    var region_name = $("#region_directory").val();
    document.getElementById('viewSiteDirectory').disabled = false;
    document.getElementById('showDirectory').disabled = false;
}

function directory_site_name() {
    document.getElementById('showDirectory').disabled = false;
}

function siteFunction(id) {
    $("#updateSiteTitle").show();
    $("#updateOfficeButton").show();
    $("#addSiteTitle").hide();
    $("#addOfficeButton").hide();
    $("#addMessage").html("");
    $("#addOfficeButtonDisabled").hide();
    $('#addOfficeModal').modal('show');

    var wordObj = {"site_id": id};

    $.ajax({
        type: "POST",
        url: "directory-update-site-details.php",
        data: wordObj,
        success: function(data){
            var obj = JSON.parse(data);
            if (obj.error) {
                $("#addMessage").html(`
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> ${obj.error}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                return;
            }
            $("input[name='site_id_val']").val(obj.site_id);
            $("select[name='region_modal']").val(obj.region_name);
            $("input[name='site_code']").val(obj.site_code);
            $("input[name='site_name']").val(obj.site_name);
            $("select[name='modal_office_type']").val(obj.office_type);
            $("input[name='site_address']").val(obj.site_address);
            $("select[name='site_partnership']").val(obj.site_partnership);
            selectedValues = obj.trxn_catered ? obj.trxn_catered.split(',').map(item => item.trim()) : [];
            updateCheckmarks();
            updateSelected();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $("#addMessage").html(`
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error!</strong> Failed to load site details: ${textStatus}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
        }
    });
}

function alertMessageSuccess(messageHTML) {
    const alert = document.getElementById("alertMessage");
    alert.innerHTML = messageHTML;
    alert.style.display = "block";
    alert.classList.remove("fade-out");
    void alert.offsetWidth;
    alert.classList.add("fade-in");
    setTimeout(() => {
        alert.classList.remove("fade-in");
        alert.classList.add("fade-out");
        setTimeout(() => {
            alert.style.display = "none";
        }, 500);
    }, 3000);
}

function toggleSelection(value, event) {
    if (event) event.stopPropagation();
    const isNoneSelected = value === 'None' || selectedValues.includes('None');
    const checkmark = document.querySelector(`[data-value="${value}"] .checkmark`);

    if (value === 'None') {
        if (!selectedValues.includes('None')) {
            selectedValues = ['None'];
            updateCheckmarks();
        } else {
            selectedValues = [];
            updateCheckmarks();
        }
    } else if (!isNoneSelected) {
        const index = selectedValues.indexOf(value);
        if (index === -1) {
            selectedValues.push(value);
            checkmark.style.display = 'inline';
        } else {
            selectedValues.splice(index, 1);
            checkmark.style.display = 'none';
        }
    }

    updateSelected();
}

let selectedValues = [];

window.toggleDropdown = function() {
    const dropdown = document.getElementById('multi-select-dropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
};

function updateCheckmarks() {
    const items = document.querySelectorAll('#multi-select-dropdown .dropdown-item');
    items.forEach(item => {
        const value = item.getAttribute('data-value');
        const checkmark = item.querySelector('.checkmark');
        if (selectedValues.includes(value)) {
            checkmark.style.display = 'inline';
        } else {
            checkmark.style.display = 'none';
        }
    });
}

function updateSelected() {
    const selectedText = document.getElementById('selected-text');
    const isNoneSelected = selectedValues.includes('None');

    const items = document.querySelectorAll('#multi-select-dropdown .dropdown-item');
    items.forEach(item => {
        const value = item.getAttribute('data-value');
        if (value !== 'None') {
            if (isNoneSelected) {
                item.classList.add('disabled');
                item.style.pointerEvents = 'none';
                item.style.opacity = '0.5';
            } else {
                item.classList.remove('disabled');
                item.style.pointerEvents = 'auto';
                item.style.opacity = '1';
            }
        }
    });

    selectedText.textContent = selectedValues.length > 0 ? selectedValues.join(', ') : 'Select transaction catered';
    selectedText.className = selectedValues.length > 0 ? '' : 'text-muted';

    let hiddenInput = document.querySelector('input[name="trxn_catered"]');
    if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'trxn_catered';
        document.querySelector('.multi-select-container').appendChild(hiddenInput);
    }
    hiddenInput.value = selectedValues.join(',');
}

document.addEventListener('click', function(event) {
    const container = document.querySelector('.multi-select-container');
    if (!container.contains(event.target)) {
        document.getElementById('multi-select-dropdown').style.display = 'none';
    }
});