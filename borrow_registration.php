<?php
// Connect to the database
$connect = mysqli_connect("localhost", "root", "", "lms", 3306);

// Get book information from URL parameters
$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : '';
$book_title = isset($_GET['book_title']) ? $_GET['book_title'] : '';
$book_writer = isset($_GET['book_writer']) ? $_GET['book_writer'] : '';

// Check if form is submitted
if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($connect, $_POST["name"]);
    $department = mysqli_real_escape_string($connect, $_POST["department"]);
    $s_id = mysqli_real_escape_string($connect, $_POST["s_id"]);
    $form_book_id = mysqli_real_escape_string($connect, $_POST["book_id"]);
    $form_book_title = mysqli_real_escape_string($connect, $_POST["book_title"]);

    // Insert borrowing details into the database
    $sql = "INSERT INTO borrow_list (name, department, s_id, book_id, book_title) VALUES ('$name', '$department', '$s_id', '$form_book_id', '$form_book_title')";

    if (mysqli_query($connect, $sql)) {
        echo '<div class="alert alert-success" role="alert">Book borrowing successfully registered!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($connect) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container col-md-4 mt-5">
        <h3 class="text-center">Borrow Book Form</h3>

        <?php if ($book_title): ?>
            <div class="alert alert-info">
                <strong>Book:</strong> <?= htmlspecialchars($book_title) ?><br>
                <strong>Author:</strong> <?= htmlspecialchars($book_writer) ?>
            </div>
        <?php endif; ?>

        <form action="borrow_registration.php" method="POST">
            <!-- Hidden fields for book information -->
            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book_id) ?>">
            <input type="hidden" name="book_title" value="<?= htmlspecialchars($book_title) ?>">

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <!-- Department -->
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select name="department" id="department" class="form-control" required>
                    <option value="CSE">CSE</option>
                    <option value="EEE">EEE</option>
                    <option value="Software">Software</option>
                </select>
            </div>

            <!-- Student ID -->
            <div class="mb-3">
                <label for="s_id" class="form-label">Student ID</label>
                <input type="text" name="s_id" id="s_id" class="form-control" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="submit" class="btn btn-primary">Borrow Book</button>
        </form>
    </div>
</body>

</html>