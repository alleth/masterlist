<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Light & Dark Mode Toggle</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
        .toggle-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .toggle-btn i {
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hello, World!</h1>
    <p>This is a simple light and dark mode toggle example.</p>
</div>
<button class="btn btn-primary toggle-btn" id="toggleButton">
    <i class="fas fa-moon"></i>
</button>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        const icon = this.querySelector('i');
        if (document.body.classList.contains('dark-mode')) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
            this.classList.remove('btn-primary');
            this.classList.add('btn-light');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
            this.classList.remove('btn-light');
            this.classList.add('btn-primary');
        }
    });
</script>
</body>
</html>
