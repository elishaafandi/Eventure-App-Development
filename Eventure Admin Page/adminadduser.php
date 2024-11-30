<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminhome.css">
    <title>Admin - Add User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .student-form {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Add User</h1>
    <form action="processadduser.php" method="POST">
       <!-- id field -->
        <label for="id">User ID:</label>
        <input type="text" name="id" id="id" required><br>

        <!-- Username Field -->
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <!-- Email Field -->
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <!-- Password Field -->
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <!-- Role Selection -->
        <label for="role">Role:</label>
        <select name="role" id="role" onchange="roleChanged()">
            <option value="1">Admin</option>
            <option value="0">Student</option>
        </select><br>

        <!-- Student Specific Fields -->
        <div id="student-form" class="student-form">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name"><br>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name"><br>

            <label for="ic">IC (Identity Card No.):</label>
            <input type="text" name="ic" id="ic"><br>

            <label for="matric_no">Matriculation No.:</label>
            <input type="text" name="matric_no" id="matric_no"><br>

            <label for="faculty_name">Faculty Name:</label>
            <input type="text" name="faculty_name" id="faculty_name"><br>

            <label for="year_course">Year and Course:</label>
            <input type="text" name="year_course" id="year_course"><br>

            <label for="college">College:</label>
            <input type="text" name="college" id="college"><br>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>
        </div>

        <!-- Submit Button -->
        <button type="submit">Submit</button>
    </form>
</div>

<script>
    function roleChanged() {
        const role = document.getElementById('role').value;
        const studentForm = document.getElementById('student-form');

        // Show the student form if Student role is selected
        if (role == 0) {
            studentForm.style.display = 'block';
        } else { // Hide the student form if Admin role is selected
            studentForm.style.display = 'none';
        }
    }
</script>

</body>
</html>
