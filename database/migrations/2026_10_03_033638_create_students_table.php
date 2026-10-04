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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->integer('year_level');
        
            // Foreign key setup matching your ON DELETE SET NULL constraint
            $table->foreignId('course_id')
                ->nullable()
                ->references('course_id')
                ->on('courses')
                ->nullOnDelete()
                ->cascadeOnUpdate();
              
            // Your dump only has created_at, not updated_at
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
