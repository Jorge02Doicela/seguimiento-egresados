<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    public function up()
    {
        // Crear la tabla si no existe
        if (!Schema::hasTable('employers')) {
            Schema::create('employers', function (Blueprint $table) {
                $table->id();

                // Relación con usuarios, única y con eliminación en cascada
                $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

                // Información principal
                $table->string('company_name');
                $table->string('contact_name');

                // Agregamos RUC aquí
                $table->string('ruc', 13)->unique();

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

                // Identificación fiscal, único (si `tax_id` es diferente de `ruc`, sino elimina este)
                $table->string('tax_id')->nullable()->unique();

                // Campo is_verified agregado directamente aquí
                $table->boolean('is_verified')->default(false);

                $table->timestamps();
            });
        } else {
            // Si ya existe, agregar columna is_verified si no existe
            Schema::table('employers', function (Blueprint $table) {
                if (!Schema::hasColumn('employers', 'is_verified')) {
                    $table->boolean('is_verified')->default(false)->after('city');
                }
                // Agregar columna ruc si no existe
                if (!Schema::hasColumn('employers', 'ruc')) {
                    $table->string('ruc', 13)->unique()->after('contact_name');
                }
            });
        }
    }

    public function down()
    {
        // Al hacer rollback
        if (Schema::hasTable('employers')) {
            Schema::table('employers', function (Blueprint $table) {
                if (Schema::hasColumn('employers', 'is_verified')) {
                    $table->dropColumn('is_verified');
                }
                if (Schema::hasColumn('employers', 'ruc')) {
                    $table->dropColumn('ruc');
                }
            });

            Schema::dropIfExists('employers');
        }
    }
}
