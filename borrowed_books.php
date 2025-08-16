<?php
// Connect to the database
$connect = mysqli_connect("localhost", "root", "", "lms", 3306);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all borrowed books from the database
$sql = "SELECT * FROM borrow_list ORDER BY id DESC";
$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books - Library Management System</title>
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
            --warning-gradient: linear-gradient(135deg, #f59e0b, #d97706);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
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

        /* Header */
        .page-header {
            background: var(--warning-gradient);
            padding: 80px 0 50px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff10" points="0,1000 1000,0 1000,1000"/></svg>');
            opacity: 0.1;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        /* Main Content */
        .main-content {
            background: var(--light-color);
            border-radius: 30px 30px 0 0;
            margin-top: -30px;
            position: relative;
            z-index: 2;
            padding: 50px 0;
            min-height: 70vh;
        }

        .table-container {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--warning-gradient);
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
            text-align: center;
        }

        .table thead th:first-child {
            border-radius: 15px 0 0 0;
        }

        .table thead th:last-child {
            border-radius: 0 15px 0 0;
        }

        .table tbody td {
            padding: 1rem;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody tr:hover {
            background-color: rgba(245, 158, 11, 0.05);
        }

        .badge-department {
            background: var(--gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
        }

        .btn-action {
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .btn-return {
            background: var(--success-color);
            color: white;
        }

        .btn-return:hover {
            background: #059669;
            transform: translateY(-2px);
            color: white;
        }

        .btn-details {
            background: var(--primary-color);
            color: white;
        }

        .btn-details:hover {
            background: #5b59f5;
            transform: translateY(-2px);
            color: white;
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

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--warning-color);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--warning-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-weight: 500;
        }

        .back-btn {
            background: var(--gradient);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .back-btn i {
            margin-right: 8px;
        }

        footer {
            background: var(--dark-color) !important;
            padding: 3rem 0 !important;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }

            .table-container {
                padding: 1rem;
                overflow-x: auto;
            }

            .stats-cards {
                grid-template-columns: 1fr;
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.html"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php"><i class="fas fa-book me-1"></i>Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.html"><i class="fas fa-user-shield me-1"></i>Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="team.html"><i class="fas fa-users me-1"></i>Team</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container header-content text-center text-white">
            <h1 class="page-title fade-in">📋 Borrowed Books</h1>
            <p class="page-subtitle fade-in">Monitor and manage all borrowed books in the library system</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <a href="admin.html" class="back-btn fade-in">
                <i class="fas fa-arrow-left"></i>
                Back to Admin Dashboard
            </a>

            <?php
            $total_borrowed = mysqli_num_rows($result);

            // Count by department
            $cse_count = 0;
            $eee_count = 0;
            $software_count = 0;

            if ($total_borrowed > 0) {
                mysqli_data_seek($result, 0); // Reset result pointer
                while ($row = mysqli_fetch_assoc($result)) {
                    switch ($row['department']) {
                        case 'CSE':
                            $cse_count++;
                            break;
                        case 'EEE':
                            $eee_count++;
                            break;
                        case 'Software':
                            $software_count++;
                            break;
                    }
                }
                mysqli_data_seek($result, 0); // Reset again for table display
            }
            ?>

            <!-- Statistics Cards -->
            <div class="stats-cards fade-in">
                <div class="stat-card">
                    <div class="stat-number"><?= $total_borrowed ?></div>
                    <div class="stat-label">Total Borrowed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $cse_count ?></div>
                    <div class="stat-label">CSE Department</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $eee_count ?></div>
                    <div class="stat-label">EEE Department</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $software_count ?></div>
                    <div class="stat-label">Software Department</div>
                </div>
            </div>

            <!-- Borrowed Books Table -->
            <div class="table-container fade-in">
                <?php if ($total_borrowed > 0): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student Name</th>
                                    <th>Department</th>
                                    <th>Student ID</th>
                                    <th>Book Title</th>
                                    <th>Book ID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><strong>#<?= $row['id'] ?></strong></td>
                                        <td>
                                            <i class="fas fa-user-graduate me-2"></i>
                                            <?= htmlspecialchars($row['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                        </td>
                                        <td>
                                            <span class="badge-department">
                                                <?= htmlspecialchars($row['department'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($row['s_id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <i class="fas fa-book me-2"></i>
                                            <?= htmlspecialchars($row['book_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['book_id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <button class="btn btn-action btn-return" onclick="markAsReturned(<?= $row['id'] ?>)">
                                                <i class="fas fa-check me-1"></i>Return
                                            </button>
                                            <button class="btn btn-action btn-details" onclick="showDetails(<?= $row['id'] ?>)">
                                                <i class="fas fa-info me-1"></i>Details
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No Borrowed Books</h3>
                        <p>There are currently no borrowed books in the system.</p>
                        <a href="books.php" class="btn btn-action btn-details">
                            <i class="fas fa-book me-1"></i>Browse Books
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white">
        <div class="container">
            <div class="text-center">
                <p class="mb-0">
                    <i class="fas fa-heart text-danger me-1"></i>
                    &copy; 2025 Library Management System | All Rights Reserved
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function markAsReturned(borrowId) {
            if (confirm('Are you sure you want to mark this book as returned?')) {
                // Here you would typically send an AJAX request to update the database
                alert('Book marked as returned! (This would typically update the database)');
                // For now, we'll just reload the page
                // location.reload();
            }
        }

        function showDetails(borrowId) {
            alert('Showing details for borrow ID: ' + borrowId + '\n(This would typically show a detailed modal)');
        }

        // Add search functionality
        function addSearchFunctionality() {
            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.className = 'form-control mb-3';
            searchInput.placeholder = 'Search by student name, book title, or department...';
            searchInput.style.borderRadius = '25px';

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            const tableContainer = document.querySelector('.table-container');
            if (tableContainer && document.querySelector('table')) {
                tableContainer.insertBefore(searchInput, tableContainer.firstChild);
            }
        }

        // Initialize search functionality
        document.addEventListener('DOMContentLoaded', addSearchFunctionality);

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.location.href = 'admin.html';
            }
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.querySelector('input[type="text"]');
                if (searchInput) searchInput.focus();
            }
        });
    </script>
</body>

</html>