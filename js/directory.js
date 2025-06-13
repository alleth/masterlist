$(function (){

    $("#updateSiteTitle").hide();
    $("#updateOfficeButton").hide();
    $("#addOfficeButtonDisabled").hide();

    $.ajax({
        type: "POST",
        url: "directory-region.php",
        success: function(data){
            $("#displayRegionFilter").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $.ajax({
        type: "POST",
        url: "directory-modal-region.php",
        success: function(data){
            $("#displayModalRegion").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $("#showDirectory").click(function(){
        // Destroy any existing DataTable instance before making the AJAX request
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
                        // Show spinner before request starts
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

                        // Reinitialize the DataTable
                        $('#directoryTable').DataTable({
                            "paging": true,
                            "ordering": false,
                            "searching": true
                        });
                    },
                    error: function () {
                        alert(data);
                    }
                });
            }else{
                var wordObj = {
                    "region_name" : region_name
                };
                $.ajax({
                    type: "POST",
                    url: "directory-specific-region.php",
                    data: wordObj,
                    beforeSend: function () {
                        // Show spinner before request starts
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

                        // Reinitialize the DataTable
                        $('#directoryTable').DataTable({
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

        }else{
            $.ajax({
                type: "POST",
                url: "directory-details-site.php",
                beforeSend: function () {
                    // Show spinner before request starts
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
                    // Reinitialize the DataTable
                    $('#directoryTable').DataTable({
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

    $("#btnAddOffice").click(function (){
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
        $("#addOfficeModal").modal('show');

    });

    $("#addOfficeButton").click(function(){
        var region_name = $("select[name='region_modal']").val();
        var site_code = $("input[name='site_code']").val();
        var site_name = $("input[name='site_name']").val();
        var office_type = $("select[name='modal_office_type']").val();
        var site_address = $("input[name='site_address']").val();
        var site_partnership = $("select[name='site_partnership']").val();

        if(region_name === "" || site_code === "" || site_name === "" || office_type === "" || site_address === "" || site_partnership === ""){
            $("#addMessage").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Warning!</strong> You should check in on some of those fields below");
        }else{
            var wordObj = {
                "region_name" : region_name,
                "site_code" : site_code,
                "site_name" : site_name,
                "office_type" : office_type,
                "site_address" : site_address,
                "site_partnership" : site_partnership
            };
            $.ajax({
                type: "POST",
                url: "directory-add-site-details.php",
                data: wordObj,
                beforeSend: function () {
                    // Show spinner before request starts
                    $("#addOfficeButtonDisabled").show();
                },success: function(data) {
                    if (data.includes("Duplicate Entry")) {
                        $("#addOfficeButtonDisabled").hide();
                        // Show error alert for duplicate site code
                        $("#addMessage").html(`
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Error!</strong> ${data}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        $("#addOfficeButton").show();
                    } else {
                        $("#addOfficeModal").modal('hide');
                        // If no duplicate, proceed with success
                        $("input[name='site_id_val']").val("");
                        $("select[name='region_modal']").val("");
                        $("input[name='site_code']").val("");
                        $("input[name='site_name']").val("");
                        $("select[name='modal_office_type']").val("");
                        $("input[name='site_address']").val("");
                        $("select[name='site_partnership']").val("");

                        alertMessageSuccess(`<strong>${data}</strong>`);

                        $("#addOfficeButton").show();
                    }
                },
                error: function() {
                    alert("An error occurred while saving the data.");
                }
            });

        }
    });


    $(document).on("click", "#updateOfficeButton", function (){

        var site_id = $("input[name='site_id_val']").val();
        var region_name = $("select[name='region_modal']").val();
        var site_code = $("input[name='site_code']").val();
        var site_name = $("input[name='site_name']").val();
        var office_type = $("select[name='modal_office_type']").val();
        var site_address = $("input[name='site_address']").val();
        var site_partnership = $("select[name='site_partnership']").val();

        if(site_id === "" || region_name === "" || site_code === "" || site_name === "" || office_type === "" || site_address === "" || site_partnership === ""){
            $("#addMessage").html("<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Warning!</strong> You should check in on some of those fields below");
        }else{
            var wordObj = {
                "site_id" : site_id,
                "region_name" : region_name,
                "site_code" : site_code,
                "site_name" : site_name,
                "office_type" : office_type,
                "site_address" : site_address,
                "site_partnership" : site_partnership
            };

            $.ajax({
                type: "POST",
                url: "directory-save-site-details.php",
                data: wordObj,
                beforeSend: function () {
                    // Show spinner before request starts
                    $("#displayValidation").html(`
                        <button class="btn btn-warning" type="button" disabled>
                          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                          Loading...
                        </button>
                    `);
                },
                success: function(data){
                    $(document.getElementById(wordObj.site_id)).html(data);
                    $("input[name='site_id_val']").val("");
                    $("select[name='region_modal']").val("");
                    $("input[name='site_code']").val("");
                    $("input[name='site_name']").val("");
                    $("select[name='modal_office_type']").val("");
                    $("input[name='site_address']").val("");
                    $("select[name='site_partnership']").val("");
                    $("#addMessage").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Updated Successfully!</strong> You updated LTO Office's information.");
                    $("#displayValidation").html(`
                        <button type="button" class="btn btn-warning" id="updateOfficeButton">Save Update</button>
                    `);



                    },error: function(data){
                    alert(data);
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
function directory_site_name(){
    document.getElementById('showDirectory').disabled = false;
}

function siteFunction(id){
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
            $("input[name='site_id_val']").val(obj.site_id);
            $("select[name='region_modal']").val(obj.region_name);
            $("input[name='site_code']").val(obj.site_code);
            $("input[name='site_name']").val(obj.site_name);
            $("select[name='modal_office_type']").val(obj.office_type);
            $("input[name='site_address']").val(obj.site_address);
            $("select[name='site_partnership']").val(obj.partnership);
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

