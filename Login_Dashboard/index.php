<?php
require_once 'config.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['faculty_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id = $_POST['faculty_id'];
    $date_of_joining = $_POST['date_of_joining'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM faculty_table WHERE faculty_id = ? AND date_of_joining = ?");
    $stmt->bind_param("ss", $faculty_id, $date_of_joining);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Login successful
        $_SESSION['faculty_id'] = $faculty_id;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid Faculty ID or Date of Joining";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .login-header {
            background: #0d6efd;
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .login-body {
            padding: 30px;
        }
        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 15px;
        }
        .current-time {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="card login-card">
            <div class="login-header">
                <h2 class="mb-0">Faculty Login</h2>
            </div>
            <div class="login-body">
                <?php if (isset($error_message)): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">Faculty ID</label>
                        <input type="text" class="form-control" id="faculty_id" name="faculty_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_joining" class="form-label">Date of Joining</label>
                        <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="current-time">
            Current Time (UTC): <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>