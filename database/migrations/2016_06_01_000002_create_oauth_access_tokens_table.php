<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id')->index()->nullable();
            $table->unsignedInteger('client_id');
            $table->string('name')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->text('json_data')->nullable();
            $table->tinyInteger('device_type')->default(1)->comment('1=Desktop, 2=Mobile, 3=Robot');
            $table->timestamps();
            $table->dateTime('expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_access_tokens');
    }
}
