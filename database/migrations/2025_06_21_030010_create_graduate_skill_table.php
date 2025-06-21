<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraduateSkillTable extends Migration
{
    public function up()
    {
        Schema::create('graduate_skill', function (Blueprint $table) {
            $table->foreignId('graduate_id')->constrained('graduates')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
            $table->primary(['graduate_id', 'skill_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('graduate_skill');
    }
}
