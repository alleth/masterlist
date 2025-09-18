<?php
// Maintenance mode flag (set to true when under maintenance)
$maintenance_mode = true; // Change to false to disable maintenance mode

if ($maintenance_mode) {
    // Include the coming-soon.php file for maintenance page
    include("maintenance.html");
    exit; // Stop further execution
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Welcome to Masterfile</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" href="icons/cube.png" type="image/x-icon">
    <script src="js/all.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            overflow: hidden;
        }
        #layoutAuthentication {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        #layoutAuthentication_content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
        }
        .countdown {
            color: blue;
            font-weight: bold;
            text-align: center;
        }
        .form-disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>
<body>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 text-center text-lg-start mb-4">
                    <h2 class="fw-bold">Hardware Inventory System</h2>
                    <h4 class="text-muted">CSG-Field Services Department</h4>
                </div>
                <div class="col-md-5 d-flex justify-content-center">
                    <main class="login-container">
                        <div class="card shadow-lg border-0 rounded-lg">
                            <div class="card-header bg-primary">
                                <h3 class="text-center font-weight-light my-4 text-light">Login</h3>
                            </div>
                            <div class="card-body">
                                <?php if (isset($_GET['error'])): ?>
                                    <div class="alert alert-danger">
                                        <?php echo htmlspecialchars($_GET['error']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($_GET['lockout'])): ?>
                                    <div class="alert alert-warning">
                                        Account locked. Please wait: <span id="countdown" class="countdown"></span>
                                    </div>
                                <?php endif; ?>
                                <form action="loginProcess.php" method="post" novalidate id="loginForm" <?php echo isset($_GET['lockout']) ? 'class="form-disabled"' : ''; ?>>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputEmail" name="user_name" type="text" placeholder="Enter your user name here" required/>
                                        <label for="inputEmail">User</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputPassword" name="user_pass" type="password" placeholder="Enter your password here" required/>
                                        <label for="inputPassword">Password</label>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4 mb-0">
                                        <input type="submit" value="Login" class="btn btn-primary w-100" />
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small">
                                    <a href="#">Having problems with your account?</a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-3 bg-light">
            <div class="container-fluid text-center">
                <small class="text-muted">Masterfile | Hardware Inventory System © <?php echo date("Y");?></small>
            </div>
        </footer>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script>

    <?php if (isset($_GET['lockout']) && isset($_GET['lockout_until'])): ?>
    const lockoutUntil = <?php echo $_GET['lockout_until'] * 1000; ?>; // Convert to milliseconds
    const countdownElement = document.getElementById('countdown');
    const loginForm = document.getElementById('loginForm');

    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = lockoutUntil - now;

        if (timeLeft <= 0) {
            countdownElement.textContent = '';
            loginForm.classList.remove('form-disabled');
            window.location.href = 'login.php'; // Clear query params
        } else {
            const seconds = Math.ceil(timeLeft / 1000);
            countdownElement.textContent = `${seconds} second${seconds !== 1 ? 's' : ''}`;
            setTimeout(updateCountdown, 1000);
        }
    }

    updateCountdown();
    <?php endif; ?>
</script>
</body>
</html>