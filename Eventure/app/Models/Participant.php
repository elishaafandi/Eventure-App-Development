<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'event_participants'; 
    protected $primaryKey = 'participant_id';
    protected $fillable = ['event_id', 'id', 'attendance', 'requirements', 'created_at'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}
