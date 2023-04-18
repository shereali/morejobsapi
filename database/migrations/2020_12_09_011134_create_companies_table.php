<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn');
            $table->string('address_en')->nullable();
            $table->string('address_bn')->nullable();
            $table->string('logo')->nullable();
            $table->text('about')->nullable();
            $table->string('trade_licence_no')->nullable();
            $table->string('rl_no')->nullable()->comment('RL No (Only for Recruiting Agency)');
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->string('website')->nullable();
            $table->boolean('status')->nullable()->comment('0=pending, 1= approved, 2= inactive/banned');
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
        Schema::dropIfExists('companies');
    }
}
