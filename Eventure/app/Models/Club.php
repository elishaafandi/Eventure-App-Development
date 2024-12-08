<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    // If the primary key column is not the default 'id', specify it here
    protected $primaryKey = 'club_id'; 

    // Define the relationship with the Event model
    public function events()
    {
        return $this->hasMany(Event::class); // A club has many events
    }

    // Define the relationship with the User model for the president
    public function president()
    {
        return $this->belongsTo(User::class, 'president_id'); // A club belongs to one user (president)
    }
}
