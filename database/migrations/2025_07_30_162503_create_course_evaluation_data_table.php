<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_evaluation_data', function (Blueprint $table) {
             $table->id();

            $table->integer('department_id');
            $table->integer('teacher_id');
            $table->integer('student_id');
            $table->integer('course_id');
            $table->integer('question_id');

            $table->integer('ratting'); 

            $table->year('year');
            $table->integer('batch_id');

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_evaluation_data');
    }
};
