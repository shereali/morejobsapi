<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedTinyInteger('duration_hour')->nullable();
            $table->unsignedTinyInteger('duration_day')->nullable();
            $table->unsignedTinyInteger('duration_month')->nullable();
            $table->unsignedTinyInteger('duration_year')->nullable();
            $table->double('price')->nullable();
            $table->foreignId('training_type_id')->nullable()->constrained('training_types');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('class_schedule')->nullable();
            $table->string('class_timetable')->nullable();
            $table->string('no_of_sessions')->nullable()->comment('No of sessions / class count');
            $table->dateTime('deadline')->nullable()->comment('Last date of registration');
            $table->string('venue');
            $table->foreignId('trainer_id')->nullable()->constrained('trainers');
            $table->text('who_can_attend')->nullable();
            $table->longText('details')->nullable()->comment('course details outline');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
