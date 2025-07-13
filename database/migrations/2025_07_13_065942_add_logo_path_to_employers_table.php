<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoPathToEmployersTable extends Migration
{
    public function up()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('website');
        });
    }

    public function down()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('logo_path');
        });
    }
}
