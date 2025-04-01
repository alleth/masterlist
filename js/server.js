$(function(){
    $("#updateServerBtn").hide();

    $.ajax({
        type: "POST",
        url: "server-region.php",
        success: function(data){
            $("#displayRegionServer").html(data);
        },
        error: function(){
            alert(data);
        }
    });
    $.ajax({
        type: "POST",
        url: "server-region-modal.php",
        success: function(data){
            $("#regionRegionModal").html(data);
        },
        error: function(){
            alert(data);
        }
    });


    $("#showServerType").click(function (){
        // Destroy any existing DataTable instance before making the AJAX request
        if ($.fn.DataTable.isDataTable('#serverTable')) {
            $('#serverTable').DataTable().destroy();
        }
        var region_name = $("select[name='server_region_name']").val();
        var server_type = $("select[name='server_type']").val();

        if ((region_name != 'all') || (server_type != 'all_server')) {

            if (server_type != 'all_server') {
                var wordObj = {
                    "region_name": region_name,
                    "server_type": server_type
                };
                $.ajax({
                    type: "POST",
                    url: "server-specific-serverType.php",
                    data: wordObj,
                    beforeSend: function () {
                        // Show spinner before request starts

                        $("#serverDisplay").html(`
                            <tr>
                                <td colspan="10" class="text-center">
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
                        $("#serverDisplay").html(data);

                        // Reinitialize the DataTable
                        $('#serverTable').DataTable({
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
                    url: "server-specific-region.php",
                    data: wordObj,
                    beforeSend: function () {
                        // Show spinner before request starts
                        $("#serverDisplay").html(`
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
                        $("#serverDisplay").html(data);

                        // Reinitialize the DataTable
                        $('#serverTable').DataTable({
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
                url: "server-all-details.php",
                beforeSend: function () {
                    // Show spinner before request starts
                    $("#serverDisplay").html(`
                    <tr>
                        <td colspan="10" class="text-center">
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

                    $("#serverDisplay").html(data);
                    // Reinitialize the DataTable
                    $('#serverTable').DataTable({
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

    $("#addServerBtn").click(function (){
        $("#saveServerBtn").show();
        $("#updateServerBtn").hide();
        $("#updateServerRegion").hide();
        $("#serverModalInput").modal('show');
        $("#staticBackdropLabel").html(`
            <i class="fas fa-info-circle"></i> Add Server
        `);
    });

});

function server_site_option(){
    document.getElementById('viewTypeServer').disabled = false;
    document.getElementById('showServerType').disabled = false;
}

function serverUpdate(id){
    $("#saveServerBtn").hide();
    $("#updateServerBtn").show();
    $("#updateServerRegion").show();
    $("#serverModalInput").modal('show');
    $("#staticBackdropLabel").html(`
            <i class="fas fa-info-circle"></i> Update server details
        `);
    document.getElementById('region_server_modal').disabled = true;

    var wordObj = {"id" : id};

    $.ajax({
        type: "POST",
        url: "server-update-details.php",
        data: wordObj,
        success: function(data){
            var obj = JSON.parse(data);
            $("input[name='regionNameModal']").val(obj.server_id);
            $("select[name='server_region_name_modal']").val(obj.region_id);
            $("input[name='site_name_input']").val(obj.site_code+" - "+obj.site_name);
            $("select[name='brand_name']").val(obj.brand_name);
        }
    });
}