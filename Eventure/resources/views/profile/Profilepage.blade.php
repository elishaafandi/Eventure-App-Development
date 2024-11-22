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
                    <p><i class="bi bi-person-fill"></i><b>{{ $role = 1 ? ' Admin' : ' Student' }}</b></p>
                    <button class="btn btn-danger"><i class="bi bi-pencil-square"></i> Edit Profile</button>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="col-md-8">
                <h2 class="profile-title">{{ $username }}'s Profile</h2>
                <div id="profile-content" class="container mt-2">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" id="personal-link">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="activity-link">Activity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="experience-link">Experience</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="club-link">Club Joined</a>
                        </li>
                    </ul>

                    <form action="{{ route ('profileEdit') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                            <div class="file-upload">
                                <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Profile Photo</button>

                                <div class="image-upload-wrap">
                                    <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
                                    <div class="drag-text">
                                        <h3>Drag and drop your picture</h3>
                                    </div>
                                </div>
                                <div class="file-upload-content">
                                    <img class="file-upload-image" src="#" alt="your image" />
                                    <div class="image-title-wrap">
                                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstname" value="{{ $firstname }}" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastname" value="{{ $lastname }}" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="idNumber">Identification Number</label>
                                <input type="text" class="form-control" id="idNumber" name="idNumber" value="{{ $ic }}" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" value="{{ $email }}" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <input type="text" class="form-control" id="gender" name="gender" value="{{ $gender = 'P' ? 'FEMALE' : 'MALE'}}" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="matricNumber">Matric Number</label>
                                <input type="text" class="form-control" id="matricNumber" name="matricNumber" value="{{ $matricno }}" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="facname">Faculty</label>
                                <input type="text" class="form-control" id="facname" name="faculty">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sem">Semester</label>
                                <input type="number" class="form-control" id="sem" name="sem">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="college">College Address</label>
                                <input type="text" class="form-control" id="college" name="college">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning">Save</button>
                        <button type="reset" class="btn btn-link">Cancel</button>
                    </form>
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

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUpload();
        }
    }

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function() {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function() {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
</script>

<script>
    $(document).ready(function() {
        //Set up AJAX for all navigation links
        $('#personal-link').click(function(e) {
            e.preventDefault();
            // loadContent("{{ route('profilepage') }}");
        });

        $('#activity-link').click(function(e) {
            e.preventDefault();         
            loadContent("{{ route('profileactivity') }}");
        });

        $('#experience-link').click(function(e) {
            e.preventDefault();
           
            loadContent("{{ route('profileexperience') }}");
        });

        $('#club-link').click(function(e) {
            e.preventDefault();
           
            loadContent("{{ route('profileclub') }}");
        });

        // Function to load content dynamically
        function loadContent(url) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Update the content container with the response from the server
                    $('#profile-content').html(response);
                },
                error: function() {
                    alert('Error loading content');
                }
            });
        }
    });
</script>