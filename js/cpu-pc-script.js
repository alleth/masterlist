$(function(){

    $("#addCPUBtn").click(function(){
        $('#addCPUHardware').modal('show');
    });

    $.ajax({
        type: "POST",
        url: "view-data-cpu-pc.php",
        success: function(data){
            $("#tableDisplay").html(data);
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

});

function viewHWDetails(id){
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

function region_option(id){
    var wordObj = {"region_id" : id};
    $.ajax({
        type: "POST",
        url: "view-site-list-option.php",
        data: wordObj,
        success: function(data){
            $('#viewSiteSelect').prop('disabled', false);
            $("#viewSiteSelect").html(data);
        },
        error: function(){
            alert(data);
        }
    });
}

function site_name_option(id){
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