<?php
require_once 'DAO/settings-DAO.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['sess_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized: No active session']);
    exit;
}

$userId = $_SESSION['sess_id'];
$dao = new UserDAO();
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'update_user_info':
        $data = [
            'fname' => $_POST['fname'] ?? '',
            'lname' => $_POST['lname'] ?? '',
            'user_name' => $_POST['user_name'] ?? ''
        ];
        if ($dao->checkUsernameExists($userId, $data['user_name'])) {
            echo json_encode(['success' => false, 'error' => 'Username is already taken']);
            exit;
        }
        $result = $dao->updateUserInfo($userId, $data);
        echo json_encode(['success' => $result, 'error' => $result ? null : 'Failed to update user info']);
        break;

    case 'change_password':
        $currentPass = $_POST['current_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';

        // Password validation
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{}|;:,.<>?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{}|;:,.<>?]{8,}$/', $newPass)) {
            echo json_encode(['success' => false, 'error' => 'New password must be at least 8 characters long and include an uppercase letter, a number, and a special character']);
            exit;
        }

        $result = $dao->changePassword($userId, $currentPass, $newPass);
        echo json_encode(['success' => $result['success'], 'error' => $result['error']]);
        break;

    case 'get_user_info':
        try {
            $user = $dao->getUserDetails($userId);
            if ($user) {
                echo json_encode(['success' => true, 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'error' => 'User not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        }
        break;

    case 'verify_current_password':
        $currentPass = $_POST['current_password'] ?? '';
        $isValid = $dao->verifyPassword($userId, $currentPass);
        echo json_encode(['valid' => $isValid, 'error' => $isValid ? null : 'Invalid current password']);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}
?>