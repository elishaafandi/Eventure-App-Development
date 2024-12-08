<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'students';

    // Primary key column (if it's not 'id')
    protected $primaryKey = 'id';

    // Disable auto-increment if 'id' is not auto-incrementing (in case you're using a custom primary key)
    public $incrementing = false;

    // The attributes that are mass assignable
    protected $fillable = [
        'first_name', 'last_name', 'ic', 'matric_no', 'faculty_name', 
        'sem_of_study', 'college', 'email', 'gender'
    ];

    // Define the relationship with the User model (assuming 'id' is the foreign key)
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
