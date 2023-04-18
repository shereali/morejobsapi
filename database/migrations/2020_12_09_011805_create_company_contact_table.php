<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_contact', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained();
            $table->string('title')->comment('email address/mobile no');
            $table->boolean('type')->comment('1= email, 2= mobile, 3= telephone, 4= fax');
            $table->boolean('is_verified')->default(0);
            $table->tinyInteger('is_default')->default(0);
            $table->string('token')->nullable();
            $table->dateTime('token_expire_at')->nullable();
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
        Schema::dropIfExists('company_contact');
    }
}
