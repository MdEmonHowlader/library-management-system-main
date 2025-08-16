<?php
$connect = mysqli_connect("localhost", "root", "", "lms", 3306);
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch books from the database and organize by department
$sql = "SELECT id, department, book_title, book_writer, quality FROM manage_books";
$result = mysqli_query($connect, $sql);

$booksByCategory = [
    "CSE" => [],
    "EEE" => [],
    "Software" => []
];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $department = $row["department"];
        if (array_key_exists($department, $booksByCategory)) {
            $booksByCategory[$department][] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Header -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Library Management System</title>
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
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
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

        .hero-section {
            background: var(--gradient);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff10" points="0,1000 1000,0 1000,1000"/></svg>');
            opacity: 0.1;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .main-content {
            background: var(--light-color);
            border-radius: 30px 30px 0 0;
            margin-top: -30px;
            position: relative;
            z-index: 2;
            padding: 50px 0;
            min-height: 70vh;
        }

        .category-section {
            margin-bottom: 3rem;
        }

        .category-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 2rem;
            text-align: center;
        }

        .category-btn {
            background: white;
            border: 2px solid transparent;
            color: var(--dark-color);
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .category-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .category-btn:hover::before {
            left: 0;
        }

        .category-btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .category-btn.active {
            background: var(--gradient);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .category-btn i {
            margin-right: 8px;
        }

        .book-card {
            background: white;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .book-card img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .book-card:hover img {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .card-text {
            color: #6b7280;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .card-text strong {
            color: var(--dark-color);
        }

        .btn-borrow {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-borrow:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .books-grid {
            margin-top: 2rem;
        }

        .category-container {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .category-container.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        footer {
            background: var(--dark-color) !important;
            margin-top: 0;
        }

        .book-stats {
            background: white;
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .category-btn {
                padding: 12px 20px;
                margin: 5px;
            }

            .main-content {
                padding: 30px 0;
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out;
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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <i class="fas fa-book-open me-2" style="font-size: 1.5rem;"></i>
                <strong>Library Management</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.html"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="books.php"><i class="fas fa-book me-1"></i>Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-user-shield me-1"></i>Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="team.html"><i class="fas fa-users me-1"></i>Team</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container hero-content text-center text-white">
            <h1 class="hero-title fade-in">📚 Discover Books</h1>
            <p class="hero-subtitle fade-in">Explore our extensive collection of books across different departments</p>

            <!-- Book Statistics -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    <div class="book-stats">
                        <div class="row">
                            <div class="col-4 stat-item">
                                <div class="stat-number"><?= count($booksByCategory['CSE']) ?></div>
                                <div class="stat-label">CSE Books</div>
                            </div>
                            <div class="col-4 stat-item">
                                <div class="stat-number"><?= count($booksByCategory['EEE']) ?></div>
                                <div class="stat-label">EEE Books</div>
                            </div>
                            <div class="col-4 stat-item">
                                <div class="stat-number"><?= count($booksByCategory['Software']) ?></div>
                                <div class="stat-label">Software Books</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="main-content">
        <div class="container">
            <!-- Categories Section -->
            <div class="category-section">
                <h2 class="category-title">Choose Your Department</h2>
                <div class="text-center">
                    <button class="btn category-btn" onclick="showBooks('CSE')" id="cse-btn">
                        <i class="fas fa-microchip"></i>Computer Science & Engineering
                    </button>
                    <button class="btn category-btn" onclick="showBooks('EEE')" id="eee-btn">
                        <i class="fas fa-bolt"></i>Electrical & Electronics Engineering
                    </button>
                    <button class="btn category-btn" onclick="showBooks('Software')" id="software-btn">
                        <i class="fas fa-code"></i>Software Engineering
                    </button>
                </div>
            </div>

            <!-- Books Section -->
            <div class="books-grid">
                <?php foreach ($booksByCategory as $category => $books): ?>
                    <div class="category-container" id="<?= $category ?>">
                        <?php if (count($books) > 0): ?>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                <?php foreach ($books as $book): ?>
                                    <div class="col">
                                        <div class="card book-card fade-in">
                                            <img src="https://picsum.photos/300/200?random=<?= $book['id'] ?>"
                                                class="card-img-top"
                                                alt="<?= htmlspecialchars($book['book_title']) ?>">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title"><?= htmlspecialchars($book['book_title']) ?></h5>
                                                <p class="card-text">
                                                    <strong><i class="fas fa-user-edit me-1"></i>Author:</strong> <?= htmlspecialchars($book['book_writer']) ?>
                                                </p>
                                                <p class="card-text">
                                                    <strong><i class="fas fa-star me-1"></i>Quality:</strong>
                                                    <span class="badge bg-success"><?= htmlspecialchars($book['quality']) ?></span>
                                                </p>
                                                <p class="card-text">
                                                    <strong><i class="fas fa-graduation-cap me-1"></i>Department:</strong> <?= htmlspecialchars($book['department']) ?>
                                                </p>
                                                <div class="mt-auto">
                                                    <a href="borrow_registration.php?book_id=<?= $book['id'] ?>&book_title=<?= urlencode($book['book_title']) ?>&book_writer=<?= urlencode($book['book_writer']) ?>"
                                                        class="btn btn-borrow">
                                                        <i class="fas fa-hand-holding me-1"></i>Borrow Book
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-book-open"></i>
                                <h3>No Books Available</h3>
                                <p>There are currently no books available in the <?= $category ?> department.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-2">
                        <i class="fas fa-heart text-danger me-1"></i>
                        Made with love by the Library Management Team
                    </p>
                    <p class="mb-0">&copy; 2024 Library Management System | All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showBooks(category) {
            // Hide all categories
            const categories = document.querySelectorAll('.category-container');
            categories.forEach(cat => {
                cat.classList.remove('active');
            });

            // Remove active class from all buttons
            const buttons = document.querySelectorAll('.category-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected category with animation
            setTimeout(() => {
                document.getElementById(category).classList.add('active');
            }, 100);

            // Add active class to clicked button
            document.getElementById(category.toLowerCase() + '-btn').classList.add('active');
        }

        // Show CSE books by default when page loads
        document.addEventListener('DOMContentLoaded', function() {
            showBooks('CSE');
        });

        // Add smooth scrolling to borrow buttons
        document.querySelectorAll('.btn-borrow').forEach(button => {
            button.addEventListener('click', function(e) {
                // Add a small loading animation
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';

                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 500);
            });
        });

        // Add hover effects to cards
        document.querySelectorAll('.book-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>

</html>