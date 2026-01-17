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
            $table->id();
             $table->string('sbd')->unique()->index();
            $table->float('toan', 5, 2)-> nullable();
            $table->float('ngu_van', 5, 2)-> nullable();
            $table->float('ngoai_ngu', 5, 2)-> nullable();
            $table->float('vat_li', 5, 2)-> nullable();
            $table->float('hoa_hoc', 5, 2)-> nullable();
            $table->float('sinh_hoc', 5, 2)-> nullable();
            $table->float('lich_su', 5, 2)-> nullable();
            $table->float('dia_li', 5, 2)-> nullable();
            $table->float('gdcd', 5, 2)-> nullable();
            $table->string('ma_ngoai_ngu')-> nullable();
            $table->timestamps();
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
