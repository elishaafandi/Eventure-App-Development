
<!DOCTYPE html>
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
        color: #800c12;
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


    header {
        background-color: #800c12;
        color: #f5f4e6;
        padding: 25px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header .logo {
        color: #f5f4e6;
        font-weight: bold;
        font-size: 25px;
        font-family: Arial;
        text-decoration: none;
    }

    header .logo:hover {
        color: #ff9b00;
    }

    .header-left {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }

    .nav-left a {
        color: #fff;
        margin-left: 20px;
        text-decoration: none;
        justify-content: flex-start;
        /* Align to the left side */
    }

    .nav-right {
        display: flex;
        align-items: center;
    }

    .nav-left a {
        color: #f5f4e6;
        margin-left: 20px;
        text-decoration: none;
        font-family: Arial;
        transition: 0.3s ease-in-out;
    }

    .nav-left a:hover {
        color: #f3d64c;
        text-decoration: underline;
    }

    .nav-left a.active {
        color: #f3d64c;
        text-decoration: underline;
    }

    .participant-site,
    .organizer-site {
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid #000;
        font-weight: 400;
        text-decoration: none;
        margin-left: 10px;
    }

    .participant-site {
        background-color: #da6124;
        color: #f5f4e6;
    }

    .organizer-site {
        background-color: #f5f4e6;
        color: #000;
    }

    .participant-site:hover {
        background-color: #e08500;
    }

    .organizer-site:hover {
        background-color: #da6124;
        color: #f5f4e6;
    }

    .notification-bell {
        font-size: 18px;
        margin-left: 10px;
    }

    body {
        font-family: sans-serif;
        background-color: #eeeeee;
    }

    .file-upload {
        background-color: #ffffff;
        width: 600px;
        margin: 2 auto;
        padding: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #800c12;
        border: none;
        padding: 10px;
        border-radius: 4px;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .file-upload-btn:hover {
        background: red;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100px;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #800c12;
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #800c12;
        border: 4px dashed #ffffff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100 bold;
        text-transform: uppercase;
        color: black;
        padding: 60px 0;
        height: 40px;
    }

    .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #ffffff;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #800c12;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }
</style>


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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>

    <header>
        <div class="row">
            <div class="header-left">
                <a href="participanthome.php" class="logo">EVENTURE</a>


                <nav class="nav-left">
                    <a href="participanthome.php"></i>Home</a></li>
                    <a href="participantdashboard.php"></i>Dashboard</a></li>
                    <a href="participantcalendar.php"></i>Calendar</a></li>
                    <a href="profilepage.php"></i>User Profile</a></li>


                </nav>
            </div>
            <div class="header-right">
                <nav class="nav-right">
                    <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
                    <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a>
                    <span class="notification-bell">🔔</span>
                </nav>
            </div>
        </div>
    </header>

    <!-- Profile Section -->
    <div class="container mt-5">
        <div class="row">
            <!-- Profile Sidebar -->
            <div class="col-md-4 text-center">
                <div class="profile-card p-4">
                    <img src="https://via.placeholder.com/100" alt="Profile Image" class="rounded-circle mb-3">
                    <h4><b>{{ $username }}</b></h4>
                    <p><i class="bi bi-envelope-fill"></i><b> {{ $email }}</b></p>
                    <p><i class="bi bi-person-fill"></i><b>{{ $role = 1 ? ' Student' : ' Admin' }}</b></p>
                    <button class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit Profile</button>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="col-md-8">
                <h2 class="profile-title">{{ $username }}'s Profile</h2>
                @yield('profile-content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
