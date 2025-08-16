<?php 
$connect = mysqli_connect("localhost", "root", "", "lms", 3306);

if (isset($_POST["submit"])) {
    $department = $_POST["department"];
    $book_title = $_POST["book_title"];
    $book_writer = $_POST["book_writer"];
    $quality = $_POST["quality"];

    $sql = "INSERT INTO manage_books (department, book_title, book_writer, quality) VALUES ('$department', '$book_title', '$book_writer', '$quality')";

    if (mysqli_query($connect, $sql) == TRUE) {
        header('location:/books.php'); // Redirect to books.php after successful insertion
    } else {
        echo '<div class="alert alert-danger" role="alert">
            Insertion error
        </div>';
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
    <div class="container col-md-4 mt-5 justify-content-center align-items-center ">
        <legend><h3>Book Registration Form</h3></legend>
        <form action="manage_books.php" method="POST">

            <!-- Department Selection -->
            <div class="mb-3">
                <label for="department" class="form-label">Choose Department</label>
                <select name="department" id="department" class="form-control">
                    <option value="CSE">CSE</option>
                    <option value="EEE">EEE</option>
                    <option value="Software">Software</option>
                </select>
            </div>

            <!-- Book Title -->
            <div class="mb-3">
                <label for="book_title" class="form-label">Enter Book Title</label>
                <input type="text" name="book_title" class="form-control" id="book_title" required>
            </div>

            <!-- Book Writer -->
            <div class="mb-3">
                <label for="book_writer" class="form-label">Enter Book Writer</label>
                <input type="text" name="book_writer" class="form-control" id="book_writer" required>
            </div>

            <!-- Book Quantity -->
            <div class="mb-3">
                <label for="quality" class="form-label">Enter Quantity</label>
                <input type="number" name="quality" class="form-control" id="quality" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>
