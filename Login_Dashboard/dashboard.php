<?php
require_once 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Database Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Faculty Database Management</h2>
            </div>
            <div class="col-md-6 text-end">
                <p>Faculty ID: <?php echo htmlspecialchars($_SESSION['faculty_id']); ?></p>
                <p>Login Time: <?php echo htmlspecialchars($_SESSION['login_time']); ?></p>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="view_faculty_data.php" method="GET">
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">Enter Faculty ID</label>
                        <input type="text" class="form-control" id="faculty_id" name="faculty_id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">View Records</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>