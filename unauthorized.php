<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 Unauthorized</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: "Segoe UI", sans-serif;
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58,59,69,.15);
            border-radius: 1rem;
            max-width: 550px;
            padding: 3rem 2rem;
            background-color: #fff;
        }

        .avatar {
            width: 100px;
            height: 100px;
            background: #e74a3b;
            color: white;
            font-size: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #e74a3b;
        }

        p {
            color: #858796;
        }

        .btn-warning {
            font-weight: 500;
            border-radius: 30px;
            padding: 0.5rem 1.25rem;
        }

        .footer-note {
            font-size: 0.875rem;
            color: #b7b9cc;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<div class="card text-center">
    <div class="avatar mb-3">
        <i class="fas fa-user-shield"></i>
    </div>
    <h1 class="mb-3">Error 401 - Unauthorized</h1>
    <p class="mb-4">You are not authorized to access this page.<br>
        Please contact your administrator if you believe this is a mistake.</p>
    <a href="index.php" class="btn btn-warning">
        <i class="fas fa-arrow-left me-2"></i>Back to Home
    </a>
    <div class="footer-note">Masterfile &copy; 2024 - 2025</div>
</div>

</body>
</html>
