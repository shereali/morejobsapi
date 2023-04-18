<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTrainingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_training', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('training course title');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->string('topic')->nullable();
            $table->year('year')->nullable();
            $table->string('duration')->nullable();
            $table->string('institute_name')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('user_training');
    }
}
