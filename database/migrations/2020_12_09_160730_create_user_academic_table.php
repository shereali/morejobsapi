<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAcademicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_academic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('education_level_id')->nullable()->constrained();
            $table->foreignId('degree_id')->nullable()->constrained();
            $table->boolean('hide_mark')->default(0)->comment('1=hide to employer, 0= public');
            $table->year('passing_year')->nullable();
            $table->unsignedSmallInteger('duration')->comment('in year: ie: 4 years')->nullable();
            $table->string('institute_name')->nullable();
            $table->string('achievement')->nullable();
            $table->double('cgpa')->nullable()->comment('total mark/grade point');
            $table->foreignId('result_type_id')->nullable()->constrained();
            $table->string('major')->nullable();
            $table->tinyInteger('view_order')->default(1);
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
        Schema::dropIfExists('user_academic');
    }
}
