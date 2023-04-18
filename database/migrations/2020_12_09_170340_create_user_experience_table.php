<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('company_name');
            $table->foreignId('industry_type_id')->constrained();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();
            $table->string('department')->nullable();
            $table->text('responsibilities')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->boolean('is_current')->default(1)->comment('Is currently working there?');
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
        Schema::dropIfExists('user_experience');
    }
}
