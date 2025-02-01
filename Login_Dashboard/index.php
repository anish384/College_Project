<?php
require_once 'config.php';

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
        header("Location: view_faculty_data.php?faculty_id=" . urlencode($faculty_id));
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
        .container1 {
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 15px 0;
        margin-bottom: 30px;
    }

    .row1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 90%;
        margin: 0 auto;
        gap: 20px;
    }

    .site_header_3 {
        color: rgb(43, 69, 152);
        text-align: center;
    }

    .site_header_3 h6 {
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .site_header_3 h2 {
        font-size: 1.5rem;
        margin-bottom: 8px;
    }

    .site_header_3 span {
        font-size: 0.9rem;
        color: #666;
    }
    </style>
</head>
<body>
<div class="container-fluid mt-4 mb-5">
        <div class="info-header">
            <div class="row">
            <div class="real">
            <div class="containerm">
                <div class="row">
                    <div class="site_topbar">
                        <i class="phone"></i> <b>0831-2438100/123</b>
                        <i class="envelope_icon"></i> info@aitmbgm.ac.in
                    </div>
                </div>
            </div>
        </div>

        <div class="container1">
            <div class="row1">
                <div class="site_header_1">
                    <h2 class="web_title">
                        <a class="back" href="https://aitmbgm.ac.in">
                            <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/Suresh-Angadi.jpg" alt="AITMBGM" title="AITMBGM">
                        </a>
                    </h2>
                </div>

                <div class="site_header_2">
                    <h2 class="web_title">
                        <a class="back" href="https://aitmbgm.ac.in">
                            <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitmbgm-logo.png" alt="AITMBGM" title="AITMBGM">
                        </a>
                    </h2>
                </div>

                <div class="site_header_3">
                    <h6>SURESH ANGADI EDUCATION FOUNDATIONS</h6>
                    <h2>ANGADI INSTITUTE OF TECHNOLOGY AND MANAGEMENT</h2>
                    <span>Approved by AICTE, New Delhi, Affiliated to VTU, Belagavi. <br>Accredited by *NBA and NAAC</span>
                </div>

                <div class="site_header_4">
                    <img class="photo" src="https://aitmbgm.ac.in/wp-content/themes/aitmbgm-20/images/aitm-logo.png" alt="AITM" title="AITM">
                </div>
            </div>
        </div>
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
            Current Time (UTC): <?php echo date('d-m-Y H:i:s'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>