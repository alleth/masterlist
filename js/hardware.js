$(function(){
    $("#updateHardwareBtn").hide();
    $("#displayHardwareValidation").hide();

    $.ajax({
        type: "POST",
        url: "hardwares-view-region.php",
        success: function(data){
            $("#displayRegionHW").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    // for modal select on region
    $.ajax({
        type: "POST",
        url: "hardware-region-modal.php",
        success: function(data){
            $("#hardwareRegionModal").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    // for modal select of description
    $.ajax({
        type: "POST",
        url: "hardware-item-description-modal.php",
        success: function(data){
            $("#itemDescription").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $("#showHwButton").click(function(){
        $("#updateHardwareBtn").show();
        // Destroy any existing DataTable instance before making the AJAX request
        if ($.fn.DataTable.isDataTable('#hardwarePerSite')) {
            $('#hardwarePerSite').DataTable().destroy();
        }
        document.getElementById('viewHwType').disabled = false;

        var site_name = $("select[name='site_name']").val();
        var hw_type = $("select[name='hw_type']").val();


        if(hw_type !== 'all_hw'){
            var wordObj = {
                "site_name" : site_name,
                "hw_type" : hw_type
            };
            $.ajax({
                type: "POST",
                url: "hardwares-view-specific-details.php",
                data: wordObj,
                beforeSend: function () {
                    // Show spinner before request starts
                    $("#rowdisplay").html(`
                            <tr>
                                <td colspan="8" class="text-center">
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
                    $("#hardwareDisplay").html(data);

                    $('#hardwarePerSite').DataTable({
                        "paging": true,
                        "ordering": false,
                        "searching": true
                    });
                },
                error: function(){
                    alert(data);
                }
            });
        }else{
            var wordObj1 = {"site_name" : site_name};
            $.ajax({
                type: "POST",
                url: "hardwares-view-details.php",
                data: wordObj1,
                beforeSend: function () {
                    // Show spinner before request starts
                    $("#rowdisplay").html(`
                            <tr>
                                <td colspan="8" class="text-center">
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
                    $("#hardwareDisplay").html(data);

                    $('#hardwarePerSite').DataTable({
                        "paging": true,
                        "ordering": false,
                        "searching": true
                        });
                    },
                error: function(){
                    alert(data);
                    }
                });
            }
        });

    $("#addHardwareBtn").click(function (){
        $("#updateHardwareBtn").hide();
        $("#saveHardwareBtn").show();
        $("#hardwareModalInput").modal('show');
    });

    $(document).on("click", "#updateHardwareBtn", function(){

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

        // Check for empty required fields and mark them
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
            $("#addMessage").html(
                "<div class='alert alert-warning alert-dismissible fade show' role='alert'>" +
                "<strong>Warning!</strong> You should check in on some of those fields below" +
                "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>" +
                "</div>"
            );
        } else {
            $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num']").removeClass('is-invalid');
            $("#addMessage").html("");
            if(hardwareStatus === "Pull Out"){
                $("#warning-pullout").html("<i class='fas fa-exclamation-triangle'></i> You're about to pull out this hardware with Asset No. <b>"+asset_num+"</b>");

                $("#hardwareModalInput").modal('hide');
                $("#trackingModal").modal('show');
            }else{
                var wordObj = {
                    "hw_id" : hw_id,
                    "brand_name" : brand_name,
                    "model_name" : model_name,
                    "acquired_value" : acquired_value,
                    "asset_num" : asset_num,
                    "serial_num" : serial_num,
                    "date_acquired" : date_acquired
                };

                $.ajax({
                    type: "POST",
                    url: "hardwares-save-details.php",
                    data: wordObj,
                    beforeSend: function () {
                        // Show spinner before request starts
                        $("#displayValidation").show();
                    },
                    success: function(data){
                        $(document.getElementById(wordObj.hw_id)).html(data);
                        $("#addMessage").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Updated Successfully!</strong> You updated hardware information.");
                        $("input[name='edit_hw_id']").val("");
                        $("input[name='edit_hw_region_name']").val("");
                        $("input[name='edit_site_name_input']").val("");
                        $("select[name='edit_brand_name']").val("");
                        $("select[name='edit_model_name']").val("");
                        $("input[name='edit_acquired_value']").val("");
                        $("input[name='edit_asset_num']").val("");
                        $("input[name='edit_serial_num']").val("");
                        $("select[name='edit_date_acquired']").val("");
                        $("#displayValidation").hide();
                        $("#updateHardwareBtn").show();
                    },error: function(data){
                        alert(data);
                    }
                });
            }
        }

    });

    $("#pullout-button").click(function (){
        const tracking_num = $("input[name='tracking_num']").val().trim(); // Trim spaces
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
        } else if (!validPattern.test(tracking_num)) {
            track_required
                .text("Tracking number must be exactly 12 digits and can only contain numbers.")
                .addClass("text-danger");
            $("input[name='tracking_num']").addClass("is-invalid");
        }else if(datePullout == ""){
            $("input[name='edit_date_pullout']").addClass("is-invalid");
            date_required.text("Date pulled out is required.").addClass("text-danger");
        } else {
            var wordObj = {
                "tracking_num" : $("input[name='tracking_num']").val(),
                "hw_id_pullout" : $("input[name='edit_hw_id']").val(),
                "datePullout" : $("input[name='edit_date_pullout']").val()
            }

            $.ajax({
                type: "POST",
                url: "tracking-number-add.php",
                data: wordObj,
                success: function(data){
                    $("#trackingModal").modal("hide");
                    alert(data);
                },
                error: function (data){
                    alert(data);
                }
            });

            $("input[name='tracking_num']").val("").removeClass("is-invalid");
            track_required.text("");
        }
    });


    // for Add hardware Save Button---------------------------
    $("#addNewHardwareBtn").click(function(){

        var RegionSelect = $('#RegionSelect').val();
        var hardwareSiteModal = $('#hardwareSiteModal').val();
        var itemSelect = $('#itemSelect').val();
        var itemBrand = $('#itemBrand').val();
        var itemModel = $('#itemModel').val();
        var asset_num = $('#asset_num').val();
        var serial_num = $('#serial_num').val();
        var date = $('#date').val();
        var acquired_value = $('#acquired_value').val();

        var wordObj = {
            RegionSelect :RegionSelect,
            hardwareSiteModal :hardwareSiteModal,
            itemSelect :itemSelect,
            itemBrand :itemBrand,
            itemModel :itemModel,
            asset_num :asset_num,
            serial_num :serial_num,
            date :date,
            acquired_value :acquired_value
        };
        if (RegionSelect === '' || hardwareSiteModal === '' || itemSelect === '' || itemBrand === '' || itemModel === '' || asset_num === '' || serial_num === '' || date === '' || acquired_value === '') {
            $("#addHWMessage").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>All Fields Reqired!</strong>");
        } else {
            $.ajax({
                type: "POST",
                url: "hardware-add-details.php",
                data: wordObj,
                success: function(response){
                    $('#response').html(response);
                    $("#addHWMessage").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Added Successfully!</strong> You added hardware to inventory.");
                    $("select[name='RegionSelect']").val("");
                    $("select[name='hardwareSiteModal']").val("");
                    $("select[name='itemSelect']").val("");
                    $("select[name='itemBrand']").val("");
                    $("select[name='itemModel']").val("");
                    $("input[name='asset_num']").val("");
                    $("input[name='date']").val("");
                    $("input[name='acquired_value']").val("");
                },
                error: function() {
                    $('#response').html('<p> AN error occured while saving the data');

                }
            });
        }
    });
});

function hardware_site_option(){

    var region_name = $("select[name='hw_region_name']").val();
    document.getElementById('viewSiteOption').disabled = false;
    document.getElementById('showHwButton').disabled = false;

    var wordObj = {"region_name" : region_name};

    $.ajax({
        type: "POST",
        url: "hardwares-view-site.php",
        data: wordObj,
        success: function(data){
            $("#viewSiteOption").html(data);
        },error: function(data){
            alert(data);
        }
    });
}

function hardwareUpdate(id){
    $("#addMessage").html("");
    $("#saveHardwareBtn").hide();
    $("#updateHardwareBtn").show();
    $("#hardwareModalInput").modal('show');
    $("input[name='edit_hw_id'], select[name='edit_brand_name'], select[name='edit_model_name'], input[name='edit_asset_num'], input[name='edit_serial_num']").removeClass('is-invalid');

    var wordObj = {"hw_id" : id};
    $.ajax({
        type: "POST",
        url: "hardware-update-details.php",
        data: wordObj,
        success: function(data){
            var obj = JSON.parse(data);
            $("input[name='edit_hw_id']").val(obj.hw_id);
            $("input[name='edit_hw_region_name']").val(obj.region_name);
            $("input[name='edit_site_name_input']").val(obj.site_code + " - " + obj.site_name);
            // Populate the select dropdown
            var brandDropdown = $("#edit_brandSelect");
            brandDropdown.append('<option value="" disabled>Select Brand</option>');

            $.each(obj.brands, function (index, brand) {
                brandDropdown.append('<option value="' + brand + '">' + brand + '</option>');
            });
            if (obj.selected_brand) {
                brandDropdown.val(obj.selected_brand);
            }
            var modelDropdown = $("#edit_model_option");
            modelDropdown.empty(); // Clear existing options
            modelDropdown.append('<option value="" disabled>Select model</option>');

            $.each(obj.hw_model, function (index, model) {
                modelDropdown.append('<option value="' + model.model_name + '">' + model.model_name + '</option>');
            });
            if (obj.selected_model) {
                modelDropdown.val(obj.selected_model);
            }
            $("input[name='edit_acquired_value']").val(obj.acq_val);
            $("input[name='edit_asset_num']").val(obj.asset_num);
            $("input[name='edit_serial_num']").val(obj.serial_num);
            $("input[name='edit_date_acquired']").val(obj.date_acq);
            $("select[name='hardware_status_option']").val(obj.hw_status);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        }
    });
}

function showHardwareModel(){
    var hw_id = $("input[name='hw_id']").val();
    var brand_name = $("select[name='brand_name']").val();
    var wordObj = {
        "hw_id" : hw_id,
        "brand_name" : brand_name
    };

    $.ajax({
        type: "POST",
        url: "hardwares-change-model.php",
        data: wordObj,
        success: function(data){
            var obj = JSON.parse(data);
            // Populate the select dropdown
            var modelDropdown = $("#model_option");
            modelDropdown.empty();
            modelDropdown.append('<option value="" disabled>Select model</option>');

            $.each(obj.hw_model, function (index, model) {
                modelDropdown.append('<option value="' + model.model_name + '">' + model.model_name + '</option>');
            });
        },
        error: function(){
            alert(data);
        }
    });

}

function hardware_site_select(){

    var site_name = $("select[name='RegionSelect']").val();
    document.getElementById('hardwareSiteModal').disabled = false;

    var wordObj = {"site_name" : site_name};

    $.ajax({
        type: "POST",
        url: "hardwares-site-modal.php",
        data: wordObj,
        success: function(data){
            $("#hardwareSiteModal").html(data);
        },error: function(data){
            alert(data);
        }
    });
}

function hardware_brand_option() {
    var item_name = $("select[name='itemSelect']").val();
    document.getElementById('itemBrand').disabled = false;
    document.getElementById('itemModel').disabled = false;

    var wordObj = {"item_name": item_name};

    $.ajax({
        type: "POST",
        url: "hardware-brand-modal.php",
        data: wordObj,
        success: function (data) {
            $("#itemBrand").html(data);
        },
        error: function (data) {
            alert(data);
        }
    });

}

function hardware_model_option() {
    var model_item_name = $("select[name='itemSelect']").val();

    var wordObj = {"model_item_name": model_item_name};

    $.ajax({
        type: "POST",
        url: "hardware-model-modal.php",
        data: wordObj,
        success: function (data) {
            $("#itemModel").html(data);
        },
        error: function (data) {
            alert(data);
        }
    });

}
$(document).ready(function(){
});
