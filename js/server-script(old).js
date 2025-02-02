$(function(){

    $("#addServerBtn").click(function(){//ADD Server BTN
        $('#addServerHardware').modal('show');//Add Server Modal

    });

    $.ajax({
        type: "POST",
        url: "view-data-server.php",//for server data originally - "view-data-cpu-pc.php"
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

});

function viewHWDetails(id){
    var wordObj = {"id" : id};
    $.ajax({
        type: "POST",
        url: "view-single-data-server.php",//For server single data originally "view-single-data-cpu-pc.php"
        data: wordObj,
        success: function(data){
            $("#srvr_info").html(data);//for view display modal ID
            $('#staticBackdrop').modal('show');
        },
        error: function(){
            alert(data);
        }
    });
}