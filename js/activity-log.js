$(function(){
    $.ajax({
        type: "POST",
        url: "activity-log-view.php",
        success: function(data){
            $("#viewLogs").html(data);
            $('#activity_tbl').DataTable({
                "paging": true,
                "ordering": false,
                "searching": false,
                "lengthChange": false
            });
        },
        error: function(){
            alert(data);
        }
    });
});