$(function(){
    $("#addDetailsUserLoading").hide();
    $("#addUserBtn").click(function(){
        $('#addUserModal').modal('show');
    });

    $.ajax({
        type: "POST",
        url: "user-view-list.php",
        success: function(data){
            $("#userList").html(data);
        },
        error: function(){
            alert(data);
        }
    });

    $("#addDetailsUser").click(function (){
        var displayMessage = document.getElementById('addMessage');

        var fname = $("input[name='f_name']").val();
        var lname = $("input[name='l_name']").val();
        var user_type = $("select[name='user_type']").val();
        var user_name = $("input[name='user_name']").val();
        var cluster_name = $("select[name='assignmentName']").val();
        var region_name = $("select[name='regionAssignmentName']").val();

        if (user_type == "SPV"){
            region_name = "All";
        }else if(user_type == "ADM"){
            cluster_name = "All";
            region_name = "All";
        }

        if(fname == "" || lname == "" || user_type == "" || user_name == "" || cluster_name == "" || region_name == ""){
            displayMessage.innerHTML = "<div class='alert alert-warning align-items-center alert-dismissible fade show' role='alert'><div class='text-center'><i class='fa fa-warning'></i>&nbsp;Please fill up all the fields.</div></div>";
            return;
        }else{
            $("#addDetailsUser").hide();
            $("#addDetailsUserLoading").show();

            var wordObj= {
                "f_name" : fname,
                "l_name" : lname,
                "user_type" : user_type,
                "user_name" : user_name,
                "clusterName" : cluster_name,
                "assignmentName" : region_name
            };

            $.ajax({
                type: "POST",
                url: "user-enroll.php",
                data: wordObj,
                success: function(data){
                    var res = JSON.parse(data);

                    if (res.exists) {
                        displayMessage.innerHTML =
                            "<div class='alert alert-danger align-items-center alert-dismissible fade show' role='alert'>" +
                            "<div class='text-center'><i class='fa fa-exclamation-circle'></i>&nbsp;" +
                            res.message +
                            "</div>" +
                            "</div>";
                    }else if (res.success) {
                        displayMessage.innerHTML =
                            "<div class='alert alert-success align-items-center alert-dismissible fade show' role='alert'>" +
                            "<div class='text-center'><i class='fa fa-check-circle'></i>&nbsp;" +
                            res.message +
                            "</div>" +
                            "</div>";

                        $("#addUserForm")[0].reset();
                        $("#addDetailsUser").show();
                        $("#addDetailsUserLoading").hide();
                    }else {
                        displayMessage.innerHTML =
                            "<div class='alert alert-danger align-items-center alert-dismissible fade show' role='alert'>" +
                            "<div class='text-center'><i class='fa fa-exclamation-circle'></i>&nbsp;" +
                            res.message +
                            "</div>" +
                            "</div>";
                    }

                    $("#addDetailsUser").modal('hide');
                    $("#addDetailsUserLoading").hide();
                },
                error: function(){
                    alert(data);
                }

            });

        }
    });

    $("#confirmDeleteBtn").click(function (){
        var wordObj = {"user_id" : $("input[name='user_id']").val()};
        var selectedId = $("input[name='user_id']").val();
        $.ajax({
            type: "POST",
            url: "user-delete-confirmation.php",
            data: wordObj,
            success: function (data){
                $("#deleteModal").modal('hide');
                var rowSelected = document.getElementById("row-"+selectedId);
                rowSelected.remove();
            },
            error: function (){
                alert(data);
            }
        });
    });
});

function deleteUser(id){
    $("input[name='user_id']").val(id);
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function editUser(id){
    alert(id);
}

function selectAssignment() {
    const userType = document.querySelector('select[name="user_type"]').value;
    const clusterSelect = document.getElementById('assignmentSelect');
    const regionSelect = document.getElementById('regionAssignmentSelect');

    // Clear previous options
    clusterSelect.innerHTML = '<option disabled selected>Please Select Cluster</option>';
    regionSelect.innerHTML = '<option disabled selected>Select region assignment</option>';

    if (userType === 'FSE') {
        clusterSelect.disabled = false;
        regionSelect.disabled = false;
        addClusterOptions(['Luzon', 'NCR', 'VisMin']);
        addRegionOptions();
    } else if (userType === 'SPV') {
        clusterSelect.disabled = false;
        regionSelect.disabled = true;
        addClusterOptions(['Luzon', 'NCR', 'VisMin']);
    } else {
        clusterSelect.disabled = true;
        regionSelect.disabled = true;
    }
}

function addClusterOptions(options) {
    const clusterSelect = document.getElementById('assignmentSelect');
    options.forEach(option => {
        const opt = document.createElement('option');
        opt.value = option;
        opt.textContent = option;
        clusterSelect.appendChild(opt);
    });
}

function addRegionOptions() {
    const regionSelect = document.getElementById('regionAssignmentSelect');

    $.ajax({
        type: "POST",
        url: "region-view.php",
        data: {},
        success: function(data){
            var obj = JSON.parse(data);

            obj.forEach(function (subcategory) {
                const opt = document.createElement('option');
                opt.value = subcategory.region_id;
                opt.textContent = subcategory.region_name;
                regionSelect.appendChild(opt);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching regions: ", error);
        }
    });
}
