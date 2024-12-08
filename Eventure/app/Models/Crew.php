<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;

    protected $table = 'event_crews';
    protected $primaryKey = 'crew_id';
    protected $fillable = ['event_id', 'id', 'role', 'commitment', 'past_experience', 'created_at'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

}
