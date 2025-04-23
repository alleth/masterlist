$(document).ready(function () {
    // Initialize DataTable once after fetch
    let dataTable;

    function fetchUsers() {
        $.ajax({
            url: 'DAO/user-actions.php',
            type: 'POST',
            data: { action: 'fetch' },
            success: function (response) {
                $('#userTable tbody').html(response);

                // Re-initialize DataTable
                if ($.fn.DataTable.isDataTable('#userTable')) {
                    dataTable.destroy();
                }

                dataTable = $('#userTable').DataTable({
                    responsive: true,
                    pageLength: 10
                });
            }
        });
    }

    fetchUsers();

    $('#saveUser').click(function (e) {
        e.preventDefault();
        let formData = $('#userForm').serialize() + '&action=save';

        $.ajax({
            url: 'DAO/user-actions.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#userModal').modal('hide');
                $('#userForm')[0].reset();
                fetchUsers();
            }
        });
    });

    // Edit User
    $(document).on('click', '.edit-btn', function () {
        const userId = $(this).data('id');
        $.ajax({
            url: 'DAO/user-actions.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'edit', id: userId },
            success: function (data) {
                $('#userId').val(data.id);
                $('#fname').val(data.fname);
                $('#lname').val(data.lname);
                $('#region').val(data.region_assigned);
                $('#cluster').val(data.cluster_name);
                $('#user_type').val(data.user_type);
                $('#username').val(data.user_name);
                $('#password').val(data.user_pass);
                $('#userModal').modal('show');
            }
        });
    });

    // Delete User
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Are you sure you want to delete this user?')) {
            const userId = $(this).data('id');
            $.ajax({
                url: 'DAO/user-actions.php',
                type: 'POST',
                data: { action: 'delete', id: userId },
                success: function (response) {
                    fetchUsers();
                }
            });
        }
    });
});
