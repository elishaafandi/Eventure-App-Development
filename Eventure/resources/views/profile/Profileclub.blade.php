@extends('layouts.profile')

@section('profile-content')
<div id="profile-content" class="container mt-2">
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{route('profilepage')}}" id="personal-link">Personal Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{route('profileactivity')}}" id="activity-link">Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('profileexperience')}}" id="experince-link">Experience</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link active" href="{{route('profileclub')}}" id="club-link">Club Joined</a>
        </li>
    </ul>
    <table class="table table-bordered events-table">
        <thead>
            <tr style="background-color:#800c12; border: 2px solid; text-align:center;">
                <th>Organizer</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($events->isEmpty())
            <tr>
                <td colspan="3" style="text-align: center;">No clubs found.</td>
            </tr>
            @else
            @foreach ($events as $event)
            <tr style="border: 2px solid; color:maroon; text-align:center;">
                <td>{{ $event->organizer }}</td>
                <td>{{ $event->description }}</td>
                <td>
                    <form method="POST" action="{{ route('deleteClubMembership') }}" onsubmit="return confirmDeletion(event)">
                    @csrf
                        <!-- Hidden input to pass the club_id -->
                        <input type="hidden" name="club_id" value="{{ $event->club_id }}">
                        <!-- Trash Icon -->
                        <button type="submit" name="delete_event" class="btn btn-link">
                            <i class="bi bi-trash danger" style="font-size: 1.5rem; color: maroon;"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

</div>

@endsection

<script>
function confirmDeletion(event) {
    const confirmed = confirm('Are you sure you want to delete this club membership?');
    if (!confirmed) {
        // Prevent form submission if the user cancels
        event.preventDefault();
    }
    return confirmed;
}
</script>