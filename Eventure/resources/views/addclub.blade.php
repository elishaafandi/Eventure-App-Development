<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventure Organizer Site</title>
    <link rel="stylesheet" href="{{asset('build/assets/addclub.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-left">
            <div class="nav-right">
                <a href="participanthome.php" class="participant-site">PARTICIPANT SITE</a>
                <a href="organizerhome.php" class="organizer-site">ORGANIZER SITE</a>
                <span class="notification-bell">🔔</span>
            </div>
        </div>
    </header>

    <main>
        <aside class="sidebar">
            <div class="logo-container">
                <a href="organizerhome.php" class="logo">EVENTURE</a>
            </div>
            <ul>
                <li><a href="organizerhome.php"><i class="fas fa-home-alt"></i> Dashboard</a></li>
                <li><a href="organizerevent.php"><i class="fas fa-calendar-alt"></i>Event Hosted</a></li>
                <li><a href="organizerparticipant.php"><i class="fas fa-user-friends"></i>Participant Listing</a></li>
                <li><a href="organizercrew.php"><i class="fas fa-users"></i>Crew Listing</a></li>
                <li><a href="organizerreport.php"><i class="fas fa-chart-line"></i>Reports</a></li>
            </ul>
            <ul style="margin-top: 60px;">
                <li><a href="organizersettings.php"><i class="fas fa-cog"></i>Settings</a></li>
                <li><a href="organizerlogout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
            <ul style="margin-top: 60px;">
                <li><a href="organizerfeedback.php"><i class="fas fa-star"></i>Feedback</a></li>
            </ul>
        </aside>

        <section class="add-club-section">
            <div class="add-club-container">
                <h1>Let's Get Your Club On Board!</h1>
                <h2>Enter your details here</h2>
                <p>For any questions, technical assistance, or inquiries about your club’s status approval, feel free to contact us using the information provided below.</p>
                <div class="contact-info">
                    <div class="contact-item"><i class="fas fa-phone"></i>+607-8997341</div>
                    <div class="contact-item"><i class="fas fa-envelope"></i>eventureutm@gmail.com</div>
                </div>
            </div>

            <div class="form-container">
                <h1>Add Club / Association</h1>
                <form action="{{route('createclub')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="club-name">Name of Club/Association:</label>
                    <input type="text" id="club-name" name="club_name" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>

                    <label for="founded_date">Club Founded Date</label>
                    <input type="date-local" id="founded_date" name="founded_date" required
                        value="2024-11-10"
                        min="2020-01-01" max="2025-12-31">


                    <label for="club_type">Club Type</label>
                    <select id="club_type" name="club_type">
                        <option value="academic">Academic</option>
                        <option value="nonacademic">Non-Academic</option>
                        <option value="collegecouncil">College Council</option>
                        <option value="uniform">Uniform</option>
                        <option value="uniform">Sport</option>
                    </select>

                    <label for="proof">Submit photo of your club's legitimacy:</label>
                    <input type="file" id="image" name="proof" accept="image/*" onchange="validateImage(this)">
                    <p id="file-error" style="color: red; display: none;">File must be less than 40 MB and only in image format.</p>

                    <label for="proof">Submit proof of your club's legitimacy:</label>
                    <input type="file" id="proof" name="proof" accept="image/*,application/pdf" required onchange="validateFile(this)">
                    <p id="file-error" style="color: red; display: none;">File must be less than 40 MB and only in PDF or image format.</p>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>

                    <p class="note">*Once club status has been approved, an email will be sent to the provided email address.</p>
                    <button type="submit" class="submit-btn">SUBMIT NOW</button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>

<script>
    function validateFile(input) {
        const file = input.files[0];
        const maxSize = 40 * 1024 * 1024; // 40 MiB in bytes
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

        const errorElement = document.getElementById('file-error');
        errorElement.style.display = 'none'; // Hide error message initially

        if (file) {
            if (!allowedTypes.includes(file.type)) {
                errorElement.textContent = 'Only PDF, JPEG, and PNG files are allowed.';
                errorElement.style.display = 'block';
                input.value = ''; // Clear the invalid input
                return false;
            }
            if (file.size > maxSize) {
                errorElement.textContent = 'File size must be less than 40 MB.';
                errorElement.style.display = 'block';
                input.value = ''; // Clear the invalid input
                return false;
            }
        }
        return true;
    }

    function validateimage(input) {
        const file = input.files[0]; // Get the selected file
        const fileError = document.getElementById('file-error');
        
        // Clear any previous error messages
        fileError.style.display = 'none';

        if (file) {
            // Check file size (40 MB = 40 * 1024 * 1024 bytes)
            const maxFileSize = 40 * 1024 * 1024;
            if (file.size > maxFileSize) {
                fileError.textContent = 'File size must be less than 40 MB.';
                fileError.style.display = 'block';
                input.value = ''; // Clear the input field
                return false;
            }

            // Check file type (image MIME types)
            const allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedFileTypes.includes(file.type)) {
                fileError.textContent = 'Only image files (JPEG, PNG, GIF, WebP) are allowed.';
                fileError.style.display = 'block';
                input.value = ''; // Clear the input field
                return false;
            }
        }
    }
</script>

