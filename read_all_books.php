<?php
// Connect to the database
$connec = mysqli_connect("localhost", "root", "", "lms", 3306);

// Check connection
if (!$connec) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete = $_GET['delete_id'];
    $sql = "DELETE FROM manage_books WHERE id=$delete";
    if (mysqli_query($connec, $sql) === true) {
        header('Location: read_all_books.php');
        exit;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting record: " . mysqli_error($connec) . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - All Books</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://media.istockphoto.com/id/1270155083/vector/blue-e-book-logo-design-vector-sign-of-electronic-book-library-icon-symbol.jpg?s=612x612&w=0&k=20&c=DGwVHcCijit8E62o3S2dqFXM2usLP2AmJoOSnDhsI5M=" alt="Library Logo" width="40" height="40" class="me-2">
                <strong>Library Management</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="read_all_books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_books.php">Register Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.html">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-success text-white text-center py-4">
        <h1>All Books</h1>
        <p>Browse and manage library books</p>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <h3 class="text-center mb-4">Library Books</h3>
        <?php
        // Fetch all book records
        $sql = "SELECT * FROM manage_books";
        $query = mysqli_query($connec, $sql);

        if (mysqli_num_rows($query) > 0) {
            echo "<table class='table table-bordered'>
                <thead class='table-success'>
                    <tr>
                        <th>ID</th>
                        <th>Department</th>
                        <th>Title</th>
                        <th>Writer</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
            ";

            // Loop through and display data
            while ($data = mysqli_fetch_assoc($query)) {
                echo "<tr>
                    <td>{$data['id']}</td>
                    <td>{$data['department']}</td>
                    <td>{$data['book_title']}</td>
                    <td>{$data['book_writer']}</td>
                    <td>{$data['quality']}</td>
                    <td>
                        <a href='edit_book.php?edit_id={$data['id']}' class='btn btn-warning text-white'>Edit</a>
                        <a href='read_all_books.php?delete_id={$data['id']}' class='btn btn-danger text-white'>Delete</a>
                    </td>
                </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info text-center'>No books found.</div>";
        }
        ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Library Management System | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
