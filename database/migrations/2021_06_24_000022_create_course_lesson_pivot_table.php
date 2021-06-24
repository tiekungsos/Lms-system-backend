<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseLessonPivotTable extends Migration
{
    public function up()
    {
        Schema::create('course_lesson', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id', 'course_id_fk_4240285')->references('id')->on('courses')->onDelete('cascade');
            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id', 'lesson_id_fk_4240285')->references('id')->on('lessons')->onDelete('cascade');
        });
    }
}
