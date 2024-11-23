@extends('layouts.profile')

@section('profile-content')

<div id="profile-content" class="container mt-2">
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" id="personal-link">Personal Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profileactivity')}}" id="activity-link">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profileexperience')}}" id="experience-link">Experience</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profileclub')}}" id="club-link">Club Joined</a>
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
@endsection

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

<!-- <script>
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
            console.log("Loading content from: " + url); // Log the URL
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#profile-content').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    console.error("Response: ", xhr.responseText);
                    alert('Error loading content: ' + xhr.status + ' ' + xhr.statusText);
                }
            });
        }
    });
</script> -->