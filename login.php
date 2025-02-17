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
    <script src="js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <div class="row mt-5 justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-sm-6 text-center text-lg-start">
                <div>
                    <h1 class="display-1">WELCOME!</h1>
                    <h1>Masterfile | Hardware Inventory System</h1>
                    <h5>Core Services Group - Field Services Department</h5>
                </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center">
                <!--- Main Login -->
                <main>
                    <div class="container">
                        <div>
                            <div class="mt-5" style="max-width: 500px;min-width: 400px;">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header bg-primary"><h3 class="text-center font-weight-light my-4 text-light">Login</h3></div>
                                    <div class="card-body">
                                        <!-- Show error message if it exists -->
                                        <?php if (isset($_GET['error'])): ?>
                                            <div class="alert alert-danger">
                                                <?php echo htmlspecialchars($_GET['error']); ?>
                                            </div>
                                        <?php endif; ?>

                                        <form action="loginProcess.php" method="post" novalidate>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="user_name" type="text" placeholder="Enter your user name here" required/>
                                                <label for="inputEmail">User</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="user_pass" type="password" placeholder="Enter your password here" required/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <input type="submit" value="Login" class="btn btn-primary" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a class="small" href="#">Having problem with your account?</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <!--- end of Main Login -->
            </div>
        </div>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Masterfile | Hardware Inventory System &copy; <?php echo date("Y");?></div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
