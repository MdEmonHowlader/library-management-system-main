<?php
// Establish database connection
$connect = mysqli_connect("localhost", "root", "", "lms", 3306);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Query to check user credentials
    $query = "SELECT * FROM admin_panel WHERE user_name = '$username' AND password = '$password'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Redirect to dashboard or home page after successful login
        header("Location: admin.html");
        exit();
    } else {
        $message = "Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Library Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --admin-gradient: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle cx="200" cy="200" r="50" fill="%23ffffff05"/><circle cx="800" cy="300" r="80" fill="%23ffffff03"/><circle cx="600" cy="700" r="60" fill="%23ffffff04"/><circle cx="300" cy="600" r="40" fill="%23ffffff06"/></svg>');
            opacity: 0.5;
        }

        .navbar {
            background: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 5px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: var(--gradient) !important;
            color: white !important;
        }

        .login-container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--admin-gradient);
        }

        .login-header {
            background: var(--admin-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 255, 255, 0.05) 10px,
                    rgba(255, 255, 255, 0.05) 20px);
            animation: slide 20s linear infinite;
        }

        @keyframes slide {
            0% {
                transform: translateX(-50%) translateY(-50%) rotate(0deg);
            }

            100% {
                transform: translateX(-50%) translateY(-50%) rotate(360deg);
            }
        }

        .login-header-content {
            position: relative;
            z-index: 1;
        }

        .login-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            opacity: 0.9;
            font-weight: 300;
        }

        .login-body {
            padding: 3rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
            background: white;
            transform: translateY(-2px);
        }

        .form-floating>label {
            color: #6b7280;
            font-weight: 500;
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-left: 3rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            z-index: 3;
            font-size: 1.1rem;
        }

        .btn-login {
            background: var(--admin-gradient);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .alert {
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fecaca, #fca5a5);
            color: #991b1b;
            border-left: 4px solid var(--danger-color);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            z-index: 3;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .login-footer {
            text-align: center;
            padding: 2rem;
            background: rgba(248, 250, 252, 0.5);
            color: #6b7280;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .back-link:hover {
            color: var(--secondary-color);
            transform: translateX(-5px);
        }

        .back-link i {
            margin-right: 0.5rem;
        }

        .security-badge {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            margin-top: 1rem;
        }

        .security-badge i {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .login-body {
                padding: 2rem;
            }

            .login-header {
                padding: 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .login-icon {
                font-size: 3rem;
            }
        }

        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 4;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <i class="fas fa-book-open me-2" style="font-size: 1.5rem;"></i>
                <strong>Library Management</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php"><i class="fas fa-book me-1"></i>Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php"><i class="fas fa-user-shield me-1"></i>Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="team.html"><i class="fas fa-users me-1"></i>Team</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 col-sm-9">
                    <div class="login-card fade-in">
                        <div class="login-header">
                            <div class="login-header-content">
                                <i class="fas fa-shield-alt login-icon"></i>
                                <h2 class="login-title">Admin Access</h2>
                                <p class="login-subtitle">Secure Login to Library Management System</p>
                            </div>
                        </div>

                        <div class="login-body">
                            <a href="index.html" class="back-link">
                                <i class="fas fa-arrow-left"></i>
                                Back to Home
                            </a>

                            <!-- Display error message if login fails -->
                            <?php if ($message): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="" id="loginForm">
                                <div class="input-group">
                                    <i class="fas fa-user input-icon"></i>
                                    <div class="form-floating">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                                        <label for="username">Username</label>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <i class="fas fa-lock input-icon"></i>
                                    <div class="form-floating">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                        <label for="password">Password</label>
                                    </div>
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>

                                <button type="submit" class="btn btn-login" id="loginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Login to Admin Panel
                                </button>

                                <div class="security-badge">
                                    <i class="fas fa-lock"></i>
                                    Secured with SSL encryption
                                </div>
                            </form>
                        </div>

                        <div class="login-footer">
                            <p class="mb-0">
                                <i class="fas fa-copyright me-1"></i>
                                2025 Library Management System | All Rights Reserved
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add loading animation to login button
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            loginBtn.classList.add('loading');
            loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Authenticating...';
            loginBtn.disabled = true;
        });

        // Add focus animations to form inputs
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.input-group').style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.closest('.input-group').style.transform = 'translateY(0)';
            });
        });

        // Add shake animation for invalid login
        <?php if ($message): ?>
            document.querySelector('.login-card').style.animation = 'shake 0.5s ease-in-out';

            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-5px); }
                    75% { transform: translateX(5px); }
                }
            `;
            document.head.appendChild(style);
        <?php endif; ?>

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.location.href = 'index.html';
            }
        });

        // Add form validation feedback
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.style.borderColor = '#10b981';
                } else {
                    this.style.borderColor = '#e5e7eb';
                }
            });
        });
    </script>
</body>

</html>