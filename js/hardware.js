$(function(){
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

    $("#showHwButton").click(function(){
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
            var wordObj = {"site_name" : site_name};
            $.ajax({
                type: "POST",
                url: "hardwares-view-details.php",
                data: wordObj,
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
        }
    });
}