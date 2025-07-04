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

            // Relación con usuarios, única y con eliminación en cascada
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            // Información principal
            $table->string('company_name');
            $table->string('contact_name');

            // Información de contacto y empresa
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Correos y teléfonos específicos de la empresa
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_address')->nullable();

            // Datos adicionales
            $table->string('website')->nullable();
            $table->string('sector')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();

            // Identificación fiscal, único
            $table->string('tax_id')->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employers');
    }
}
