<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('archive_username')->nullable();
            $table->unsignedInteger('user_type')->default(2)->comment('1=super admin, 2=employee, 3= employer');
            $table->unsignedInteger('reg_medium')->default(1)->comment('1=custom registration, 2=facebook, 3=google, 4=mobile registration');
            $table->string('image')->nullable();
            $table->string('password');
            $table->dateTime('account_verified_at')->nullable();
            $table->string('account_verification_token', 60)->nullable();
            $table->boolean('status')->default(1)->comment('0=inactive, 1= active, 3= blocked');
            $table->boolean('resume_completed')->default(0)->comment('0=not completed, 1=completed');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
