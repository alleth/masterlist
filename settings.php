<?php include("includes/header.php"); ?>
<?php include 'includes/components.php'; ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #2d3748;
        }

        .container-fluid {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .card-body {
            padding: 2rem;
        }

        .profile-header {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 2rem;
        }

        .nav-tabs {
            border: none;
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .nav-tabs .nav-link {
            background: none;
            border: none;
            font-size: 1rem;
            font-weight: 500;
            color: #718096;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #2b6cb0;
            border-bottom: 2px solid #2b6cb0;
        }

        .nav-tabs .nav-link:hover {
            color: #2b6cb0;
        }

        .profile-picture-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 1.5rem;
            background: #edf2f7;
            transition: transform 0.3s ease;
        }

        .profile-picture-container:hover {
            transform: scale(1.05);
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #2b6cb0, #4299e1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
            font-weight: 600;
            display: none;
        }

        .profile-info {
            display: grid;
            gap: 1rem;
            padding: 1rem;
            background: #fafafa;
            border-radius: 8px;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: #2d3748;
        }

        .form-control {
            border: none;
            border-bottom: 1px solid #e2e8f0;
            background: transparent;
            padding: 0.5rem 0;
            font-size: 1rem;
            color: #2d3748;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-bottom: 1px solid #2b6cb0;
            box-shadow: none;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-primary {
            background-color: #2b6cb0;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #2c5282;
            transform: translateY(-2px);
        }

        .btn-primary:disabled {
            background-color: #a0aec0;
            cursor: not-allowed;
        }

        .tab-content {
            padding: 1.5rem;
            background: #fff;
            border-radius: 8px;
        }

        #passwordFeedback {
            font-size: 0.85rem;
            color: #e53e3e;
            margin-top: 0.5rem;
            transition: opacity 0.3s ease;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        .toast {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .toast-success {
            background-color: #e6fffa;
            color: #2b6cb0;
        }

        .toast-error {
            background-color: #fff5f5;
            color: #e53e3e;
        }

        .toast-header {
            border-bottom: none;
            font-weight: 600;
        }

        .toast-body {
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .profile-picture-container {
                width: 100px;
                height: 100px;
            }

            .profile-header {
                font-size: 1.25rem;
            }

            .toast-container {
                top: 10px;
                right: 10px;
                width: 90%;
                max-width: 350px;
            }
        }
    </style>

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