$(function(){
    $("#addDetailsServerLoading").hide();
    $("#saveEditBtn").hide();
    $("#hw_displayEdit").hide();
    $("#addServerBtn").click(function(){
        $('#addServerHardware').modal('show');
    });
    $(".button-close").click(function (){
        $("#saveEditBtn").hide();
    });

    $("#saveEditBtn").click(function (){
        const alertMessage = document.getElementById("alertMessage");
        alertMessage.innerHTML = "<strong>You successfully updated CPU-PC.</strong>";
        alertMessageSuccess();
        $("#saveEditBtn").hide();

    });

    $("#editBtn").click(function (){
        var hwValue = $("input[name='dataValue']").val();
        $("#hw_display").hide();
        $("#hw_displayEdit").show();
        $("#editBtn").hide();
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
                $("input[name='hw_idEdit']").val(obj.id);
                displayRegion.innerHTML = "<option value='"+obj.region_name+"'>"+obj.region_name+"</option>";
                displaySiteName.innerHTML = "<option value='"+obj.site_name+"'>"+obj.site_name+"</option>";
                displaySiteCode.innerHTML = "<option value='"+obj.site_code+"'>"+obj.site_code+"</option>";
                $("input[name='brand_nameEdit']").val(obj.hw_brand_name);
                $("input[name='model_nameEdit']").val(obj.hw_model);
                $("input[name='asset_numEdit']").val(obj.hw_asset_num);
                $("input[name='serial_numEdit']").val(obj.hw_serial_num);
                $("input[name='date_acqEdit']").val(obj.hw_year_acq);
                $("input[name='status_nameEdit']").val(obj.hw_status);
                $("input[name='host_nameEdit']").val(obj.hw_host_name);
                $("input[name='ip_addEdit']").val(obj.hw_ip_add);
                $("input[name='mac_addEdit']").val(obj.hw_mac_add);
                $("input[name='user_nameEdit']").val(obj.hw_user_name);
                $("input[name='primary_roleEdit']").val(obj.hw_primary_role);
                $("input[name='acq_valEdit']").val(obj.hw_acq_val);
            },
            error: function(){
                alert(data);
            }
        });
    });

    $("#addDetailsServer").click(function (){
        var displayMessage = document.getElementById('addMessage');
        $("#addDetailsServer").hide();
        $("#addDetailsServerLoading").show();
        var region_name = $("select[name='region_name']").val();
        var site_name = $("select[name='site_name']").val();
        var site_code = $("input[name='site_code']").val();
        var brand_name = $("select[name='brand_name']").val();
        var model_name = $("select[name='model_name']").val();
        var asset_num = $("input[name='asset_num']").val();
        var serial_num = $("input[name='serial_num']").val();
        var hw_month = $("select[name='hw_month']").val();
        var hw_day = $("select[name='hw_day']").val();
        var hw_year = $("select[name='hw_year']").val();
        var status_option = $("select[name='status_option']").val();
        var host_name = $("input[name='host_name']").val();
        var ip_address = $("input[name='ip_address']").val();
        var mac_address = $("input[name='mac_address']").val();
        var user_name = $("input[name='user_name']").val();
        var primary_role = $("select[name='primary_role']").val();
        var acquired_value = $("input[name='acquired_value']").val();

        if(region_name == "" || site_name == "" || site_code == "" || brand_name == "" || model_name == "" || asset_num == "" || serial_num == "" || hw_month == "" || hw_day == "" || hw_year == "" || status_option == "" || host_name == "" || ip_address == "" || mac_address == "" || user_name == "" || primary_role == "" || acquired_value == ""){
            displayMessage.innerHTML = "<div class='alert alert-danger align-items-center alert-dismissible fade show' role='alert'><div class='text-center'><i class='fa fa-warning'></i>&nbsp;Please fill up all the fields.</div></div>";
            $("#addDetailsServer").show();
            $("#addDetailsServerLoading").hide();
        }else{
            $("#addDetailsServerLoading").show();
            var wordObj = {
                "region_name" : region_name,
                "site_name" : site_name,
                "site_code" : site_code,
                "brand_name" : brand_name,
                "model_name" : model_name,
                "asset_num" : asset_num,
                "serial_num" : serial_num,
                "hw_month" : hw_month,
                "hw_day" : hw_day,
                "hw_year" : hw_year,
                "status_option" : status_option,
                "host_name" : host_name,
                "ip_address" : ip_address,
                "mac_address" : mac_address,
                "user_name" : user_name,
                "primary_role" : primary_role,
                "acquired_value" : acquired_value
            };
            $.ajax({
                type: "POST",
                url: "add-server.php",
                data: wordObj,
                success: function(data){
                    var returnValue = data;
                    if(returnValue == "asset number"){
                        displayMessage.innerHTML = "<div class='alert alert-warning align-items-center alert-dismissible fade show shadow p-3 mb-5 bg-white rounded' role='alert'><div class='text-center'><i class='fa fa-warning'></i>&nbsp;Asset number already exist.</div></div>";
                        $("#addDetailsServerLoading").hide();
                        $("#addDetailsServer").show();
                    }else if(returnValue == "serial number"){
                        displayMessage.innerHTML = "<div class='alert alert-warning align-items-center alert-dismissible fade show' role='alert'><div class='text-center'><i class='fa fa-warning'></i>&nbsp;Serial number already exist.</div></div>";
                        $("#addDetailsServerLoading").hide();
                        $("#addDetailsServer").show();
                    }else{
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
                        $("#addDetailsServerLoading").hide();
                        $("#addDetailsServer").show();
                        displayMessage.innerHTML = "<div class='alert alert-success align-items-center alert-dismissible fade show' role='alert'><div class='text-center'><i class='fa fa-check-circle'></i>&nbsp;You successfully added new CPU-PC on the list.</div></div>";
                    }
                },
                error: function(){
                    alert(data);
                }
            });
        }
    });

    $.ajax({
        type: "POST",
        url: "view-data-server.php",//"view-data-cpu-pc.php"
        success: function(data){
            $("#tableDisplay2").html(data);
            $('#example').DataTable({
                "paging" : true,
                "ordering" : true,
                "searching" : true
            });
        },
        error: function(){
            alert(data);
        }
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

});

function viewHWDetails(id){
    $("#hw_displayEdit").hide();
    $("#hw_display").show();
    $("#editBtn").show();
    $("#saveBtn").hide();
    var wordObj = {"id" : id};
    $.ajax({
        type: "POST",
        url: "view-single-data-server.php",
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
        url: "view-site-list-option.php",
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
    alert.innerHTML = "<strong>You successfully updated CPU-PC.</strong>";

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