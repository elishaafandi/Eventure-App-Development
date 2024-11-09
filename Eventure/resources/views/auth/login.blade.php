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
                    <img src="{{ asset('Eventure logo.jpg') }}" alt="Eventure Logo" class="logo img-fluid">
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

        <!-- Session Status -->;
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="registration-form border border-3 border-white">
                    <div class="form-header">
                        <h3>Login Form</h3>
                    </div>
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <x-input-label for="email" class="text-white" :value="__('Email')" />
                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <x-input-label for="password" class="text-white" :value="__('Password')" />
                            <x-text-input id="password" class="form-control" type="password" name="password" required placeholder="Enter password" autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class=" text-white inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div class="block" style="text-align:center;">
                        <button style="background-color: #ff0000; color: white; padding: 12px 40px; border-radius: 9999px; ">
                            {{ __('Log in') }}
                        </button>




                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>