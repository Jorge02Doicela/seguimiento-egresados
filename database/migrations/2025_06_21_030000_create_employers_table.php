<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('contact_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employers');
    }
}
