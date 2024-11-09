<style>
    /* Background and Text Styles */
    body {
        background: linear-gradient(to right, #FFB29D, #ffffc5);
    }

    .navbar {
        background-color: #800c12;
    }

    .navbar-nav .btn-warning,
    .navbar-nav .btn-light {
        border-radius: 20px;
        /* Rounded corners for Participant and Organizer buttons */
    }

    .navbar-nav .nav-link i.bi-bell-fill {
        border-radius: 20px;
        /* Rounded corners for the bell icon */
        padding: 10px;
        /* Add padding for a button-like look */
        color:#800c12;
        background-color: #fff;
        /* Optional: Add background color for the icon */
    }

    .profile-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-title {
        font-size: 28px;
        color: #800c12;
    }

    .nav-tabs .nav-link {
        color: #800c12;
    }

    .nav-tabs .nav-link.active {
        background-color: #FFDFD4;
        color: #800c12;
    }

    .btn-warning {
        color: #fff;
        background-color: #efbf04;
        border: none;
    }

    .btn-link {
        color: #800c12;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <a class="navbar-brand ml-4" href="#"><img src="Eventure logo.jpg" alt="Eventure Logo" width="30%"; height="auto";></a>
        <div class="navbar-nav mx-auto">
            <a class="nav-link" href="#">Home</a>
            <a class="nav-link" href="#">Calendar</a>
            <a class="nav-link active" href="#">User Profile</a>
            <a class="nav-link" href="#">Dashboard</a>
        </div>
        <div class="navbar-nav mr-4">
            <a class="btn btn-warning mx-1" href="#">PARTICIPANT SITE</a>
            <a class="btn btn-light mx-1" href="#">ORGANIZER SITE</a>
            <a class="nav-link" href="#"><i class="bi bi-bell-fill"></i></a>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="container mt-5">
        <div class="row">
            <!-- Profile Sidebar -->
            <div class="col-md-4 text-center">
                <div class="profile-card p-4">
                    <img src="https://via.placeholder.com/100" alt="Profile Image" class="rounded-circle mb-3">
                    <h4>Emily Knowles</h4>
                    <p class="text-muted">UTM12345678</p>
                    <p><i class="bi bi-house-door-fill"></i> Kolej Tun Dr. Ismail</p>
                    <p><i class="bi bi-envelope-fill"></i> emilyknowles@example.com</p>
                    <button class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit Profile</button>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="col-md-8">
                <h2 class="profile-title">User Profile</h2>
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Personal Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Activity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Experience</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Skills</a>
                    </li>
                </ul>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="idNumber">Identification Number</label>
                            <input type="text" class="form-control" id="idNumber">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="college">College Address</label>
                            <input type="text" class="form-control" id="college">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="matricNumber">Matric Number</label>
                            <input type="text" class="form-control" id="matricNumber">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="course">Course</label>
                            <input type="text" class="form-control" id="course">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">Save</button>
                    <button type="reset" class="btn btn-link">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>