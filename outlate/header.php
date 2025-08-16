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
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Adimn</a>
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