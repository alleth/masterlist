<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimalist Tables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

<div class="container">
    <div class="row g-4">

        <!-- Design 1: Simple Bordered Table -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Bordered Table</h5>
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Value 1</td>
                            <td>Value 2</td>
                        </tr>
                        <tr>
                            <td>Value 3</td>
                            <td>Value 4</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Design 2: Striped Table with Hover Effect -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Striped Table</h5>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark text-white">
                        <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Value 1</td>
                            <td>Value 2</td>
                        </tr>
                        <tr>
                            <td>Value 3</td>
                            <td>Value 4</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Design 3: Soft Colors with Shadow -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Soft Shadow Table</h5>
                    <table class="table">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-white shadow-sm">
                            <td>Value 1</td>
                            <td>Value 2</td>
                        </tr>
                        <tr class="bg-white shadow-sm">
                            <td>Value 3</td>
                            <td>Value 4</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
