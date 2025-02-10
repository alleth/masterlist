<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compact Datepicker</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <style>
        /* Fullscreen Centered Container */
        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: "Poppins", sans-serif;
        }

        /* Minimalist Card */
        .datepicker-container {
            width: 100%;
            max-width: 300px;
            background: #fff;
            padding: 16px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Stylish Input Field */
        .datepicker-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            background: #fff;
            transition: 0.3s;
        }

        /* Input Field on Focus */
        .datepicker-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.2);
        }

        /* Calendar Icon */
        .datepicker-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 16px;
            transition: 0.3s;
        }

        /* Calendar Icon Hover */
        .datepicker-icon:hover {
            color: #007bff;
        }

        /* 🔥 COMPACT CUSTOM CALENDAR UI */
        .datepicker {
            background: #fff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 8px;
        }

        .datepicker table {
            width: 100%;
        }

        .datepicker td,
        .datepicker th {
            padding: 6px;
            text-align: center;
            font-size: 12px;
            border-radius: 6px;
            transition: 0.2s;
        }

        .datepicker td:hover {
            background: rgba(0, 123, 255, 0.1);
        }

        .datepicker .active {
            background: #007bff !important;
            color: white !important;
            font-weight: bold;
        }

        .datepicker .today {
            background: rgba(0, 123, 255, 0.2) !important;
            font-weight: bold;
        }

        .datepicker .prev, .datepicker .next {
            font-size: 14px;
            cursor: pointer;
            color: #007bff;
            transition: 0.3s;
        }

        .datepicker .prev:hover,
        .datepicker .next:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Minimalist Datepicker Card -->
<div class="datepicker-container">
    <label for="datepicker" class="form-label">Select a Date:</label>
    <div class="position-relative">
        <input type="text" id="datepicker" class="datepicker-input" placeholder="MM/DD/YYYY" readonly>
        <i class="bi bi-calendar datepicker-icon" id="datepicker-icon"></i>
    </div>
</div>

<!-- jQuery & Datepicker Script -->
<script>
    $(document).ready(function () {
        $('#datepicker').datepicker({
            format: "mm/dd/yyyy",
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        // Open Datepicker when Clicking Icon
        $('#datepicker, #datepicker-icon').click(function () {
            $('#datepicker').datepicker('show');
        });
    });
</script>

</body>
</html>
