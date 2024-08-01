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
        Schema::create('campus_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained('campus')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('academic_programs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campus_programs');
    }
};
