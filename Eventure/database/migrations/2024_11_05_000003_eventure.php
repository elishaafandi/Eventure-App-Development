<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('ic', 12);
            $table->string('matric_no', 8)->unique();
            $table->string('faculty_name', 100);
            $table->string('sem_of_study', 3);
            $table->string('college', 4);
            $table->string('email', 100);
            $table->boolean('gender');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        }); 

        Schema::create('clubs', function (Blueprint $table) {
            $table->id('club_id'); // Auto-incrementing primary key
            $table->string('club_name', 255)->unique(); // Unique club name
            $table->text('description'); // Description as TEXT
            $table->date('founded_date'); // Date the club was founded
            $table->string('club_type', 50); // Type of club
            $table->unsignedBigInteger('president_id'); // Foreign key to User table
        
            // Foreign key constraint
            $table->foreign('president_id')->references('id')->on('users')->onDelete('cascade');
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        });


        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id'); // Auto-incrementing primary key
            $table->unsignedBigInteger('organizer_id'); // Foreign key to User table
            $table->string('event_name', 255); // Event name
            $table->text('description'); // Event description
            $table->string('location', 255); // Event location
            $table->integer('total_slots'); // Maximum slots
            $table->integer('available_slots'); // Slots remaining
            $table->enum('event_status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->enum('event_type', ['academic', 'sports', 'cultural', 'social', 'volunteer', 'college']);
            $table->enum('event_format', ['in-person', 'online', 'hybrid'])->notNullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'canceled']);
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        
            // Foreign key constraint
            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('cascade');
        });


        Schema::create('club_memberships', function (Blueprint $table) {
            $table->bigIncrements('memberships_id'); // Custom name for the primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to the 'users' table
            $table->unsignedBigInteger('club_id'); // Foreign key to the 'clubs' table
            $table->string('position', 50); // Position with a max length of 50
            $table->date('join_date'); // Join date
            $table->enum('status', ['active', 'inactive']); // Status as ENUM
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        });
        

       

        Schema::create('event_crews', function (Blueprint $table) {
            $table->id('crew_id'); // Auto-incrementing primary key
            $table->unsignedBigInteger('event_id'); // Foreign key to Event table
            $table->unsignedBigInteger('id'); // Foreign key to User table
            $table->enum('role', ['protocol', 'technical', 'gift', 'food', 'special_task', 'multimedia', 'sponsorship', 'documentation', 'transportation', 'activity']);
            $table->enum('application_status', ['applied', 'interview', 'rejected', 'pending', 'accepted']);
            $table->enum('attendance_status', ['present', 'absent', 'pending']);
            $table->text('feedback')->nullable(); // Nullable feedback
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        
            // Foreign key constraints
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });

        
        
        
        Schema::create('event_clubs', function (Blueprint $table) {
            $table->id('association_id'); // Auto-incrementing primary key
            $table->unsignedBigInteger('event_id'); // Foreign key to Event table
            $table->unsignedBigInteger('club_id'); // Foreign key to Club table
            $table->string('role', 50); // Role in the association
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        
            // Foreign key constraints
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
            $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
        });
        
        Schema::create('student_experiences', function (Blueprint $table) {
            $table->id('experience_id'); // Auto-incrementing primary key
            $table->unsignedBigInteger('id'); // Foreign key to User table
            $table->unsignedBigInteger('event_id'); // Foreign key to Event table
            $table->enum('role', ['protocol', 'technical', 'gift', 'food', 'special_task', 'multimedia', 'sponsorship', 'documentation', 'transportation', 'activity']);
            $table->boolean('feedback_given')->default(false);
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        
            // Foreign key constraints
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
        });
        

        Schema::create('feedback', function (Blueprint $table) {
            $table->id('feedback_id'); // Auto-incrementing primary key
            $table->unsignedBigInteger('event_id'); // Foreign key to Event table
            $table->unsignedBigInteger('from_id'); // Foreign key to User table
            $table->unsignedBigInteger('to_id')->nullable(); // Nullable foreign key to User table
            $table->text('feedback_text'); // Feedback text
            $table->integer('rating'); // Rating integer
            $table->enum('feedback_type', ['event', 'participant', 'crew']); // Feedback type
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        
            // Foreign key constraints
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id('participant_id'); // Auto-incrementing primary key
            $table->unsignedBigInteger('event_id'); // Foreign key to Event table
            $table->unsignedBigInteger('id'); // Foreign key to User table
            $table->enum('registration_status', ['registered', 'cancelled']); // Registration status
            $table->enum('attendance_status', ['present', 'absent', 'pending']); // Attendance status
            $table->text('feedback')->nullable(); // Nullable feedback
        
            $table->timestamps(); // Adds created_at and updated_at timestamps
        
            // Foreign key constraints
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('club_memberships');
        Schema::dropIfExists('clubs');
        Schema::dropIfExists('event_crews');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_clubs');
        Schema::dropIfExists('student_experiences');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('event_participants');
    }
};
