<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCertificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_certification', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Certification name');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('duration')->nullable()->comment('anything, month, year');
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
        Schema::dropIfExists('user_certification');
    }
}
