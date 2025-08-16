<?php 
$connect = mysqli_connect("localhost", "root", "", "lms", 3306);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if (isset($_POST["submit"])) {
    // Sanitize inputs
    $user_name = mysqli_real_escape_string($connect, $_POST["user_name"]);
    $user_id = mysqli_real_escape_string($connect, $_POST["user_id"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);

    // Insert query
    $sql = "INSERT INTO admin_panel (user_name, user_id, password) VALUES ('$user_name', '$user_id', '$password')";

    if (mysqli_query($connect, $sql)) {
        $message = '<div class="alert alert-success" role="alert">Data inserted successfully!</div>';
    } else {
        $message = '<div class="alert alert-danger" role="alert">Insertion error: ' . mysqli_error($connect) . '</div>';
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
                        <a class="nav-link" href="books.html">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.html">Adimn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Team</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="bg-secondary text-white text-center py-4">
        <h1>Admin Panel</h1>
        <p>Manage library resources and users</p>
    </header>
<body>
    <div class="container col-md-4 mt-5">
        <h3>Admin Registration Form</h3>
        
        <!-- Display messages -->
        <?php echo $message; ?>
        
        <form action="admin.html" method="POST">
            <div class="mb-3">
                <label for="user_name" class="form-label">User Name</label>
                <input type="text" name="user_name" class="form-control" id="user_name" required>
            </div>
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="text" name="user_id" class="form-control" id="user_id" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
