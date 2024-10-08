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