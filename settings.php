<?php include("includes/header.php"); ?>
<?php include 'includes/components.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
    .form-control {
        border: none;
        border-bottom: 2px solid #e2e8f0;
        border-radius: 0;
        padding: 0.5rem 0;
        font-size: 1rem;
        background-color: transparent;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-bottom: 2px solid #14B8A6;
        outline: none;
        box-shadow: none;
    }

    .form-label {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-primary {
        background-color: #14B8A6;
        border-color: #14B8A6;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0d8c7e;
        border-color: #0d8c7e;
    }

    .btn-primary:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
    }

    .card-body {
        padding: 2rem;
    }

    .profile-picture-container {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 4px solid transparent;
        overflow: hidden;
        margin: 0 auto 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        background-color: #f8f9fa;
    }

    .profile-picture {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #14B8A6, #0d8c7e);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #fff;
        font-weight: bold;
        display: none;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-weight: 500;
        color: #6b7280;
        font-size: 0.85rem;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: #1f2937;
        font-weight: 500;
    }

    .nav-tabs {
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }

    .nav-tabs .nav-link {
        font-weight: 500;
        color: #6b7280;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem 0.375rem 0 0;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
        background-color: #14B8A6;
        color: #fff;
        border-color: #14B8A6;
    }

    .tab-content {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-top: none;
        border-radius: 0 0 0.375rem 0.375rem;
        padding: 2rem;
    }
</style>

<main>
    <div class="container-fluid px-4">
        <h4 class="mt-4">User Profile</h4>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
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
                                    <div class="col-md-4 text-center text-md-start">
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
        </div>
    </div>
</main>

<br />
<script src="js/settings.js?v=<?= time() ?>"></script>
<?php include 'includes/footer.php'; ?>