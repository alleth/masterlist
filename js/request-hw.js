$(function(){
    $.ajax({
        type: "POST",
        url: "requests-view.php",
        success: function(data){
            if ($.trim(data) === "") {
                $("#requestList").html("<tr><td colspan='6' class='text-center text-muted'>You do not have a request.</td></tr>");
            } else {
                $("#requestList").html(data);
            }
        },
        error: function(){
            alert(data);
        }
    });
});