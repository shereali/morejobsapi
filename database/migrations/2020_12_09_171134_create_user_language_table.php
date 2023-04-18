<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->tinyInteger('reading_skill')->nullable()->comment('1=high, 2= medium, 3= low');
            $table->tinyInteger('writing_skill')->nullable()->comment('1=high, 2= medium, 3= low');
            $table->tinyInteger('speaking_skill')->nullable()->comment('1=high, 2= medium, 3= low');
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
        Schema::dropIfExists('user_language');
    }
}
