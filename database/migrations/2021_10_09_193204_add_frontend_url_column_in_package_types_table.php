<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFrontendUrlColumnInPackageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_types', function (Blueprint $table) {
            $table->string('frontend_url')->after('title')->nullable()->comment('use-case: to manage frontend component when click routerlink');
            $table->longText('description')->after('frontend_url')->nullable()->comment('why from us?');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_types', function (Blueprint $table) {
            $table->dropColumn('frontend_url', 'description');
        });
    }
}
