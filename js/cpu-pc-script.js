$(function(){
    $("#addDetailsCPULoading").hide();
    $("#saveEditBtn").hide();
    $("#hw_displayEdit").hide();
    $("#addCPUBtn").click(function(){
        $('#addCPUHardware').modal('show');
    });
    $(".button-close").click(function (){
        $("#saveEditBtn").hide();
    });

    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    $("#pullout-button").click(function (){
        const tracking_num = $("input[name='tracking_num']").val().trim(); // Trim spaces
        const track_required = $("#tracking_required");
        const validPattern = /^[0-9]{11}$/;

        $("input[name='tracking_num']").removeClass("is-invalid");
        track_required.text("").removeClass("text-danger");

        if (!tracking_num) {
            track_required.text("Tracking number is required.").addClass("text-danger");
            $("input[name='tracking_num']").addClass("is-invalid");
        } else if (!validPattern.test(tracking_num)) {
            track_required
                .text("Tracking number must be exactly 11 digits and can only contain numbers.")
                .addClass("text-danger");
            $("input[name='tracking_num']").addClass("is-invalid");
        } else {

            var wordObj = {
                "tracking_num" : $("input[name='tracking_num']").val(),
                "hw_id_pullout" : $("input[name='hw_id_pullout']").val()
            }

            $.ajax({
                type: "POST",
                url: "tracking-number-add.php",
                data: wordObj,
                success: function(data){
                    $("#trackingModal").modal("hide");
                    const alertMessage = document.getElementById("alertMessage");
                    alertMessage.innerHTML = "<strong>Hardware successfully sent to SMC</strong>";
                    alertMessageSuccess();
                },
                error: function (data){
                    alert(data);
                }
            });

            $("input[name='tracking_num']").val("").removeClass("is-invalid");
            track_required.text("");
        }
    });

    $("#saveEditBtn").click(function (){
        $("#staticBackdrop").modal('hide');

        var wordObj = {
            "hw_id" : $("input[name='hw_idEdit']").val(),
            "brand_name" : $("select[name='brand_nameEdit']").val(),
            "model_name" : $("select[name='model_nameEdit']").val(),
            "asset_num" : $("input[name='asset_numEdit']").val(),
            "serial_num" : $("input[name='serial_numEdit']").val(),
            "date_acquired" : $("input[name='date_acqEdit']").val(),
            "hw_status" : $("select[name='status_nameEdit']").val(),
            "host_name" : $("input[name='host_nameEdit']").val(),
            "ip_add" : $("input[name='ip_addEdit']").val(),
            "mac_add" : $("input[name='mac_addEdit']").val(),
            "hw_user" : $("input[name='user_nameEdit']").val(),
            "primary_role" : $("select[name='primary_roleEdit']").val()
        }

        $.ajax({
            type: "POST",
            url: "cpu-edit-details.php",
            data: wordObj,
            success: function(data){
                $("#saveEditBtn").hide();
                const alertMessage = document.getElementById("alertMessage");
                alertMessage.innerHTML = "<strong>You successfully updated CPU-PC</strong>";
                alertMessageSuccess();
            },
            error: function (){
                alert(data);
            }
        });
    });

    $("#pulloutBtn").click(function (){
        var hw_id = $("input[name='hw_id_pullout']").val();
        $("#staticBackdrop").modal('hide');
        $("#trackingModal").modal('show');
        $("#saveEditBtn").hide();
    });

    $("#editBtn").click(function (){
        var hwValue = $("input[name='dataValue']").val();
        $("#hw_display").hide();
        $("#hw_displayEdit").show();
        $("#editBtn").hide();
        $("#pulloutBtn").hide();
        $("#saveEditBtn").show();

        var wordObj = {"hwValue" : hwValue};
        $.ajax({
            type: "POST",
            url: "update-hw-data.php",
            data: wordObj,
            success: function(data){
                var obj = JSON.parse(data);
                var displayRegion = document.getElementById('regionEdit');
                var displaySiteName = document.getElementById('siteNameEdit');
                var displaySiteCode = document.getElementById('siteCodeEdit');
                $("input[name='hw_idEdit']").val(obj.hw_id);
                displayRegion.innerHTML = "<option value='"+obj.region_name+"'>"+obj.region_name+"</option>";
                displaySiteName.innerHTML = "<option value='"+obj.site_name+"'>"+obj.site_name+"</option>";
                displaySiteCode.innerHTML = "<option value='"+obj.site_code+"'>"+obj.site_code+"</option>";

                //brand
                var brandFetch = obj.hw_brand_name;
                var brandDropdown = $("select[name='brand_nameEdit']");
                brandDropdown.val(brandFetch);

                //model
                var modelNameFetch = obj.hw_model;
                var modelDropdown = $("select[name='model_nameEdit']");
                modelDropdown.val(modelNameFetch);

                $("input[name='asset_numEdit']").val(obj.hw_asset_num);
                $("input[name='serial_numEdit']").val(obj.hw_serial_num);
                $("input[name='date_acqEdit']").val(obj.hw_year_acq);

                //status
                var statusFetch = obj.hw_status;
                var statusDropdown = $("select[name='status_nameEdit']");
                statusDropdown.val(statusFetch);

                $("input[name='host_nameEdit']").val(obj.hw_host_name);
                $("input[name='ip_addEdit']").val(obj.hw_ip_add);
                $("input[name='mac_addEdit']").val(obj.hw_mac_add);
                $("input[name='user_nameEdit']").val(obj.hw_user_name);

                var roleFetch = obj.hw_primary_role;
                var roleDropdown = $("select[name='primary_roleEdit']");
                roleDropdown.val(roleFetch);

                $("input[name='acq_valEdit']").val(obj.hw_acq_val);
            },
            error: function(){
                alert(data);
            }
        });
    });

    $("#addDetailsCPU").click(function () {
        const displayMessage = document.getElementById('addMessage');

        // Disable buttons and show loading spinner
        $("#addDetailsCPU").hide();
        $("#addDetailsCPULoading").show();

        // Collect input values
        var data = {
            region_name: $("select[name='region_name']").val(),
            site_name: $("select[name='site_name']").val(),
            site_code: $("input[name='site_code']").val(),
            brand_name: $("#brand_option").val(),
            model_name: $("#model_option").val(),
            asset_num: $("input[name='asset_num']").val(),
            serial_num: $("input[name='serial_num']").val(),
            hw_month: $("select[name='hw_month']").val(),
            hw_day: $("select[name='hw_day']").val(),
            hw_year: $("select[name='hw_year']").val(),
            status_option: $("select[name='status_option']").val(),
            host_name: $("input[name='host_name']").val(),
            ip_address: $("input[name='ip_address']").val(),
            mac_address: $("input[name='mac_address']").val(),
            user_name: $("input[name='user_name']").val(),
            primary_role: $("select[name='primary_role']").val(),
            acquired_value: $("input[name='acquired_value']").val()
        };

        // Check if any field is empty
        if (Object.values(data).some(value => value === "")) {
            displayMessage.innerHTML = `
            <div class='alert alert-danger align-items-center alert-dismissible fade show' role='alert'>
                <div class='text-center'><i class='fa fa-warning'></i>&nbsp;Please fill up all the fields.</div>
            </div>`;
            $("#addDetailsCPU").show();
            $("#addDetailsCPULoading").hide();
            return;
        }

        // Send AJAX request to the PHP script
        $.ajax({
            type: "POST",
            url: "add-cpu-pc.php",
            data: data,
            success: function (response) {
                try {
                    var result = JSON.parse(response);

                    if (result.status === "error") {
                        // Display error message for asset or serial number conflict
                        displayMessage.innerHTML = `
                        <div class='alert alert-warning align-items-center alert-dismissible fade show' role='alert'>
                            <div class='text-center'><i class='fa fa-warning'></i>&nbsp;${result.message}</div>
                        </div>`;
                    } else if (result.status === "success") {
                        // Clear form fields and display success message
                        $("select[name='region_name']").val("");
                        $("select[name='site_name']").val("");
                        $("input[name='site_code']").val("");
                        $("select[name='brand_name']").val("");
                        $("select[name='model_name']").val("");
                        $("input[name='asset_num']").val("");
                        $("input[name='serial_num']").val("");
                        $("select[name='hw_month']").val("");
                        $("select[name='hw_day']").val("");
                        $("select[name='hw_year']").val("");
                        $("select[name='status_option']").val("");
                        $("input[name='host_name']").val("");
                        $("input[name='ip_address']").val("");
                        $("input[name='mac_address']").val("");
                        $("input[name='user_name']").val("");
                        $("select[name='primary_role']").val("");
                        $("input[name='acquired_value']").val("");

                        displayMessage.innerHTML = `
                        <div class='alert alert-success align-items-center alert-dismissible fade show' role='alert'>
                            <div class='text-center'><i class='fa fa-check-circle'></i>&nbsp;You successfully added a new CPU-PC to the list.</div>
                        </div>`;
                    }
                } catch (e) {
                    alert(response);
                    // Handle unexpected response
                    console.error("Invalid JSON response:", response);
                    displayMessage.innerHTML = `
                    <div class='alert alert-danger align-items-center alert-dismissible fade show' role='alert'>
                        <div class='text-center'><i class='fa fa-warning'></i>&nbsp;An unexpected error occurred. Please try again.</div>
                    </div>`;
                }
            },
            error: function () {
                alert(response);
                displayMessage.innerHTML = `
                <div class='alert alert-danger align-items-center alert-dismissible fade show' role='alert'>
                    <div class='text-center'><i class='fa fa-warning'></i>&nbsp;Failed to connect to the server. Please try again later.</div>
                </div>`;
            },
            complete: function () {
                // Re-enable the button and hide loading spinner
                $("#addDetailsCPU").show();
                $("#addDetailsCPULoading").hide();
            }
        });
    });


    $.ajax({
        type: "POST",
        url: "view-region-select.php",
        success: function(data){
            $("#viewRegionSelect").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $.ajax({
        type: "POST",
        url: "view-hw-brand-option.php",
        success: function(data){
            $("#brand_option").html(data);
            $("#brand_optionUpdate").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $.ajax({
        type: "POST",
        url: "view-hw-model-option.php",
        success: function(data){
            $("#model_option").html(data);
            $("#brand_modelUpdate").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $.ajax({
        type: "POST",
        url: "restriction-select.php",
        success: function(data){
            $("#displayFilter").html(data);
        },
        error: function(){
            alert(data);
        }
    });

});

function viewHWDetails(id){
    $("input[name='hw_id_pullout']").val(id);
    $("#hw_displayEdit").hide();
    $("#hw_display").show();
    $("#editBtn").show();
    $("#pulloutBtn").show();
    $("#saveBtn").hide();
    var wordObj = {"hw_id" : id};
    $.ajax({
        type: "POST",
        url: "view-single-data-cpu-pc.php",
        data: wordObj,
        success: function(data){
            $("#hw_display").html(data);
            $('#staticBackdrop').modal('show');
        },
        error: function(){
            alert(data);
        }
    });
}

function region_option(){
    var region_id = $("select[name='region_name']").val();
    var selectSiteName = document.getElementById('viewSiteSelect');
    var wordObj = {"region_id" : region_id};
    selectSiteName.innerHTML='';
    $.ajax({
        type: "POST",
        url: "region-view.php",
        data: wordObj,
        success: function(data){
            document.getElementById('viewSiteSelect').disabled = false;
            var obj = JSON.parse(data);
            var input = document.createElement('input');
            obj.forEach(function (subcategory){
                var option = document.createElement('option');
                option.value = subcategory.site_id;
                option.text = subcategory.site_name;
                selectSiteName.appendChild(option);
            });
        }
    });
}

function site_name_option(){

    var id = $("select[name='site_name']").val();
    var wordObj = {"site_id" : id};
    $.ajax({
        type: "POST",
        url: "view-site-code-option.php",
        data: wordObj,
        success: function(data){
            $("input[name='site_code']").val(data);
        },
        error: function(){
            alert(data);
        }
    });
}

function brandName(){
    document.getElementById('model_option').disabled = false;
}

function alertMessageSuccess(){
    const alert = document.getElementById("alertMessage");
    alert.classList.add("alert-success");

    alert.classList.remove("hide");
    alert.style.display = "block";
    setTimeout(() => {
        alert.classList.add("show");
    }, 10);

    setTimeout(() => {
        alert.classList.remove("show");
        alert.classList.add("hide");

        setTimeout(() => {
            alert.style.display = "none";
        }, 500);
    }, 3000);
}

function sortHardware() {
    var selectElement = document.getElementById("specificSizeSelect");
    var rowdisplay = document.getElementById("rowdisplay");

    // Get the selected value
    var selectedValue = selectElement.value;

    // Destroy any existing DataTable instance before making the AJAX request
    if ($.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy();
    }

    if (selectedValue === "all") {
        $.ajax({
            type: "POST",
            url: "view-data-cpu-pc.php",
            success: function (data) {
                // Replace the table content
                $("#tableDisplay").html(data);

                // Reinitialize the DataTable
                $('#example').DataTable({
                    "paging": true,
                    "ordering": true,
                    "searching": false
                });
            },
            error: function () {
                alert("Error occurred while fetching data.");
            }
        });
    } else {
        var wordObj = { "selectedValue": selectedValue };

        $.ajax({
            type: "POST",
            data: wordObj,
            url: "cpu-pc-sort.php",
            success: function (data) {
                // Replace the table content
                $("#tableDisplay").html(data);

                // Reinitialize the DataTable
                $('#example').DataTable({
                    "paging": true,
                    "ordering": true,
                    "searching": false
                });
            },
            error: function () {
                alert("Error occurred while fetching data.");
            }
        });
    }
}

function changeStatus(){

}