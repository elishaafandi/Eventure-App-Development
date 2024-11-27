<?php

session_start();

require_once('config.php'); // Include your database connection


// Check if user is already logged in

if (isset($_SESSION['id'])) {

    //echo "User  is already logged in.";
}


$error_message = ""; // Initialize error message variable


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize form inputs

    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

    $password = trim($_POST['password']);


    // Check if email is valid

    if (!$email) {

        $error_message = "Invalid email address!";
    } else {

        // Prepare the SQL query

        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");

        if ($stmt) {

            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {

                $result = $stmt->get_result();

                if ($result->num_rows == 1) {

                    $row = $result->fetch_assoc();

                    if (password_verify($password, $row['password'])) {

                        // Store user ID in session and regenerate session ID

                        session_regenerate_id(true);

                        $_SESSION['id'] = $row['id'];

                        header("Location: organizerhome.php"); // Redirect to homepage

                        exit();
                    } else {

                        $error_message = "Incorrect password!";
                    }
                } else {

                    $error_message = "No account found with that email!";
                }
            } else {

                $error_message = "Error executing query!";
            }

            $stmt->close();
        } else {

            $error_message = "Database connection failed!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Legal Assistant Login</title>
    <link rel="icon" href="logo.png" type="image/x-icon" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #800c12;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .registration-form {
            background-color: #800c12;
            border-radius: 10px;
            padding: 30px;
            width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .registration-form h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }

        .registration-form .form-label {
            color: #ffffff;
        }

        .registration-form input {
            border-radius: 20px;
            padding: 10px;
        }

        .registration-form .form-control:focus {
            box-shadow: none;
            border-color: #3d7ff5;
        }

        .btn-register {
            background-color: #d20424;
            border: none;
            border-radius: 20px;
            padding: 10px;
            width: 100%;
            color: #ffffff;
            margin-top: 20px;
        }

        .btn-register:hover {
            background-color: #e43b40;
        }

        .form-header {
            background-color: #d20424;
            color: #ffffff;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            margin-bottom: 10px;
        }

        .text-light {
            color: #9ca2ad !important;
        }

        .logo {
            max-width: 250px;
            margin-bottom: 10px;
        }

        .legal_logo {
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
        }

        .welcome {
            position: absolute;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Grid Structure for Logo and Form -->
        <div class="row">
            <!-- Logo Section -->
            <div class="col-12 d-flex justify-content-center">
                <div class="Logo">
                    <img src="Eventure logo.jpg" alt="Eventure Logo" class="logo img-fluid">
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Logo Section -->
            <div class="col-12 d-flex justify-content-center">
                <div class="p-2 welcome">
                    <!-- <h1 class="text-white">Welcome to Eventure</h1> -->
                </div>
            </div>
        </div>

        <!-- Registration Form Section -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="registration-form border border-3 border-white">
                    <div class="form-header">
                        <h3>Login Form</h3>
                    </div>
                    <!-- Display error message if login fails -->
                    <?php if (!empty($error_message)): ?>
                        <p class="error"><?= htmlspecialchars($error_message) ?></p>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <button type="submit" class="btn btn-register">Login</button>
                    </form>

                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($error_message)) : ?>
                        <p style="color: red;"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>