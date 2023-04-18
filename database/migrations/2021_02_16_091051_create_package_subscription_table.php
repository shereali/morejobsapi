<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_subscription', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('package_detail_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedInteger('quantity');
            $table->double('total');
            $table->double('paid');
            $table->unsignedInteger('remaining');
            $table->dateTime('subscribe_at')->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->boolean('status')->default(0)->comment('0=pending, 1= approved');
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
        Schema::dropIfExists('package_subscription');
    }
}
