<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySomeColumnsInPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
           \DB::statement( 'ALTER TABLE `posts` CHANGE `category_id` `category_id` BIGINT(20) UNSIGNED NULL');
           \DB::statement( 'ALTER TABLE `posts` CHANGE `package_id` `package_id` BIGINT(20) UNSIGNED NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            \DB::statement('ALTER TABLE `posts` CHANGE `category_id` `category_id` BIGINT(20) UNSIGNED NOT NULL');
            \DB::statement('ALTER TABLE `posts` CHANGE `package_id` `package_id` BIGINT(20) UNSIGNED NOT NULL');
        });
    }
}
