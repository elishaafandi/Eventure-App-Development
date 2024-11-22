<div id="profile-content" class="container mt-2">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('profilepage')}}" id="personal-link">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{route('profileactivity')}}" id="activity-link">Activity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="{{route('profileexperince')}}" id="experince-link">Experience</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('profileclub')}}" id="club-link">Club Joined</a>
                        </li>
                    </ul>
                    <table class="table table-bordered events-table">
                    <thead>
                        <tr style="background-color:#800c12; border: 2px solid; background-color:maroon; text-align:center;">
                            <th>Organizer</th>
                            <th>Event Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
    
                </div>