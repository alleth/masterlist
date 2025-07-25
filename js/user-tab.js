$(function () {
    let dataTable;

    $("#inputPassword").hide();

    // Toast helper with auto-dismiss
    function showToast(message, type = 'success', duration = 3000) {
        const toastId = 'toast-' + Date.now();
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        $('#toastContainer').append(toastHTML);
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            delay: duration,
            autohide: true
        });
        toast.show();
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }

    // Function to populate region dropdown
    function populateRegions(selectedRegionId = '', cluster = '') {
        const regionSelect = $('#region');
        regionSelect.empty().append('<option value="" disabled selected>Select Region</option>');

        if (!cluster) {
            regionSelect.prop('disabled', true);
            return;
        }

        $.ajax({
            url: 'DAO/user-actions.php',
            type: 'POST',
            data: { action: 'fetch_regions_by_cluster', cluster: cluster },
            dataType: 'json',
            success: function (response) {
                console.log('Regions response:', response);
                if (response.error) {
                    showToast(response.error, 'danger');
                    regionSelect.prop('disabled', true);
                    return;
                }
                response.forEach(region => {
                    const isSelected = region.region_id == selectedRegionId ? 'selected' : '';
                    regionSelect.append(`<option value="${region.region_id}" ${isSelected}>${region.region_name}</option>`);
                });
                regionSelect.prop('disabled', response.length === 0);
                if (response.length === 0) {
                    showToast('No regions available for the selected cluster.', 'warning');
                }
            },
            error: function (xhr, status, error) {
                console.error('Regions AJAX error:', xhr.responseText, status, error);
                showToast('Failed to load regions: ' + error, 'danger');
                regionSelect.prop('disabled', true);
            }
        });
    }

    function fetchUsers() {
        $('#btn-refresh').html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Refreshing...').prop('disabled', true);
        if ($.fn.DataTable.isDataTable('#userTable')) {
            dataTable.clear().destroy();
        }
        $.ajax({
            url: 'DAO/user-actions.php',
            type: 'POST',
            data: { action: 'fetch' },
            success: function (response) {
                $('#userTable tbody').html(response);
                dataTable = $('#userTable').DataTable({
                    responsive: true,
                    pageLength: 10
                });
            },
            error: function (xhr, status, error) {
                console.error('Fetch users AJAX error:', xhr.responseText, status, error);
                showToast('Failed to load users: ' + error, 'danger');
            },
            complete: function () {
                $('#btn-refresh').html('<i class="bi bi-arrow-clockwise"></i> <span class="btn-text">Refresh</span>').prop('disabled', false);
            }
        });
    }

    // Initial load
    fetchUsers();

    // Refresh button
    $("#btn-refresh").click(function () {
        fetchUsers();
    });

    // Real-time validation
    $('#fname, #lname, #username').on('input', function () {
        const input = $(this);
        if (input.val().trim() !== '') {
            input.removeClass('is-invalid');
            input.siblings('.invalid-feedback').text('');
        }
    });

    // User Type change handler
    $('#user_type').on('change', function () {
        const userType = $(this).val();
        const clusterSelect = $('#cluster');
        const regionSelect = $('#region');

        // Reset dropdowns
        clusterSelect.prop('disabled', false).empty().append(`
            <option value="" disabled selected>Select Cluster</option>
            <option value="NCR">NCR</option>
            <option value="Luzon">Luzon</option>
            <option value="VisMin">Vismin</option>
        `);
        regionSelect.prop('disabled', true).empty().append('<option value="" disabled selected>Select Region</option>');

        if (userType === 'ADM') {
            clusterSelect.empty().append('<option value="All Cluster" selected>All Cluster</option>').prop('disabled', true);
            regionSelect.empty().append('<option value="0" selected>All Region</option>').prop('disabled', true);
        } else if (userType === 'SPV') {
            regionSelect.empty().append('<option value="0" selected>All Region</option>').prop('disabled', true);
        }
    });

    // Cluster change handler
    $('#cluster').on('change', function () {
        const userType = $('#user_type').val();
        const cluster = $(this).val();
        const regionSelect = $('#region');

        if (userType === 'FSE' && cluster && cluster !== '') {
            populateRegions('', cluster);
        } else {
            regionSelect.prop('disabled', true).empty().append('<option value="" disabled selected>Select Region</option>');
        }
    });

    // Open modal for new user
    $('[data-bs-target="#userModal"]').click(function () {
        $('#userForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('#userId').val('');
        $('#userModalLabel').text('Add New User');
        $('#cluster').empty().append(`
            <option value="" disabled selected>Select Cluster</option>
            <option value="NCR">NCR</option>
            <option value="Luzon">Luzon</option>
            <option value="VisMin">Vismin</option>
        `);
        $('#region').empty().append('<option value="" disabled selected>Select Region</option>').prop('disabled', true);
    });

    // Save user
    $('#saveUser').click(function (e) {
        e.preventDefault();
        const fields = [
            { id: '#fname', msg: 'First name is required.' },
            { id: '#lname', msg: 'Last name is required.' },
            { id: '#user_type', msg: 'Please select a user type.' },
            { id: '#username', msg: 'Username is required.' }
        ];

        const userType = $('#user_type').val();
        if (userType === 'FSE') {
            fields.push(
                { id: '#cluster', msg: 'Please select a cluster.' },
                { id: '#region', msg: 'Please select a region.' }
            );
        }

        let isValid = true;
        fields.forEach(field => {
            const input = $(field.id);
            if (input.val()?.trim() === '') {
                input.addClass('is-invalid');
                input.next('.invalid-feedback').text(field.msg);
                isValid = false;
            } else {
                input.removeClass('is-invalid');
            }
        });
        if (!isValid) return;

        let formData = $('#userForm').serializeArray();
        let formDataObject = {};
        formData.forEach(item => {
            formDataObject[item.name] = item.value;
        });

        formDataObject.action = 'save';

        $('#saveUser').prop('disabled', true).text('Saving...');
        $.ajax({
            url: 'DAO/user-actions.php',
            type: 'POST',
            data: formDataObject,
            dataType: 'json',
            success: function (response) {
                console.log('Save response:', response);
                if (response.error) {
                    const usernameInput = $('#username');
                    usernameInput.addClass('is-invalid');
                    usernameInput.siblings('.invalid-feedback').text(response.error);
                    showToast(response.error, 'danger');
                } else {
                    $('#userModal').modal('hide');
                    $('#userForm')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    fetchUsers();
                    showToast('User saved successfully!');
                }
            },
            error: function (xhr, status, error) {
                console.error('Save AJAX error:', xhr.responseText, status, error);
                showToast('Failed to save user: ' + error, 'danger');
            },
            complete: function () {
                $('#saveUser').prop('disabled', false).text('Save');
            }
        });
    });

    // Edit user
    $(document).on('click', '.edit-btn', function () {
        const userId = $(this).data('id');
        $.ajax({
            url: 'DAO/user-actions.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'edit', id: userId },
            success: function (data) {
                console.log('Edit response:', data);
                if (data.error) {
                    showToast(data.error, 'danger');
                    return;
                }
                $('#userId').val(data.id);
                $('#fname').val(data.fname || '');
                $('#lname').val(data.lname || '');
                $('#user_type').val(data.user_type || '');
                $('#username').val(data.user_name || '');
                $('#password').val('');

                const clusterSelect = $('#cluster');
                clusterSelect.empty();
                if (data.user_type === 'ADM') {
                    clusterSelect.append('<option value="All Cluster" selected>All Cluster</option>').prop('disabled', true);
                } else {
                    clusterSelect.append(`
                        <option value="" disabled ${!data.cluster_name ? 'selected' : ''}>Select Cluster</option>
                        <option value="NCR" ${data.cluster_name === 'NCR' ? 'selected' : ''}>NCR</option>
                        <option value="Luzon" ${data.cluster_name === 'Luzon' ? 'selected' : ''}>Luzon</option>
                        <option value="VisMin" ${data.cluster_name === 'VisMin' ? 'selected' : ''}>Vismin</option>
                    `).prop('disabled', false);
                }

                const regionSelect = $('#region');
                if (data.user_type === 'ADM' || data.user_type === 'SPV') {
                    regionSelect.empty().append(`<option value="0" selected>All Region</option>`).prop('disabled', true);
                } else {
                    regionSelect.empty().append('<option value="" disabled selected>Select Region</option>').prop('disabled', !data.cluster_name);
                    if (data.cluster_name) {
                        populateRegions(data.region_assigned || '', data.cluster_name);
                    }
                }

                $('#userModalLabel').text('Edit User');
                $('#userModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Edit AJAX error:', xhr.responseText, status, error);
                showToast('Failed to load user: ' + error, 'danger');
            }
        });
    });


    $(document).on('click', '.delete-btn', function () {
        if (confirm('Are you sure you want to delete this user?')) {
            const userId = $(this).data('id');
            $.ajax({
                url: 'DAO/user-actions.php',
                type: 'POST',
                data: { action: 'delete', id: userId },
                dataType: 'json',
                success: function (response) {
                    console.log('Delete response:', response);
                    if (response.error) {
                        showToast(response.error, 'danger');
                    } else {
                        fetchUsers();
                        showToast('User deleted successfully!', 'warning');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Delete AJAX error:', xhr.responseText, status, error);
                    showToast('Failed to delete user: ' + error, 'danger');
                }
            });
        }
    });


    // Cleanup modal
    $('#userModal').on('hidden.bs.modal', function () {
        $('#userForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('#userModalLabel').text('Add New User');
        $('#userId').val('');
        $('#cluster').empty().append(`
            <option value="" disabled selected>Select Cluster</option>
            <option value="NCR">NCR</option>
            <option value="Luzon">Luzon</option>
            <option value="VisMin">Vismin</option>
        `);
        $('#region').empty().append('<option value="" disabled selected>Select Region</option>').prop('disabled', true);
    });
});