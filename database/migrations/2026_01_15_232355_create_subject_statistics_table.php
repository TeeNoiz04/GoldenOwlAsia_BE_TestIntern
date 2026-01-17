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
        Schema::create('subject_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->unique();
            $table->unsignedInteger('excellent')->default(0); // >= 8
            $table->unsignedInteger('good')->default(0);      // >= 6
            $table->unsignedInteger('average')->default(0);   // >= 4
            $table->unsignedInteger('poor')->default(0);      // < 4
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_statistics');
    }
};
