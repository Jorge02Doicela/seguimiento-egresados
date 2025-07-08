<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // egresado
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('answer_text'); // texto o JSON para múltiples respuestas
            $table->timestamps();

            $table->unique(['user_id', 'question_id']); // evitar duplicados
        });
    }

    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
