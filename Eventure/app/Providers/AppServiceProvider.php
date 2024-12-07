<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Composers\ProfileComposer;
use App\Http\Composers\OrganizerComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    // }

    public function boot()
    {
        // Attach the composer to specific views
        View::composer(
            ['profile.Profilepage', 'profile.Profileclub', 'profile.Profileactivity', 'profile.Profileexperience', 'participant.editparticipant'],
            ProfileComposer::class
        );
        View::composer(
            ['Homepage', 'participant.participantdashboard','participant.editparticipant'], // List the views that will receive the data
            OrganizerComposer::class
        );
    }
}
