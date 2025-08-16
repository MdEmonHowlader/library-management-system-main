<?php
// Connect to the database
$connec = mysqli_connect("localhost", "root", "", "lms", 3306);

// Check connection
if (!$connec) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Sanitize the input to avoid SQL Injection
    $delete_id = mysqli_real_escape_string($connec, $delete_id);

    // Delete record from the database
    $sql = "DELETE FROM admin_panel WHERE id = '$delete_id'";

    if (mysqli_query($connec, $sql)) {
        // Redirect to the same page after deletion
        header('Location: read_admin.php');
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
    <title>Admin - Library Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <!-- Logo -->
                <img src="https://media.istockphoto.com/id/1270155083/vector/blue-e-book-logo-design-vector-sign-of-electronic-book-library-icon-symbol.jpg?s=612x612&w=0&k=20&c=DGwVHcCijit8E62o3S2dqFXM2usLP2AmJoOSnDhsI5M=" alt="Library Logo" width="40" height="40" class="me-2">
                <strong>Library Management</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.html">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="team.html">Team</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="bg-success text-white text-center py-4">
        <h1>Admin Panel</h1>
        <p>Manage library resources and users</p>
    </header>

    <div class="container col-md-8 mt-5 justify-content-center align-items-center border border-success mb-5">
        <h3 class="text-center p-2 m-2 bg-success text-white">Admin Panel Records</h3>

        <?php
        // Fetch all records
        $sql = "SELECT * FROM admin_panel";
        $query = mysqli_query($connec, $sql);

        if ($query && mysqli_num_rows($query) > 0) {
            echo "<table class='table table-bordered'>
                <thead class='table-success'>
                    <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>User ID</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
            ";

            // Loop through and display data
            while ($data = mysqli_fetch_assoc($query)) {
                $id = $data['id'];
                $user_name = $data['user_name'];
                $user_id = $data['user_id'];
                $password = $data['password'];

                echo "<tr>
                    <td><b>$id</b></td>
                    <td>$user_name</td>
                    <td>$user_id</td>
                    <td>$password</td>
                    <td>
                        <a href='edit.php?edit_id=$id' class='btn btn-success text-white text-decoration-none'>Edit</a>
                        <a href='read_admin.php?delete_id=$id' class='btn btn-danger text-white text-decoration-none' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                    </td>
                </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info text-center' role='alert'>No records found.</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
