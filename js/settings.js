$(function() {
    // Store initial form values
    let personalFormInitial = {};

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
                alert('Failed to load user information: ' + (response.error || 'Unknown error'));
                $('#profilePicture').attr('src', 'assets/img/avatar.png').show();
                $('#avatarPlaceholder').hide();
                $('#region_assigned_display').text('Not set');
                $('#user_type_display').text('Not set');
                $('#cluster_name_display').text('Not set');
            }
        },
        error: function(xhr, status, error) {
            alert('Error loading user data: ' + error);
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
                    alert('Personal info updated!');
                    // Update initial values after successful save
                    personalFormInitial = {
                        fname: $('#fname').val(),
                        lname: $('#lname').val(),
                        user_name: $('#user_name').val()
                    };
                    $('#personalSaveBtn').prop('disabled', true);
                } else {
                    if (response.error === 'Username is already taken') {
                        alert('The username is already in use. Please choose a different username.');
                    } else {
                        alert('Failed to update personal info: ' + (response.error || 'Unknown error'));
                    }
                }
            },
            error: function(xhr, status, error) {
                alert('Error updating personal info: ' + error);
            }
        });
    });

    // Enable Save Changes button when password form changes
    $('#changePasswordForm input').on('input', function() {
        const currentValues = {
            current_password: $('#current_password').val(),
            new_password: $('#new_password').val(),
            confirm_password: $('#confirm_password').val()
        };
        const hasChanged = Object.values(currentValues).some(val => val !== '');
        $('#passwordSaveBtn').prop('disabled', !hasChanged);
    });

    // Change password
    $('#changePasswordForm').on('submit', function(e) {
        e.preventDefault();
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();

        if (!currentPassword || !newPassword || !confirmPassword) {
            alert('All password fields are required.');
            return;
        }

        if (newPassword !== confirmPassword) {
            alert('New passwords do not match!');
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
                    alert('Password changed successfully!');
                    $('#changePasswordForm')[0].reset();
                    $('#passwordSaveBtn').prop('disabled', true);
                } else {
                    alert('Failed to change password: ' + (response.error || 'Current password incorrect'));
                }
            },
            error: function(xhr, status, error) {
                alert('Error changing password: ' + error);
            }
        });
    });
});