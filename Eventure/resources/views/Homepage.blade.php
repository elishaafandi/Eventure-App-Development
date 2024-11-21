<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .submenu {
            background-color: #800c12;
            height: 100vh;
            /*same meaning with 100%  Ensure body takes full height */
            color: white;
            font-weight: bold;
        }

        .menu-item {

            text-align: left;
            padding: 5px;
            border-radius: 20px;
            margin-top: 10px;
            /* Space between items */
            transition: background-color 0.3s ease;
            color: white;
        }

        .menu-item:hover {
            background-color: #da6124;
            /* Red background on hover */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row"> <!-- Wrap submenu and main content in a row -->
            <div class="col-2 submenu"> <!-- Keeps col-2 width -->
                <div class="text-center">
                    <img src="Eventure logo.jpg" alt="Eventure Logo" class="logo img-fluid">
                </div>
                <div class="p-2">
                    <div class="menu-item Dashboard"><i class="fa-solid fa-table-columns"></i> Dashboard</div>
                    <div class="menu-item Events"><i class="fa-solid fa-box-open"></i> Events Hosted</div>
                    <div class="menu-item Participant"><i class="fa-solid fa-cart-shopping"></i> Participant Listing</div>
                    <div class="menu-item Crew"><i class="fa-solid fa-wallet"></i> Crew Listing</div>
                    <div class="menu-item Reports"><i class="bi bi-bar-chart-fill"></i> Reports</div>
                </div>

                <div class="p-2" style="margin-top: 60px;">
                    <div class="menu-item Settings"><i class="fa-sharp-duotone fa-solid fa-gear"></i> Settings</div>
                    <a href="{{ route('login') }}"><div class="menu-item Log Out"><i class="fa-solid fa-right-from-bracket"></i> Log Out</div></a>
                </div>

                <div class="p-2" style="margin-top: 100px;">
                    <div class="menu-item Feedback"><i class="fa-solid fa-comments"></i> Feedback</div>
                </div>
            </div>

            <div class="col-10 main-content"> <!-- Main content follows the submenu -->
                <b>Welcome Back,</b>
                <div class="row">

                    <div class="d-flex justify-content-end align-items-center gap-3 ">
                        <!-- Participant Site Button -->
                        <div class="menu-item club text-center border border-gray-300" style="width: auto; min-width: 150px; color: #800c12;">
                            PARTICIPANT SITE
                        </div>

                        <!-- Organiser Site Button -->
                        <div class="menu-item club text-center border border-gray-300 text-white" style="width: auto; min-width: 150px; background-color: #800c12;">
                            ORGANISER SITE
                        </div>

                        <!-- Notification Bell Icon -->
                        <div class="menu-item bell text-center text-white bg-maroon p-2 rounded-circle" style="width: 40px; height: 40px; background-color: #800c12;">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <a href="/profile" class="menu-item bell text-center text-white bg-maroon p-2 rounded-circle" style="width: 40px; height: 40px; background-color: #da6124;">
                            <i class="bi bi-person-circle"></i>
                        </a>

                    </div>

                    <div class="m-2  menu-item club" style="width: 20%; background-color: #800c12; text-align: center;">
                        CGMA Club President
                        <i class="bi bi-caret-down-square-fill"></i>
                    </div>

                    <div class="m-2 menu-item club d-flex align-items-center justify-content-center" style="width: 20%; background-color: #da6124; text-align: center;">
                        <i class="bi bi-plus-square-fill fs-4"></i>
                        <span class="ms-2"> Add Club</span> <!-- Added a span for better control of spacing -->
                    </div>

                </div>

                <div class="row">
                    <div class="col-4 container-fluid" style="background-color: #ad121a; margin: 5px; padding: 5px; border-radius: 20px; width: 30%;">
                        <h1>CREATE NEW PROGRAM & EVENT</h1>
                        <p>Elevate your membership status and indulge in a realm of luxury and exclusivity.</p>
                        <div class="m-2 menu-item create" style="background-color: #da6124; width:40%">
                            CREATE EVENT
                        </div>
                    </div>

                    <div class="col-4 container-fluid">
                        <h1>CREATE NEW PROGRAM & EVENT</h1>
                        <p>Elevate your membership status and indulge in a realm of luxury and exclusivity.</p>
                    </div>

                    <div class="col-4 container-fluid">
                        <h1>CREATE NEW PROGRAM & EVENT</h1>
                        <p>Elevate your membership status and indulge in a realm of luxury and exclusivity.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 container-fluid">
                        Filter things
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>