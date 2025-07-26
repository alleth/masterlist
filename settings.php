<?php include("includes/header.php"); ?>
<?php include 'includes/components.php'; ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/settings-style.css">

    <main>
        <div class="container-fluid">
            <div class="toast-container" id="toastContainer"></div>
            <h4 class="profile-header">User Profile</h4>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">Personal Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Change Password</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="settingsTabsContent">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="profile-picture-container">
                                        <img src="assets/img/avatar.png" class="profile-picture" id="profilePicture" alt="Profile Picture">
                                        <div class="avatar-placeholder" id="avatarPlaceholder">?</div>
                                    </div>
                                    <div class="profile-info">
                                        <div>
                                            <div class="info-label">Region Assigned</div>
                                            <div class="info-value" id="region_assigned_display"></div>
                                        </div>
                                        <div>
                                            <div class="info-label">User Type</div>
                                            <div class="info-value" id="user_type_display"></div>
                                        </div>
                                        <div>
                                            <div class="info-label">Cluster Name</div>
                                            <div class="info-value" id="cluster_name_display"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <form id="personalInfoForm">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="fname" class="form-label">First Name</label>
                                                <input type="text" class="form-control" name="fname" id="fname">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="lname" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" name="lname" id="lname">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="user_name" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="user_name" id="user_name">
                                        </div>
                                        <button type="submit" class="btn btn-primary" id="personalSaveBtn" disabled>Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form id="changePasswordForm">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" id="current_password">
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="new_password" id="new_password">
                                    <div id="passwordFeedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                </div>
                                <button type="submit" class="btn btn-primary" id="passwordSaveBtn" disabled>Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <br />
    <script src="js/settings.js?v=<?= time() ?>"></script>
    <script src="js/inactivity.js.js?v=<?= time() ?>"></script>
<?php include 'includes/footer.php'; ?>