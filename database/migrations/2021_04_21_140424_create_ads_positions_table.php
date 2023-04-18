<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_positions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('key')->nullable()->comment('BELOW_GOVT_SECTION, HOT_JOBS_RIGHT_SECTION');
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
        Schema::dropIfExists('ads_positions');
    }
}
