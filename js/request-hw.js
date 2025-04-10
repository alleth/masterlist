$(function(){
    $.ajax({
        type: "POST",
        url: "requests-view.php",
        beforeSend: function () {
            // Show spinner before request starts
            $("#requestList").html(`
                            <tr>
                                <td colspan="8" class="text-center">
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
            if ($.trim(data) === "") {
                $("#requestList").html("<tr><td colspan='6' class='text-center text-muted'>You do not have a request.</td></tr>");
                $("#requestDisplay").DataTable({
                    "paging": true,
                    "ordering": false,
                    "searching": false
                });
            } else {
                $("#requestList").html(data);
                $("#requestDisplay").DataTable({
                    "paging": true,
                    "ordering": false,
                    "searching": true
                });
            }
        },
        error: function(){
            alert(data);
        }
    });
});