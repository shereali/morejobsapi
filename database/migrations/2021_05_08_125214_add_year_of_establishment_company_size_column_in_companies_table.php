<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearOfEstablishmentCompanySizeColumnInCompaniesTable extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('year_establishment')->nullable()->after('organization_type_id');
            $table->string('company_size')->nullable()->after('organization_type_id');
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('year_establishment', 'company_size');
        });
    }
}
