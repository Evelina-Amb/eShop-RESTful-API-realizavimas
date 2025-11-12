<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('miestas', function (Blueprint $table) {
            $table->id();
            $table->string('pavadinimas', 100);
            $table->unsignedBigInteger('salis_id')->nullable();
            $table->timestamps();

            $table->foreign('salis_id')->references('id')->on('salis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('miestas');
    }
};

