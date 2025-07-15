<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraduatesTable extends Migration
{
    public function up()
    {
        Schema::create('graduates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('cohort_year');
            $table->enum('gender', ['M', 'F', 'Otro'])->nullable();
            $table->foreignId('career_id')->nullable()->constrained()->onDelete('set null');
            $table->string('company')->nullable();
            $table->string('position')->nullable(); // Tecnológico
            $table->string('non_tech_position')->nullable(); // No tecnológico
            $table->boolean('is_working')->default(false);
            $table->text('salary')->nullable();
            $table->enum('sector', ['privado', 'público', 'freelance'])->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('graduates');
    }
}
