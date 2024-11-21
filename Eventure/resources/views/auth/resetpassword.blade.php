<!DOCTYPE html>
<html lang="en">

<head>
    <title>Eventure Login</title>
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
                        <h3>Reset Password Form</h3>
                    </div>

                    <form method="POST" action="{{ route('resetpassword') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                        </div>
                        <!-- Flash Message -->
                        @if (session('status'))
                        <p class="alert alert-success">{{ session('status') }}</p>
                        @endif
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>




                </div>
            </div>
        </div>
    </div>
</body>