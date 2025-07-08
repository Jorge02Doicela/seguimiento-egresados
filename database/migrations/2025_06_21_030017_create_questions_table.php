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
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['option', 'checkbox', 'scale', 'boolean']);
            $table->json('options')->nullable(); // para opciones de "option" o "checkbox"
            $table->unsignedTinyInteger('scale_min')->nullable();
            $table->unsignedTinyInteger('scale_max')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
