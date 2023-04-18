<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('dob')->nullable();
            $table->foreignId('gender_id')->nullable()->constrained();
            $table->foreignId('religion_id')->nullable()->constrained();
            $table->foreignId('marital_status_id')->nullable()->constrained('marital_status');
            $table->foreignId('country_id')->nullable()->comment('nationality')->constrained();
            $table->string('nid_no')->nullable()->comment('nid, birth certificate/passport etc.');
            $table->foreignId('present_area_id')->nullable()->constrained('areas');
            $table->foreignId('permanent_area_id')->nullable()->constrained('areas');
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->mediumText('objective')->nullable();
            $table->mediumText('career_summary')->nullable();
            $table->mediumText('keywords')->nullable();
            $table->mediumText('extracurricular')->nullable();
            $table->mediumText('specialization')->nullable()->comment('specialization description');
            $table->double('present_salary')->default(0);
            $table->double('expected_salary')->default(0 );
            $table->foreignId('job_level_id')->nullable()->constrained('job_levels');
            $table->foreignId('job_nature_id')->nullable()->constrained('job_natures');
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
        Schema::dropIfExists('user_profile');
    }
}
