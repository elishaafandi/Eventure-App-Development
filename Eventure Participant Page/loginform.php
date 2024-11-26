<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* You can put your custom styles here, but it's cleaner to move them to a separate CSS file */
        body {
            background-color: #800c12;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            color: #800c12;
            margin-bottom: 20px;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container form label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .container form input {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .container form button {
            padding: 10px;
            background-color: #800c12;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .container form button:hover {
            background-color: #d20424;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h1>Login</h1>

        <!-- Display error message if login fails -->
        <?php
        session_start();
        if (isset($_SESSION["loginError"])) {
            echo "<p class='error'>" . $_SESSION["loginError"] . "</p>";
            unset($_SESSION["loginError"]); // Remove error message after displaying it
        }
        ?>

        <form method="post" action="login.php" id="loginForm">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>

    </div>
</body>

</html>
