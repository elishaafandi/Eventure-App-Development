<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events'; // Table name
    protected $primaryKey = 'event_id'; 

    protected $fillable = [
        'organizer_id', 'event_name', 'description', 'location', 'total_slots',
        'available_slots', 'event_status', 'event_type', 'event_format',
        'start_date', 'end_date', 'status', 'created_at', 'updated_at'
    ];

    // Define the relationship with the Club model
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id'); // Each event belongs to a single club
    }

    public function crews()
    {
        return $this->hasMany(Crew::class, 'event_id', 'event_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'event_id', 'event_id');
    }

}

