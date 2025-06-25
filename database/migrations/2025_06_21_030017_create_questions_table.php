<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['option', 'scale', 'text']);
            $table->json('options')->nullable();      // Opciones para preguntas tipo opción múltiple
            $table->unsignedTinyInteger('scale_min')->nullable();  // Para escala (mínimo valor)
            $table->unsignedTinyInteger('scale_max')->nullable();  // Para escala (máximo valor)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
