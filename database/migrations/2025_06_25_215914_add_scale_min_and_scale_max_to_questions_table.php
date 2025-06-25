<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'scale_min')) {
                $table->integer('scale_min')->nullable()->after('options');
            }
            if (!Schema::hasColumn('questions', 'scale_max')) {
                $table->integer('scale_max')->nullable()->after('scale_min');
            }
        });
    }
};
