$(function(){

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