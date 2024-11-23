@extends('layouts.profile')

@section('profile-content')

<div id="profile-content" class="container mt-2">
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{route('profilepage')}}" id="personal-link">Personal Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profileactivity')}}" id="activity-link">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{route('profileexperience')}}" id="experince-link">Experience</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profileclub')}}" id="club-link">Club Joined</a>
        </li>
    </ul>
    <table class="table table-bordered events-table">
        <thead>
            <tr style="background-color:#800c12; border: 2px solid; background-color:maroon; text-align:center;">
                <th>Role</th>
                <th>Organizer</th>
                <th>Event Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        @if($events->isEmpty())
                <tr>
                    <td colspan="3" style="text-align: center;">Not experienced as crew in any programs.</td>
                </tr>
            @else
                @foreach ($events as $event)
                    <tr style="border: 2px solid; color:maroon; text-align:center;">
                        <td>{{ $event->role }}</td>
                        <td>{{ $event->organizer }}</td>
                        <td>{{ $event->event_name }}</td>
                        <td>{{ $event->description }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>
@endsection