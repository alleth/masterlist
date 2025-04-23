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

    $("#deleteButton").click(function () {
        var requestDeleteId = $("input[name='idDelete']").val();
        var wordObj = { "requestDeleteId": requestDeleteId };

        $.ajax({
            type: "POST",
            url: "request-delete.php",
            data: wordObj,
            success: function (data) {
                $("#deleteModal").modal('hide');

                $(document.getElementById(wordObj.requestDeleteId)).remove();

                if ($("#requestDisplay tbody").children().length === 0) {
                    $("#requestDisplay tbody").append(`
                    <tr>
                        <td colspan="100%" class="text-center text-muted fst-italic">You do not have any request...</td>
                    </tr>
                `);
                }
            },
            error: function () {
                alert("Something went wrong.");
            }
        });
    });

    $("#deleteItem").click(function (){
        $("#viewDetailsRequest").modal('hide');
        var requestDeleteId = $("input[name='item_id']").val();
        $("input[name='idDelete']").val(requestDeleteId);
        $("#deleteModal").modal('show');
    });

    $("#declineItem").click(function (){

        const maxChars = 60;

        $("#leaveRemarks").on("input", function() {
            const currentLength = $(this).val().length;
            const remaining = maxChars - currentLength;
            $("#charCount").text(remaining);
        });

        $("#viewDetailsRequest").modal('hide');
        $("#declineModal").modal('show');
    });

    $("#declineRequest").click(function(){
        $("#declineModal").modal('hide');
        var requestDeclineId = $("input[name='item_id']").val();
        var remarks = $("textarea[name='remarks']").val();
        var wordObj = {
            "requestId" : requestDeclineId,
            "remarks" : remarks
        };
        var button = $(this); // store reference to button
        var originalText = button.html();

        $.ajax({
            type: "POST",
            url: "request-decline.php",
            data: wordObj,
            beforeSend: function () {
                button.prop("disabled", true);
                button.html("<span class='spinner-border spinner-border-sm'></span> Please wait...");
            },
            success: function (data){
                $("textarea[name='remarks']").val("");
                $(".view-details-btn[data-id='" + requestDeclineId + "']").attr('data-status', 0);
                // Update the status cell
                $(".status-cell[data-id='" + requestDeclineId + "']").html("<span class='badge bg-danger'>Declined</span>");
                button.prop("disabled", false);
                button.html(originalText);
            },
            error: function(){
                alert("An error occurred.");
                button.prop("disabled", false);
                button.html("Decline");
            }
        });
    });

    $(document).on('click', '.view-details-btn', function() {
        var id = $(this).data('id');
        var statMess = $(this).attr('data-status');
        viewDetailsRequest(id, statMess);
    });

    $("#approveRequest").click(function (){
        var requestApproveId = $("input[name='item_id']").val();

        var wordObj = {
            "requestId" : requestApproveId
        };
        var button = $(this); // store reference to button
        var decline_button = $("#declineItem"); // store reference to button
        var originalText = button.html();

        $.ajax({
            type: "POST",
            url: "request-approve.php",
            data: wordObj,
            beforeSend: function () {
                button.prop("disabled", true);
                button.html("<span class='spinner-border spinner-border-sm'></span> Please wait...");
            },
            success: function (data){
                $("#viewDetailsRequest").modal('hide');
                $("textarea[name='remarks']").val("");
                $(".view-details-btn[data-id='" + requestApproveId + "']").attr('data-status', 0);
                // Update the status cell
                $(".status-cell[data-id='" + requestApproveId + "']").html("<span class='badge bg-success'>Received</span>");
                button.prop("disabled", true);
                decline_button.prop("disabled", true);
                button.html(originalText);
            },
            error: function(){
                alert("An error occurred.");
                button.prop("disabled", false);
                button.html("Approve");
            }
        });
    });
});
function deleteRequest(id){
    $("input[name='idDelete']").val(id);
    $("#deleteModal").modal('show');
}

function viewDetailsRequest(id, statMess){
    var requestStatus = statMess;
    if(requestStatus == 0){
        $("#viewButtons").hide();
    }else{
        $("#viewButtons").show();
    }
    $("input[name='item_id']").val(id);
    $("#viewDetailsRequest").modal('show');

    var wordObj = {"requestId" : id};

    $.ajax({
        type: "POST",
        url: "requests-view-details.php",
        data: wordObj,
        beforeSend: function () {
            $("#viewFullDetailsRequest").html(`
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
            $("#viewFullDetailsRequest").html(data);
        },
        error: function(){
            alert(data);
        }
    });
}