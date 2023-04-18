<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizationTypeIdColumnInCompaniesTable extends Migration
{

    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_type_id')->after('title_bn')->nullable();
        });
    }


    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('organization_type_id');
        });
    }
}
