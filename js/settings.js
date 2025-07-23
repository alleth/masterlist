$(function() {
    // Store initial form values
    let personalFormInitial = {};

    // Password validation regex
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{}|;:,.<>?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{}|;:,.<>?]{8,}$/;

    // Function to show Bootstrap toast
    function showToast(message, type = 'error') {
        const toastContainer = $('#toastContainer');
        const toastId = 'toast-' + new Date().getTime();
        const toastClass = type === 'success' ? 'bg-success text-white' : 'bg-danger text-white';
        const toastHeader = type === 'success' ? 'Success' : 'Error';
        const toastHtml = `
            <div id="${toastId}" class="toast ${toastClass}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header">
                    <strong class="me-auto">${toastHeader}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        `;
        toastContainer.append(toastHtml);
        const toastElement = $(`#${toastId}`);
        toastElement.toast('show');
        toastElement.on('hidden.bs.toast', function () {
            $(this).remove();
        });
    }

    // Real-time password feedback
    function updatePasswordFeedback() {
        const newPassword = $('#new_password').val();
        const feedback = $('#passwordFeedback');
        if (!feedback.length) {
            $('#new_password').after('<div id="passwordFeedback" style="font-size: 0.85rem; color: #e53e3e;"></div>');
        }
        if (newPassword && !passwordRegex.test(newPassword)) {
            $('#passwordFeedback').text('Password must be at least 8 characters long and include an uppercase letter, a number, and a special character.');
            $('#passwordSaveBtn').prop('disabled', true);
        } else {
            $('#passwordFeedback').text('');
            const currentValues = {
                current_password: $('#current_password').val(),
                new_password: $('#new_password').val(),
                confirm_password: $('#confirm_password').val()
            };
            const hasChanged = Object.values(currentValues).some(val => val !== '');
            $('#passwordSaveBtn').prop('disabled', !hasChanged);
        }
    }

    // Fetch and fill personal info
    $.ajax({
        url: 'settings-updates.php',
        method: 'POST',
        data: { action: 'get_user_info' },
        success: function(response) {
            if (response.success) {
                const u = response.user;
                $('#fname').val(u.fname);
                $('#lname').val(u.lname);
                $('#user_name').val(u.user_name);
                $('#region_assigned_display').text(u.region_assigned || 'Not set');
                $('#user_type_display').text(u.user_type || 'Not set');
                $('#cluster_name_display').text(u.cluster_name || 'Not set');

                // Handle profile picture
                if (u.profile_picture) {
                    $('#profilePicture').attr('src', u.profile_picture).show();
                    $('#avatarPlaceholder').hide();
                } else {
                    $('#profilePicture').attr('src', 'assets/img/avatar.png').show();
                    $('#avatarPlaceholder').hide();
                }

                // Store initial values after loading
                personalFormInitial = {
                    fname: u.fname || '',
                    lname: u.lname || '',
                    user_name: u.user_name || ''
                };
            } else {
                showToast('Failed to load user information: ' + (response.error || 'Unknown error'));
                $('#profilePicture').attr('src', 'assets/img/avatar.png').show();
                $('#avatarPlaceholder').hide();
                $('#region_assigned_display').text('Not set');
                $('#user_type_display').text('Not set');
                $('#cluster_name_display').text('Not set');
            }
        },
        error: function(xhr, status, error) {
            showToast('Error loading user data: ' + error);
            $('#profilePicture').attr('src', 'assets/img/avatar.png').show();
            $('#avatarPlaceholder').hide();
            $('#region_assigned_display').text('Not set');
            $('#user_type_display').text('Not set');
            $('#cluster_name_display').text('Not set');
        }
    });

    // Enable Save Changes button when personal info form changes
    $('#personalInfoForm input').on('input', function() {
        const currentValues = {
            fname: $('#fname').val(),
            lname: $('#lname').val(),
            user_name: $('#user_name').val()
        };
        const hasChanged = Object.keys(personalFormInitial).some(key => currentValues[key] !== personalFormInitial[key]);
        $('#personalSaveBtn').prop('disabled', !hasChanged);
    });

    // Save personal info
    $('#personalInfoForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'settings-updates.php',
            method: 'POST',
            data: {
                action: 'update_user_info',
                ...Object.fromEntries(new FormData(this))
            },
            success: function(response) {
                if (response.success) {
                    showToast('Personal info updated!', 'success');
                    // Update initial values after successful save
                    personalFormInitial = {
                        fname: $('#fname').val(),
                        lname: $('#lname').val(),
                        user_name: $('#user_name').val()
                    };
                    $('#personalSaveBtn').prop('disabled', true);
                } else {
                    if (response.error === 'Username is already taken') {
                        showToast('The username is already in use. Please choose a different username.');
                    } else {
                        showToast('Failed to update personal info: ' + (response.error || 'Unknown error'));
                    }
                }
            },
            error: function(xhr, status, error) {
                showToast('Error updating personal info: ' + error);
            }
        });
    });

    // Enable Save Changes button when password form changes with real-time validation
    $('#changePasswordForm input').on('input', updatePasswordFeedback);

    // Change password
    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();

        if (!currentPassword || !newPassword || !confirmPassword) {
            showToast('All password fields are required.');
            return;
        }

        if (newPassword !== confirmPassword) {
            showToast('New passwords do not match!');
            return;
        }

        if (!passwordRegex.test(newPassword)) {
            showToast('Password must be at least 8 characters long and include an uppercase letter, a number, and a special character.');
            return;
        }

        $.ajax({
            url: 'settings-updates.php',
            method: 'POST',
            data: {
                action: 'change_password',
                current_password: currentPassword,
                new_password: newPassword
            },
            success: function(response) {
                if (response.success) {
                    showToast('Password changed successfully!', 'success');
                    $('#changePasswordForm')[0].reset();
                    $('#passwordFeedback').remove();
                    $('#passwordSaveBtn').prop('disabled', true);
                } else {
                    showToast(response.error || 'Failed to change password');
                }
            },
            error: function(xhr, status, error) {
                showToast('Error changing password: ' + error);
            }
        });
    });
});