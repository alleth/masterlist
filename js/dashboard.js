$(function(){
    $.ajax({
        type: "POST",
        url: "dashboard-count-cpu-pc.php",
        success: function(data){
            $("#cpu-count").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $.ajax({
        type: "POST",
        url: "dashboard-count-server.php",
        success: function(data){
            $("#Server").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    innerHTML.text();
});

